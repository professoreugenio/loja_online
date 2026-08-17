<?php

declare(strict_types=1);

namespace App\Controllers\Cliente;

use App\Helpers\ClienteAuth;
use App\Repositories\ClienteRepository;

final class ClienteController
{
    public function painel(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Proteção
        |--------------------------------------------------------------------------
        */

        ClienteAuth::exigirLogin();


        /*
        |--------------------------------------------------------------------------
        | Banco
        |--------------------------------------------------------------------------
        */

        require_once APP_ROOT
            . '/database/conexao.php';

        $pdo =
            \Config::connect();


        /*
        |--------------------------------------------------------------------------
        | Repository
        |--------------------------------------------------------------------------
        */

        $clienteRepository =
            new ClienteRepository(
                $pdo
            );


        /*
        |--------------------------------------------------------------------------
        | Cliente autenticado
        |--------------------------------------------------------------------------
        */

        $clienteId =
            ClienteAuth::id();


        $cliente =
            $clienteRepository
            ->buscarPorId(
                (int)
                $clienteId
            );


        if ($cliente === null) {

            ClienteAuth::sair();

            header(
                'Location: '
                    . BASE_URL
                    . '/cliente/login'
            );

            exit;
        }


        /*
        |--------------------------------------------------------------------------
        | View
        |--------------------------------------------------------------------------
        */

        $arquivoView =
            APP_ROOT
            . '/views/cliente/painel.php';

        if (!is_file($arquivoView)) {
            throw new \RuntimeException(
                'A página do painel do cliente não foi encontrada: '
                    . $arquivoView
            );
        }

        require $arquivoView;
    }
}
