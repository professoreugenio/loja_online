<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Helpers\IdSeguro;
use App\Repositories\ProdutoAdminRepository;
use DateTime;
use RuntimeException;
use Throwable;

final class ModuloAdminController
{
    public function relatorios(): void
    {
        $this->carregarView('relatorios');
    }

    public function produtos(): void
    {
        [$pdo, $repository] =
            $this->produtoRepository();

        $busca = trim(
            (string) ($_GET['q'] ?? '')
        );

        $categoriaId = filter_input(
            INPUT_GET,
            'categoria',
            FILTER_VALIDATE_INT
        );

        if (
            $categoriaId === false
            || $categoriaId === null
            || $categoriaId < 1
        ) {
            $categoriaId = null;
        }

        $destaqueRecebido =
            (string) ($_GET['destaque'] ?? '');

        $destaque = null;

        if (
            $destaqueRecebido === '0'
            || $destaqueRecebido === '1'
        ) {
            $destaque =
                (int) $destaqueRecebido;
        }

        $categorias =
            $repository->listarCategorias();

        $produtos =
            $repository->listarComFiltros(
                $busca,
                $categoriaId,
                $destaque
            );

        foreach ($produtos as &$produto) {
            $produto['id_seguro'] =
                IdSeguro::criptografar(
                    (int) $produto['id']
                );
        }

        unset($produto);

        $this->carregarView(
            'produtos',
            [
                'produtos' => $produtos,
                'categorias' => $categorias,
                'filtros' => [
                    'q' => $busca,
                    'categoria' => $categoriaId,
                    'destaque' => $destaqueRecebido,
                ],
            ]
        );
    }

    public function produtoNovo(): void
    {
        $this->carregarView('produto_novo');
    }

    public function produtoImagens(): void
    {
        $this->carregarView('produto_imagens');
    }

    public function produtoEditar(): void
    {
        /*
        |--------------------------------------------------------------------------
        | IMPORTANTE
        |--------------------------------------------------------------------------
        |
        | Config::connect() é executado ANTES de IdSeguro::descriptografar().
        | Isso faz o Dotenv carregar APP_KEY do arquivo .env.
        */
        [$pdo, $repository] =
            $this->produtoRepository();

        $token = trim(
            (string) ($_GET['id'] ?? '')
        );

        if ($token === '') {
            http_response_code(400);

            throw new RuntimeException(
                'Produto não informado.'
            );
        }

        $produtoId =
            IdSeguro::descriptografar($token);

        if (
            $produtoId === null
            || $produtoId < 1
        ) {
            http_response_code(400);

            throw new RuntimeException(
                'Identificador do produto inválido.'
            );
        }

        $produto =
            $repository->buscarPorId(
                $produtoId
            );

        if ($produto === null) {
            http_response_code(404);

            throw new RuntimeException(
                'Produto não encontrado.'
            );
        }

        $categorias =
            $repository->listarCategorias();

        $erro =
            $_SESSION['admin_produto_erro']
            ?? null;

        $sucesso =
            $_SESSION['admin_produto_sucesso']
            ?? null;

        $dadosFormulario =
            $_SESSION['admin_produto_dados']
            ?? $produto;

        unset(
            $_SESSION['admin_produto_erro'],
            $_SESSION['admin_produto_sucesso'],
            $_SESSION['admin_produto_dados']
        );

        $csrfToken =
            $this->gerarCsrfProduto();

        $this->carregarView(
            'produto_editar',
            [
                'produto' => $produto,
                'dadosFormulario' => $dadosFormulario,
                'categorias' => $categorias,
                'produtoToken' => $token,
                'csrfToken' => $csrfToken,
                'erro' => $erro,
                'sucesso' => $sucesso,
            ]
        );
    }

