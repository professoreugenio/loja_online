<?php

declare(strict_types=1);

use App\Controllers\Site\ProdutosController;

return [
    [
        'method' => 'GET',
        'path' => '/produtos',
        'action' => [
            ProdutosController::class,
            'index',
        ],
    ],
    
];