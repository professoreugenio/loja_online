<?php

declare(strict_types=1);

namespace App\Repositories;

use PDO;

final class PagamentoRepository
{
    private PDO $pdo;

    public function __construct(
        PDO $pdo
    ) {
        $this->pdo = $pdo;
    }

    public function criarPendente(
        int $pedidoId,
        float $valor
    ): int {
        $sql = '
            INSERT INTO pagamentos (
                pedido_id,
                provedor,
                metodo,
                status,
                valor
            ) VALUES (
                :pedido_id,
                :provedor,
                NULL,
                :status,
                :valor
            )
        ';

        $consulta =
            $this->pdo->prepare($sql);

        $consulta->execute([
            'pedido_id' => $pedidoId,
            'provedor' => 'mercadopago',
            'status' => 'pendente',
            'valor' =>
                number_format($valor, 2, '.', ''),
        ]);

        return (int) $this->pdo
            ->lastInsertId();
    }

    public function salvarPreferencia(
        int $pagamentoId,
        string $preferenciaId,
        string $url
    ): void {
        $sql = '
            UPDATE pagamentos
            SET
                preferencia_externa_id =
                    :preferencia_id,
                url_pagamento =
                    :url
            WHERE id = :id
        ';

        $consulta =
            $this->pdo->prepare($sql);

        $consulta->execute([
            'preferencia_id' =>
                $preferenciaId,
            'url' => $url,
            'id' => $pagamentoId,
        ]);
    }
}
