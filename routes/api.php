<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Mobile\AuthController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


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
