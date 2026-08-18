<?php

declare(strict_types=1);

namespace App\Controllers\Site;

use App\Helpers\IdSeguro;
use App\Repositories\CategoriaRepository;
use App\Repositories\ProdutoRepository;
use App\Helpers\CsrfCarrinho;
use Config;

use RuntimeException;

class CategoriasController
{
    public function index(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Carrega a conexão/configurações
        |--------------------------------------------------------------------------
        */
        require_once APP_ROOT
            . '/database/conexao.php';
        $pdo =
            Config::connect();
        /*
        |--------------------------------------------------------------------------
        | 2. Recebe o token da categoria
        |--------------------------------------------------------------------------
        |
        | Exemplo:
        |
        | /categorias?cat=TOKEN
        |
        */
        $token = trim(
            (string) (
                $_GET['cat']
                ?? ''
            )
        );
        /*
        |--------------------------------------------------------------------------
        | 3. Verifica se o token foi informado
        |--------------------------------------------------------------------------
        */
        if ($token === '') {
            $this->pagina404(
                'Token da categoria não informado.'
            );
            return;
        }
        /*
        |--------------------------------------------------------------------------
        | 4. Descriptografa o ID
        |--------------------------------------------------------------------------
        */
        $categoriaId =
            IdSeguro::descriptografar(
                $token
            );
        /*
        |--------------------------------------------------------------------------
        | 5. Verifica se o token é válido
        |--------------------------------------------------------------------------
        */
        if ($categoriaId === null) {
            $this->pagina404(
                'Não foi possível descriptografar o token da categoria.'
            );
            return;
        }
        /*
        |--------------------------------------------------------------------------
        | 6. Instancia os repositories
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
        | 7. Busca primeiro a categoria selecionada
        |--------------------------------------------------------------------------
        */
        $categoria =
            $categoriaRepository
            ->buscarPorId(
                $categoriaId
            );
        /*
        |--------------------------------------------------------------------------
        | 8. Verifica se a categoria existe
        |--------------------------------------------------------------------------
        */
        if ($categoria === null) {
            $this->pagina404(
                'Categoria não encontrada. ID: '
                    . $categoriaId
            );
            return;
        }
        /*
        |--------------------------------------------------------------------------
        | 9. Busca os produtos da categoria
        |--------------------------------------------------------------------------
        */
        $produtos =
            $produtoRepository
            ->listarPorCategoria(
                $categoriaId
            );
        /*
|--------------------------------------------------------------------------
| 10. Adiciona id_seguro aos produtos
|--------------------------------------------------------------------------
*/
        $produtos = array_map(
            static function (array $produto): array {
                $produto['id_seguro'] =
                    IdSeguro::criptografar(
                        (int) $produto['id']
                    );
                return $produto;
            },
            $produtos
        );
        /*
        |--------------------------------------------------------------------------
        | 10. Busca categorias para o HEADER
        |--------------------------------------------------------------------------
        */
        $categorias =
            $categoriaRepository
            ->listarAtivas();
        /*
        |--------------------------------------------------------------------------
        | 11. Adiciona id_seguro para os links do HEADER
        |--------------------------------------------------------------------------
        */
        $categorias = array_map(
            static function (
                array $item
            ): array {
                $item['id_seguro'] =
                    IdSeguro::criptografar(
                        (int) $item['id']
                    );
                return $item;
            },
            $categorias
        );
        /*
        |--------------------------------------------------------------------------
        | 12. Dados da página
        |--------------------------------------------------------------------------
        */
        $tituloPagina =
            $categoria['nome']
            . ' - Loja Online';
        $descricaoPagina =
            !empty($categoria['descricao'])
            ? (string) $categoria['descricao']
            : 'Produtos da categoria '
            . $categoria['nome'];



        $csrfCarrinho = CsrfCarrinho::gerar();


        /*
        |--------------------------------------------------------------------------
        | 13. Localiza a View
        |--------------------------------------------------------------------------
        */
        $arquivoView =
            APP_ROOT
            . '/views/site/categorias.php';
        if (!is_file($arquivoView)) {
            throw new RuntimeException(
                'A página de categorias não foi encontrada: '
                    . $arquivoView
            );
        }
        /*
        |--------------------------------------------------------------------------
        | 14. Carrega a View
        |--------------------------------------------------------------------------
        |
        | Variáveis disponíveis:
        |
        | $categorias
        | $categoria
        | $produtos
        | $tituloPagina
        | $descricaoPagina
        |
        */
        require $arquivoView;
    }
    /**
     * Exibe a página 404.
     */
    private function pagina404(
        string $motivo = ''
    ): void {
        /*
         * Registra o motivo real no log do PHP.
         */
        if ($motivo !== '') {
            error_log(
                'CategoriasController: '
                    . $motivo
            );
        }
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
