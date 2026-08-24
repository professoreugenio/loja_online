<?php

declare(strict_types=1);

namespace App\Repositories;

use PDO;

final class ProdutoAdminRepository
{
    public function __construct(
        private PDO $pdo
    ) {}

    public function listarCategorias(): array
    {
        $sql = "
            SELECT id, nome, ativo
            FROM categorias
            ORDER BY nome ASC
        ";

        $dados = $this->pdo
            ->query($sql)
            ->fetchAll(PDO::FETCH_ASSOC);

        return is_array($dados) ? $dados : [];
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

        /*
    |--------------------------------------------------------------------------
    | Parâmetros
    |--------------------------------------------------------------------------
    */
        $parametros = [];

        /*
    |--------------------------------------------------------------------------
    | Pesquisa
    |--------------------------------------------------------------------------
    */
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

        /*
    |--------------------------------------------------------------------------
    | Categoria
    |--------------------------------------------------------------------------
    */
        if ($categoriaId !== null) {

            $sql .= "
            AND p.categoria_id = :categoria_id
        ";

            $parametros['categoria_id'] =
                $categoriaId;
        }

        /*
    |--------------------------------------------------------------------------
    | Destaque
    |--------------------------------------------------------------------------
    */
        if ($destaque !== null) {

            $sql .= "
            AND p.destaque = :destaque
        ";

            $parametros['destaque'] =
                $destaque;
        }

        /*
    |--------------------------------------------------------------------------
    | Ordenação
    |--------------------------------------------------------------------------
    */
        $sql .= "
        ORDER BY
            p.nome ASC,
            p.id DESC
    ";

        /*
    |--------------------------------------------------------------------------
    | Prepare
    |--------------------------------------------------------------------------
    */
        $stmt = $this->pdo->prepare($sql);

        /*
    |--------------------------------------------------------------------------
    | Bind pesquisa
    |--------------------------------------------------------------------------
    */
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

        /*
    |--------------------------------------------------------------------------
    | Bind categoria
    |--------------------------------------------------------------------------
    */
        if (isset($parametros['categoria_id'])) {

            $stmt->bindValue(
                ':categoria_id',
                $parametros['categoria_id'],
                PDO::PARAM_INT
            );
        }

        /*
    |--------------------------------------------------------------------------
    | Bind destaque
    |--------------------------------------------------------------------------
    */
        if (array_key_exists(
            'destaque',
            $parametros
        )) {

            $stmt->bindValue(
                ':destaque',
                $parametros['destaque'],
                PDO::PARAM_INT
            );
        }

        /*
    |--------------------------------------------------------------------------
    | Executar
    |--------------------------------------------------------------------------
    */
        $stmt->execute();

        $dados = $stmt->fetchAll(
            PDO::FETCH_ASSOC
        );

        return is_array($dados)
            ? $dados
            : [];
    }
}
