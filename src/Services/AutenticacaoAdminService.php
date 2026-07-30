<?php

declare(strict_types=1);

namespace Aluno\LojaOnline\Services;

use Aluno\LojaOnline\Models\UsuarioAdmin;
use Aluno\LojaOnline\Repositories\UsuarioAdminRepository;

final class AutenticacaoAdminService
{
    public function __construct(
        private readonly UsuarioAdminRepository $usuarios
    ) {
    }

    public function autenticar(
        string $email,
        string $senha
    ): ?UsuarioAdmin {
        $usuario = $this->usuarios
            ->buscarPorEmail($email);

        if ($usuario === null) {
            return null;
        }

        if (!$usuario->estaAtivo()) {
            return null;
        }

        if (
            !password_verify(
                $senha,
                $usuario->getSenhaHash()
            )
        ) {
            return null;
        }

        if (
            password_needs_rehash(
                $usuario->getSenhaHash(),
                PASSWORD_DEFAULT
            )
        ) {
            $novoHash = password_hash(
                $senha,
                PASSWORD_DEFAULT
            );

            $this->usuarios
                ->atualizarHashSenha(
                    $usuario->getId(),
                    $novoHash
                );
        }

        $this->usuarios
            ->registrarUltimoAcesso(
                $usuario->getId()
            );

        return $usuario;
    }
}
