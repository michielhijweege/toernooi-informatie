<?php

use Illuminate\Support\Facades\Route;

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
/*
Route::get('/', function () {
    return view('home');
});

Route::get('/welcome', function () {
    return view('welcome');
});*/

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/game', [App\Http\Controllers\GameController::class, 'index'])->name('game');
Route::get('/yourgames', [App\Http\Controllers\YourgameController::class, 'index'])->name('yourgame');
Route::get('/creategame', [App\Http\Controllers\GameController::class, 'create'])->name('creategame');
Route::post('/uploadgame', [App\Http\Controllers\GameController::class, 'store'])->name('gamestore');
Route::post('/cancelgame', [App\Http\Controllers\GameController::class, 'destroy'])->name('cancelgame');
Route::post('/acceptgame', [App\Http\Controllers\GameController::class, 'update'])->name('acceptgame');
Route::get('/searchgame', [App\Http\Controllers\GameController::class, 'search'])->name('search');
