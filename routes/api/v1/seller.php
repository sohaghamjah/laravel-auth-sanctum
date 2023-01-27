<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Seller\AuthController;

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');  
});
Route::middleware('auth:seller-api')->group(function (){
    Route::controller(AuthController::class)->group(function(){
        Route::post('/logout', 'logout');
        Route::get('/me', 'user');
    });
});