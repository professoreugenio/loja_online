<?php
declare(strict_types=1);
namespace App\Controllers\Site;
use App\Helpers\CarrinhoSessao;
use App\Helpers\ClienteAuth;
use App\Helpers\CsrfCarrinho;
use App\Helpers\IdSeguro;
use App\Repositories\CarrinhoRepository;
use App\Repositories\CategoriaRepository;
use App\Repositories\ProdutoRepository;
use RuntimeException;
final class CarrinhoController
{
    /*
    |--------------------------------------------------------------------------
    | Repositories
    |--------------------------------------------------------------------------
    */
    private CarrinhoRepository
        $carrinhoRepository;
    private ProdutoRepository
        $produtoRepository;
    private CategoriaRepository
        $categoriaRepository;
    /*
    |--------------------------------------------------------------------------
    | Construtor
    |--------------------------------------------------------------------------
    */
    public function __construct()
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Conexão
        |--------------------------------------------------------------------------
        */
        require_once APP_ROOT
            . '/database/conexao.php';
        $pdo =
            \Config::connect();
        /*
        |--------------------------------------------------------------------------
        | 2. Repositories
        |--------------------------------------------------------------------------
        */
        $this->carrinhoRepository =
            new CarrinhoRepository(
                $pdo
            );
        $this->produtoRepository =
            new ProdutoRepository(
                $pdo
            );
        $this->categoriaRepository =
            new CategoriaRepository(
                $pdo
            );
    }
    /*
    |--------------------------------------------------------------------------
    | Exibir carrinho
    |--------------------------------------------------------------------------
    */
    public function index(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Obtém o carrinho atual
        |--------------------------------------------------------------------------
        */
        $carrinhoId =
            $this->carrinhoAtualId();
        /*
        |--------------------------------------------------------------------------
        | 2. Lista os itens
        |--------------------------------------------------------------------------
        */
        $itens =
            $this->carrinhoRepository
                ->listarItens(
                    $carrinhoId
                );
        /*
        |--------------------------------------------------------------------------
        | 3. Gera ID seguro dos produtos
        |--------------------------------------------------------------------------
        */
        foreach (
            $itens
            as &$item
        ) {
            $item['id_seguro'] =
                IdSeguro::criptografar(
                    (int)
                    $item['produto_id']
                );
        }
        unset($item);
        /*
        |--------------------------------------------------------------------------
        | 4. Calcula subtotal
        |--------------------------------------------------------------------------
        */
        $subtotal = 0.0;
        foreach (
            $itens
            as $item
        ) {
            $subtotal +=
                (float)
                $item['preco_unitario']
                *
                (int)
                $item['quantidade'];
        }
        /*
        |--------------------------------------------------------------------------
        | 5. Frete
        |--------------------------------------------------------------------------
        |
        | Nesta etapa ainda não estamos
        | calculando o frete.
        |
        */
        $frete = 0.0;
        /*
        |--------------------------------------------------------------------------
        | 6. Total
        |--------------------------------------------------------------------------
        */
        $total =
            $subtotal
            + $frete;
        /*
        |--------------------------------------------------------------------------
        | 7. Parcelamento
        |--------------------------------------------------------------------------
        */
        $quantidadeParcelas = 10;
        $valorParcela =
            $total > 0
                ? $total
                    / $quantidadeParcelas
                : 0.0;
        /*
        |--------------------------------------------------------------------------
        | 8. Categorias do header
        |--------------------------------------------------------------------------
        */
        $categorias =
            $this->categoriaRepository
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
        | 9. CSRF
        |--------------------------------------------------------------------------
        */
        $csrfToken =
            CsrfCarrinho::gerar();
        /*
        |--------------------------------------------------------------------------
        | 10. Mensagens flash
        |--------------------------------------------------------------------------
        */
        $mensagemSucesso =
            $_SESSION[
                'carrinho_sucesso'
            ]
            ?? null;
        $mensagemErro =
            $_SESSION[
                'carrinho_erro'
            ]
            ?? null;
        unset(
            $_SESSION[
                'carrinho_sucesso'
            ],
            $_SESSION[
                'carrinho_erro'
            ]
        );
        /*
        |--------------------------------------------------------------------------
        | 11. SEO
        |--------------------------------------------------------------------------
        */
        $tituloPagina =
            'Carrinho de Compras';
        $descricaoPagina =
            'Confira os produtos '
            . 'adicionados ao seu carrinho.';
        /*
        |--------------------------------------------------------------------------
        | 12. View
        |--------------------------------------------------------------------------
        */
        $arquivoView =
            APP_ROOT
            . '/views/site/carrinho.php';
        if (!is_file($arquivoView)) {
            throw new RuntimeException(
                'A página do carrinho '
                . 'não foi encontrada.'
            );
        }
        require $arquivoView;
    }
    /*
    |--------------------------------------------------------------------------
    | Adicionar produto
    |--------------------------------------------------------------------------
    */
    public function adicionar(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Valida CSRF
        |--------------------------------------------------------------------------
        */
        $csrfToken =
            isset(
                $_POST['csrf_token']
            )
                ? (string)
                    $_POST['csrf_token']
                : null;
        if (
            !CsrfCarrinho::validar(
                $csrfToken
            )
        ) {
            http_response_code(403);
            exit(
                'Solicitação inválida.'
            );
        }
        /*
        |--------------------------------------------------------------------------
        | 2. Recebe o produto criptografado
        |--------------------------------------------------------------------------
        */
        $tokenProduto =
            trim(
                (string) (
                    $_POST['produto']
                    ?? ''
                )
            );
        if ($tokenProduto === '') {
            $this->falhar(
                'Produto não informado.'
            );
            return;
        }
        /*
        |--------------------------------------------------------------------------
        | 3. Descriptografa o ID
        |--------------------------------------------------------------------------
        */
        $produtoId =
            IdSeguro::descriptografar(
                $tokenProduto
            );
        if ($produtoId === null) {
            $this->falhar(
                'Produto inválido.'
            );
            return;
        }
        /*
        |--------------------------------------------------------------------------
        | 4. Quantidade
        |--------------------------------------------------------------------------
        */
        $quantidade =
            filter_var(
                $_POST['quantidade']
                ?? 1,
                FILTER_VALIDATE_INT
            );
        if (
            $quantidade === false
            ||
            $quantidade < 1
        ) {
            $quantidade = 1;
        }
        /*
        |--------------------------------------------------------------------------
        | 5. Busca o produto real
        |--------------------------------------------------------------------------
        */
        $produto =
            $this->produtoRepository
                ->buscarPorId(
                    (int)
                    $produtoId
                );
        if ($produto === null) {
            $this->falhar(
                'Produto não encontrado.'
            );
            return;
        }
        /*
        |--------------------------------------------------------------------------
        | 6. Estoque
        |--------------------------------------------------------------------------
        */
        $estoque =
            (int)
            $produto['estoque'];
        if ($estoque < 1) {
            $this->falhar(
                'Produto sem estoque.'
            );
            return;
        }
        /*
        |--------------------------------------------------------------------------
        | 7. Carrinho atual
        |--------------------------------------------------------------------------
        */
        $carrinhoId =
            $this->carrinhoAtualId();
        /*
        |--------------------------------------------------------------------------
        | 8. Quantidade que já existe
        |--------------------------------------------------------------------------
        */
        $quantidadeAtual =
            $this->carrinhoRepository
                ->quantidadeDoProduto(
                    $carrinhoId,
                    (int)
                    $produtoId
                );
        /*
        |--------------------------------------------------------------------------
        | 9. Nova quantidade
        |--------------------------------------------------------------------------
        */
        $novaQuantidade =
            $quantidadeAtual
            + $quantidade;
        /*
        |--------------------------------------------------------------------------
        | 10. Valida estoque
        |--------------------------------------------------------------------------
        */
        if (
            $novaQuantidade
            > $estoque
        ) {
            $this->falhar(
                'A quantidade solicitada '
                . 'é maior que o estoque '
                . 'disponível.'
            );
            return;
        }
        /*
        |--------------------------------------------------------------------------
        | 11. Define o preço
        |--------------------------------------------------------------------------
        */
        $precoUnitario =
            isset(
                $produto[
                    'preco_oferta'
                ]
            )
            &&
            $produto[
                'preco_oferta'
            ] !== null
                ? (float)
                    $produto[
                        'preco_oferta'
                    ]
                : (float)
                    $produto['preco'];
        /*
        |--------------------------------------------------------------------------
        | 12. Salva o item
        |--------------------------------------------------------------------------
        */
        $this->carrinhoRepository
            ->salvarItem(
                $carrinhoId,
                (int)
                $produtoId,
                $novaQuantidade,
                $precoUnitario
            );
        /*
        |--------------------------------------------------------------------------
        | 13. Renova CSRF
        |--------------------------------------------------------------------------
        */
        CsrfCarrinho::renovar();
        /*
        |--------------------------------------------------------------------------
        | 14. Mensagem
        |--------------------------------------------------------------------------
        */
        $_SESSION[
            'carrinho_sucesso'
        ] =
            'Produto adicionado '
            . 'ao carrinho.';
        /*
        |--------------------------------------------------------------------------
        | 15. Redireciona
        |--------------------------------------------------------------------------
        */
        header(
            'Location: '
            . BASE_URL
            . '/carrinho'
        );
        exit;
    }
    /*
    |--------------------------------------------------------------------------
    | Atualizar quantidade
    |--------------------------------------------------------------------------
    */
    public function atualizar(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1. CSRF
        |--------------------------------------------------------------------------
        */
        $csrfToken =
            isset(
                $_POST['csrf_token']
            )
                ? (string)
                    $_POST['csrf_token']
                : null;
        if (
            !CsrfCarrinho::validar(
                $csrfToken
            )
        ) {
            http_response_code(403);
            exit(
                'Solicitação inválida.'
            );
        }
        /*
        |--------------------------------------------------------------------------
        | 2. Produto criptografado
        |--------------------------------------------------------------------------
        */
        $tokenProduto =
            trim(
                (string) (
                    $_POST['produto']
                    ?? ''
                )
            );
        $produtoId =
            IdSeguro::descriptografar(
                $tokenProduto
            );
        if ($produtoId === null) {
            $this->falhar(
                'Produto inválido.'
            );
            return;
        }
        /*
        |--------------------------------------------------------------------------
        | 3. Quantidade
        |--------------------------------------------------------------------------
        */
        $quantidade =
            filter_var(
                $_POST['quantidade']
                ?? null,
                FILTER_VALIDATE_INT
            );
        if (
            $quantidade === false
            ||
            $quantidade < 1
        ) {
            $this->falhar(
                'Quantidade inválida.'
            );
            return;
        }
        /*
        |--------------------------------------------------------------------------
        | 4. Busca produto
        |--------------------------------------------------------------------------
        */
        $produto =
            $this->produtoRepository
                ->buscarPorId(
                    (int)
                    $produtoId
                );
        if ($produto === null) {
            $this->falhar(
                'Produto não encontrado.'
            );
            return;
        }
        /*
        |--------------------------------------------------------------------------
        | 5. Valida estoque
        |--------------------------------------------------------------------------
        */
        $estoque =
            (int)
            $produto['estoque'];
        if (
            $quantidade
            > $estoque
        ) {
            $this->falhar(
                'Quantidade superior '
                . 'ao estoque disponível.'
            );
            return;
        }
        /*
        |--------------------------------------------------------------------------
        | 6. Carrinho
        |--------------------------------------------------------------------------
        */
        $carrinhoId =
            $this->carrinhoAtualId();
        /*
        |--------------------------------------------------------------------------
        | 7. Atualiza
        |--------------------------------------------------------------------------
        */
        $this->carrinhoRepository
            ->atualizarQuantidade(
                $carrinhoId,
                (int)
                $produtoId,
                (int)
                $quantidade
            );
        /*
        |--------------------------------------------------------------------------
        | 8. Renova CSRF
        |--------------------------------------------------------------------------
        */
        CsrfCarrinho::renovar();
        /*
        |--------------------------------------------------------------------------
        | 9. Mensagem
        |--------------------------------------------------------------------------
        */
        $_SESSION[
            'carrinho_sucesso'
        ] =
            'Quantidade atualizada.';
        /*
        |--------------------------------------------------------------------------
        | 10. Redireciona
        |--------------------------------------------------------------------------
        */
        header(
            'Location: '
            . BASE_URL
            . '/carrinho'
        );
        exit;
    }
    /*
    |--------------------------------------------------------------------------
    | Remover produto
    |--------------------------------------------------------------------------
    */
    public function remover(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1. CSRF
        |--------------------------------------------------------------------------
        */
        $csrfToken =
            isset(
                $_POST['csrf_token']
            )
                ? (string)
                    $_POST['csrf_token']
                : null;
        if (
            !CsrfCarrinho::validar(
                $csrfToken
            )
        ) {
            http_response_code(403);
            exit(
                'Solicitação inválida.'
            );
        }
        /*
        |--------------------------------------------------------------------------
        | 2. Produto criptografado
        |--------------------------------------------------------------------------
        */
        $tokenProduto =
            trim(
                (string) (
                    $_POST['produto']
                    ?? ''
                )
            );
        $produtoId =
            IdSeguro::descriptografar(
                $tokenProduto
            );
        if ($produtoId === null) {
            $this->falhar(
                'Produto inválido.'
            );
            return;
        }
        /*
        |--------------------------------------------------------------------------
        | 3. Carrinho atual
        |--------------------------------------------------------------------------
        */
        $carrinhoId =
            $this->carrinhoAtualId();
        /*
        |--------------------------------------------------------------------------
        | 4. Remove
        |--------------------------------------------------------------------------
        */
        $this->carrinhoRepository
            ->removerItem(
                $carrinhoId,
                (int)
                $produtoId
            );
        /*
        |--------------------------------------------------------------------------
        | 5. Renova CSRF
        |--------------------------------------------------------------------------
        */
        CsrfCarrinho::renovar();
        /*
        |--------------------------------------------------------------------------
        | 6. Mensagem
        |--------------------------------------------------------------------------
        */
        $_SESSION[
            'carrinho_sucesso'
        ] =
            'Produto removido '
            . 'do carrinho.';
        /*
        |--------------------------------------------------------------------------
        | 7. Redireciona
        |--------------------------------------------------------------------------
        */
        header(
            'Location: '
            . BASE_URL
            . '/carrinho'
        );
        exit;
    }
    /*
    |--------------------------------------------------------------------------
    | Obtém ou cria carrinho atual
    |--------------------------------------------------------------------------
    */
    private function carrinhoAtualId(): int
    {
        /*
        |--------------------------------------------------------------------------
        | Token da sessão
        |--------------------------------------------------------------------------
        */
        $tokenSessao =
            CarrinhoSessao::token();
        /*
        |--------------------------------------------------------------------------
        | Cliente
        |--------------------------------------------------------------------------
        */
        $clienteId = null;
        if (
            ClienteAuth::logado()
        ) {
            $clienteId =
                (int)
                ClienteAuth::id();
        }
        /*
        |--------------------------------------------------------------------------
        | Obtém ou cria
        |--------------------------------------------------------------------------
        */
        return
            $this->carrinhoRepository
                ->obterOuCriar(
                    $clienteId,
                    $tokenSessao
                );
    }
    /*
    |--------------------------------------------------------------------------
    | Falha da operação
    |--------------------------------------------------------------------------
    */
    private function falhar(
        string $mensagem
    ): void {
        $_SESSION[
            'carrinho_erro'
        ] =
            $mensagem;
        header(
            'Location: '
            . BASE_URL
            . '/carrinho'
        );
        exit;
    }
}