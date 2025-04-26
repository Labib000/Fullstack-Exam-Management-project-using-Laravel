<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;



Route::get('/admin/form', [StudentController::class, 'create'])->name('students.create');
Route::post('student/store', [StudentController::class, 'store'])->name('students.store');
Route::get('student/table', [StudentController::class, 'table']);
Route::get('/student/edit/{id}', [StudentController::class, 'edit']);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/table', function(){

        return view('admin.table');
    });

    Route::get('/admin/login', function () {
        return view('admin.admin-login');
    });
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });

    Route::get('/student/login', function () {
        return view('user.student-login');
    });
    Route::get('/student/dashboard', function () {
        return view('user.student-dashboard');
    });

    Route::get('/moderator/login', function () {
        return view('moderators.moderator-login');
    });
    
    Route::get('/moderator/dashboard', function () {
        return view('moderators.moderator-dashboard');
    });
    
