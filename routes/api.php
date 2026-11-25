<?php

use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\CourseController;
use Illuminate\Support\Facades\Route;

// Student REST API
Route::apiResource('students', StudentController::class);

// Course REST API
Route::apiResource('courses', CourseController::class);
