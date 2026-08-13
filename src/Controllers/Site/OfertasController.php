<?php

declare(strict_types=1);

namespace App\Controllers\Site;

use App\Helpers\IdSeguro;
use App\Repositories\CategoriaRepository;
use RuntimeException;

class OfertasController
{
    public function index(): void
    {

        $raizProjeto =
            dirname(__DIR__, 3);

        require_once $raizProjeto
            . '/database/conexao.php';
        $pdo =
            \Config::connect();

        $categoriaRepository =
            new CategoriaRepository(
                $pdo
            );
        $categorias =
            $categoriaRepository
            ->listarAtivas();

        foreach ($categorias as &$categoria) {
            $categoria['id_seguro'] =
                IdSeguro::criptografar(
                    (int) $categoria['id']
                );
        }
        unset($categoria);

        $arquivoView =
            $raizProjeto
            . '/views/site/ofertas.php';
        if (!is_file($arquivoView)) {
            throw new RuntimeException(
                'A página de ofertas não foi encontrada.'
            );
        }
        /*
        |--------------------------------------------------------------------------
        | 7. Carrega a View
        |--------------------------------------------------------------------------
        |
        | $categorias estará disponível
        | dentro de ofertas.php.
        |
        */
        require $arquivoView;
    }
}
