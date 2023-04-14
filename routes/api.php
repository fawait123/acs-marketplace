<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ResourceController;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('unauthenticate',[AuthController::class,'unauthenticate'])->name('unauthenticate')->middleware('cors')->middleware('json.response');

Route::group(['prefix'=>'auth','middleware'=>['cors', 'json.response']],function(){
    Route::post('login',[AuthController::class,'login']);
});


// machine
Route::group(['middleware'=>['authapi:api','cors', 'json.response']],function(){
    Route::get('categories',[ResourceController::class,'categories']);
    Route::get('types',[ResourceController::class,'types']);
    Route::get('products',[ResourceController::class,'products']);
    Route::get('notifications',[ResourceController::class,'notifications']);
});

Route::group(['middleware'=>['auth.api','cors', 'json.response'],'prefix'=>'auth'],function(){
    Route::post('logout',[AuthController::class,'logout']);
});

Route::group(['middleware'=>['authapi:api','cors', 'json.response'],'prefix'=>'auth'],function(){
    Route::get('me',[AuthController::class,'me']);
});
