<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoansController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::apiResource('categories',CategoryController::class);
Route::apiResource('books',BookController::class);
Route::group(['prefix'=>'archive/' , 'controller'=>BookController::class, ],function(){
    Route::get('{id}','archive');
    Route::get('return/{id}','return');
    });
Route::apiResource('loans',LoansController::class);
Route::apiResource('users',UserController::class);