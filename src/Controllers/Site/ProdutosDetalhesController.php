<?php
declare(strict_types=1);
namespace App\Controllers\Site;
use App\Helpers\IdSeguro;
use App\Repositories\CategoriaRepository;
use App\Repositories\ProdutoRepository;
use App\Helpers\CsrfCarrinho;
use RuntimeException;
final class ProdutosDetalhesController
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
        | 3. Recebe o token do produto
        |--------------------------------------------------------------------------
        */
        $token = trim(
            (string) (
                $_GET['prod']
                ?? ''
            )
        );
        /*
        |--------------------------------------------------------------------------
        | 4. Token obrigatório
        |--------------------------------------------------------------------------
        */
        if ($token === '') {
            $this->pagina404(
                'Produto não informado.'
            );
            return;
        }
        /*
        |--------------------------------------------------------------------------
        | 5. Descriptografa
        |--------------------------------------------------------------------------
        */
        $produtoId =
            IdSeguro::descriptografar(
                $token
            );
        if ($produtoId === null) {
            $this->pagina404(
                'Token do produto inválido.'
            );
            return;
        }
        /*
        |--------------------------------------------------------------------------
        | 6. Repositories
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
        | 7. Busca somente o produto selecionado
        |--------------------------------------------------------------------------
        */
        $produto =
            $produtoRepository
            ->buscarPorId(
                $produtoId
            );
        if ($produto === null) {
            $this->pagina404(
                'Produto não encontrado.'
            );
            return;
        }
        /*
|--------------------------------------------------------------------------
| Gera ID seguro do produto
|--------------------------------------------------------------------------
*/
        $produto['id_seguro'] =
            IdSeguro::criptografar(
                (int) $produto['id']
            );
        /*
        |--------------------------------------------------------------------------
        | 8. Categorias do header
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
        | 9. SEO
        |--------------------------------------------------------------------------
        */
        $tituloPagina =
            $produto['nome']
            . ' - Loja Online';
        $descricaoPagina =
            !empty($produto['descricao'])
            ? (string)
            $produto['descricao']
            : 'Detalhes do produto '
            . $produto['nome'];
        $csrfCarrinho = CsrfCarrinho::gerar();
        /*
        |--------------------------------------------------------------------------
        | 10. View
        |--------------------------------------------------------------------------
        */
        $arquivoView =
            $raizProjeto
            . '/views/site/'
            . 'produtos_detalhes.php';
        if (!is_file($arquivoView)) {
            throw new RuntimeException(
                'A página de detalhes '
                    . 'do produto não foi encontrada.'
            );
        }
        require $arquivoView;
    }
    /*
    |--------------------------------------------------------------------------
    | Página 404
    |--------------------------------------------------------------------------
    */
    private function pagina404(
        string $motivo = ''
    ): void {
        if ($motivo !== '') {
            error_log(
                'ProdutosDetalhesController: '
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
        echo 'Produto não encontrado.';
    }
}
