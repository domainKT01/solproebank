<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\pagesController;

use App\Http\Controllers\Admin\patientController;

use App\Http\Controllers\Admin\formController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('parametros', [pagesController::class, 'compare'])->name('parametros');

Route::get('pacientes', [pagesController::class, 'patients'])->name('pacientes');

Route::post('forms', [formController::class, 'store'])->name('forms');

Route::post('patientForms', [patientController::class, 'store'])->name('patientForms');