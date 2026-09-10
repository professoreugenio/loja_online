<?php

declare(strict_types=1);

use App\Controllers\Site\CheckoutController;
use App\Controllers\Site\MercadoPagoWebhookController;

return [
    [
        'method' => 'GET',
        'path' => '/checkout',
        'action' => [
            CheckoutController::class,
            'index',
        ],
    ],
    [
        'method' => 'POST',
        'path' => '/checkout/finalizar',
        'action' => [
            CheckoutController::class,
            'finalizar',
        ],
    ],
    [
        'method' => 'GET',
        'path' => '/checkout/retorno',
        'action' => [
            CheckoutController::class,
            'retorno',
        ],
    ],
    [
        'method' => 'POST',
        'path' => '/mercadopago/webhook',
        'action' => [
            MercadoPagoWebhookController::class,
            'receber',
        ],
    ],
];
