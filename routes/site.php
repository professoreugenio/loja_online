<?php

declare(strict_types=1);

use App\Controllers\Site\HomeController;

return [
    [
        'method' => 'GET',
        'path' => '/',
        'action' => [
            HomeController::class,
            'index',
        ],
    ],
    
];
