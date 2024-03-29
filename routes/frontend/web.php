<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\CheckoutController;


Route::get('/', [WelcomeController::class,'index'])->name('welcome');
Route::get('products', [WelcomeController::class,'products'])->name('frontend.product.index');
Route::get('product/{id}', [WelcomeController::class,'product'])->name('frontend.product.show');
Route::get('categories/{category}', [WelcomeController::class,'categories'])->name('frontend.categories');
Route::get('checkout',[CheckoutController::class,'index'])->name('checkout.index');
