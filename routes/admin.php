<?php

use App\Http\Controllers\admin\EstadoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\admin\MunicipioController;
use App\Http\Controllers\Admin\RequestoringController;
use App\Http\Controllers\admin\PersonController;
use App\Http\Controllers\admin\ProveedorController;
use App\Models\Proveedor;

Route::get('', [HomeController::class, 'index'])->name('admin.home');

Route::resource('requestorings', RequestoringController::class)->names('admin.requestorings');

Route::resource('persons', PersonController::class)->names('admin.persons');

Route::resource('providers',ProveedorController::class)->names('admin.providers');

Route::resource('states',EstadoController::class)->names('admin.states');

Route::resource('municipios',MunicipioController::class)->names('admin.municipios');