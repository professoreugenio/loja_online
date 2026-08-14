<?php

declare(strict_types=1);

use App\Controllers\Site\ProdutosController;
use App\Controllers\Site\ProdutosDetalhesController;

return [
    [
        'method' => 'GET',
        'path' => '/produtos',
        'action' => [
            ProdutosController::class,
            'index',
        ],
    ],
    [
        'method' => 'GET',
        'path' => '/produto/detalhes',
        'action' => [
            ProdutosDetalhesController::class,
            'index',
        ],
    ],
    
];