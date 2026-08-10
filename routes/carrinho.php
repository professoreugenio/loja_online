<?php

declare(strict_types=1);

use App\Controllers\Site\CarrinhoController;

return [
    [
        'method' => 'GET',
        'path' => '/carrinho',
        'action' => [
            CarrinhoController::class,
            'index',
        ],
    ],
    
];