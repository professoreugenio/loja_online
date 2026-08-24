<?php

declare(strict_types=1);

namespace App\Repositories;

use PDO;

final class ProdutoImagemAdminRepository
{
    public function __construct(
        private PDO $pdo
    ) {
    }

    public function listarPorProduto(
        int $produtoId
    ): array {
        $sql = "
            SELECT
                id,
                produto_id,
                url_imagem,
                texto_alternativo,
                principal,
                ordem,
                criado_em
            FROM produto_imagens
            WHERE produto_id = :produto_id
            ORDER BY
                principal DESC,
                ordem ASC,
                id ASC
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(
            ':produto_id',
            $produtoId,
            PDO::PARAM_INT
        );

        $stmt->execute();

        $dados = $stmt->fetchAll(
            PDO::FETCH_ASSOC
        );

        return is_array($dados)
            ? $dados
            : [];
    }

    public function buscarPrincipal(
        int $produtoId
    ): ?array {
        $sql = "
            SELECT
                id,
                produto_id,
                url_imagem,
                texto_alternativo,
                principal,
                ordem,
                criado_em
            FROM produto_imagens
            WHERE produto_id = :produto_id
              AND principal = 1
            ORDER BY ordem ASC, id ASC
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(
            ':produto_id',
            $produtoId,
            PDO::PARAM_INT
        );

        $stmt->execute();

        $imagem = $stmt->fetch(
            PDO::FETCH_ASSOC
        );

        return is_array($imagem)
            ? $imagem
            : null;
    }

    public function buscarPorIdEProduto(
        int $imagemId,
        int $produtoId
    ): ?array {
        $sql = "
            SELECT
                id,
                produto_id,
                url_imagem,
                texto_alternativo,
                principal,
                ordem,
                criado_em
            FROM produto_imagens
            WHERE id = :id
              AND produto_id = :produto_id
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(
            ':id',
            $imagemId,
            PDO::PARAM_INT
        );

        $stmt->bindValue(
            ':produto_id',
            $produtoId,
            PDO::PARAM_INT
        );

        $stmt->execute();

        $imagem = $stmt->fetch(
            PDO::FETCH_ASSOC
        );

        return is_array($imagem)
            ? $imagem
            : null;
    }

    public function possuiPrincipal(
        int $produtoId
    ): bool {
        $sql = "
            SELECT 1
            FROM produto_imagens
            WHERE produto_id = :produto_id
              AND principal = 1
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(
            ':produto_id',
            $produtoId,
            PDO::PARAM_INT
        );

        $stmt->execute();

        return $stmt->fetchColumn() !== false;
    }

    public function proximaOrdem(
        int $produtoId
    ): int {
        $sql = "
            SELECT
                COALESCE(MAX(ordem), 0) + 1
            FROM produto_imagens
            WHERE produto_id = :produto_id
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(
            ':produto_id',
            $produtoId,
            PDO::PARAM_INT
        );

        $stmt->execute();

        return max(
            1,
            (int) $stmt->fetchColumn()
        );
    }

    public function inserir(
        int $produtoId,
        string $urlImagem,
        ?string $textoAlternativo,
        bool $principal,
        int $ordem
    ): int {
        $sql = "
            INSERT INTO produto_imagens (
                produto_id,
                url_imagem,
                texto_alternativo,
                principal,
                ordem
            ) VALUES (
                :produto_id,
                :url_imagem,
                :texto_alternativo,
                :principal,
                :ordem
            )
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(
            ':produto_id',
            $produtoId,
            PDO::PARAM_INT
        );

        $stmt->bindValue(
            ':url_imagem',
            $urlImagem,
            PDO::PARAM_STR
        );

        if ($textoAlternativo === null) {
            $stmt->bindValue(
                ':texto_alternativo',
                null,
                PDO::PARAM_NULL
            );
        } else {
            $stmt->bindValue(
                ':texto_alternativo',
                $textoAlternativo,
                PDO::PARAM_STR
            );
        }

        $stmt->bindValue(
            ':principal',
            $principal ? 1 : 0,
            PDO::PARAM_INT
        );

        $stmt->bindValue(
            ':ordem',
            $ordem,
            PDO::PARAM_INT
        );

        $stmt->execute();

        return (int) $this->pdo
            ->lastInsertId();
    }

    public function definirComoPrincipal(
        int $produtoId,
        int $imagemId
    ): void {
        $sqlZerar = "
            UPDATE produto_imagens
            SET principal = 0
            WHERE produto_id = :produto_id
        ";

        $stmtZerar =
            $this->pdo->prepare($sqlZerar);

        $stmtZerar->bindValue(
            ':produto_id',
            $produtoId,
            PDO::PARAM_INT
        );

        $stmtZerar->execute();

        $sqlPrincipal = "
            UPDATE produto_imagens
            SET principal = 1
            WHERE id = :id
              AND produto_id = :produto_id
        ";

        $stmtPrincipal =
            $this->pdo->prepare($sqlPrincipal);

        $stmtPrincipal->bindValue(
            ':id',
            $imagemId,
            PDO::PARAM_INT
        );

        $stmtPrincipal->bindValue(
            ':produto_id',
            $produtoId,
            PDO::PARAM_INT
        );

        $stmtPrincipal->execute();
    }

    public function excluir(
        int $imagemId,
        int $produtoId
    ): void {
        $sql = "
            DELETE FROM produto_imagens
            WHERE id = :id
              AND produto_id = :produto_id
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(
            ':id',
            $imagemId,
            PDO::PARAM_INT
        );

        $stmt->bindValue(
            ':produto_id',
            $produtoId,
            PDO::PARAM_INT
        );

        $stmt->execute();
    }

    public function definirPrimeiraDisponivelComoPrincipal(
        int $produtoId
    ): void {
        $sql = "
            SELECT id
            FROM produto_imagens
            WHERE produto_id = :produto_id
            ORDER BY ordem ASC, id ASC
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(
            ':produto_id',
            $produtoId,
            PDO::PARAM_INT
        );

        $stmt->execute();

        $imagemId =
            $stmt->fetchColumn();

        if ($imagemId === false) {
            return;
        }

        $this->definirComoPrincipal(
            $produtoId,
            (int) $imagemId
        );
    }
}