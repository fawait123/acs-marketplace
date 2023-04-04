<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AuthController;
use App\Helpers\Socket;

// ======================== AUTH    =========================
Route::group(['prefix'=>'auth'],function(){
    Route::get('login',[AuthController::class,'login'])->name('login');
    Route::post('login',[AuthController::class,'actionLogin'])->name('action.login');
    Route::post('register',[AuthController::class,'actionRegister'])->name('action.register');
    Route::get('register',[AuthController::class,'register'])->name('register');
    Route::post('logout',[AuthController::class,'logout'])->name('logout');
});

// ======================== HOME    =========================
Route::get('/home',[HomeController::class,'index'])->name('home')->middleware('auth');;

// ======================== notification    =========================
Route::group(['prefix'=>'notification','middleware'=>'auth'],function(){
    Route::get('show/{notification}',[NotificationController::class,'show'])->name('notification.show');
    Route::get('/',[NotificationController::class,'index'])->name('notification.index');
    Route::delete('destroy/{notification}',[NotificationController::class,'destroy'])->name('notification.destroy');
});

Route::group(['prefix'=>'market','middleware'=>'auth'],function(){
    Route::get('register',[MarketController::class,'register'])->name('market.register');
    Route::post('register',[MarketController::class,'actionRegister'])->name('market.register.action');
});


// ======================== route module core    =========================
require('module/core.php');

// ======================== market    =========================
require('module/market.php');

// ======================== frontend    =========================
require('frontend/web.php');
