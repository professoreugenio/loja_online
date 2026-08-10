<?php

declare(strict_types=1);

use App\Controllers\Site\OfertasController;

return [
    [
        'method' => 'GET',
        'path' => '/ofertas',
        'action' => [
            OfertasController::class,
            'index',
        ],
    ],
    
];