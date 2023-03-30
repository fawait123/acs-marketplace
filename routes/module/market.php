<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Market\MarketController;


Route::group(['prefix'=>'market','middleware'=>'market'],function(){
    Route::get('/',[MarketController::class,'index'])->name('market.index');
});
