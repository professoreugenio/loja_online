<?php

declare(strict_types=1);

namespace App\Controllers\Cliente;

use App\Helpers\ClienteAuth;
use RuntimeException;

final class PerfilController
{
    public function index(): void
    {
        ClienteAuth::exigirLogin();


        $arquivoView =
            APP_ROOT
            . '/views/cliente/perfil.php';


        if (!is_file($arquivoView)) {

            throw new RuntimeException(
                'A página de perfil '
                    . 'não foi encontrada.'
            );
        }


        require $arquivoView;
    }


    public function seguranca(): void
    {
        ClienteAuth::exigirLogin();


        $arquivoView =
            APP_ROOT
            . '/views/cliente/seguranca.php';


        if (!is_file($arquivoView)) {

            throw new RuntimeException(
                'A página de segurança '
                    . 'não foi encontrada.'
            );
        }


        require $arquivoView;
    }
}
