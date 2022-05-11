<?php

use App\Http\Controllers\admin\EstadoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\TownController;
use App\Http\Controllers\Admin\RequestoringController;
use App\Http\Controllers\admin\PersonController;
use App\Http\Controllers\admin\ProveedorController;
use App\Models\Proveedor;
use App\Http\Controllers\StateController;
use Illuminate\Routing\RouteUri;
use App\Http\Controllers\Admin\pagesController;

Route::get('', [HomeController::class, 'index'])->name('admin.home');

Route::resource('requestorings', RequestoringController::class)->names('admin.requestorings');

Route::resource('persons', PersonController::class)->names('admin.persons');

Route::resource('providers',ProveedorController::class)->names('admin.providers');

Route::resource('states',StateController::class)->names('admin.states');




/*Route::get('/towns/{id}', [StateController::class, 'getTowns']);*/

/*Route::resource('towns',TownController::class)->names('admin.towns');*/

/*Route::get('', [StateController::class, 'index'])->name('admin.state');*/

/*Route::post('/states', 'state@store')->name('states.store');*/
/*Route::get('/towns', [stateController::class, 'getTowns']);*/





