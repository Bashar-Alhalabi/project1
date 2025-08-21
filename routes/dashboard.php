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
use App\Http\Controllers\Api\V1\Dashboard\SupervisorController as  DashboardSupervisorController ;
use App\Http\Controllers\Api\V1\Dashboard\SearchController as  DashboardSearchController ;
use App\Http\Controllers\TeacherController  as DashboardTeacherController;
use App\Http\Controllers\SessionYearController;
use App\Http\Controllers\Api\v1\Dashboard\SemesterController as DashboardSemesterController;
use App\Http\Controllers\Api\v1\Dashboard\YearController as DashboardYearController;
use App\Http\Controllers\Api\v1\Dashboard\EventsController as DashboardEventsController;
use App\Http\Controllers\Api\v1\Dashboard\LoginStudentController as DashboardLoginStudentController;


Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['api', 'localize'],
], function () {
    Route::post('v1/dashboard/forgot-password', [DashboardAuthController::class, 'sendPasswordResetLink']);
    Route::post('v1/dashboard/reset-password', [DashboardAuthController::class, 'resetPassword']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('v1/dashboard/logout', [DashboardAuthController::class, 'logout']);
    });

    Route::post('v1/dashboard/login', [DashboardAuthController::class, 'login'])
        ->name('dashboard.login');

});

Route::prefix('v1/dashboard')->middleware('auth:sanctum')->group(function () {
      Route::get('/home', [DashboardHomeController::class, 'index']);
      Route::apiResource('/student', StudentController::class);
      Route::apiResource('/teacher', TeacherController::class);
      Route::apiResource('/supervisor',  DashboardSupervisorController::class);
      Route::post('/search', [ DashboardSearchController::class, 'search']);
      Route::get('/semester', [DashboardSemesterController::class, 'index']);
      Route::post('/semester', [DashboardSemesterController::class, 'store']); 
      Route::post('/years', [DashboardYearController::class, 'store']); 
      Route::post('/events', [DashboardEventsController::class, 'store']);
     Route::get('/get-stages', [DashboardLoginStudentController::class, 'index']);
   
    });


