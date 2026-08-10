<?php

declare(strict_types=1);

use App\Controllers\Site\AjudaPerguntasController;

return [
    [
        'method' => 'GET',
        'path' => '/ajuda/perguntas',
        'action' => [
            AjudaPerguntasController::class,
            'index',
        ],
    ],
    
];