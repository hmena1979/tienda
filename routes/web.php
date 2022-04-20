<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});


// Auth::routes();

Route::get('/login','ConnectController@getLogin')->name('login');
Route::post('/login','ConnectController@postLogin')->name('login');
Route::get('/registerate','ConnectController@getRegister')->name('resgisterate');
Route::post('/registerate','ConnectController@postRegister')->name('resgisterate');
Route::get('/logout','ConnectController@getLogout')->name('logout');
Route::post('/logout','ConnectController@getLogout')->name('logout');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
