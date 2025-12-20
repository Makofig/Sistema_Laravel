<?php

namespace App\Services;

use MercadoPago\SDK;
use MercadoPago\Preference;
use MercadoPago\Item;

class MercadoPagoService
{
    public function __construct()
    {
        SDK::setAccessToken(config('mercadopago.access_token'));
    }

    public function crearLinkPago(array $data): string
    {
        $preference = new Preference();

        $item = new Item();
        $item->title = $data['title'];
        $item->quantity = 1;
        $item->unit_price = (float) $data['price'];

        $preference->items = [$item];
        $preference->external_reference = (string) $data['external_reference'];

        // URLs opcionales (después las usamos mejor)
        $preference->back_urls = [
            'success' => env('APP_URL') . '/pago-exitoso',
            'failure' => env('APP_URL') . '/pago-fallido',
            'pending' => env('APP_URL') . '/pago-pendiente',
        ];

        $preference->auto_return = 'approved';

        $preference->save();

        return $preference->init_point;
    }
}
