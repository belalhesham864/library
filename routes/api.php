<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\password\ForegetPasswordController;
use App\Http\Controllers\Auth\password\ResetPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerifayEmailController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;

use App\Http\Controllers\LoansController;
use App\Http\Controllers\User\UserCategoryController;
use App\Http\Controllers\User\UserLoanController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('auth/register', [RegisterController::class, 'register']);
Route::group(['prefix' => 'auth/', 'controller' => LoginController::class,], function () {
    Route::post('login', 'login');
    Route::delete('logout', 'logout')->middleware('auth:sanctum');
});
Route::group(['prefix' => 'auth/email/verifay', 'controller' => VerifayEmailController::class, 'middleware' => 'auth:sanctum'], function () {
    Route::post('/', 'verifay');
    Route::get('/sendotp', 'sendOtAgain');
});
Route::group(['prefix' => 'auth/', 'controller' => ForegetPasswordController::class,], function () {

    Route::post('forget-Password',  'forgetPassword');
    Route::post('check-Otp',  'checkOtp');
});

Route::post('auth/reset-password', [ResetPasswordController::class, 'reset']);



Route::apiResource('categories', CategoryController::class);
Route::apiResource('books', BookController::class);
Route::group(['prefix' => 'archive/', 'controller' => BookController::class,], function () {
    Route::get('{id}', 'archive');
    Route::get('return/{id}', 'return');
});
Route::apiResource('loans', LoansController::class);
     

Route::middleware('auth:sanctum')->prefix('user')->group(function () {
    Route::get('/profile',    [UserController::class, 'show']);
    Route::put('/profile',    [UserController::class, 'update']);
    Route::delete('/profile', [UserController::class, 'destroy']);



     Route::get('/loans',[UserLoanController::class, 'index']);
       Route::post('/loans',    [UserLoanController::class, 'store']);
             Route::put('/loans/{id}/return',   [UserLoanController::class, 'return']);

});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('categories',       [UserCategoryController::class, 'index']);
    Route::get('categories/{id}',  [UserCategoryController::class, 'show']);
});
