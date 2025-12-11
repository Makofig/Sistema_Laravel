<?php

use Illuminate\Support\Facades\Route;

// Import controladores 
use App\Http\Controllers\clientController; 
use App\Http\Controllers\contractController;
use App\Http\Controllers\access_pointController;
use App\Http\Controllers\paymentController;
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

// Rutas de los clientes 
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
    Route::get('/clients/banned', [clientController::class, 'banned'])->name('clients.banned');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/clients/edit/{id}', [clientController::class, 'edit'])->name('clients.edit');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::put('/clients/update/{id}', [clientController::class, 'update'])->name('clients.update');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::delete('/clients/destroy/{id}', [clientController::class, 'destroy'])->name('clients.destroy');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/clients/show/{id}', [clientController::class, 'show'])->name('clients.show');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function (){
    Route::get('/clients/export/{type}', [clientController::class, 'exportPdf'])->name('clients.export');
});

// Ruta de los access points 
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
    Route::post('/access-point/store', [access_pointController::class, 'store'])->name('access-point.store');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/access-point/create', [access_pointController::class, 'create'])->name('access-point.create');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/access-point/show/{id}', [access_pointController::class, 'show'])->name('access-point.show');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/access-point/edit/{id}', [access_pointController::class, 'edit'])->name('access-point.edit');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::put('/access-point/update/{id}', [access_pointController::class, 'update'])->name('access-point.update');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::delete('/access-point/destroy/{id}', [access_pointController::class, 'destroy'])->name('access-point.destroy');
});

// Ruta de los planes 
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
    Route::get('/contracts/create', [contractController::class, 'create'])->name('contracts.create');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::post('/contracts/store', [contractController::class, 'store'])->name('contracts.store');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/contracts/edit/{id}', [contractController::class, 'edit'])->name('contracts.edit');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::put('/contracts/update/{id}', [contractController::class, 'update'])->name('contracts.update');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::delete('/contracts/destroy/{id}', [contractController::class, 'destroy'])->name('contracts.destroy');
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
    Route::get('/quota/create', [quotaController::class, 'create'])->name('quota.create');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::post('/quota/store', [quotaController::class, 'store'])->name('quota.store');
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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/payments/show/{id}', [paymentController::class, 'show'])->name('payments.show');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/payments/edit/{id}', [paymentController::class, 'edit'])->name('payments.edit');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::put('/payments/update/{id}', [paymentController::class, 'update'])->name('payments.update');
});