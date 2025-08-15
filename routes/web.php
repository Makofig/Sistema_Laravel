<?php

use Illuminate\Support\Facades\Route;

// Import controladores 
use App\Http\Controllers\clientController; 
use App\Http\Controllers\contractController;
use App\Http\Controllers\access_pointController;
use App\Http\Controllers\quotaController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/clients', [clientController::class, 'index'])->name('clients');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/clients/create', [clientController::class, 'create'])->name('clients.create');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::post('/clients/store', [clientController::class, 'store'])->name('clients.store');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/access-point', [access_pointController::class, 'index'])->name('access-point');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/contracts', [contractController::class, 'index'])->name('contracts');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/quota', [quotaController::class, 'index'])->name('quota');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/clients/debtors', [clientController::class, 'debtors'])->name('debtors');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/statistics', function () {
        return view('statistics');
    })->name('statistics');
});