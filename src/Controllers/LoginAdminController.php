<?php

declare(strict_types=1);

namespace App\Controllers;

class LoginAdminController
{
    public function index(): void
    {
        $raizProjeto = dirname(__DIR__, 2);

        require $raizProjeto . '/views/site/loginadmin.php';
    }
}