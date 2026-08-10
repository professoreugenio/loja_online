<?php

declare(strict_types=1);

use App\Controllers\Site\AjudaTrocasController;

return [
    [
        'method' => 'GET',
        'path' => '/ajuda/trocas',
        'action' => [
            AjudaTrocasController::class,
            'index',
        ],
    ],
    
];