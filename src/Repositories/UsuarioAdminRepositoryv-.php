<?php

declare(strict_types=1);

namespace App\Repositories;

use PDO;

final class UsuarioAdminRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function buscarAtivoPorEmail(string $email): ?array
    {
        $sql = '
            SELECT
                id,
                nome,
                email,
                senha_hash,
                status,
                nivel_admin,
                ultimo_acesso
            FROM usuarios_admin
            WHERE email = :email
              AND status = :status
            LIMIT 1
        ';

        $consulta = $this->pdo->prepare($sql);

        $consulta->execute([
            'email' => strtolower(trim($email)),
            'status' => 'ativo',
        ]);

        $usuario = $consulta->fetch();

        return is_array($usuario)
            ? $usuario
            : null;
    }

    public function buscarPorId(int $id): ?array
    {
        $sql = "
        SELECT
            id,
            nome,
            email,
            status,
            nivel_admin,    
            ultimo_acesso,
            criado_em,
            atualizado_em
        FROM usuarios_admin
        WHERE id = :id
        LIMIT 1
    ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':id' => $id,
        ]);

        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        return is_array($admin)
            ? $admin
            : null;
    }


    public function emailExiste(
        string $email,
        ?int $ignorarId = null
    ): bool {
        $sql = "
        SELECT id
        FROM usuarios_admin
        WHERE email = :email
    ";

        $parametros = [
            ':email' => mb_strtolower(trim($email)),
        ];

        if ($ignorarId !== null) {
            $sql .= " AND id <> :ignorar_id";

            $parametros[':ignorar_id'] =
                $ignorarId;
        }

        $sql .= " LIMIT 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($parametros);

        return $stmt->fetchColumn() !== false;
    }


    public function listarTodos(): array
    {
        $sql = "
        SELECT
            id,
            nome,
            email,
            nivel_admin,
            status,
            ultimo_acesso,
            criado_em,
            atualizado_em
        FROM usuarios_admin
        ORDER BY nome ASC
    ";

        $dados = $this->pdo
            ->query($sql)
            ->fetchAll(PDO::FETCH_ASSOC);

        return is_array($dados)
            ? $dados
            : [];
    }


    public function cadastrar(array $dados): int
    {
        $sql = "
        INSERT INTO usuarios_admin
        (
            nome,
            email,
            senha_hash,
            status,
            nivel_admin
        )
        VALUES
        (
            :nome,
            :email,
            :senha_hash,
            'ativo',
            :nivel_admin
        )
    ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':nome' => $dados['nome'],
            ':email' => $dados['email'],
            ':senha_hash' => $dados['senha_hash'],
            ':nivel_admin' => $dados['nivel_admin'],
        ]);

        return (int) $this->pdo->lastInsertId();
    }


    public function atualizarPerfil(
        int $id,
        string $nome,
        string $email
    ): bool {
        $sql = "
        UPDATE usuarios_admin
        SET
            nome = :nome,
            email = :email
        WHERE id = :id
    ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':id' => $id,
            ':nome' => $nome,
            ':email' => $email,
        ]);
    }

    public function atualizarAdmin(
        int $id,
        array $dados
    ): bool {
        $sql = "
        UPDATE usuarios_admin
        SET
            nome = :nome,
            email = :email,
            nivel_admin = :nivel_admin,
            status = :status
        WHERE id = :id
    ";

        $stmt =
            $this->pdo->prepare(
                $sql
            );

        return $stmt->execute([
            ':id' =>
            $id,

            ':nome' =>
            $dados['nome'],

            ':email' =>
            $dados['email'],

            ':nivel_admin' =>
            $dados['nivel_admin'],

            ':status' =>
            $dados['status'],
        ]);
    }

    public function registrarUltimoAcesso(int $usuarioId): void
    {
        $sql = '
            UPDATE usuarios_admin
            SET ultimo_acesso = NOW()
            WHERE id = :id
        ';

        $consulta = $this->pdo->prepare($sql);

        $consulta->execute([
            'id' => $usuarioId,
        ]);
    }

    public function atualizarHashSenha(
        int $usuarioId,
        string $novoHash
    ): void {
        $sql = '
            UPDATE usuarios_admin
            SET senha_hash = :senha_hash
            WHERE id = :id
        ';

        $consulta = $this->pdo->prepare($sql);

        $consulta->execute([
            'senha_hash' => $novoHash,
            'id' => $usuarioId,
        ]);
    }
}
