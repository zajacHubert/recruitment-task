<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pets', [PetController::class, 'getPetsByStatus']);
Route::get('/pets/{id}', [PetController::class, 'show'])->where('id', '[0-9]+');
Route::get('/pets/{id}/edit', [PetController::class, 'edit']);
Route::get('/pets/create', [PetController::class, 'create']);
Route::post('/pets', [PetController::class, 'store'])->name('pets.store');
Route::put('/pets/{id}', [PetController::class, 'update'])->name('pets.update');
Route::delete('/pets/{id}', [PetController::class, 'destroy']);
