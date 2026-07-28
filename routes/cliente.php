<?php

declare(strict_types=1);

use App\Controllers\Cliente\ClienteController;

return [
    [
        'method' => 'GET',
        'path' => '/cliente/login',
        'action' => [ClienteController::class, 'login'],
    ],
    [
        'method' => 'GET',
        'path' => '/cliente/cadastro',
        'action' => [ClienteController::class, 'cadastro'],
    ],
    [
        'method' => 'GET',
        'path' => '/cliente/pedidos',
        'action' => [ClienteController::class, 'pedidos'],
    ],
];