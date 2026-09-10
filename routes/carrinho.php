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

    [
        'method' => 'POST',
        'path' =>
        '/carrinho/calcular-frete',
        'action' => [
            CarrinhoController::class,
            'calcularFrete',
        ],
    ],



    [
        'method' => 'POST',
        'path' => '/carrinho/adicionar',
        'action' => [
            CarrinhoController::class,
            'adicionar',
        ],
    ],


    [
        'method' => 'POST',
        'path' => '/carrinho/atualizar',
        'action' => [
            CarrinhoController::class,
            'atualizar',
        ],
    ],


    [
        'method' => 'POST',
        'path' => '/carrinho/remover',
        'action' => [
            CarrinhoController::class,
            'remover',
        ],
    ],

];
