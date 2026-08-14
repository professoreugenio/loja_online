<?php

declare(strict_types=1);

namespace App\Helpers;

final class Cpf
{
    public static function somenteNumeros(
        string $cpf
    ): string {

        return preg_replace(
            '/\D+/',
            '',
            $cpf
        ) ?? '';
    }


    public static function validar(
        string $cpf
    ): bool {

        $cpf =
            self::somenteNumeros(
                $cpf
            );


        if (strlen($cpf) !== 11) {
            return false;
        }


        if (
            preg_match(
                '/^(\d)\1{10}$/',
                $cpf
            )
        ) {
            return false;
        }


        for (
            $digito = 9;
            $digito < 11;
            $digito++
        ) {
            $soma = 0;

            for (
                $indice = 0;
                $indice < $digito;
                $indice++
            ) {
                $soma +=
                    (int) $cpf[$indice]
                    * (
                        ($digito + 1)
                        - $indice
                    );
            }


            $resto =
                ($soma * 10)
                % 11;


            if ($resto === 10) {
                $resto = 0;
            }


            if (
                $resto
                !== (int)
                    $cpf[$digito]
            ) {
                return false;
            }
        }


        return true;
    }
}
