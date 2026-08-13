<?php

declare(strict_types=1);

namespace App\Controllers\Site;

use App\Helpers\IdSeguro;
use App\Repositories\CategoriaRepository;
use RuntimeException;

class ClienteLoginController
{
    public function index(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Raiz do projeto
        |--------------------------------------------------------------------------
        */
        $raizProjeto =
            dirname(__DIR__, 3);


        /*
        |--------------------------------------------------------------------------
        | 2. Conexão com o banco
        |--------------------------------------------------------------------------
        */
        require_once $raizProjeto
            . '/database/conexao.php';


        $pdo =
            \Config::connect();


        /*
        |--------------------------------------------------------------------------
        | 3. Categorias
        |--------------------------------------------------------------------------
        */
        $categoriaRepository =
            new CategoriaRepository(
                $pdo
            );


        $categorias =
            $categoriaRepository
                ->listarAtivas();


        /*
        |--------------------------------------------------------------------------
        | 4. Gera ID seguro das categorias
        |--------------------------------------------------------------------------
        */
        foreach ($categorias as &$categoria) {

            $categoria['id_seguro'] =
                IdSeguro::criptografar(
                    (int) $categoria['id']
                );
        }


        unset($categoria);


        /*
        |--------------------------------------------------------------------------
        | 5. Dados específicos da página
        |--------------------------------------------------------------------------
        |
        | Futuramente:
        |
        | $ofertas = ...
        |
        */


        /*
        |--------------------------------------------------------------------------
        | 6. Localiza a View
        |--------------------------------------------------------------------------
        */
        $arquivoView =
            $raizProjeto
            . '/views/site/cliente_login.php';


        if (!is_file($arquivoView)) {

            throw new RuntimeException(
                'A página de ofertas não foi encontrada.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | 7. Carrega a View
        |--------------------------------------------------------------------------
        |
        | $categorias estará disponível
        | dentro de ofertas.php.
        |
        */
        require $arquivoView;
    }
}