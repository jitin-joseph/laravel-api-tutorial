<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Login
Route::post('/login', [AuthController::class, 'login']);
//Show Categories
Route::get('categories', [\App\Http\Controllers\Api\CategoryController::class, 'index'])->middleware('auth:sanctum'); 


