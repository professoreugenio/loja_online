<?php

declare(strict_types=1);

namespace App\Controllers\Site;

use App\Helpers\IdSeguro;
use App\Repositories\CategoriaRepository;
use App\Repositories\ProdutoRepository;
use RuntimeException;

class HomeController
{
    public function index(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Raiz do projeto
        |--------------------------------------------------------------------------
        */
        $raizProjeto = dirname(__DIR__, 3);
        /*
        |--------------------------------------------------------------------------
        | Conexão com o banco
        |--------------------------------------------------------------------------
        */
        require_once $raizProjeto
            . '/database/conexao.php';
        $pdo = \Config::connect();
        /*
        |--------------------------------------------------------------------------
        | Busca as categorias ativas
        |--------------------------------------------------------------------------
        */
        /*
        |--------------------------------------------------------------------------
        | Localiza a View
        |--------------------------------------------------------------------------
        */
        $arquivoView =
            $raizProjeto
            . '/views/site/home.php';
        if (!is_file($arquivoView)) {
            throw new \RuntimeException(
                'A página inicial não foi encontrada.'
            );
        }
        /*
        |--------------------------------------------------------------------------
        | Carrega a View
        |--------------------------------------------------------------------------
        |
        | A variável $categorias estará disponível
        | dentro da home.php.
        |
        */
        $categoriaRepository = new CategoriaRepository($pdo);
        $categorias = $categoriaRepository->listarAtivas();
        $produtoRepository = new ProdutoRepository($pdo);
        $produtosDestaque = $produtoRepository->listarDestaques(10);
        $maisVendidos = $produtoRepository->listarMaisVendidos(10);


        foreach ($categorias as &$categoria) {

            $categoria['id_seguro'] =
                IdSeguro::criptografar(
                    (int) $categoria['id']
                );
        }

        unset($categoria);


        require $arquivoView;
    }
}
