<?php

declare(strict_types=1);

namespace App\Controllers\Site;

use App\Helpers\IdSeguro;
use App\Repositories\CategoriaRepository;
use App\Repositories\ProdutoRepository;
use App\Helpers\CsrfCarrinho;

use RuntimeException;

final class OfertasController
{
    public function index(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Raiz do projeto
        |--------------------------------------------------------------------------
        */

        $raizProjeto =
            dirname(__DIR__, 3);


        /*
        |--------------------------------------------------------------------------
        | 2. Conexão
        |--------------------------------------------------------------------------
        */

        require_once $raizProjeto
            . '/database/conexao.php';


        $pdo =
            \Config::connect();


        /*
        |--------------------------------------------------------------------------
        | 3. Repositories
        |--------------------------------------------------------------------------
        */

        $categoriaRepository =
            new CategoriaRepository(
                $pdo
            );


        $produtoRepository =
            new ProdutoRepository(
                $pdo
            );


        /*
        |--------------------------------------------------------------------------
        | 4. Categorias do header
        |--------------------------------------------------------------------------
        */

        $categorias =
            $categoriaRepository
                ->listarAtivas();


        foreach (
            $categorias
            as &$categoria
        ) {

            $categoria['id_seguro'] =
                IdSeguro::criptografar(
                    (int)
                    $categoria['id']
                );
        }


        unset($categoria);


        /*
        |--------------------------------------------------------------------------
        | 5. Produtos em oferta
        |--------------------------------------------------------------------------
        */

        $ofertas =
            $produtoRepository
                ->listarOfertasAtivas(
                    60
                );


        /*
        |--------------------------------------------------------------------------
        | 6. ID seguro dos produtos
        |--------------------------------------------------------------------------
        */

        foreach (
            $ofertas
            as &$produto
        ) {

            $produto['id_seguro'] =
                IdSeguro::criptografar(
                    (int)
                    $produto['id']
                );
        }


        unset($produto);


        /*
        |--------------------------------------------------------------------------
        | 7. SEO
        |--------------------------------------------------------------------------
        */

        $tituloPagina =
            'Ofertas - Loja Online';


        $descricaoPagina =
            'Confira os produtos em oferta '
            . 'disponíveis na Loja Online.';


        /*
        |--------------------------------------------------------------------------
        | 8. View
        |--------------------------------------------------------------------------
        */

        $csrfCarrinho = CsrfCarrinho::gerar();

        $arquivoView =
            $raizProjeto
            . '/views/site/ofertas.php';


        if (!is_file($arquivoView)) {

            throw new RuntimeException(
                'A página de ofertas '
                . 'não foi encontrada.'
            );
        }


        require $arquivoView;
    }
}
