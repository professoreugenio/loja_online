<?php
declare(strict_types=1);
namespace App\Helpers;
final class CsrfCliente
{
    /*
    |--------------------------------------------------------------------------
    | Chave utilizada na sessão
    |--------------------------------------------------------------------------
    */
    private const CHAVE =
        '_csrf_cliente';
    /*
    |--------------------------------------------------------------------------
    | Gera ou recupera o token CSRF
    |--------------------------------------------------------------------------
    */
    public static function gerar(): string
    {
        if (
            empty(
                $_SESSION[self::CHAVE]
            )
        ) {
            $_SESSION[self::CHAVE] =
                bin2hex(
                    random_bytes(32)
                );
        }
        return (string)
            $_SESSION[self::CHAVE];
    }
    /*
    |--------------------------------------------------------------------------
    | Valida o token recebido
    |--------------------------------------------------------------------------
    */
    public static function validar(
        ?string $token
    ): bool {
        if (
            $token === null
            || empty(
                $_SESSION[self::CHAVE]
            )
        ) {
            return false;
        }
        return hash_equals(
            (string)
                $_SESSION[self::CHAVE],
            $token
        );
    }
    /*
    |--------------------------------------------------------------------------
    | Gera um novo token
    |--------------------------------------------------------------------------
    */
    public static function renovar(): string
    {
        $_SESSION[self::CHAVE] =
            bin2hex(
                random_bytes(32)
            );
        return (string)
            $_SESSION[self::CHAVE];
    }
}