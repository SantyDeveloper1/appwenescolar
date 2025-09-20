<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\IndexController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\DocenteController;

Route::get('/', [IndexController::class, 'actionIndex']);

Route::get('/alumno', [AlumnoController::class, 'actionAlumno']);
Route::match(['get','post'],'alumno/insert', [AlumnoController::class, 'actionInsert']);
Route::post('alumno/update/{idAlumno}', [AlumnoController::class, 'actionUpdate']);
Route::delete('alumno/delete/{idAlumno}', [AlumnoController::class, 'actionDelete']);
Route::put('alumno/estado/{idAlumno}', [AlumnoController::class, 'actionEstado']);

//RUTAS PARA DOCENTE
Route::get('/docente', [DocenteController::class, 'actionDocente']);
Route::match(['get','post'],'docente/insertDocente', [DocenteController::class, 'actionInsert']);

Route::get('/', function () {
    return view('welcome');
})->name('home');
