<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;

// Welcome Page
Route::get('/', function () {
    return view('welcome');
});

// Student CRUD Routes
Route::resource('students', StudentController::class);

// Course CRUD Routes
Route::resource('courses', CourseController::class);
