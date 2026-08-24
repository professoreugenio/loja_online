<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Helpers\IdSeguro;
use App\Repositories\ProdutoAdminRepository;
use RuntimeException;

final class ModuloAdminController
{
    public function relatorios(): void
    {
        $this->carregarView('relatorios');
    }

    public function produtos(): void
    {
        $raizProjeto = dirname(__DIR__, 3);

        require_once $raizProjeto
            . '/database/conexao.php';

        $pdo = \Config::connect();

        $repository =
            new ProdutoAdminRepository($pdo);

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
    public function produtoEditar(): void
    {
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

        $this->carregarView(
            'produto_editar',
            [
                'produtoId' => $produtoId,
                'produtoToken' => $token,
            ]
        );
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

        /*
         * Quando a tela de detalhes for implementada,
         * consulte o pedido pelo Repository antes de carregar a view.
         */
        $this->carregarView(
            'pedidos/detalhes',
            [
                'pedidoId' => (int) $pedidoId,
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
        /*
         * Ajuste as chaves abaixo caso sua autenticação admin
         * utilize nomes específicos dentro de $_SESSION.
         */
        unset(
            $_SESSION['admin_id'],
            $_SESSION['admin_nome'],
            $_SESSION['admin_email'],
            $_SESSION['usuario_admin']
        );

        session_regenerate_id(true);

        $destino = defined('BASE_URL')
            ? BASE_URL . '/loginadmin'
            : '/loja_online/public/loginadmin';

        header(
            'Location: ' . $destino
        );
        exit;
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