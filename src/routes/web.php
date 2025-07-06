<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//一般ユーザー向け 画面（お問い合わせ）
Route::get('/', [ContactController::class, 'index'])->name('contact.index');/// にアクセスしたらお問い合わせ入力画面（index.blade.php）表示
Route::post('/confirm', [ContactController::class, 'confirm'])->name('contact.confirm');//入力ページの「確認」ボタンを押したとき、POSTで送信されるルート入力値をバリデーションして、確認画面に進む
Route::post('/process', [ContactController::class, 'process'])->name('contact.process');//確認画面で「送信」or「修正」ボタンを押したときにアクセスされる。送信 → DBに保存して thanks ページへ。修正 → 入力画面に戻る。
Route::post('/contacts', [ContactController::class, 'store'])->name('contact.store');//データ保存（単体では使ってないけど、processから呼ばれる）実質的に process() メソッドから呼ばれる。session にあるデータを contacts テーブルに保存。
Route::get('/thanks', [ContactController::class, 'thanks'])->name('contact.thanks');//お問い合わせが完了した後に表示される「送信ありがとうございました」のページ。GET アクセスOK。

//会員登録・ログイン
Route::get('/register', [ContactController::class, 'showRegisterForm'])->name('register');//登録画面を表示するルート。登録画面 register.blade.php を表示する。
Route::post('/register', [ContactController::class, 'register']);//登録フォームから送信された内容を受け取り、ユーザーをDBに保存する。バリデーションは RegisterRequest を使う。
Route::get('/login', [ContactController::class, 'showLoginForm'])->name('login');//ログイン画面を表示するルート。
Route::post('/login', [ContactController::class, 'login']);//入力されたログイン情報を元に認証する。成功 → 管理画面 /admin へリダイレクト。失敗 → エラーメッセージと一緒にログイン画面に戻る。
Route::get('/logout', [ContactController::class, 'logout'])->name('logout');

//管理者画面（要ログイン）
Route::middleware(['auth'])->group(function () {
Route::get('/admin', [ContactController::class, 'adminIndex'])->name('admin.index');//管理画面トップ（GET）※ログイン必須。管理画面の一覧ページを表示。
Route::get('/admin/search', [ContactController::class, 'adminSearch'])->name('admin.search');// 検索機能（POST）※ログイン必須。管理画面で名前や性別などを入力して検索すると、このルートが呼ばれて一覧が更新される。
Route::delete('/admin/delete/{id}', [ContactController::class, 'delete'])->name('admin.delete');
Route::get('/admin/export', [ContactController::class, 'export'])->name('admin.export');
});

// 強制ログアウト
Route::get('/force-logout', function (Request $request) {
    Auth::logout();//// 強制ログアウト（GET）→ ログアウトしてトップに戻る。ログイン状態を強制的に解除するルート。セッションを初期化して /（入力ページ）へ戻す。
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
});

// セッション削除（GET）→ デバッグ用。セッション（formの入力内容など）を全て削除してトップページへ戻す。
Route::get('/clear-session', function (Request $request) {
    $request->session()->flush();
    return redirect('/');
});

