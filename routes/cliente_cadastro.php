<?php

declare(strict_types=1);

use App\Controllers\Site\ClienteCadastroController;

return [
    [
        'method' => 'GET',
        'path' => '/cliente/cadastro',
        'action' => [
            ClienteCadastroController::class,
            'index',
        ],
    ],
    
];