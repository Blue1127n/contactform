<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


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

    public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);
        if (Auth::attempt($credentials)) {

        $request->session()->regenerate();
            return redirect()->intended('/admin');

            return back()->withErrors([
                'email' => '提供された資格情報は記録と一致しません',
            ])->withInput($request->only('email'));
        }
    }
        public function register(RegisterRequest $request)
{
            // $validatedData = $request->validate([
            //     'name' => 'required|string|max:255',
            //     'email' => 'required|email|max:255|unique:users,email',
            //     'password' => 'required|string|max:255',
            // ]);

            User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
            ]);

            return redirect()->route('login')->with('success', '登録が完了しました');
}
}


