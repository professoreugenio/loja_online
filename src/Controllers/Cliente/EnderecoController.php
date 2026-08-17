<?php

declare(strict_types=1);

namespace App\Controllers\Cliente;

use App\Helpers\ClienteAuth;
use RuntimeException;

final class EnderecoController
{
    public function index(): void
    {
        ClienteAuth::exigirLogin();


        $arquivoView =
            APP_ROOT
            . '/views/cliente/enderecos.php';


        if (!is_file($arquivoView)) {

            throw new RuntimeException(
                'A página de endereços '
                    . 'não foi encontrada.'
            );
        }


        require $arquivoView;
    }
}
