<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['prefix'=>'admin','middleware'=>['api','checkPassword']],function()
{
     Route::post('/login',[AuthController::class,'login']);
     Route::post('/profile',[AdminController::class,'profile_data'])->middleware('auth.guard:admin-api');
     Route::post('/logout',[AuthController::class,'logout'])->middleware('auth.guard:admin-api');
     Route::group(['prefix'=>'location','middleware'=>'auth.guard:admin-api'],function()
     {
        Route::post('/insert',[LocationController::class,'insert']);
        Route::post('/show',[LocationController::class,'show']);
        Route::post('/delete',[LocationController::class,'delete']);
     });
     Route::group(['prefix'=>'notification','middleware'=>'auth.guard:admin-api'],function()
     {
        Route::post('/insert',[NotificationController::class,'insert']);
        Route::post('/show',[NotificationController::class,'show']);
        Route::post('/delete',[NotificationController::class,'delete']);
     });
     Route::group(['prefix'=>'user','middleware'=>'auth.guard:admin-api'],function()
     {
        Route::post('/show',[UserController::class,'show']);
        Route::post('/delete',[UserController::class,'delete']);
     });
});

