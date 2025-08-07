<?php

use App\Http\Controllers\Api\V1\Mobile\Student\StudentCallController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Mobile\Auth\AuthController as AuthController;
use App\Http\Controllers\Api\V1\Mobile\Teacher\TeacherCallController;
use App\Http\Controllers\Api\V1\Mobile\Teacher\TeacherHomeController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Api\V1\Dashboard\AuthController as DashboardAuthController;
use App\Http\Controllers\Api\V1\Dashboard\HomeController as DashboardHomeController;
use App\Http\Controllers\Api\V1\Mobile\Teacher\TeacherStudentsController;
use App\Http\Controllers\Api\V1\Mobile\Teacher\TeacherScheduleController;
use App\Http\Controllers\Api\V1\Mobile\Teacher\TeacherNoteController;
use App\Http\Controllers\Api\V1\Mobile\Teacher\TeacherFinanceController;
use App\Http\Controllers\Api\V1\Mobile\Teacher\TeacherDictationController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['api', 'localize'],
], function () {
    Route::post('v1/mobile/login', [AuthController::class, 'login'])
        ->name('login');
    Route::group([
        'prefix' => 'v1/mobile/teacher',
        'middleware' => ['auth:sanctum', 'IsTeacher'],
    ], function () {
        Route::get('home', [TeacherHomeController::class, 'index']);
        Route::get('students', [TeacherStudentsController::class, 'index']);
        Route::get('weekly-schedule', [TeacherScheduleController::class, 'weekly']);
        Route::post('call', [TeacherCallController::class, 'store']);
        Route::post('call/{call}/end', [TeacherCallController::class, 'end']);
        Route::post('notes/create', [TeacherNoteController::class, 'store']);
        Route::post('dictations/create', [TeacherDictationController::class, 'store']);
        Route::get('money-info', [TeacherFinanceController::class, 'moneyInfo']);

    });
    Route::group([
        'prefix' => 'v1/mobile/teacher',
        'middleware' => ['auth:sanctum', 'IsStudent'],
    ], function () {
        Route::post('call/join', [StudentCallController::class, 'join']);
    });
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