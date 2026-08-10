<?php

declare(strict_types=1);

namespace App\Repositories;

use PDO;

final class CategoriaRepository
{
    public function __construct(
        private PDO $pdo
    ) {
    }

    /**
     * Retorna somente categorias ativas.
     */
    public function listarAtivas(): array
    {
        $sql = "
            SELECT
                id,
                nome,
                slug,
                imgcategoria,
                descricao
            FROM categorias
            WHERE ativo = 1
            ORDER BY nome ASC
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Localiza uma categoria pelo slug.
     */
    public function buscarPorSlug(string $slug): ?array
    {
        $sql = "
            SELECT
                id,
                nome,
                slug,
                imgcategoria,
                descricao
            FROM categorias
            WHERE slug = :slug
              AND ativo = 1
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'slug' => $slug
        ]);

        $categoria = $stmt->fetch(PDO::FETCH_ASSOC);

        return $categoria ?: null;
    }
}