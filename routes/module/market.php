<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Market\MarketController;
use App\Http\Controllers\Market\AssetController;


Route::group(['prefix'=>'market','middleware'=>['market','auth']],function(){
    Route::get('/',[MarketController::class,'index'])->name('market.index')->middleware('permission:market');
    Route::get('asset/json',[AssetController::class,'json'])->name('asset.json')->middleware('permission:asset');
    Route::resource('asset',AssetController::class)->middleware('permission:asset');
});
