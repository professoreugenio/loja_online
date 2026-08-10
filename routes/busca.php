<?php

declare(strict_types=1);

use App\Controllers\Site\BuscaController;

return [
    [
        'method' => 'GET',
        'path' => '/buscar',
        'action' => [
            BuscaController::class,
            'index',
        ],
    ],
    
];