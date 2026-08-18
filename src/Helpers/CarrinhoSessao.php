<?php

declare(strict_types=1);

namespace App\Helpers;

final class CarrinhoSessao
{
    private const CHAVE =
        '_carrinho_token';


    public static function token(): string
    {
        if (
            empty(
                $_SESSION[
                    self::CHAVE
                ]
            )
        ) {

            $_SESSION[
                self::CHAVE
            ] =
                bin2hex(
                    random_bytes(32)
                );
        }


        return (string)
            $_SESSION[
                self::CHAVE
            ];
    }


    public static function renovar(): string
    {
        $_SESSION[
            self::CHAVE
        ] =
            bin2hex(
                random_bytes(32)
            );


        return (string)
            $_SESSION[
                self::CHAVE
            ];
    }
}
