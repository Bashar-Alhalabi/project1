<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Mobile\AuthController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Api\V1\Dashboard\AuthController as DashboardAuthController;
use App\Http\Controllers\Api\V1\Dashboard\HomeController as DashboardHomeController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['api', 'localize'],
], function () {
    Route::get('v1/test', function () {
        return response()->json(['message' => app()->getLocale(),]);
    });
    Route::post('v1/mobile/login', [AuthController::class, 'login'])
        ->name('mobile.login');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['api', 'localize'], 
], function () {
    Route::post('v1/dashboard/forgot-password', [DashboardAuthController::class, 'sendPasswordResetLink']);
    Route::post('v1/dashboard/reset-password', [DashboardAuthController::class, 'resetPassword']);
    
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('v1/dashboard/logout', [DashboardAuthController::class, 'logout']);
    });
    Route::post('v1/dashboard/login', [DashboardAuthController::class, 'login'])
        ->name('dashboard.login');

});

Route::prefix('v1/dashboard')->group(function () {
    Route::get('/home', [DashboardHomeController::class, 'index']);
});