    public function produtoAtualizar(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Carrega .env / APP_KEY antes de descriptografar o token
        |--------------------------------------------------------------------------
        */
        [$pdo, $repository] =
            $this->produtoRepository();

        $token = trim(
            (string) ($_POST['id'] ?? '')
        );

        if ($token === '') {
            http_response_code(400);

            throw new RuntimeException(
                'Produto não informado.'
            );
        }

        $produtoId =
            IdSeguro::descriptografar(
                $token
            );

        if (
            $produtoId === null
            || $produtoId < 1
        ) {
            http_response_code(400);

            throw new RuntimeException(
                'Identificador do produto inválido.'
            );
        }

        $csrfToken =
            (string) ($_POST['csrf_token'] ?? '');

        if (
            !$this->validarCsrfProduto(
                $csrfToken
            )
        ) {
            $this->redirecionarProdutoEditar(
                $token,
                'O formulário expirou. Atualize a página e tente novamente.',
                $_POST
            );
        }

        $categoriaId = filter_input(
            INPUT_POST,
            'categoria_id',
            FILTER_VALIDATE_INT
        );

        $nome = trim(
            (string) ($_POST['nome'] ?? '')
        );

        $slug = trim(
            (string) ($_POST['slug'] ?? '')
        );

        $descricao = trim(
            (string) ($_POST['descricao'] ?? '')
        );

        $precoTexto = str_replace(
            ',',
            '.',
            trim((string) ($_POST['preco'] ?? ''))
        );

        $estoque = filter_input(
            INPUT_POST,
            'estoque',
            FILTER_VALIDATE_INT
        );

        $status = trim(
            (string) ($_POST['status'] ?? '')
        );

        $destaque =
            isset($_POST['destaque'])
                ? 1
                : 0;

        $ofertaAtiva =
            isset($_POST['oferta_ativa'])
                ? 1
                : 0;

        $percentualTexto = str_replace(
            ',',
            '.',
            trim(
                (string) (
                    $_POST['percentual_oferta']
                    ?? ''
                )
            )
        );

        $ofertaInicioTexto = trim(
            (string) (
                $_POST['oferta_inicio']
                ?? ''
            )
        );

        $ofertaFimTexto = trim(
            (string) (
                $_POST['oferta_fim']
                ?? ''
            )
        );

        $erros = [];

        if (
            !$categoriaId
            || $categoriaId < 1
        ) {
            $erros[] =
                'Selecione uma categoria válida.';
        }

        if ($nome === '') {
            $erros[] =
                'Informe o nome do produto.';
        }

        if ($slug === '') {
            $slug =
                $this->gerarSlug($nome);
        }

        if (
            $precoTexto === ''
            || !is_numeric($precoTexto)
            || (float) $precoTexto < 0
        ) {
            $erros[] =
                'Informe um preço válido.';
        }

        if (
            $estoque === false
            || $estoque === null
            || $estoque < 0
        ) {
            $erros[] =
                'Informe um estoque válido.';
        }

        if (
            !in_array(
                $status,
                ['ativo', 'inativo'],
                true
            )
        ) {
            $erros[] =
                'Status inválido.';
        }

        $percentualOferta = null;

        if ($percentualTexto !== '') {
            if (
                !is_numeric($percentualTexto)
                || (float) $percentualTexto < 0
                || (float) $percentualTexto > 100
            ) {
                $erros[] =
                    'O percentual da oferta deve estar entre 0 e 100.';
            } else {
                $percentualOferta =
                    number_format(
                        (float) $percentualTexto,
                        2,
                        '.',
                        ''
                    );
            }
        }

        if (
            $ofertaAtiva === 1
            && (
                $percentualOferta === null
                || (float) $percentualOferta <= 0
            )
        ) {
            $erros[] =
                'Informe um percentual maior que zero para ativar a oferta.';
        }

        $ofertaInicio =
            $this->converterDataHora(
                $ofertaInicioTexto
            );

        $ofertaFim =
            $this->converterDataHora(
                $ofertaFimTexto
            );

        if (
            $ofertaInicioTexto !== ''
            && $ofertaInicio === null
        ) {
            $erros[] =
                'Data inicial da oferta inválida.';
        }

        if (
            $ofertaFimTexto !== ''
            && $ofertaFim === null
        ) {
            $erros[] =
                'Data final da oferta inválida.';
        }

        if (
            $ofertaInicio !== null
            && $ofertaFim !== null
            && strtotime($ofertaFim)
                <= strtotime($ofertaInicio)
        ) {
            $erros[] =
                'A data final da oferta deve ser posterior à data inicial.';
        }

        if ($erros !== []) {
            $this->redirecionarProdutoEditar(
                $token,
                implode(' ', $erros),
                $_POST
            );
        }

        $dados = [
            'categoria_id' => (int) $categoriaId,
            'nome' => $nome,
            'slug' => $slug,
            'descricao' =>
                $descricao !== ''
                    ? $descricao
                    : null,
            'preco' =>
                number_format(
                    (float) $precoTexto,
                    2,
                    '.',
                    ''
                ),
            'oferta_ativa' => $ofertaAtiva,
            'percentual_oferta' =>
                $ofertaAtiva === 1
                    ? $percentualOferta
                    : null,
            'oferta_inicio' =>
                $ofertaAtiva === 1
                    ? $ofertaInicio
                    : null,
            'oferta_fim' =>
                $ofertaAtiva === 1
                    ? $ofertaFim
                    : null,
            'estoque' => (int) $estoque,
            'status' => $status,
            'destaque' => $destaque,
        ];

        try {
            $repository->atualizar(
                $produtoId,
                $dados
            );

            $_SESSION['admin_produto_sucesso'] =
                'Produto atualizado com sucesso.';

            header(
                'Location: '
                . $this->baseUrl()
                . '/admin/produto/editar?id='
                . rawurlencode($token)
            );

            exit;

        } catch (Throwable $erro) {
            error_log(
                '[ADMIN PRODUTO ATUALIZAR] '
                . $erro->getMessage()
            );

            $this->redirecionarProdutoEditar(
                $token,
                'Não foi possível atualizar o produto. Verifique os dados e tente novamente.',
                $_POST
            );
        }
    }

    public function categorias(): void
    {
        $this->carregarView('categorias');
    }

    public function clientes(): void
    {
        $this->carregarView('clientes');
    }

    public function pedidos(): void
    {
        $this->carregarView('pedidos');
    }

