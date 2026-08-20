<?php

declare(strict_types=1);

namespace App\Repositories;

use PDO;

final class PedidoRepository
{
    private PDO $pdo;


    public function __construct(
        PDO $pdo
    ) {
        $this->pdo = $pdo;
    }

    public function resumoPainel(
        int $clienteId
    ): array {

        $sql = '
        SELECT
            COUNT(*) AS total_pedidos,

            COALESCE(
                SUM(
                    CASE
                        WHEN status IN (
                            :aguardando,
                            :pago,
                            :separacao,
                            :enviado
                        )
                        THEN 1
                        ELSE 0
                    END
                ),
                0
            ) AS em_andamento,

            COALESCE(
                SUM(
                    CASE
                        WHEN status =
                            :entregue
                        THEN 1
                        ELSE 0
                    END
                ),
                0
            ) AS entregues

        FROM pedidos

        WHERE cliente_id =
            :cliente_id
    ';


        $consulta =
            $this->pdo
            ->prepare($sql);


        $consulta->execute([
            'aguardando' =>
            'aguardando_pagamento',

            'pago' =>
            'pago',

            'separacao' =>
            'em_separacao',

            'enviado' =>
            'enviado',

            'entregue' =>
            'entregue',

            'cliente_id' =>
            $clienteId,
        ]);


        $resumo =
            $consulta->fetch();


        if (!is_array($resumo)) {

            return [
                'total_pedidos' => 0,
                'em_andamento' => 0,
                'entregues' => 0,
            ];
        }


        return [
            'total_pedidos' =>
            (int)
            $resumo['total_pedidos'],

            'em_andamento' =>
            (int)
            $resumo['em_andamento'],

            'entregues' =>
            (int)
            $resumo['entregues'],
        ];
    }

    public function listarUltimosDoCliente(
        int $clienteId,
        int $limite = 3
    ): array {

        $limite =
            max(
                1,
                min(
                    $limite,
                    20
                )
            );


        $sql = '
        SELECT
            id,
            codigo,
            status,
            total,
            criado_em

        FROM pedidos

        WHERE cliente_id =
            :cliente_id

        ORDER BY
            criado_em DESC,
            id DESC

        LIMIT :limite
    ';


        $consulta =
            $this->pdo
            ->prepare($sql);


        $consulta->bindValue(
            ':cliente_id',
            $clienteId,
            PDO::PARAM_INT
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
}
