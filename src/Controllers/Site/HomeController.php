<?php

declare(strict_types=1);

namespace App\Controllers\Site;

use App\Helpers\IdSeguro;
use App\Repositories\CategoriaRepository;
use App\Repositories\ProdutoRepository;
use App\Services\CarrinhoService;
use RuntimeException;

class HomeController
{
    public function index(): void
    {

        $raizProjeto = dirname(__DIR__, 3);
        require_once $raizProjeto . '/database/conexao.php';

        $pdo = \Config::connect();


        /*
        |--------------------------------------------------------------------------
        | 3. Categorias
        |--------------------------------------------------------------------------
        */
        $categoriaRepository =
            new CategoriaRepository(
                $pdo
            );

        $categorias =
            $categoriaRepository
            ->listarAtivas();


        /*
        |--------------------------------------------------------------------------
        | 4. Gera ID seguro das categorias
        |--------------------------------------------------------------------------
        */
        foreach ($categorias as &$categoria) {

            $categoria['id_seguro'] =
                IdSeguro::criptografar(
                    (int) $categoria['id']
                );
        }

        unset($categoria);


        /*
        |--------------------------------------------------------------------------
        | 5. Produtos
        |--------------------------------------------------------------------------
        */
        $produtoRepository =
            new ProdutoRepository(
                $pdo
            );

        $produtosDestaque =
            $produtoRepository
            ->listarDestaques(10);

        $maisVendidos =
            $produtoRepository
            ->listarMaisVendidos(10);


        /*
        |--------------------------------------------------------------------------
        | 6. Localiza a View
        |--------------------------------------------------------------------------
        */


        $carrinhoService =
            new CarrinhoService($pdo);

        $quantidadeCarrinho =
            $carrinhoService->quantidade();




        $arquivoView =
            $raizProjeto
            . '/views/site/home.php';


        if (!is_file($arquivoView)) {

            throw new RuntimeException(
                'A página inicial não foi encontrada.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | 7. Carrega a View
        |--------------------------------------------------------------------------
        */
        require $arquivoView;
    }
}
