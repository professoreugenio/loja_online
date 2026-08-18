<?php
declare(strict_types=1);
namespace App\Repositories;
use PDO;
final class CategoriaRepository
{
    private PDO $pdo;
    public function __construct(
        PDO $pdo
    ) {
        $this->pdo = $pdo;
    }
    public function listarAtivas(): array
    {
        $sql = '
            SELECT
                id,
                nome,
                imgcategoria,
                slug,
                descricao
            FROM categorias
            WHERE ativo = 1
            ORDER BY nome ASC
        ';
        $consulta =
            $this->pdo->prepare($sql);
        $consulta->execute();
        return $consulta->fetchAll();
    }
    public function buscarPorId(
        int $id
    ): ?array {
        $sql = '
            SELECT
                id,
                nome,
                imgcategoria,
                slug,
                descricao
            FROM categorias
            WHERE id = :id
              AND ativo = 1
            LIMIT 1
        ';
        $consulta =
            $this->pdo->prepare($sql);
        $consulta->execute([
            'id' => $id,
        ]);
        $categoria =
            $consulta->fetch();
        return is_array($categoria)
            ? $categoria
            : null;
    }
}
