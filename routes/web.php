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

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/searchgame', [App\Http\Controllers\GameController::class, 'search'])->name('search');
Route::get('/yourgames', [App\Http\Controllers\YourgameController::class, 'index'])->name('yourgame');
Route::get('/creategame', [App\Http\Controllers\GameController::class, 'create'])->name('creategame');
Route::post('/uploadgame', [App\Http\Controllers\GameController::class, 'store'])->name('gamestore');
Route::post('/cancelgame', [App\Http\Controllers\GameController::class, 'destroy'])->name('cancelgame');
Route::post('/acceptgame', [App\Http\Controllers\GameController::class, 'update'])->name('acceptgame');
Route::post('/updategame', [App\Http\Controllers\GameController::class, 'updatepage'])->name('updategame');
Route::post('/savescore', [App\Http\Controllers\GameController::class, 'updatescore'])->name('saveupdategame');
Route::post('/followgame', [App\Http\Controllers\GameController::class, 'followgame'])->name('followgame');
Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('users');
Route::post('/useredit', [App\Http\Controllers\AdminController::class, 'update'])->name('useredit');
Route::post('/saveuser', [App\Http\Controllers\AdminController::class, 'storeupdate'])->name('userstore');
Route::post('/admin', [App\Http\Controllers\AdminController::class, 'destroy'])->name('destroy');
Route::get('/settings', [App\Http\Controllers\SettingsController::class, 'index'])->name('usersettings');
Route::post('/savesettings', [App\Http\Controllers\SettingsController::class, 'update'])->name('userupdatesettings');
