<?php

declare(strict_types=1);

use App\Controllers\Admin\LoginAdminController;

return [
    [
        'method' => 'GET',
        'path' => '/loginadmin',
        'action' => [
            LoginAdminController::class,
            'formulario',
        ],
    ],
    [
        'method' => 'POST',
        'path' => '/loginadmin',
        'action' => [
            LoginAdminController::class,
            'autenticar',
        ],
    ],
    [
        'method' => 'POST',
        'path' => '/logout-admin',
        'action' => [
            LoginAdminController::class,
            'sair',
        ],
    ],
];
