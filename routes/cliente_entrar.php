<?php

declare(strict_types=1);

use App\Controllers\Site\ClienteEntrarController;

return [
    [
        'method' => 'GET',
        'path' => '/cliente/login',
        'action' => [
            ClienteEntrarController::class,
            'index',
        ],
    ],
    
];