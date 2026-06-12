<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\password\ForegetPasswordController;
use App\Http\Controllers\Auth\password\ResetPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerifayEmailController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\CategoryController;

use App\Http\Controllers\Admin\LoansController;
use App\Http\Controllers\User\ReviewController;
use App\Http\Controllers\User\UserBookController;
use App\Http\Controllers\User\UserCategoryController;
use App\Http\Controllers\User\UserLoanController;
use App\Http\Controllers\User\UserProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\User\SearchBookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



 Route::get('/me', function(){
            return apiResponse(200,'Success',auth()->user());
        })->middleware('auth:api');

/////////////////////////// Authontaction/////////////////////
Route::prefix('auth')->group(function () {
    Route::post('/register', [RegisterController::class, 'register'])
    // ->middleware('throttle:register')
    ;
    Route::controller(LoginController::class)->group(function () {
        Route::post('/login', 'login')
        // ->middleware('throttle:login')
        ;
       
        Route::delete('/logout', 'logout')->middleware('auth:api');
    });

    Route::middleware('auth:api')->prefix('email/verifay')->controller(VerifayEmailController::class)->group(function () {
        Route::post('/', 'verifay');
        Route::get('/sendotp', 'sendOtAgain');
    });

    Route::controller(ForegetPasswordController::class)->group(function () {
        Route::post('/forget-Password', 'forgetPassword');
        Route::post('/check-Otp', 'checkOtp');
    });

    Route::post('/reset-password', [ResetPasswordController::class, 'reset']);
});






////////////////////// Admin /////////////////////////////////

Route::prefix('admin/')->group(function () {



    Route::apiResource('categories', CategoryController::class);

    Route::apiResource('books', BookController::class);
    Route::group(['prefix' => 'archive/', 'controller' => BookController::class,], function () {
        Route::get('{id}', 'archive');
        Route::get('return/{id}', 'return');
    });
    Route::apiResource('loans', LoansController::class);
    Route::apiResource('users', UserController::class);
});














///////////////////////////////////// User ///////////////////////

Route::middleware('auth:api')->group(function () {
    Route::prefix('user')->group(function () {
        Route::controller(UserProfileController::class)->group(function () {
            Route::get('/profile', 'show');
            Route::post('/profile', 'update');
            Route::delete('/profile', 'destroy');
        });
        Route::controller(UserLoanController::class)->group(function () {
            Route::get('/loans', 'index');
            Route::post('/loans', 'store')
            ->middleware('throttle:loans');
            Route::put('/loans/{id}/return', 'return');
            Route::get('/download/{id}', 'download');
            Route::get('/reseve/{id}', 'reseve');
            Route::get('/cancelreseve/{id}', 'cancelreseve');
            
        });
        Route::post('search',[SearchBookController::class,'search']);
        Route::post('review',[ReviewController::class,'review']);
    });
    Route::controller(UserCategoryController::class)->group(function () {
        Route::get('categories', 'index');
        Route::get('categories/{id}', 'show');
    });
    Route::controller(UserBookController::class)->group(function () {
        Route::get('books', 'index');
        Route::get('books/{id}', 'show')->name('books.show');
    });
});
