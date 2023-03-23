<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Core\UserController;
use App\Http\Controllers\Core\RoleController;

Route::get('/', function () {
    return view('welcome');
});

// ======================== AUTH    =========================
Route::group(['prefix'=>'auth'],function(){
    Route::get('login',[AuthController::class,'login'])->name('login');
    Route::post('login',[AuthController::class,'actionLogin'])->name('action.login');
    Route::get('register',[AuthController::class,'register'])->name('register');
    Route::post('logout',[AuthController::class,'logout'])->name('logout');
});

// ======================== HOME    =========================
Route::get('/home',[HomeController::class,'index'])->name('home')->middleware('auth');;


Route::group(['prefix'=>'core','middleware'=>'auth'],function(){
    Route::get('user/json',[UserController::class,'json'])->name('user.json');
    Route::get('role/json',[RoleController::class,'json'])->name('role.json');
    Route::get('role/permission/{id}',[RoleController::class,'permission'])->name('role.permission');
    Route::get('role/permission',[RoleController::class,'permissionSync'])->name('role.permission.sync');
    Route::resource('user',UserController::class);
    Route::resource('role',RoleController::class);
});
