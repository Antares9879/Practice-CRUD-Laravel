<?php

use App\Models\Student;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/mahasiswa', function () {

    $mahasiswa = Mahasiswa::all();

    $data = [ 'data' => $mahasiswa ];

    return response()->json( $data );
});


Route::get('/student', function () {

    $Student = Student::all();
    $data = [ 'data' => $Student ];

    return response()->json( $data );
});
