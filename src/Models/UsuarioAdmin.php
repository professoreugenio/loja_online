<?php

declare(strict_types=1);

namespace Aluno\LojaOnline\Models;

final class UsuarioAdmin
{
    public function __construct(
        private readonly int $id,
        private readonly string $nome,
        private readonly string $email,
        private readonly string $senhaHash,
        private readonly string $status,
        private readonly ?string $ultimoAcesso
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getSenhaHash(): string
    {
        return $this->senhaHash;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getUltimoAcesso(): ?string
    {
        return $this->ultimoAcesso;
    }

    public function estaAtivo(): bool
    {
        return $this->status === 'ativo';
    }
}
