<?php

declare(strict_types=1);

namespace App\Repositories;

use PDO;

final class ProdutoRepository
{
    private PDO $pdo;
    public function __construct(
        PDO $pdo
    ) {
        $this->pdo = $pdo;
    }
    /**
     * Lista todos os produtos ativos.
     */
    public function listarTodos(
        int $limite = 60
    ): array {
        $sql = '
        SELECT
            p.id,
            p.categoria_id,
            p.nome,
            p.slug,
            p.descricao,
            p.preco,
            p.percentual_oferta,
            p.estoque,
            c.nome AS categoria,
            (
                SELECT pi.url_imagem
                FROM produto_imagens pi
                WHERE pi.produto_id = p.id
                ORDER BY
                    pi.principal DESC,
                    pi.ordem ASC,
                    pi.id ASC
                LIMIT 1
            ) AS imagem
        FROM produtos p
        INNER JOIN categorias c
            ON c.id = p.categoria_id
        WHERE p.status = :status
          AND c.ativo = 1
        ORDER BY
            p.nome ASC
        LIMIT :limite
    ';
        $consulta =
            $this->pdo->prepare(
                $sql
            );
        $consulta->bindValue(
            ':status',
            'ativo',
            PDO::PARAM_STR
        );
        $consulta->bindValue(
            ':limite',
            $limite,
            PDO::PARAM_INT
        );
        $consulta->execute();
        return $consulta->fetchAll();
    }



