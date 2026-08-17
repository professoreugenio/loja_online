<?php

declare(strict_types=1);

namespace App\Helpers;

use RuntimeException;

final class View
{
    /*
    |--------------------------------------------------------------------------
    | Componentes do site
    |--------------------------------------------------------------------------
    |
    | Caminho:
    | views/componentes/site/
    |
    */
    public static function componente(
        string $nome,
        array $dados = []
    ): void {
        self::carregarComponente(
            'site',
            $nome,
            $dados
        );
    }
    /*
    |--------------------------------------------------------------------------
    | Componentes da área do cliente
    |--------------------------------------------------------------------------
    |
    | Caminho:
    | views/componentes/cliente/
    |
    */
    public static function componenteCliente(
        string $nome,
        array $dados = []
    ): void {
        self::carregarComponente(
            'cliente',
            $nome,
            $dados
        );
    }
    /*
    |--------------------------------------------------------------------------
    | Carregador interno
    |--------------------------------------------------------------------------
    */
    private static function carregarComponente(
        string $area,
        string $nome,
        array $dados = []
    ): void {
        /*
        |--------------------------------------------------------------------------
        | Limpeza do nome
        |--------------------------------------------------------------------------
        */
        $nome = trim(
            $nome,
            '/'
        );
        /*
        |--------------------------------------------------------------------------
        | Validação
        |--------------------------------------------------------------------------
        */
        if (
            $nome === ''
            || str_contains(
                $nome,
                '..'
            )
        ) {
            throw new RuntimeException(
                'Nome de componente inválido.'
            );
        }
        /*
        |--------------------------------------------------------------------------
        | Caminho do componente
        |--------------------------------------------------------------------------
        */
        $arquivo =
            APP_ROOT
            . '/views/componentes/'
            . $area
            . '/'
            . $nome
            . '.php';
        /*
        |--------------------------------------------------------------------------
        | Verifica se existe
        |--------------------------------------------------------------------------
        */
        if (!is_file($arquivo)) {
            throw new RuntimeException(
                "Componente não encontrado: "
                    . "{$area}/{$nome}"
            );
        }
        /*
        |--------------------------------------------------------------------------
        | Disponibiliza dados para o componente
        |--------------------------------------------------------------------------
        */
        extract(
            $dados,
            EXTR_SKIP
        );
        /*
        |--------------------------------------------------------------------------
        | Carrega o componente
        |--------------------------------------------------------------------------
        */
        require $arquivo;
    }
}
