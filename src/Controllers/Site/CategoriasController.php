<?php

declare(strict_types=1);

namespace App\Controllers\Site;

use App\Helpers\IdSeguro;
use App\Repositories\CategoriaRepository;
use App\Repositories\ProdutoRepository;
use Config;
use RuntimeException;

class CategoriasController
{
    public function index(): void
    {
        /*
         * 1. Recebe o token criptografado da URL
         *
         * Exemplo:
         * /categoria?cat=TOKEN_CRIPTOGRAFADO
         */
        $token = trim(
            (string) (
                $_GET['cat']
                ?? ''
            )
        );

        /*
         * 2. Verifica se o parâmetro foi informado
         */
        if ($token === '') {
            $this->pagina404();
            return;
        }

        /*
         * 3. Descriptografa o ID da categoria
         */
        $categoriaId =
            IdSeguro::descriptografar(
                $token
            );

        if ($categoriaId === null) {
            $this->pagina404();
            return;
        }

        /*
         * 4. Conecta ao banco de dados
         */
        require_once APP_ROOT
            . '/database/conexao.php';

        $pdo = Config::connect();

        /*
         * 5. Instancia os repositories
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
         * 6. Busca a categoria
         */
        $categoria =
            $categoriaRepository
                ->buscarPorId(
                    $categoriaId
                );

        /*
         * Categoria não encontrada
         */
        if ($categoria === null) {
            $this->pagina404();
            return;
        }

        /*
         * 7. Busca os produtos da categoria
         */
        $produtos =
            $produtoRepository
                ->listarPorCategoria(
                    $categoriaId
                );

        /*
         * 8. Carrega a página
         */
        $arquivoView =
            APP_ROOT
            . '/views/site/categorias.php';

        if (!is_file($arquivoView)) {
            throw new RuntimeException(
                'A página de categorias não foi encontrada.'
            );
        }

        /*
         * As variáveis:
         *
         * $categoria
         * $produtos
         *
         * estarão disponíveis dentro de categorias.php
         */
        require $arquivoView;
    }


    /**
     * Exibe a página de erro 404
     */
    private function pagina404(): void
    {
        http_response_code(404);

        $arquivo404 =
            APP_ROOT
            . '/views/erros/404.php';

        if (is_file($arquivo404)) {
            require $arquivo404;
            return;
        }

        echo 'Página não encontrada.';
    }
}