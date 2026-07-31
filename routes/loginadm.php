<?php

declare(strict_types=1);

use App\Controllers\Site\MickeyMouseController;


return [
    [
        'method' => 'GET',
        'path' => '/mickey',
        'action' => [
            MickeyMouseController::class,
            'index',
        ],
    ],
    
];
