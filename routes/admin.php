<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\RequestoringController;

Route::get('', [HomeController::class, 'index'])->name('admin.home');
Route::resource('requestorings', RequestoringController::class)->names('admin.requestorings');
