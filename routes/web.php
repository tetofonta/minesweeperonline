<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\UserController;
use \App\Http\Middleware\DBTransaction;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('html.home.welcome');
});

Route::get('/register', function () {
    if(Auth::check()) return redirect("/");
    return view('html.register.register');
})->name('register.get');
Route::post('/register', [UserController::class, 'store'])->middleware(DBTransaction::class)->name('register.post');
Route::get('/confirm/{id}', [UserController::class, 'verify'])->middleware(DBTransaction::class)->name('register.confirm');

Route::get('/login', function () {
    if(Auth::check()) return redirect("/");
    return view('html.login.login');
});
Route::post('/login', [UserController::class, 'login']);
Route::get('/logout', [UserController::class, 'logout']);

Route::get('/profile', function () {
    return view('html.profile.profile', ["page" => "profile"]);
})->middleware('auth')->name('profile.get');

Route::post('/profile-delete', [UserController::class, 'self_delete'])->middleware('auth')->middleware(DBTransaction::class);
Route::post('/chpsw', [UserController::class, 'chpsw'])->middleware('auth')->middleware(DBTransaction::class);
