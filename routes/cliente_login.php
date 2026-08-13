<?php

declare(strict_types=1);

use App\Controllers\Site\ClienteLoginController;

return [
    [
        'method' => 'GET',
        'path' => '/cliente/login',
        'action' => [
            ClienteLoginController::class,
            'index',
        ],
    ],
    
];