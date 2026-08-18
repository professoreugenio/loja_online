<?php

declare(strict_types=1);

namespace App\Controllers\Site;

use App\Helpers\IdSeguro;
use App\Repositories\CategoriaRepository;
use App\Repositories\ProdutoRepository;
use App\Helpers\CsrfCarrinho;

use RuntimeException;

class ProdutosController
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
        | 2. Conexão com o banco
        |--------------------------------------------------------------------------
        */
        require_once $raizProjeto
            . '/database/conexao.php';
        $pdo =
            \Config::connect();
        /*
        |--------------------------------------------------------------------------
        | 3. Categorias do menu
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
        | 4. Gera o ID seguro das categorias
        |--------------------------------------------------------------------------
        */
        foreach (
            $categorias
            as &$categoria
        ) {
            $categoria['id_seguro'] =
                IdSeguro::criptografar(
                    (int) $categoria['id']
                );
        }
        unset($categoria);
        /*
        |--------------------------------------------------------------------------
        | 5. Busca os produtos
        |--------------------------------------------------------------------------
        */
        $produtoRepository =
            new ProdutoRepository(
                $pdo
            );
        /*
|--------------------------------------------------------------------------
| Todos os produtos
|--------------------------------------------------------------------------
*/
        $produtos =
            $produtoRepository
            ->listarTodos();



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
| Produtos em destaque
|--------------------------------------------------------------------------
*/
        $produtosDestaque =
            $produtoRepository
            ->listarDestaques(10);

        foreach (
            $produtosDestaque
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
| Produtos mais vendidos
|--------------------------------------------------------------------------
*/
        $maisVendidos =
            $produtoRepository
            ->listarMaisVendidos(10);

        foreach (
            $maisVendidos
            as &$produto
        ) {

            $produto['id_seguro'] =
                IdSeguro::criptografar(
                    (int)
                    $produto['id']
                );
        }

        unset($produto);


        $csrfCarrinho = CsrfCarrinho::gerar();

        /*
        |--------------------------------------------------------------------------
        | 6. Localiza a View
        |--------------------------------------------------------------------------
        */
        $arquivoView =
            $raizProjeto
            . '/views/site/produtos.php';
        if (!is_file($arquivoView)) {
            throw new RuntimeException(
                'A página de produtos não foi encontrada.'
            );
        }
        /*
        |--------------------------------------------------------------------------
        | 7. Carrega a View
        |--------------------------------------------------------------------------
        |
        | As variáveis:
        |
        | $categorias
        | $produtos
        |
        | estarão disponíveis em produtos.php
        |
        */
        require $arquivoView;
    }
}
