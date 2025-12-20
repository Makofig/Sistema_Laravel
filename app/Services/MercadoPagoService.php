<?php
namespace App\Services;

use MercadoPago\SDK;
use MercadoPago\Preference;
use MercadoPago\Item;
use Illuminate\Support\Facades\Log;

class MercadoPagoService
{
    protected bool $initialized = false;

    protected function init(): void
    {
        if ($this->initialized) {
            return;
        }

        $token = config('services.mercadopago.token');

        if (!$token) {
            throw new \Exception('MercadoPago token no configurado');
        }

        SDK::setAccessToken($token);

        // ⏱️ timeout global del SDK
        SDK::setRequestTimeout(5000); // 5 segundos

        $this->initialized = true;
    }

    public function crearLinkPago(array $data): string
    {
        $this->init();

        try {
            $preference = new Preference();

            $item = new Item();
            $item->title = $data['title'];
            $item->quantity = 1;
            $item->unit_price = (float) $data['price'];

            $preference->items = [$item];
            $preference->external_reference = (string) $data['external_reference'];

            $preference->save();

            return $preference->init_point;
        } catch (\Throwable $e) {
            Log::error('MercadoPago error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            throw new \Exception('Error al crear link de pago');
        }
    }
}
