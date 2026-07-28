<?php

declare(strict_types=1);

namespace App\Controllers\Site;

class HomeController
{
    public function index(): void
    {
        $arquivoView = dirname(__DIR__, 3) . '/views/site/home.php';

        if (!is_file($arquivoView)) {
            throw new \RuntimeException(
                'A página inicial não foi encontrada.'
            );
        }

        require $arquivoView;
    }
}