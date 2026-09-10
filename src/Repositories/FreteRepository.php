<?php

declare(strict_types=1);

namespace App\Repositories;

use PDO;

final class FreteRepository
{
    private PDO $pdo;

    public function __construct(
        PDO $pdo
    ) {
        $this->pdo = $pdo;
    }

    public function buscarPorCep(
        int $cep
    ): ?array {
        $sql = '
            SELECT
                id,
                nome,
                cep_inicio,
                cep_fim,
                valor,
                prazo_dias
            FROM fretes_faixas_cep
            WHERE :cep BETWEEN
                cep_inicio
                AND cep_fim
              AND ativo = 1
            ORDER BY
                cep_inicio DESC
            LIMIT 1
        ';

        $consulta =
            $this->pdo
            ->prepare($sql);

        $consulta->bindValue(
            ':cep',
            $cep,
            PDO::PARAM_INT
        );

        $consulta->execute();

        $frete =
            $consulta->fetch();

        return is_array($frete)
            ? $frete
            : null;
    }
}
