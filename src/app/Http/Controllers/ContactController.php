<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Models\Category;

class ContactController extends Controller
{
    // お問い合わせフォーム入力ページの表示
    public function index(Request $request)
{
    $contact = [];
    // 「修正」ボタンから戻ってきたときだけ、セッションのデータを使用する
    if ($request->session()->has('contact_back'))
    {
        $contact = $request->session()->get('contact');
        $request->session()->forget('contact_back');
    }
    else
    {
        // 初回アクセス時や通常のアクセス時には、セッションのデータをクリアする
        $request->session()->forget('contact');
    }
        // カテゴリーを取得
        $categories = Category::all();
        return view('index', compact('contact', 'categories'));
}

    // 確認ページの表示
    public function confirm(ContactRequest $request)
    {
        $validatedData = $request->validated();

        // 電話番号の取得と保存
        $validatedData['tel'] = $validatedData['phone_number'];

        // 性別のテキスト変換
        $genderTextMap = [
            1 => '男性',
            2 => '女性',
            3 => 'その他',
        ];
        $validatedData['gender_text'] = $genderTextMap[$validatedData['gender']];

        // カテゴリー名を取得
        $category = Category::find($validatedData['category_id']);
        $validatedData['category_content'] = $category ? $category->content : '';

        // 電話番号の各パートを保存
        $validatedData['phone_part1'] = $request->input('phone_part1');
        $validatedData['phone_part2'] = $request->input('phone_part2');
        $validatedData['phone_part3'] = $request->input('phone_part3');

        // セッションにデータを保存（修正用）
        $request->session()->put('contact', $validatedData);

        return view('confirm')->with('contact', $validatedData);
    }

    // データの保存とサンクスページへのリダイレクト
    public function store(Request $request)
    {
        $contactData = $request->session()->get('contact');

        // $contactData が存在しない場合のチェック
        if (!$contactData) {
        return redirect()->route('contact.index');
    }

        // 'content' を 'detail' にマッピング
        $contact = new Contact($contactData);
        $contact->save();

        // セッションのデータを削除
        $request->session()->forget('contact');

        return redirect()->route('contact.thanks');
    }

    public function process(Request $request)
{
    $action = $request->input('action');

    if ($action === 'submit') {
        // データの保存処理
        return $this->store($request);
    } elseif ($action === 'back') {
        // 修正処理
        $request->session()->put('contact_back', true);
        return redirect()->route('contact.index');
    }
}

    // サンクスページの表示
    public function thanks()
    {
        return view('thanks');
    }
}