<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Mobile\AuthController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Api\V1\Dashboard\AuthController as DashboardAuthController;
use App\Http\Controllers\Api\V1\Dashboard\HomeController as DashboardHomeController;
use App\Http\Controllers\Api\V1\Dashboard\StudentController as DashboardStudentController;
use App\Http\Controllers\Api\V1\Dashboard\StudentController;
use App\Http\Controllers\Api\V1\Dashboard\TeacherController;
use App\Http\Controllers\Api\V1\Dashboard\SupervisorController as SupervisorController ;
use App\Http\Controllers\Api\V1\Dashboard\SearchController as SearchController ;
use App\Http\Controllers\TeacherController  as DashboardTeacherController;
use App\Http\Controllers\SessionYearController;
use App\Http\Controllers\Api\v1\Dashboard\SemesterController as DashboardSemesterController;
use App\Http\Controllers\Api\v1\Dashboard\YearController as DashboardYearController;
use App\Http\Controllers\Api\v1\Dashboard\EventsController as DashboardEventsController;
use App\Http\Controllers\Api\v1\Dashboard\LoginStudentController as DashboardLoginStudentController ;

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