<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\UsuarioAdminRepository;

final class AutenticacaoAdminService
{
    private UsuarioAdminRepository $usuarios;

    public function __construct(
        UsuarioAdminRepository $usuarios
    ) {
        $this->usuarios = $usuarios;
    }

    public function autenticar(
        string $email,
        string $senha
    ): ?array {
        $email = mb_strtolower(
            trim($email)
        );

        if (
            filter_var(
                $email,
                FILTER_VALIDATE_EMAIL
            ) === false
            || $senha === ''
        ) {
            return null;
        }

        $usuario = $this->usuarios
            ->buscarAtivoPorEmail(
                $email
            );

        if ($usuario === null) {
            return null;
        }

        $senhaHash = (string) (
            $usuario['senha_hash']
            ?? ''
        );

        if (
            $senhaHash === ''
            || !password_verify(
                $senha,
                $senhaHash
            )
        ) {
            return null;
        }

        if (
            password_needs_rehash(
                $senhaHash,
                PASSWORD_DEFAULT
            )
        ) {
            $novoHash = password_hash(
                $senha,
                PASSWORD_DEFAULT
            );

            $this->usuarios
                ->atualizarHashSenha(
                    (int) $usuario['id'],
                    $novoHash
                );

            $usuario['senha_hash'] =
                $novoHash;
        }

        $this->usuarios
            ->registrarUltimoAcesso(
                (int) $usuario['id']
            );

        return $usuario;
    }
}