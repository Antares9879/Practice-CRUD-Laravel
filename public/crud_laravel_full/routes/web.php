<?php


use Illuminate\Support\Facades\Route;

// Include Student Controller
use App\Http\Controllers\StudentController;

use App\Http\Controllers\MahasiswaController;

use App\Http\Controllers\AuthController;


Route::get('/', function () {
    redirect('/student');
})
    ->name('student.create')->middleware('admin.guard');

Route::get('/student/add', [StudentController::class, 'create'])
    ->name('student.create')->middleware('admin.guard');

// Routing untuk Proses Logout
Route::post('/logout', [AuthController::class, 'proses_logout'])
    ->name('logout')->middleware('admin.guard');

Route::get('/student/edit/{id}', [StudentController::class, 'edit'])
    ->name('student.edit')->middleware('admin.guard');
Route::PUT('/student/edit/{id}', [StudentController::class, 'update'])
    ->name('student.update')->middleware('admin.guard');

Route::DELETE('/student/delete/{id}', [StudentController::class, 'destroy'])
    ->name('student.destroy')->middleware('admin.guard');

Route::get('/student/download/{id}', [StudentController::class, 'download'])
    ->name('student.download')->middleware('admin.guard');
Route::get('/student/preview/{id}', [StudentController::class, 'preview'])
    ->name('student.preview')->middleware('admin.guard');


Route::get('/student', [StudentController::class, 'index'])
    ->name('student.index')->middleware('admin.guard');

Route::POST('/student/add', [StudentController::class, 'store'])
    ->name('student.store')->middleware('admin.guard');

// Route Baru
Route::get('/student/pdf', [StudentController::class, 'pdf'])
    ->name('student.pdf')->middleware('admin.guard');


Route::get('/student/edit/{id}', [StudentController::class, 'edit'])
    ->name('student.edit')->middleware('admin.guard');
Route::PUT('/student/edit/{id}', [StudentController::class, 'update'])
    ->name('student.update')->middleware('admin.guard');

Route::DELETE('/student/delete/{id}', [StudentController::class, 'destroy'])
    ->name('student.destroy')->middleware('admin.guard');

Route::get('/student/download/{id}', [StudentController::class, 'download'])
    ->name('student.download')->middleware('admin.guard');
Route::get('/student/preview/{id}', [StudentController::class, 'preview'])
    ->name('student.preview')->middleware('admin.guard');


// Routing untuk Halaman Register
Route::get('/register', [AuthController::class, 'halaman_register'])
    ->name('register.index')->middleware('guest');

// Routing untuk Proses Register
Route::post('/register', [AuthController::class, 'proses_register'])
    ->name('register.process')->middleware('guest');

// Routing untuk Halaman Login
Route::get('/login', [AuthController::class, 'halaman_login'])
    ->name('login');

// Routing untuk Proses Login
Route::post('/login', [AuthController::class, 'proses_login'])
    ->name('login.process')->middleware('guest');
