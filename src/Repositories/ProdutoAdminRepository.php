<?php

declare(strict_types=1);

namespace App\Repositories;

use PDO;

final class ProdutoAdminRepository
{
    public function __construct(
        private PDO $pdo
    ) {
    }

    public function listarCategorias(): array
    {
        $sql = "
            SELECT
                id,
                nome,
                ativo
            FROM categorias
            ORDER BY nome ASC
        ";

        $dados = $this->pdo
            ->query($sql)
            ->fetchAll(PDO::FETCH_ASSOC);

        return is_array($dados)
            ? $dados
            : [];
    }

    public function listarComFiltros(
        string $busca = '',
        ?int $categoriaId = null,
        ?int $destaque = null
    ): array {
        $sql = "
            SELECT
                p.id,
                p.categoria_id,
                p.nome,
                p.slug,
                p.preco,
                p.oferta_ativa,
                p.percentual_oferta,
                p.estoque,
                p.status,
                p.destaque,
                p.criado_em,
                p.atualizado_em,
                c.nome AS categoria_nome
            FROM produtos AS p
            INNER JOIN categorias AS c
                ON c.id = p.categoria_id
            WHERE 1 = 1
        ";

        $parametros = [];

        if ($busca !== '') {
            $sql .= "
                AND (
                    p.nome LIKE :busca_nome
                    OR p.slug LIKE :busca_slug
                )
            ";

            $parametros['busca_nome'] =
                '%' . $busca . '%';

            $parametros['busca_slug'] =
                '%' . $busca . '%';
        }

        if ($categoriaId !== null) {
            $sql .= "
                AND p.categoria_id = :categoria_id
            ";

            $parametros['categoria_id'] =
                $categoriaId;
        }

        if ($destaque !== null) {
            $sql .= "
                AND p.destaque = :destaque
            ";

            $parametros['destaque'] =
                $destaque;
        }

        $sql .= "
            ORDER BY
                p.nome ASC,
                p.id DESC
        ";

        $stmt = $this->pdo->prepare($sql);

        if (isset($parametros['busca_nome'])) {
            $stmt->bindValue(
                ':busca_nome',
                $parametros['busca_nome'],
                PDO::PARAM_STR
            );

            $stmt->bindValue(
                ':busca_slug',
                $parametros['busca_slug'],
                PDO::PARAM_STR
            );
        }

        if (isset($parametros['categoria_id'])) {
            $stmt->bindValue(
                ':categoria_id',
                $parametros['categoria_id'],
                PDO::PARAM_INT
            );
        }

        if (array_key_exists('destaque', $parametros)) {
            $stmt->bindValue(
                ':destaque',
                $parametros['destaque'],
                PDO::PARAM_INT
            );
        }

        $stmt->execute();

        $dados = $stmt->fetchAll(
            PDO::FETCH_ASSOC
        );

        return is_array($dados)
            ? $dados
            : [];
    }

    public function buscarPorId(
        int $produtoId
    ): ?array {
        $sql = "
            SELECT
                p.id,
                p.categoria_id,
                p.nome,
                p.slug,
                p.descricao,
                p.preco,
                p.oferta_ativa,
                p.percentual_oferta,
                p.oferta_inicio,
                p.oferta_fim,
                p.estoque,
                p.status,
                p.destaque,
                p.criado_em,
                p.atualizado_em,
                c.nome AS categoria_nome
            FROM produtos AS p
            INNER JOIN categorias AS c
                ON c.id = p.categoria_id
            WHERE p.id = :id
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(
            ':id',
            $produtoId,
            PDO::PARAM_INT
        );

        $stmt->execute();

        $produto = $stmt->fetch(
            PDO::FETCH_ASSOC
        );

        return is_array($produto)
            ? $produto
            : null;
    }

    public function atualizar(
        int $produtoId,
        array $dados
    ): bool {
        $sql = "
            UPDATE produtos
            SET
                categoria_id = :categoria_id,
                nome = :nome,
                slug = :slug,
                descricao = :descricao,
                preco = :preco,
                oferta_ativa = :oferta_ativa,
                percentual_oferta = :percentual_oferta,
                oferta_inicio = :oferta_inicio,
                oferta_fim = :oferta_fim,
                estoque = :estoque,
                status = :status,
                destaque = :destaque
            WHERE id = :id
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(
            ':categoria_id',
            (int) $dados['categoria_id'],
            PDO::PARAM_INT
        );

        $stmt->bindValue(
            ':nome',
            (string) $dados['nome'],
            PDO::PARAM_STR
        );

        $stmt->bindValue(
            ':slug',
            (string) $dados['slug'],
            PDO::PARAM_STR
        );

        if ($dados['descricao'] === null) {
            $stmt->bindValue(
                ':descricao',
                null,
                PDO::PARAM_NULL
            );
        } else {
            $stmt->bindValue(
                ':descricao',
                (string) $dados['descricao'],
                PDO::PARAM_STR
            );
        }

        $stmt->bindValue(
            ':preco',
            (string) $dados['preco'],
            PDO::PARAM_STR
        );

        $stmt->bindValue(
            ':oferta_ativa',
            (int) $dados['oferta_ativa'],
            PDO::PARAM_INT
        );

        if ($dados['percentual_oferta'] === null) {
            $stmt->bindValue(
                ':percentual_oferta',
                null,
                PDO::PARAM_NULL
            );
        } else {
            $stmt->bindValue(
                ':percentual_oferta',
                (string) $dados['percentual_oferta'],
                PDO::PARAM_STR
            );
        }

        if ($dados['oferta_inicio'] === null) {
            $stmt->bindValue(
                ':oferta_inicio',
                null,
                PDO::PARAM_NULL
            );
        } else {
            $stmt->bindValue(
                ':oferta_inicio',
                (string) $dados['oferta_inicio'],
                PDO::PARAM_STR
            );
        }

        if ($dados['oferta_fim'] === null) {
            $stmt->bindValue(
                ':oferta_fim',
                null,
                PDO::PARAM_NULL
            );
        } else {
            $stmt->bindValue(
                ':oferta_fim',
                (string) $dados['oferta_fim'],
                PDO::PARAM_STR
            );
        }

        $stmt->bindValue(
            ':estoque',
            (int) $dados['estoque'],
            PDO::PARAM_INT
        );

        $stmt->bindValue(
            ':status',
            (string) $dados['status'],
            PDO::PARAM_STR
        );

        $stmt->bindValue(
            ':destaque',
            (int) $dados['destaque'],
            PDO::PARAM_INT
        );

        $stmt->bindValue(
            ':id',
            $produtoId,
            PDO::PARAM_INT
        );

        return $stmt->execute();
    }
}
