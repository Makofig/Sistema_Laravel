<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/pagos/generar-mensuales', [PaymentController::class, 'generarMensuales']);

Route::post('/test', function () {
    return response()->json(['ok' => true]);
});

Route::get('/mp-test', function () {
    $mp = app(\App\Services\MercadoPagoService::class);

    return $mp->crearLinkPago([
        'title' => 'Test pago',
        'price' => 1000,
        'external_reference' => 1,
    ]);
});