    public function pedidoDetalhes(): void
    {
        $pedidoId = filter_input(
            INPUT_GET,
            'id',
            FILTER_VALIDATE_INT
        );

        if (!$pedidoId || $pedidoId < 1) {
            http_response_code(400);

            throw new RuntimeException(
                'Pedido inválido ou não informado.'
            );
        }

        $this->carregarView(
            'pedidos/detalhes',
            [
                'pedidoId' =>
                    (int) $pedidoId,
            ]
        );
    }

    public function pagamentos(): void
    {
        $this->carregarView('pagamentos');
    }

    public function carrinhos(): void
    {
        $this->carregarView('carrinhos');
    }

    public function estoque(): void
    {
        $filtro = trim(
            (string) ($_GET['filtro'] ?? '')
        );

        $this->carregarView(
            'estoque',
            [
                'filtro' => $filtro,
            ]
        );
    }

    public function notificacoes(): void
    {
        $this->carregarView('notificacoes');
    }

    public function contatos(): void
    {
        $this->carregarView('contatos');
    }

    public function configuracoes(): void
    {
        $this->carregarView('configuracoes');
    }

    public function perfil(): void
    {
        $this->carregarView('perfil');
    }

    public function perfilNovo(): void
    {
        $this->carregarView('perfil_novo');
    }

    public function perfilLista(): void
    {
        $this->carregarView('perfil_lista');
    }

    public function buscar(): void
    {
        $termo = trim(
            (string) ($_GET['q'] ?? '')
        );

        $this->carregarView(
            'buscar',
            [
                'termo' => $termo,
            ]
        );
    }

    public function sair(): void
    {
        unset(
            $_SESSION['admin_id'],
            $_SESSION['admin_nome'],
            $_SESSION['admin_email'],
            $_SESSION['usuario_admin']
        );

        session_regenerate_id(true);

        header(
            'Location: '
            . $this->baseUrl()
            . '/loginadmin'
        );

        exit;
    }

    private function produtoRepository(): array
    {
        $raizProjeto =
            dirname(__DIR__, 3);

        require_once $raizProjeto
            . '/database/conexao.php';

        /*
         * Config::connect() carrega o .env
         * por meio do phpdotenv.
         */
        $pdo =
            \Config::connect();

        return [
            $pdo,
            new ProdutoAdminRepository($pdo),
        ];
    }

    private function gerarCsrfProduto(): string
    {
        if (
            empty(
                $_SESSION['admin_produto_csrf']
            )
        ) {
            $_SESSION['admin_produto_csrf'] =
                bin2hex(
                    random_bytes(32)
                );
        }

        return (string)
            $_SESSION['admin_produto_csrf'];
    }

    private function validarCsrfProduto(
        string $token
    ): bool {
        $salvo =
            (string) (
                $_SESSION['admin_produto_csrf']
                ?? ''
            );

        return $token !== ''
            && $salvo !== ''
            && hash_equals(
                $salvo,
                $token
            );
    }

    private function gerarSlug(
        string $texto
    ): string {
        $texto = trim($texto);

        if ($texto === '') {
            return '';
        }

        $convertido = iconv(
            'UTF-8',
            'ASCII//TRANSLIT//IGNORE',
            $texto
        );

        if ($convertido !== false) {
            $texto = $convertido;
        }

        $texto = strtolower($texto);

        $texto = preg_replace(
            '/[^a-z0-9]+/',
            '-',
            $texto
        ) ?? '';

        return trim(
            $texto,
            '-'
        );
    }

    private function converterDataHora(
        string $valor
    ): ?string {
        $valor = trim($valor);

        if ($valor === '') {
            return null;
        }

        $data =
            DateTime::createFromFormat(
                'Y-m-d\TH:i',
                $valor
            );

        if (
            !$data
            || $data->format('Y-m-d\TH:i')
                !== $valor
        ) {
            return null;
        }

        return $data->format(
            'Y-m-d H:i:s'
        );
    }

    private function redirecionarProdutoEditar(
        string $token,
        string $erro,
        array $dados
    ): never {
        $_SESSION['admin_produto_erro'] =
            $erro;

        $_SESSION['admin_produto_dados'] =
            $dados;

        header(
            'Location: '
            . $this->baseUrl()
            . '/admin/produto/editar?id='
            . rawurlencode($token)
        );

        exit;
    }

    private function baseUrl(): string
    {
        return defined('BASE_URL')
            ? rtrim(BASE_URL, '/')
            : '/loja_online/public';
    }

    private function carregarView(
        string $view,
        array $dados = []
    ): void {
        $view = trim(
            str_replace('\\', '/', $view),
            '/'
        );

        if (
            $view === ''
            || str_contains($view, '..')
        ) {
            throw new RuntimeException(
                'Nome de view administrativa inválido.'
            );
        }

        $arquivoView =
            dirname(__DIR__, 3)
            . '/views/admin/'
            . $view
            . '.php';

        if (!is_file($arquivoView)) {
            http_response_code(404);

            throw new RuntimeException(
                'View administrativa não encontrada: '
                . $view
            );
        }

        extract(
            $dados,
            EXTR_SKIP
        );

        require $arquivoView;
    }
}
