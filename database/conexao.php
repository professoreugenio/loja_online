<?php

declare(strict_types=1);

use Dotenv\Dotenv;

final class Config
{
    private static ?PDO $conexao = null;

    private function __construct()
    {
    }

    public static function connect(): PDO
    {
        if (self::$conexao instanceof PDO) {
            return self::$conexao;
        }

        $raizProjeto = dirname(__DIR__);

        require_once $raizProjeto
            . '/vendor/autoload.php';

        $dotenv = Dotenv::createImmutable(
            $raizProjeto
        );

        $dotenv->safeLoad();

        $host = (string) (
            $_ENV['DB_HOST']
                ?? 'localhost'
        );

        $porta = (string) (
            $_ENV['DB_PORT']
                ?? '3307'
        );

        $banco = (string) (
            $_ENV['DB_DATABASE']
                ?? ''
        );

        $usuario = (string) (
            $_ENV['DB_USERNAME']
                ?? 'root'
        );

        $senha = (string) (
            $_ENV['DB_PASSWORD']
                ?? ''
        );

        if ($banco === '') {
            throw new RuntimeException(
                'A variável DB_DATABASE não foi configurada.'
            );
        }

        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
            $host,
            $porta,
            $banco
        );

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
                ]
            );

            return self::$conexao;

        } catch (PDOException $erro) {

            error_log(
                '[CONEXÃO COM O BANCO] '
                . $erro->getMessage()
            );

            throw new RuntimeException(
                'Não foi possível conectar ao banco de dados.',
                0,
                $erro
            );
        }
    }
}
