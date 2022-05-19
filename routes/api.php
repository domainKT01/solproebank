<?php

use App\Http\Controllers\Admin\patientsController;
use App\Http\Requests\patientRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\pagesController;
use App\Http\Controllers\Admin\parameterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('pacientes', [patientsController::class, 'index'])->name('pacientes');

Route::post('pacientes', [patientsController::class, 'store'])->name('pacientes');

Route::get('parametros', [parameterController::class, 'index'])->name('parametros');

Route::post('parametros', [parameterController::class, 'store'])->name('parametros');

//Route::get('pacientes', [patientsController::class, 'show'])->name('pacientes.sow');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
