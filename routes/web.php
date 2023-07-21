<?php

use App\Http\Controllers\GameController;
use App\Http\Middleware\InGame;
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

//Route::get('/profile', function () {
//    return view('html.profile.profile', ["page" => "profile"]);
//})->middleware('auth')->name('profile.get');
Route::get('/profile/{username}', [UserController::class, 'show'])->name('profile');

Route::post('/profile-delete', [UserController::class, 'self_delete'])->middleware('auth')->middleware(DBTransaction::class);
Route::post('/chpsw', [UserController::class, 'chpsw'])->middleware('auth')->middleware(DBTransaction::class);
Route::post('/chimg', [UserController::class, 'chimg'])->middleware('auth');

Route::post('/game/new', [GameController::class, 'newGame'])->middleware('auth')->middleware(DBTransaction::class);
Route::get('/game', [GameController::class, 'getGame'])->middleware('auth')->middleware(InGame::class);

Route::get('/standings/{type}', [GameController::class, 'getStandings'])->name('standings');

//should be an api
Route::get('/api/game/state', [GameController::class, "api_get_game_state"])->middleware('auth')->middleware(InGame::class);
Route::get('/api/game/update/{x}/{y}', [GameController::class, "api_update_game_state"])->middleware('auth')->middleware(DBTransaction::class)->middleware(InGame::class);
Route::post('/api/game/surrender', [GameController::class, "api_surrender"])->middleware(DBTransaction::class)->middleware(InGame::class);
