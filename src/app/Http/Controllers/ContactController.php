<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ContactController extends Controller
{
    public function index(Request $request)
{
    $contact = [];
    if ($request->session()->has('contact_back'))
    {
        $contact = $request->session()->get('contact');
        $request->session()->forget('contact_back');
    }
    else
    {
        $request->session()->forget('contact');
    }
        $categories = Category::all();
        Log::info('Categories retrieved', ['categories' => $categories->toArray()]); // カテゴリーデータをログ出力
        return view('index', compact('contact', 'categories'));
}

    public function confirm(ContactRequest $request)
    {
        $validatedData = $request->validated();

        $validatedData['tel'] = $validatedData['phone_number'];

        $genderTextMap = [
            1 => '男性',
            2 => '女性',
            3 => 'その他',
        ];

        $validatedData['gender_text'] = $genderTextMap[$validatedData['gender']];

        $category = Category::find($validatedData['category_id']);
        $validatedData['category_content'] = $category ? $category->content : '';

        $validatedData['phone_part1'] = $request->input('phone_part1');
        $validatedData['phone_part2'] = $request->input('phone_part2');
        $validatedData['phone_part3'] = $request->input('phone_part3');

        $request->session()->put('contact', $validatedData);

        return view('confirm')->with('contact', $validatedData);
    }

    public function store(Request $request)
    {
        $contactData = $request->session()->get('contact');

        if (!$contactData) {
        return redirect()->route('contact.index');
    }

        $contact = new Contact($contactData);
        $contact->save();

        $request->session()->forget('contact');

        return redirect()->route('contact.thanks');
    }

    public function process(Request $request)
{
    $action = $request->input('action');

    if ($action === 'submit') {
        return $this->store($request);
    } elseif ($action === 'back') {
        $request->session()->put('contact_back', true);
        return redirect()->route('contact.index');
    }
}

    public function thanks()
    {
        return view('thanks');
    }

    public function showLoginForm()
{
        return view('auth.login');
}

    public function login(LoginRequest $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/admin');
    }

    return back()->withErrors([
        'email' => '提供された資格情報は記録と一致しません',
    ])->withInput($request->only('email'));
}

    public function showRegisterForm()
{
    return view('auth.register');
}

    public function register(RegisterRequest $request)
{
    // validated() を使ってバリデーション済みデータを取得
    $validatedData = $request->validated();

    // 「姓 名」形式で入力された名前を分割 半角・全角スペースに対応
    $parts = preg_split('/[\s　]+/', trim($request->name), 2);
    $lastName = $parts[0] ?? '';
    $firstName = $parts[1] ?? '';

    User::create([
        'last_name' => $lastName,
        'first_name' => $firstName,
        'email' => $validatedData['email'],
        'password' => Hash::make($validatedData['password']),
    ]);

    return redirect()->route('login')->with('success', '登録が完了しました');
}
        public function adminIndex(Request $request)
{
        // 初期表示用
        Log::info('Admin Index Accessed'); // ログ追加
        $contacts = Contact::paginate(7); // ページネーションで7件表示
        $categories = Category::all(); // お問い合わせ種類

        return view('admin', compact('contacts', 'categories'));
}

        public function adminSearch(Request $request)
{
        $query = Contact::query();

        $search = $request->input('query');

    // フルネーム・部分一致・メール検索
        if ($request->filled('query')) {
            $query->where(function ($q) use ($search) {
                $q->whereRaw("CONCAT(last_name, first_name) LIKE ?", ["%{$search}%"])
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('first_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $contacts = $query->paginate(7)->appends($request->all());
        $categories = Category::all();

    return view('admin', compact('contacts', 'categories'));
}

public function delete($id)
{
    Contact::findOrFail($id)->delete();
    return redirect()->route('admin.search')->with('success', '削除しました');
}

public function export(Request $request)
{
    $query = Contact::with('category');

    // 検索条件があれば追加
    if ($request->filled('query')) {
        $query->where(function ($q) use ($request) {
            $q->where('last_name', 'like', '%' . $request->query . '%')
              ->orWhere('first_name', 'like', '%' . $request->query . '%')
              ->orWhereRaw("CONCAT(last_name, ' ', first_name) LIKE ?", ['%' . $request->query . '%'])
              ->orWhere('email', 'like', '%' . $request->query . '%');
        });
    }
    if ($request->filled('gender')) {
        $query->where('gender', $request->gender);
    }
    if ($request->filled('category_id')) {
        $query->where('category_id', $request->category_id);
    }
    if ($request->filled('date')) {
        $query->whereDate('created_at', $request->date);
    }

    $contacts = $query->get();

    // CSV出力の準備
    $csvFileName = 'contacts_' . date('Ymd_His') . '.csv';

    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => "attachment; filename={$csvFileName}",
    ];

    $callback = function () use ($contacts) {
        $handle = fopen('php://output', 'w');

        // ヘッダー行
        $header = ['お名前', '性別', 'メールアドレス', 'お問い合わせの種類', 'お問い合わせ内容', '日付'];
        fputcsv($handle, array_map(function ($value) {
            return mb_convert_encoding($value, 'SJIS-win', 'UTF-8');
        }, $header));

        // データ行
        foreach ($contacts as $contact) {
            $row = [
                $contact->last_name . ' ' . $contact->first_name,
                $contact->gender == 1 ? '男性' : ($contact->gender == 2 ? '女性' : 'その他'),
                $contact->email,
                $contact->category->content,
                $contact->detail,
                $contact->created_at->format('Y-m-d'),
            ];

            fputcsv($handle, array_map(function ($value) {
                return mb_convert_encoding($value, 'SJIS-win', 'UTF-8');
            }, $row));
        }

        fclose($handle);
    };

    return response()->stream($callback, 200, $headers);
}

public function logout(Request $request)
{
    Auth::logout(); // ログイン状態を解除（認証情報を削除）

    $request->session()->invalidate(); // セッションを完全に削除してリセット
    $request->session()->regenerateToken(); // セキュリティ的に新しいCSRFトークンを発行

    return redirect()->route('login'); // ログイン画面へリダイレクト
}
}