    public function listarPorCategoria(
        int $categoriaId,
        int $limite = 24
    ): array {
        $sql = '
            SELECT
                p.id,
                p.categoria_id,
                p.nome,
                p.slug,
                p.descricao,
                p.preco,
                p.percentual_oferta,
                p.estoque,
                c.nome AS categoria,
                (
                    SELECT pi.url_imagem
                    FROM produto_imagens pi
                    WHERE pi.produto_id = p.id
                    ORDER BY
                        pi.principal DESC,
                        pi.ordem ASC,
                        pi.id ASC
                    LIMIT 1
                ) AS imagem
            FROM produtos p
            INNER JOIN categorias c
                ON c.id = p.categoria_id
            WHERE p.categoria_id = :categoria_id
              AND p.status = :status
              AND c.ativo = 1
            ORDER BY p.nome ASC
            LIMIT :limite
        ';
        $consulta =
            $this->pdo->prepare($sql);
        $consulta->bindValue(
            ':categoria_id',
            $categoriaId,
            PDO::PARAM_INT
        );
        $consulta->bindValue(
            ':status',
            'ativo',
            PDO::PARAM_STR
        );
        $consulta->bindValue(
            ':limite',
            $limite,
            PDO::PARAM_INT
        );
        $consulta->execute();
        return $consulta->fetchAll();
    }
    public function listarDestaques(
        int $limite = 10
    ): array {
        $sql = '
            SELECT
                p.id,
                p.nome,
                p.slug,
                p.descricao,
                p.preco,
                p.percentual_oferta,
                p.estoque,
                c.nome AS categoria,
                (
                    SELECT pi.url_imagem
                    FROM produto_imagens pi
                    WHERE pi.produto_id = p.id
                    ORDER BY
                        pi.principal DESC,
                        pi.ordem ASC,
                        pi.id ASC
                    LIMIT 1
                ) AS imagem
            FROM produtos p
            INNER JOIN categorias c
                ON c.id = p.categoria_id
            WHERE p.status = :status
              AND p.destaque = 1
              AND c.ativo = 1
            ORDER BY
                p.atualizado_em DESC
            LIMIT :limite
        ';
        $consulta =
            $this->pdo->prepare($sql);
        $consulta->bindValue(
            ':status',
            'ativo'
        );
        $consulta->bindValue(
            ':limite',
            $limite,
            PDO::PARAM_INT
        );
        $consulta->execute();
        return $consulta->fetchAll();
    }
    public function listarMaisVendidos(
        int $limite = 10
    ): array {
        $sql = '
            SELECT
                p.id,
                p.nome,
                p.slug,
                p.descricao,
                p.preco,
                p.percentual_oferta,
                p.estoque,
                c.nome AS categoria,
                SUM(
                    pedido_item.quantidade
                ) AS total_vendido,
                (
                    SELECT pi.url_imagem
                    FROM produto_imagens pi
                    WHERE pi.produto_id = p.id
                    ORDER BY
                        pi.principal DESC,
                        pi.ordem ASC,
                        pi.id ASC
                    LIMIT 1
                ) AS imagem
            FROM produtos p
            INNER JOIN categorias c
                ON c.id = p.categoria_id
            INNER JOIN pedido_itens pedido_item
                ON pedido_item.produto_id = p.id
            INNER JOIN pedidos pedido
                ON pedido.id = pedido_item.pedido_id
            WHERE p.status = :produto_status
              AND c.ativo = 1
              AND pedido.status IN (
                  "pago",
                  "em_separacao",
                  "enviado",
                  "entregue"
              )
            GROUP BY
                p.id,
                p.nome,
                p.slug,
                p.descricao,
                p.preco,
                p.percentual_oferta,
                p.estoque,
                c.nome
            ORDER BY
                total_vendido DESC,
                p.nome ASC
            LIMIT :limite
        ';
        $consulta =
            $this->pdo->prepare($sql);
        $consulta->bindValue(
            ':produto_status',
            'ativo'
        );
        $consulta->bindValue(
            ':limite',
            $limite,
            PDO::PARAM_INT
        );
        $consulta->execute();
        return $consulta->fetchAll();
    }
    public function buscar(
        string $termo,
        int $limite = 30
    ): array {

        $termo =
            trim(
                $termo
            );


        if ($termo === '') {

            return [];
        }


        $sql = '
        SELECT
            p.id,
            p.categoria_id,
            p.nome,
            p.slug,
            p.descricao,
            p.preco,
            p.estoque,

            p.percentual_oferta,
            p.oferta_ativa,
            p.oferta_inicio,
            p.oferta_fim,

            c.nome AS categoria,

            CASE

                WHEN
                    p.oferta_ativa = 1

                    AND p.percentual_oferta > 0

                    AND p.percentual_oferta < 100

                    AND (
                        p.oferta_inicio IS NULL
                        OR p.oferta_inicio <= NOW()
                    )

                    AND (
                        p.oferta_fim IS NULL
                        OR p.oferta_fim >= NOW()
                    )

                THEN ROUND(
                    p.preco
                    * (
                        1
                        - p.percentual_oferta
                        / 100
                    ),
                    2
                )

                ELSE NULL

            END AS preco_oferta,

            (
                SELECT
                    pi.url_imagem

                FROM produto_imagens pi

                WHERE
                    pi.produto_id = p.id

                ORDER BY
                    pi.principal DESC,
                    pi.ordem ASC,
                    pi.id ASC

                LIMIT 1
            ) AS imagem

        FROM produtos p

        INNER JOIN categorias c
            ON c.id = p.categoria_id

        WHERE
            p.status = :status

            AND c.ativo = 1

            AND (
                p.nome
                    LIKE :termo_nome

                OR p.descricao
                    LIKE :termo_descricao

                OR c.nome
                    LIKE :termo_categoria
            )

        ORDER BY
            p.nome ASC

        LIMIT :limite
    ';


        $consulta =
            $this->pdo
            ->prepare(
                $sql
            );


        $valorBusca =
            '%'
            . $termo
            . '%';


        $consulta->bindValue(
            ':status',
            'ativo',
            PDO::PARAM_STR
        );


        $consulta->bindValue(
            ':termo_nome',
            $valorBusca,
            PDO::PARAM_STR
        );


        $consulta->bindValue(
            ':termo_descricao',
            $valorBusca,
            PDO::PARAM_STR
        );


        $consulta->bindValue(
            ':termo_categoria',
            $valorBusca,
            PDO::PARAM_STR
        );


        $consulta->bindValue(
            ':limite',
            $limite,
            PDO::PARAM_INT
        );


        $consulta->execute();


        return
            $consulta->fetchAll();
    }

