<?php

declare(strict_types=1);

namespace App\Helpers;

final class ClienteAuth
{
    public static function logado(): bool
    {
        return !empty($_SESSION['cliente']['id']);
    }


    public static function usuario(): ?array
    {
        if (!self::logado()) {
            return null;
        }

        return $_SESSION['cliente'];
    }


    public static function id(): ?int
    {
        if (!self::logado()) {
            return null;
        }

        return (int)
        $_SESSION['cliente']['id'];
    }


    public static function entrar(
        array $cliente
    ): void {

        session_regenerate_id(true);

        $_SESSION['cliente'] = [
            'id' =>
            (int) $cliente['id'],

            'nome' =>
            (string) $cliente['nome'],

            'email' =>
            (string) $cliente['email'],

            'foto_url' =>
            $cliente['foto_url']
                ?? null,
        ];
    }


    public static function exigirLogin(): void
    {
        if (self::logado()) {
            return;
        }

        $_SESSION['cliente_destino'] =
            $_SERVER['REQUEST_URI']
            ?? '';

        header(
            'Location: '
                . BASE_URL
                . '/cliente/login'
        );

        exit;
    }


    public static function sair(): void
    {
        unset(
            $_SESSION['cliente']
        );

        session_regenerate_id(true);
    }
}
