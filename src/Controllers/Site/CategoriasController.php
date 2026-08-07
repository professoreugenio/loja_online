<?php

declare(strict_types=1);

namespace App\Controllers\Site;

class CategoriasController
{
    public function index(): void
    {
        $arquivoView = dirname(__DIR__, 3) . '/views/site/categorias.php';

        if (!is_file($arquivoView)) {
            throw new \RuntimeException(
                'A página inicial não foi encontrada.'
            );
        }

        require $arquivoView;
    }
}