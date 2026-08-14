<?php
declare(strict_types=1);
use App\Controllers\Cliente\ClienteCadastroController;
return [
    [
        'method' => 'GET',
        'path' => '/cliente/cadastro',
        'action' => [
            ClienteCadastroController::class,
            'formulario',
        ],
    ],
    [
        'method' => 'POST',
        'path' => '/cliente/cadastrar',
        'action' => [
            ClienteCadastroController::class,
            'cadastrar',
        ],
    ],
];
