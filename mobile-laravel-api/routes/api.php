<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;

// Route::get('/test', function () {return response()->json(["message" => "Hello World"]);});

// Public routes
Route::group(['prefix'=>'/user'],function(){
    Route::post("login",[AuthController::class,'login']);
    Route::post("register",[AuthController::class,'register']);
});

// Protected routes
Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::post("/user/logout",[AuthController::class,'logout']);
    Route::resource("/blog",BlogController::class);
});