<?php

use App\Http\Controllers\Api\User\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/register', 'register');    
});
Route::middleware('auth:sanctum')->group(function (){

    Route::controller(AuthController::class)->group(function(){
        Route::post('/logout', 'logout');
        Route::get('/user', 'user');
    });
});
