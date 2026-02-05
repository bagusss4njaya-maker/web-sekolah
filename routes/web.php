<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\GradeController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\SchoolClassController;
use App\Http\Controllers\Guru\GradeController as GuruGradeController;

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Change Password Routes
Route::middleware('auth')->group(function () {
    Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('password.update');
});

// Dashboard Routes (Protected by auth middleware)
Route::middleware('auth')->group(function () {
    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');
        Route::resource('students', StudentController::class);
        Route::post('students/{student}/reset-password', [StudentController::class, 'resetPassword'])->name('students.reset-password');
        Route::resource('teachers', TeacherController::class);
        Route::post('teachers/{teacher}/reset-password', [TeacherController::class, 'resetPassword'])->name('teachers.reset-password');
        Route::resource('schedules', ScheduleController::class);
        Route::resource('grades', GradeController::class);
        Route::resource('subjects', SubjectController::class);
        Route::resource('school_classes', SchoolClassController::class);
    });

    // Guru Routes
    Route::prefix('guru')->name('guru.')->group(function () {
        Route::get('/', [GuruController::class, 'index'])->name('dashboard');
        Route::resource('grades', GuruGradeController::class);
    });

    // Siswa Routes
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.dashboard');
});
