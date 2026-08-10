<?php

declare(strict_types=1);

use App\Controllers\Site\AjudaCentralController;

return [
    [
        'method' => 'GET',
        'path' => '/ajuda/central',
        'action' => [
            AjudaCentralController::class,
            'index',
        ],
    ],
    
];