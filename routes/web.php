<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    return redirect('students');
});

Route::get ('/students', [StudentController::class, 'index'])
    ->name('students.index');

Route::get ('/students/add', [StudentController::class, 'create'])
    ->name('students.create');
Route::post('/students', [StudentController::class, 'store'])
    ->name('students.store');

Route::get ('/students/{id}', [StudentController::class, 'show'])
    ->name('students.show');

Route::get ('/students/edit/{id}', [StudentController::class, 'edit'])
    ->name('students.edit');
Route::put ('/students/edit/{id}', [StudentController::class, 'update'])
    ->name('students.update');

Route::delete('/students/{id}', [StudentController::class, 'destroy'])
    ->name('students.destroy');