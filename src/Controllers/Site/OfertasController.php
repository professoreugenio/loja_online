<?php

declare(strict_types=1);

namespace App\Controllers\Site;

use App\Helpers\IdSeguro;
use App\Repositories\CategoriaRepository;
use RuntimeException;

class OfertasController
{
    public function index(): void
    {
<<<<<<< HEAD
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
            . '/views/site/ofertas.php';

=======
>>>>>>> a44f3531591f7935422e38ed5728e818c04fdfe5

        $raizProjeto =
            dirname(__DIR__, 3);

        require_once $raizProjeto
            . '/database/conexao.php';
        $pdo =
            \Config::connect();

        $categoriaRepository =
            new CategoriaRepository(
                $pdo
            );
        $categorias =
            $categoriaRepository
            ->listarAtivas();

        foreach ($categorias as &$categoria) {
            $categoria['id_seguro'] =
                IdSeguro::criptografar(
                    (int) $categoria['id']
                );
        }
        unset($categoria);

        $arquivoView =
            $raizProjeto
            . '/views/site/ofertas.php';
        if (!is_file($arquivoView)) {
<<<<<<< HEAD

=======
>>>>>>> a44f3531591f7935422e38ed5728e818c04fdfe5
            throw new RuntimeException(
                'A página de ofertas não foi encontrada.'
            );
        }
<<<<<<< HEAD


=======
>>>>>>> a44f3531591f7935422e38ed5728e818c04fdfe5
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
