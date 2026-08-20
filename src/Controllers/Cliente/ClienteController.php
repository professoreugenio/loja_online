<?php

declare(strict_types=1);

namespace App\Controllers\Cliente;

use App\Helpers\ClienteAuth;
use App\Helpers\IdSeguro;
use App\Repositories\ClienteRepository;
use App\Repositories\EnderecoRepository;
use App\Repositories\PedidoRepository;

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
        $clienteRepository =
            new ClienteRepository(
                $pdo
            );
        $pedidoRepository =
            new PedidoRepository(
                $pdo
            );
        $enderecoRepository =
            new EnderecoRepository(
                $pdo
            );
        $clienteId =
            ClienteAuth::id();
        if ($clienteId === null) {
            ClienteAuth::exigirLogin();
            return;
        }
        $cliente =
            $clienteRepository
            ->buscarPorId(
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

        $resumoPedidos =
            $pedidoRepository
            ->resumoPainel(
                $clienteId
            );

        $totalPedidos =
            $resumoPedidos['total_pedidos'];


        $pedidosEmAndamento =
            $resumoPedidos['em_andamento'];


        $pedidosEntregues =
            $resumoPedidos['entregues'];

        $ultimosPedidos =
            $pedidoRepository
            ->listarUltimosDoCliente(
                $clienteId,
                3
            );

        foreach (
            $ultimosPedidos
            as &$pedido
        ) {

            $pedido['id_seguro'] =
                IdSeguro::criptografar(
                    (int)
                    $pedido['id']
                );
        }


        unset($pedido);

        $quantidadeEnderecos =
            $enderecoRepository
            ->contarPorCliente(
                $clienteId
            );


        $enderecoPrincipal =
            $enderecoRepository
            ->buscarPrincipalPorCliente(
                $clienteId
            );

        $nomeCompleto =
            trim(
                (string)
                $cliente['nome']
            );


        $primeiroNome =
            $nomeCompleto;


        $partesNome =
            preg_split(
                '/\s+/',
                $nomeCompleto
            );


        if (
            is_array($partesNome)
            &&
            isset($partesNome[0])
        ) {

            $primeiroNome =
                $partesNome[0];
        }
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
