<?php

declare(strict_types=1);

namespace App\Helpers;

use RuntimeException;

final class IdSeguro
{
    private const CIFRA = 'aes-256-cbc';

    private static function chave(): string
    {
        $appKey = (string) (
            $_ENV['APP_KEY']
                ?? ''
        );

        if ($appKey === '') {
            throw new RuntimeException(
                'APP_KEY não foi configurada.'
            );
        }

        return hash(
            'sha256',
            $appKey,
            true
        );
    }

    public static function criptografar(
        int $id
    ): string {

        $tamanhoIv =
            openssl_cipher_iv_length(
                self::CIFRA
            );

        $iv = random_bytes(
            $tamanhoIv
        );

        $criptografado =
            openssl_encrypt(
                (string) $id,
                self::CIFRA,
                self::chave(),
                OPENSSL_RAW_DATA,
                $iv
            );

        if ($criptografado === false) {
            throw new RuntimeException(
                'Não foi possível criptografar o ID.'
            );
        }

        $valor = base64_encode(
            $iv . $criptografado
        );

        return rtrim(
            strtr(
                $valor,
                '+/',
                '-_'
            ),
            '='
        );
    }

    public static function descriptografar(
        string $token
    ): ?int {

        $token = trim($token);

        if ($token === '') {
            return null;
        }

        $base64 = strtr(
            $token,
            '-_',
            '+/'
        );

        $resto = strlen($base64) % 4;

        if ($resto !== 0) {
            $base64 .= str_repeat(
                '=',
                4 - $resto
            );
        }

        $dados = base64_decode(
            $base64,
            true
        );

        if ($dados === false) {
            return null;
        }

        $tamanhoIv =
            openssl_cipher_iv_length(
                self::CIFRA
            );

        if (
            strlen($dados)
            <= $tamanhoIv
        ) {
            return null;
        }

        $iv = substr(
            $dados,
            0,
            $tamanhoIv
        );

        $conteudo = substr(
            $dados,
            $tamanhoIv
        );

        $id = openssl_decrypt(
            $conteudo,
            self::CIFRA,
            self::chave(),
            OPENSSL_RAW_DATA,
            $iv
        );

        if (
            $id === false
            || !ctype_digit($id)
        ) {
            return null;
        }

        $idInteiro = (int) $id;

        return $idInteiro > 0
            ? $idInteiro
            : null;
    }
}
