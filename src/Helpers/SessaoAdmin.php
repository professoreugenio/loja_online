<?php

declare(strict_types=1);

namespace App\Helpers;

final class SessaoAdmin
{
    private const CHAVE_SESSAO = 'usuario_admin';

    private function __construct() {}

    public static function entrar(array $usuario): void
    {
        if (
            !isset(
                $usuario['id'],
                $usuario['nome'],
                $usuario['email']
            )
        ) {
            throw new \InvalidArgumentException(
                'Dados do usuário administrativo incompletos.'
            );
        }

        session_regenerate_id(true);

        $_SESSION[self::CHAVE_SESSAO] = [
            'id' => (int) $usuario['id'],
            'nome' => (string) $usuario['nome'],
            'email' => (string) $usuario['email'],
            'autenticado_em' => time(),
        ];
    }

    public static function autenticado(): bool
    {
        return !empty($_SESSION[self::CHAVE_SESSAO]['id']);
    }

    public static function dados(): array
    {
        $dados = $_SESSION[self::CHAVE_SESSAO]
            ?? [];

        return is_array($dados)
            ? $dados
            : [];
    }

    public static function id(): ?int
    {
        $id = self::dados()['id'] ?? null;

        return is_numeric($id)
            ? (int) $id
            : null;
    }

    public static function nome(): ?string
    {
        $nome = self::dados()['nome'] ?? null;

        return is_string($nome)
            && $nome !== ''
            ? $nome
            : null;
    }

    public static function exigirLogin(): void
    {
        if (self::autenticado()) {
            return;
        }

        $base = defined('BASE_URL')
            ? rtrim((string) BASE_URL, '/')
            : '';

        header(
            'Location: '
                . $base
                . '/loginadmin'
        );

        exit;
    }

    public static function sair(): void
    {
        $_SESSION = [];

        if (
            session_status()
            === PHP_SESSION_ACTIVE
            && ini_get('session.use_cookies')
        ) {
            $parametros =
                session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                [
                    'expires' =>
                    time() - 42000,

                    'path' =>
                    $parametros['path']
                        ?: '/',

                    'domain' =>
                    $parametros['domain']
                        ?: '',

                    'secure' =>
                    (bool)
                    $parametros['secure'],

                    'httponly' =>
                    (bool)
                    $parametros['httponly'],

                    'samesite' =>
                    'Lax',
                ]
            );
        }

        if (
            session_status()
            === PHP_SESSION_ACTIVE
        ) {
            session_destroy();
        }
    }
}
