<?php

declare(strict_types=1);

namespace Aluno\LojaOnline\Helpers;

use Aluno\LojaOnline\Models\UsuarioAdmin;

final class SessaoAdmin
{
    public static function entrar(
        UsuarioAdmin $usuario
    ): void {
        session_regenerate_id(true);

        $_SESSION['admin'] = [
            'id' => $usuario->getId(),
            'nome' => $usuario->getNome(),
            'email' => $usuario->getEmail(),
            'ultimo_acesso_anterior' =>
                $usuario->getUltimoAcesso(),
            'autenticado_em' => time(),
        ];
    }

    public static function autenticado(): bool
    {
        return !empty(
            $_SESSION['admin']['id']
        );
    }

    public static function dados(): array
    {
        return is_array(
            $_SESSION['admin'] ?? null
        )
            ? $_SESSION['admin']
            : [];
    }

    public static function sair(): void
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $parametros =
                session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                [
                    'expires' => time() - 42000,
                    'path' =>
                        $parametros['path'],

                    'domain' =>
                        $parametros['domain'],

                    'secure' =>
                        $parametros['secure'],

                    'httponly' =>
                        $parametros['httponly'],

                    'samesite' => 'Lax',
                ]
            );
        }

        session_destroy();
    }
}
