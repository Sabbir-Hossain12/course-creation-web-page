<?php

use App\Http\Controllers\Course\CourseController;
use Illuminate\Support\Facades\Route;

Route::view('/','pages.index');

Route::resource('/courses', CourseController::class)->names('course');
