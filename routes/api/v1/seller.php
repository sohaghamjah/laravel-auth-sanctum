<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Seller\AuthController;

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');  
});