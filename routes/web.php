<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Core\UserController;
use App\Http\Controllers\Core\RoleController;
use App\Helpers\Socket;

Route::get('/', function () {
    return view('welcome');
});

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


Route::group(['prefix'=>'core','middleware'=>'auth'],function(){
    Route::post('user/status/{user}',[UserController::class,'status'])->name('user.status');
    Route::get('user/json',[UserController::class,'json'])->name('user.json')->middleware('permission:user');
    Route::get('role/json',[RoleController::class,'json'])->name('role.json')->middleware('permission:role');
    Route::get('role/permission/{id}',[RoleController::class,'permission'])->name('role.permission')->middleware('permission:role');
    Route::get('role/permission',[RoleController::class,'permissionSync'])->name('role.permission.sync')->middleware('permission:role');
    Route::resource('user',UserController::class)->middleware('permission:user');
    Route::resource('role',RoleController::class)->middleware('permission:role');
});

Route::group(['prefix'=>'notification','middleware'=>'auth'],function(){
    Route::get('show/{notification}',[NotificationController::class,'show'])->name('notification.show');
    Route::get('/',[NotificationController::class,'index'])->name('notification.index');
    Route::delete('destroy/{notification}',[NotificationController::class,'destroy'])->name('notification.destroy');
});
