<?php

declare(strict_types=1);

namespace App\Controllers\Site;

use App\Helpers\IdSeguro;
use App\Repositories\CategoriaRepository;
use App\Repositories\ProdutoRepository;
use App\Helpers\CsrfCarrinho;
use RuntimeException;

final class BuscaController
{
    public function index(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Raiz
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
        | 5. Recebe o termo
        |--------------------------------------------------------------------------
        */

        $termo = trim(
            (string) (
                $_GET['q']
                ?? ''
            )
        );


        /*
        |--------------------------------------------------------------------------
        | 6. Pesquisa
        |--------------------------------------------------------------------------
        */

        $produtos =
            $termo !== ''
            ? $produtoRepository
            ->buscar(
                $termo,
                30
            )

            : [];


        /*
        |--------------------------------------------------------------------------
        | 7. IDs seguros
        |--------------------------------------------------------------------------
        */

        foreach (
            $produtos
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
        | 8. Total
        |--------------------------------------------------------------------------
        */

        $totalResultados =
            count(
                $produtos
            );


        /*
        |--------------------------------------------------------------------------
        | 9. SEO
        |--------------------------------------------------------------------------
        */

        $tituloPagina =
            $termo !== ''
            ? 'Busca por '
            . $termo
            . ' - Loja Online'

            : 'Busca - Loja Online';


        $descricaoPagina =
            $termo !== ''
            ? 'Resultados da busca por '
            . $termo
            . '.'

            : 'Pesquise produtos '
            . 'na Loja Online.';


        $csrfCarrinho = CsrfCarrinho::gerar();


        /*
        |--------------------------------------------------------------------------
        | 10. View
        |--------------------------------------------------------------------------
        */

        $arquivoView =
            $raizProjeto
            . '/views/site/busca.php';


        if (!is_file($arquivoView)) {

            throw new RuntimeException(
                'A página de busca '
                    . 'não foi encontrada.'
            );
        }


        require $arquivoView;
    }
}
