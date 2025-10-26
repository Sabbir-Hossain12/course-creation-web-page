<?php

use App\Http\Controllers\Course\CourseController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/courses', CourseController::class);
