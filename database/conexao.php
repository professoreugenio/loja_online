<?php

declare(strict_types=1);

use Dotenv\Dotenv;

final class Config
{
    private static ?PDO $conexao = null;

    private function __construct()
    {
    }

    /**
     * Retorna uma única conexão PDO com o banco de dados.
     */
    public static function connect(): PDO
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Reutiliza conexão existente
        |--------------------------------------------------------------------------
        */
        if (self::$conexao instanceof PDO) {
            return self::$conexao;
        }

        /*
        |--------------------------------------------------------------------------
        | 2. Localiza a raiz do projeto
        |--------------------------------------------------------------------------
        |
        | Estrutura esperada:
        |
        | projeto/
        | ├── database/
        | │   └── conexao.php
        | ├── vendor/
        | ├── .env
        | └── index.php
        |
        */
        $raizProjeto = dirname(__DIR__);

        /*
        |--------------------------------------------------------------------------
        | 3. Carrega o Composer
        |--------------------------------------------------------------------------
        */
        $autoload = $raizProjeto
            . '/vendor/autoload.php';

        if (!is_file($autoload)) {
            throw new RuntimeException(
                'O autoload do Composer não foi encontrado.'
            );
        }

        require_once $autoload;

        /*
        |--------------------------------------------------------------------------
        | 4. Carrega o arquivo .env
        |--------------------------------------------------------------------------
        */
        $dotenv = Dotenv::createImmutable(
            $raizProjeto
        );

        $dotenv->safeLoad();

        /*
        |--------------------------------------------------------------------------
        | 5. Ambiente da aplicação
        |--------------------------------------------------------------------------
        */
        $ambiente = (string) (
            $_ENV['APP_ENV']
                ?? 'production'
        );

        /*
        |--------------------------------------------------------------------------
        | 6. Configurações do banco
        |--------------------------------------------------------------------------
        */
        $host = trim(
            (string) (
                $_ENV['DB_HOST']
                    ?? 'localhost'
            )
        );

        $porta = trim(
            (string) (
                $_ENV['DB_PORT']
                    ?? '3306'
            )
        );

        $banco = trim(
            (string) (
                $_ENV['DB_DATABASE']
                    ?? ''
            )
        );

        $usuario = trim(
            (string) (
                $_ENV['DB_USERNAME']
                    ?? ''
            )
        );

        $senha = (string) (
            $_ENV['DB_PASSWORD']
                ?? ''
        );

        /*
        |--------------------------------------------------------------------------
        | 7. Validação das configurações
        |--------------------------------------------------------------------------
        */
        if ($host === '') {
            throw new RuntimeException(
                'A variável DB_HOST não foi configurada.'
            );
        }

        if ($porta === '') {
            throw new RuntimeException(
                'A variável DB_PORT não foi configurada.'
            );
        }

        if ($banco === '') {
            throw new RuntimeException(
                'A variável DB_DATABASE não foi configurada.'
            );
        }

        if ($usuario === '') {
            throw new RuntimeException(
                'A variável DB_USERNAME não foi configurada.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 8. Monta o DSN
        |--------------------------------------------------------------------------
        */
        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
            $host,
            $porta,
            $banco
        );

        /*
        |--------------------------------------------------------------------------
        | 9. Realiza a conexão
        |--------------------------------------------------------------------------
        */
        try {

            self::$conexao = new PDO(
                $dsn,
                $usuario,
                $senha,
                [
                    PDO::ATTR_ERRMODE =>
                        PDO::ERRMODE_EXCEPTION,

                    PDO::ATTR_DEFAULT_FETCH_MODE =>
                        PDO::FETCH_ASSOC,

                    PDO::ATTR_EMULATE_PREPARES =>
                        false,

                    PDO::ATTR_STRINGIFY_FETCHES =>
                        false,
                ]
            );

            return self::$conexao;

        } catch (PDOException $erro) {

            /*
            |--------------------------------------------------------------------------
            | Registra o erro real apenas no log do servidor
            |--------------------------------------------------------------------------
            */
            error_log(
                '[CONEXÃO MYSQL] '
                . $erro->getMessage()
            );

            /*
            |--------------------------------------------------------------------------
            | Ambiente local
            |--------------------------------------------------------------------------
            |
            | Podemos apresentar informações adicionais durante o
            | desenvolvimento.
            */
            if ($ambiente === 'local') {

                throw new RuntimeException(
                    'Erro ao conectar ao banco: '
                    . $erro->getMessage(),
                    0,
                    $erro
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Ambiente de produção
            |--------------------------------------------------------------------------
            |
            | Não revela host, banco, usuário ou detalhes internos.
            */
            throw new RuntimeException(
                'Não foi possível conectar ao banco de dados.',
                0,
                $erro
            );
        }
    }
}