    public function buscarPorSlug(
        string $slug
    ): ?array {
        $sql = '
            SELECT
                p.id,
                p.categoria_id,
                p.nome,
                p.slug,
                p.descricao,
                p.preco,
                p.estoque,
                p.criado_em,
                c.nome AS categoria,
                c.slug AS categoria_slug,
                (
                    SELECT pi.url_imagem
                    FROM produto_imagens pi
                    WHERE pi.produto_id = p.id
                    ORDER BY
                        pi.principal DESC,
                        pi.ordem ASC,
                        pi.id ASC
                    LIMIT 1
                ) AS imagem
            FROM produtos p
            INNER JOIN categorias c
                ON c.id = p.categoria_id
            WHERE p.slug = :slug
              AND p.status = :status
              AND c.ativo = 1
            LIMIT 1
        ';
        $consulta =
            $this->pdo->prepare($sql);
        $consulta->execute([
            'slug' => $slug,
            'status' => 'ativo',
        ]);
        $produto =
            $consulta->fetch();
        return is_array($produto)
            ? $produto
            : null;
    }

    public function buscarPorId(
        int $produtoId
    ): ?array {

        $sql = '
        SELECT
            p.id,
            p.categoria_id,
            p.nome,
            p.slug,
            p.descricao,
            p.preco,
            p.estoque,

            p.percentual_oferta,
            p.oferta_ativa,
            p.oferta_inicio,
            p.oferta_fim,

            c.nome AS categoria,
            c.slug AS categoria_slug,

            (
                SELECT pi.url_imagem

                FROM produto_imagens pi

                WHERE pi.produto_id = p.id

                ORDER BY
                    pi.principal DESC,
                    pi.ordem ASC,
                    pi.id ASC

                LIMIT 1
            ) AS imagem,

            CASE

                WHEN
                    p.oferta_ativa = 1

                    AND p.percentual_oferta > 0

                    AND p.percentual_oferta < 100

                    AND (
                        p.oferta_inicio IS NULL
                        OR p.oferta_inicio <= NOW()
                    )

                    AND (
                        p.oferta_fim IS NULL
                        OR p.oferta_fim >= NOW()
                    )

                THEN ROUND(
                    p.preco
                    * (
                        1
                        - p.percentual_oferta
                        / 100
                    ),
                    2
                )

                ELSE NULL

            END AS preco_oferta

        FROM produtos p

        INNER JOIN categorias c
            ON c.id = p.categoria_id

        WHERE p.id = :produto_id
          AND p.status = :status
          AND c.ativo = 1

        LIMIT 1
    ';


        $consulta =
            $this->pdo
            ->prepare($sql);


        $consulta->bindValue(
            ':produto_id',
            $produtoId,
            PDO::PARAM_INT
        );


        $consulta->bindValue(
            ':status',
            'ativo',
            PDO::PARAM_STR
        );


        $consulta->execute();


        $produto =
            $consulta->fetch();


        return is_array($produto)
            ? $produto
            : null;
    }

    public function listarOfertasAtivas(
        int $limite = 60
    ): array {
        $sql = '
        SELECT
            p.id,
            p.categoria_id,
            p.nome,
            p.slug,
            p.descricao,
            p.preco,
            p.estoque,
            p.percentual_oferta,
            p.oferta_inicio,
            p.oferta_fim,
            c.nome AS categoria,
            ROUND(
                p.preco
                * (
                    1
                    - p.percentual_oferta
                    / 100
                ),
                2
            ) AS preco_oferta,
            (
                SELECT pi.url_imagem
                FROM produto_imagens pi
                WHERE pi.produto_id = p.id
                ORDER BY
                    pi.principal DESC,
                    pi.ordem ASC,
                    pi.id ASC
                LIMIT 1
            ) AS imagem
        FROM produtos p
        INNER JOIN categorias c
            ON c.id = p.categoria_id
        WHERE p.status = :status
          AND c.ativo = 1
          AND p.oferta_ativa = 1
          AND p.percentual_oferta > 0
          AND p.percentual_oferta < 100
          AND (
              p.oferta_inicio IS NULL
              OR p.oferta_inicio <= NOW()
          )
          AND (
              p.oferta_fim IS NULL
              OR p.oferta_fim >= NOW()
          )
        ORDER BY
            p.percentual_oferta DESC,
            p.nome ASC
        LIMIT :limite
    ';
        $consulta =
            $this->pdo
            ->prepare($sql);
        $consulta->bindValue(
            ':status',
            'ativo',
            PDO::PARAM_STR
        );
        $consulta->bindValue(
            ':limite',
            $limite,
            PDO::PARAM_INT
        );
        $consulta->execute();
        return $consulta->fetchAll();
    }
}
