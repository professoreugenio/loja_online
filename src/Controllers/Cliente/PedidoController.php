<?php

declare(strict_types=1);

namespace App\Controllers\Cliente;

use App\Helpers\ClienteAuth;
use RuntimeException;

final class PedidoController
{
    public function index(): void
    {
        ClienteAuth::exigirLogin();


        $arquivoView =
            APP_ROOT
            . '/views/cliente/pedidos.php';


        if (!is_file($arquivoView)) {

            throw new RuntimeException(
                'A página de pedidos '
                    . 'não foi encontrada.'
            );
        }


        require $arquivoView;
    }


    public function detalhe(): void
    {
        ClienteAuth::exigirLogin();


        $arquivoView =
            APP_ROOT
            . '/views/cliente/pedido.php';


        if (!is_file($arquivoView)) {

            throw new RuntimeException(
                'A página do pedido '
                    . 'não foi encontrada.'
            );
        }


        require $arquivoView;
    }
}
