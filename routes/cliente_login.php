<?php
declare(strict_types=1);
use App\Controllers\Cliente\ClienteLoginController;
return [
    /*
    |--------------------------------------------------------------------------
    | Formulário de login
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
    /*
    |--------------------------------------------------------------------------
    | Processar login
    |--------------------------------------------------------------------------
    */
    [
        'method' => 'POST',
        'path' => '/cliente/login',
        'action' => [
            ClienteLoginController::class,
            'autenticar',
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */
    [
        'method' => 'POST',
        'path' => '/cliente/sair',
        'action' => [
            ClienteLoginController::class,
            'sair',
        ],
    ],
];
