<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FacultyDepartmentController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;
// Protected routes with Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('faculty-departments', FacultyDepartmentController::class);
    Route::apiResource('students', StudentController::class);
    Route::apiResource('supervisors', SupervisorController::class);
    Route::apiResource('projects', ProjectController::class);

    Route::post('students/{student}/update-image', [StudentController::class, 'updateImage']);
    Route::post('supervisors/{supervisor}/update-image', [SupervisorController::class, 'updateImage']);

    Route::post('projects/{project}/update-poster', [ProjectController::class, 'updatePoster']);
    Route::post('projects/{project}/update-thesis', [ProjectController::class, 'updateThesis']);
    Route::post('projects/{project}/update-video', [ProjectController::class, 'updateVideo']);

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Public route
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Publicly accessible: index and show for each resource
Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{category}', [CategoryController::class, 'show']);

Route::get('faculty-departments', [FacultyDepartmentController::class, 'index']);
Route::get('faculty-departments/{faculty_department}', [FacultyDepartmentController::class, 'show']);

Route::get('students', [StudentController::class, 'index']);
Route::get('students/{student}', [StudentController::class, 'show']);

Route::get('supervisors', [SupervisorController::class, 'index']);
Route::get('supervisors/{supervisor}', [SupervisorController::class, 'show']);

Route::get('projects', [ProjectController::class, 'index']);
Route::get('home', [ProjectController::class, 'home']);
Route::get('projects/{project}', [ProjectController::class, 'show']);
