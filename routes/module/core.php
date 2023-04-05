<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Core\RoleController;
use App\Http\Controllers\Core\MarketController as AdminMarketController;
use App\Http\Controllers\Core\UserController;
use App\Http\Controllers\Core\TypeController;
use App\Http\Controllers\Core\MachineController;
use App\Http\Controllers\Core\CustomerController;

// route setting
Route::group(['prefix'=>'core','middleware'=>'auth'],function(){
    Route::post('user/status/{user}',[UserController::class,'status'])->name('user.status');
    Route::get('user/json',[UserController::class,'json'])->name('user.json')->middleware('permission:user');
    Route::get('role/json',[RoleController::class,'json'])->name('role.json')->middleware('permission:role');
    Route::get('role/permission/{id}',[RoleController::class,'permission'])->name('role.permission')->middleware('permission:role');
    Route::get('role/permission',[RoleController::class,'permissionSync'])->name('role.permission.sync')->middleware('permission:role');
    Route::resource('user',UserController::class)->middleware('permission:user');
    Route::resource('role',RoleController::class)->middleware('permission:role');
    Route::get('market',[AdminMarketController::class,'index'])->name('core.market.index');
    Route::get('market/json',[AdminMarketController::class,'json'])->name('core.market.json');
    Route::post('market/status/{market}',[AdminMarketController::class,'status'])->name('core.market.status');
    Route::get('market/show/{market}',[AdminMarketController::class,'show'])->name('core.market.show');
});


// route master data
Route::group(['prefix'=>'core','middleware'=>'auth'],function(){
    Route::get('machine/removeImage',[MachineController::class,'removeImage'])->name('machine.remove.image');
    Route::get('type/json',[TypeController::class,'json'])->name('type.json')->middleware('permission:type');
    Route::get('machine/json',[MachineController::class,'json'])->name('machine.json')->middleware('permission:machine');
    Route::get('customer/json',[CustomerController::class,'json'])->name('customer.json')->middleware('permission:customer');
    Route::post('customer/status/{customer}',[CustomerController::class,'status'])->name('customer.status')->middleware('permission:customer');
    Route::get('customer/remove-image',[CustomerController::class,'removeImage'])->name('customer.remove.image')->middleware('permission:customer');
    Route::resource('type',TypeController::class)->middleware('permission:type');
    Route::resource('machine',MachineController::class)->middleware('permission:machine');
    Route::resource('customer',CustomerController::class)->middleware('permission:customer');
});
