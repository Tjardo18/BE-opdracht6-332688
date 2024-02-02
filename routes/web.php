<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OverzichtController;
use App\Http\Controllers\AllergeenController;
use App\Http\Controllers\LeverancierController;

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

Route::get('/overzicht', [OverzichtController::class, 'index',])->name('overzicht.index');

Route::get('/allergie/{id}', [AllergeenController::class, 'index',])->name('allergie.index');

Route::get('/leverancier/{id}', [LeverancierController::class, 'index'])->name('leverancier.index');
