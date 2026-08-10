<?php

declare(strict_types=1);

use App\Controllers\Site\AjudaContatoController;

return [
    [
        'method' => 'GET',
        'path' => '/ajuda/contato',
        'action' => [
            AjudaContatoController::class,
            'index',
        ],
    ],
    
];