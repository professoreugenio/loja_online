<?php

declare(strict_types=1);

namespace App\Controllers\Site;

class AjudaPerguntasController
{
    public function index(): void
    {
        $arquivoView = dirname(__DIR__, 3) . '/views/site/ajuda_perguntas.php';

        if (!is_file($arquivoView)) {
            throw new \RuntimeException(
                'A página inicial não foi encontrada.'
            );
        }

        require $arquivoView;
    }
}