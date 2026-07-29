<?php

declare(strict_types=1);

use App\Controllers\LoginAdminController;

return [
    [
        'method' => 'GET',
        'path' => '/loginadmin',
        'action' => [
            LoginAdminController::class,
            'index'
        ],
    ],
];