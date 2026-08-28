<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Repositories\AdminRepository;
use RuntimeException;

final class AdminController
{
    public function index(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Raiz do projeto
        |--------------------------------------------------------------------------
        */
        $raizProjeto = dirname(__DIR__, 3);

        /*
        |--------------------------------------------------------------------------
        | 2. Conexão PDO
        |--------------------------------------------------------------------------
        */
        require_once $raizProjeto
            . '/database/conexao.php';

        $pdo = \Config::connect();

        /*
        |--------------------------------------------------------------------------
        | 3. Repository do dashboard
        |--------------------------------------------------------------------------
        */
        $AdminRepository =
            new AdminRepository($pdo);

        /*
        |--------------------------------------------------------------------------
        | 4. Dados reais do banco
        |--------------------------------------------------------------------------
        */
        $indicadores =
            $AdminRepository
                ->obterIndicadores();

        $pedidosRecentes =
            $AdminRepository
                ->listarPedidosRecentes(5);

        $produtosEstoqueBaixo =
            $AdminRepository
                ->listarEstoqueBaixo(5);

        /*
        |--------------------------------------------------------------------------
        | 5. Módulos que ainda não possuem tabela no SQL atual
        |--------------------------------------------------------------------------
        |
        | O arquivo loja_virtual_db enviado não possui:
        | - notificacoes
        | - contatos
        |
        | Mantemos 0 para não criar consultas em tabelas inexistentes.
        */
        $notificacoesNaoLidas = 0;
        $contatosRecebidos = 0;
        $contatosAguardando = 0;

        /*
        |--------------------------------------------------------------------------
        | 6. View
        |--------------------------------------------------------------------------
        */
        $arquivoView =
            $raizProjeto
            . '/views/admin/dashboard.php';

        if (!is_file($arquivoView)) {
            throw new RuntimeException(
                'A página dashboard administrativo não foi encontrada.'
            );
        }

        require $arquivoView;
    }
}
