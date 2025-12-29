<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/pagos/generar-mensuales', [PaymentController::class, 'generarMensuales']);

Route::get('/test', function () {
    return response()->json(['ok' => true]);
});

Route::get('/mp/test', function () {
    set_time_limit(0);

    $mp = app(\App\Services\MercadoPagoService::class);

    return response()->json(['successfully' => $mp->crearLinkPago()]);

    /* return redirect(
        $mp->crearLinkPago([
            'title' => 'Producto Test 002',
            'price' => 1000,
            'external_reference' => 'TEST_002',
        ])
    ); */
});

/* 
curl -X POST https://api.mercadopago.com/checkout/preferences \
  -H "Authorization: Bearer TEST-8680470863093704-122017-54f32b717ee92f9181cb4de8e0765e5a-1128558007" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  --data '{
    "auto_return": "approved",
    "back_urls": {
      "success": "https://www.httpbin.org/get?back_url=success",
      "failure": "https://www.httpbin.org/get?back_url=failure",
      "pending": "https://www.httpbin.org/get?back_url=pending"
    },
    "statement_descriptor": "TestStore",
    "binary_mode": false,
    "external_reference": "IWD1238971",
    "items": [
      {
        "id": "010983098",
        "title": "My Product",
        "quantity": 1,
        "unit_price": 2000,
        "description": "Description of my product",
        "category_id": "retail"
      }
    ],
    "payer": {
      "email": "test_user_12398378192@testuser.com"
    },
    "payment_methods": {
      "installments": 12,
      "default_payment_method_id": "account_money"
    },
    "notification_url": "https://www.your-site.com/webhook"
  }'
 */