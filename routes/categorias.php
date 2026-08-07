<?php

declare(strict_types=1);

use App\Controllers\Site\CategoriasController;

return [
    [
        'method' => 'GET',
        'path' => '/categoria',
        'action' => [
            CategoriasController::class,
            'index',
        ],
    ],
    
];