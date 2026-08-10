<?php

declare(strict_types=1);

use App\Controllers\Site\AjudaRastreioController;

return [
    [
        'method' => 'GET',
        'path' => '/ajuda/rastreio',
        'action' => [
            AjudaRastreioController::class,
            'index',
        ],
    ],
    
];