<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use RuntimeException;

final class ModuloAdminController
{
    public function relatorios(): void
    {
        $this->carregarView('relatorios');
    }

    public function produtos(): void
    {
        $this->carregarView('produtos');
    }

    public function novoProduto(): void
    {
        $this->carregarView('produto_novo');
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
