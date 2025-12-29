<?php

namespace App\Services;

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;
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

        MercadoPagoConfig::setAccessToken($token);
        MercadoPagoConfig::setRuntimeEnviroment(MercadoPagoConfig::LOCAL);

        $this->initialized = true;
    }

    public function crearLinkPago(): array
    {
        $this->init();

        try {
            $client = new PreferenceClient();

            $preference = $client->create([
                "auto_return" => "approved",
                "back_urls" => [
                    "success" => "https://www.httpbin.org/get?back_url=success",
                    "failure" => "https://www.httpbin.org/get?back_url=failure",
                    "pending" => "https://www.httpbin.org/get?back_url=pending"
                ],
                "statement_descriptor" => "TestStore",
                "binary_mode" => false,
                "external_reference" => "IWD1238971",
                "items" => [
                    [
                        "id" => "010983098",
                        "title" => "My Product",
                        "quantity" => 1,
                        "unit_price" => 1000,
                        "description" => "Description of my product",
                        "category_id" => "retail",
                    ]
                ],
                "payer" => [
                    "email" => "test_user_12398378192@testuser.com",
                ],
                "payment_methods" => [
                    "installments" => 12,
                    "default_payment_method_id" => "account_money",
                ],
                "notification_url" => "https://www.your-site.com/webhook",
            ]);

            return [
                "id" => $preference->id,
                "init_point" => $preference->init_point,
                "sandbox_init_point" => $preference->sandbox_init_point,
            ];

        } catch (MPApiException $e) {
            Log::error('MercadoPago API error', [
                'status' => $e->getApiResponse()->getStatusCode(),
                'content' => $e->getApiResponse()->getContent(),
            ]);

            throw new \Exception('Error MercadoPago API');
        } catch (\Throwable $e) {
            Log::error('MercadoPago error', [
                'message' => $e->getMessage(),
            ]);

            throw new \Exception('Error al crear link de pago');
        }
    }

    public function showToken(): string
    {
        $this->init();

        return MercadoPagoConfig::getAccessToken();
    }
}
