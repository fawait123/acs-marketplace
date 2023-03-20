<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Core\UserController;

Route::get('/', function () {
    return view('welcome');
});

// ======================== HOME    =========================
Route::get('/home',[HomeController::class,'index'])->name('home');


Route::group(['prefix'=>'core'],function(){
    Route::resource('user',UserController::class);
});
