<?php

declare(strict_types=1);

namespace App\Repositories;

use PDO;

final class AdminCategoriasRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Lista categorias com filtros e quantidade de produtos vinculados.
     */
public function listar(
    string $busca = '',
    string $status = ''
): array {

    $sql = "
        SELECT
            c.id,
            c.nome,
            c.imgcategoria,
            c.slug,
            c.descricao,
            c.ativo,
            c.criado_em,
            c.atualizado_em,
            COUNT(p.id) AS total_produtos

        FROM categorias AS c

        LEFT JOIN produtos AS p
            ON p.categoria_id = c.id

        WHERE 1 = 1
    ";

    $parametros = [];

    /*
    |--------------------------------------------------------------------------
    | Filtro de pesquisa
    |--------------------------------------------------------------------------
    */
    if ($busca !== '') {

        $sql .= "
            AND (
                c.nome LIKE :busca_nome
                OR c.slug LIKE :busca_slug
                OR c.descricao LIKE :busca_descricao
            )
        ";

        $termo = '%' . $busca . '%';

        $parametros[':busca_nome'] =
            $termo;

        $parametros[':busca_slug'] =
            $termo;

        $parametros[':busca_descricao'] =
            $termo;
    }

    /*
    |--------------------------------------------------------------------------
    | Filtro por status
    |--------------------------------------------------------------------------
    */
    if ($status === 'ativo') {

        $sql .= "
            AND c.ativo = 1
        ";

    } elseif ($status === 'inativo') {

        $sql .= "
            AND c.ativo = 0
        ";
    }

    /*
    |--------------------------------------------------------------------------
    | Agrupamento
    |--------------------------------------------------------------------------
    */
    $sql .= "
        GROUP BY
            c.id,
            c.nome,
            c.imgcategoria,
            c.slug,
            c.descricao,
            c.ativo,
            c.criado_em,
            c.atualizado_em

        ORDER BY
            c.nome ASC
    ";

    /*
    |--------------------------------------------------------------------------
    | Executa consulta
    |--------------------------------------------------------------------------
    */
    $stmt = $this->pdo->prepare(
        $sql
    );

    $stmt->execute(
        $parametros
    );

    return $stmt->fetchAll(
        PDO::FETCH_ASSOC
    );
}

    public function buscarPorId(int $id): ?array
    {
        $sql = "
            SELECT
                id,
                nome,
                imgcategoria,
                slug,
                descricao,
                ativo,
                criado_em,
                atualizado_em
            FROM categorias
            WHERE id = :id
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':id' => $id,
        ]);

        $categoria = $stmt->fetch(PDO::FETCH_ASSOC);

        return $categoria !== false
            ? $categoria
            : null;
    }

    public function nomeExiste(
        string $nome,
        ?int $ignorarId = null
    ): bool {
        $sql = "
            SELECT id
            FROM categorias
            WHERE nome = :nome
        ";

        $parametros = [
            ':nome' => $nome,
        ];

        if ($ignorarId !== null) {
            $sql .= " AND id <> :ignorar_id ";
            $parametros[':ignorar_id'] = $ignorarId;
        }

        $sql .= " LIMIT 1 ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($parametros);

        return $stmt->fetchColumn() !== false;
    }

    public function slugExiste(
        string $slug,
        ?int $ignorarId = null
    ): bool {
        $sql = "
            SELECT id
            FROM categorias
            WHERE slug = :slug
        ";

        $parametros = [
            ':slug' => $slug,
        ];

        if ($ignorarId !== null) {
            $sql .= " AND id <> :ignorar_id ";
            $parametros[':ignorar_id'] = $ignorarId;
        }

        $sql .= " LIMIT 1 ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($parametros);

        return $stmt->fetchColumn() !== false;
    }

    public function cadastrar(array $dados): int
    {
        $sql = "
            INSERT INTO categorias (
                nome,
                imgcategoria,
                slug,
                descricao,
                ativo
            ) VALUES (
                :nome,
                :imgcategoria,
                :slug,
                :descricao,
                1
            )
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':nome' => $dados['nome'],
            ':imgcategoria' => $dados['imgcategoria'],
            ':slug' => $dados['slug'],
            ':descricao' => $dados['descricao'],
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function atualizar(
        int $id,
        array $dados
    ): bool {
        $sql = "
            UPDATE categorias
            SET
                nome = :nome,
                imgcategoria = :imgcategoria,
                slug = :slug,
                descricao = :descricao
            WHERE id = :id
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':id' => $id,
            ':nome' => $dados['nome'],
            ':imgcategoria' => $dados['imgcategoria'],
            ':slug' => $dados['slug'],
            ':descricao' => $dados['descricao'],
        ]);
    }

    public function desativar(int $id): bool
    {
        $stmt = $this->pdo->prepare("
            UPDATE categorias
            SET ativo = 0
            WHERE id = :id
              AND ativo = 1
        ");

        $stmt->execute([
            ':id' => $id,
        ]);

        return $stmt->rowCount() > 0;
    }

    public function ativar(int $id): bool
    {
        $stmt = $this->pdo->prepare("
            UPDATE categorias
            SET ativo = 1
            WHERE id = :id
              AND ativo = 0
        ");

        $stmt->execute([
            ':id' => $id,
        ]);

        return $stmt->rowCount() > 0;
    }
}