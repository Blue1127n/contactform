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
Route::get('/', [ContactController::class, 'index'])->name('contact.index');
Route::post('/confirm', [ContactController::class, 'confirm'])->name('contact.confirm');
Route::post('/process', [ContactController::class, 'process'])->name('contact.process');
Route::post('/contacts', [ContactController::class, 'store'])->name('contact.store');
Route::get('/thanks', [ContactController::class, 'thanks'])->name('contact.thanks');

//会員登録・ログイン
Route::get('/register', [ContactController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [ContactController::class, 'register']);
Route::get('/login', [ContactController::class, 'showLoginForm'])->name('login');
Route::post('/login', [ContactController::class, 'login']);

//管理者画面（要ログイン）
Route::middleware(['auth'])->group(function () {
Route::get('/admin', [ContactController::class, 'adminIndex'])->name('admin.index');
Route::post('/admin/search', [ContactController::class, 'adminSearch'])->name('admin.search');
});

// 強制ログアウト
Route::get('/force-logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
});

// セッション削除（デバッグ用など）
Route::get('/clear-session', function (Request $request) {
    $request->session()->flush();
    return redirect('/');
});