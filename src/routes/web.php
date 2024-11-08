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

Route::get('/', [ContactController::class, 'index'])->name('contact.index');
Route::post('/confirm', [ContactController::class, 'confirm'])->name('contact.confirm');
Route::post('/contacts', [ContactController::class, 'store'])->name('contact.store');
Route::get('/thanks', [ContactController::class, 'thanks'])->name('contact.thanks');
Route::post('/process', [ContactController::class, 'process'])->name('contact.process');
Route::post('/register', [ContactController::class, 'register'])->name('register.post');
Route::get('/login', [ContactController::class, 'showLoginForm'])->name('login');
Route::post('/login', [ContactController::class, 'login']);
Route::get('/force-logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
});

Route::get('/clear-session', function (Request $request) {
    $request->session()->flush();
    return redirect('/');
});