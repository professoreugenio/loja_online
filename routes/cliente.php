<?php

declare(strict_types=1);

use App\Controllers\Cliente\ClienteController;
use App\Controllers\Cliente\ClienteLoginController;
use App\Controllers\Cliente\EnderecoController;
use App\Controllers\Cliente\PedidoController;
use App\Controllers\Cliente\PerfilController;

return [

    /*
    |--------------------------------------------------------------------------
    | Autenticação
    |--------------------------------------------------------------------------
    */

    [
        'method' => 'GET',
        'path' => '/cliente/login',
        'action' => [
            ClienteLoginController::class,
            'formulario',
        ],
    ],

    [
        'method' => 'POST',
        'path' => '/cliente/login',
        'action' => [
            ClienteLoginController::class,
            'autenticar',
        ],
    ],

    [
        'method' => 'POST',
        'path' => '/cliente/sair',
        'action' => [
            ClienteLoginController::class,
            'sair',
        ],
    ],


    /*
    |--------------------------------------------------------------------------
    | Área protegida
    |--------------------------------------------------------------------------
    */

    [
        'method' => 'GET',
        'path' => '/cliente',
        'action' => [
            ClienteController::class,
            'painel',
        ],
    ],

    [
        'method' => 'GET',
        'path' => '/cliente/perfil',
        'action' => [
            PerfilController::class,
            'index',
        ],
    ],

    [
        'method' => 'GET',
        'path' => '/cliente/enderecos',
        'action' => [
            EnderecoController::class,
            'index',
        ],
    ],

    [
        'method' => 'GET',
        'path' => '/cliente/pedidos',
        'action' => [
            PedidoController::class,
            'index',
        ],
    ],

    [
        'method' => 'GET',
        'path' => '/cliente/pedido',
        'action' => [
            PedidoController::class,
            'detalhe',
        ],
    ],

    [
        'method' => 'GET',
        'path' => '/cliente/seguranca',
        'action' => [
            PerfilController::class,
            'seguranca',
        ],
    ],
];
