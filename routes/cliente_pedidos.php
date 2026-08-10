<?php

declare(strict_types=1);

use App\Controllers\Site\ClientePedidosController;

return [
    [
        'method' => 'GET',
        'path' => '/cliente/pedidos',
        'action' => [
            ClientePedidosController::class,
            'index',
        ],
    ],
    
];