<?php

declare(strict_types=1);

namespace App\Repositories;

use PDO;

final class CheckoutRepository
{
    private PDO $pdo;

    public function __construct(
        PDO $pdo
    ) {
        $this->pdo = $pdo;
    }

    public function criarPedido(
        int $carrinhoId,
        int $clienteId,
        int $enderecoId,
        float $subtotal,
        float $frete,
        float $desconto,
        float $total
    ): array {
        $codigo =
            'PED-'
            . date('YmdHis')
            . '-'
            . strtoupper(
                bin2hex(random_bytes(3))
            );

        $sql = '
            INSERT INTO pedidos (
                codigo,
                cliente_id,
                carrinho_id,
                endereco_id,
                status,
                subtotal,
                frete,
                desconto,
                total
            ) VALUES (
                :codigo,
                :cliente_id,
                :carrinho_id,
                :endereco_id,
                :status,
                :subtotal,
                :frete,
                :desconto,
                :total
            )
        ';

        $consulta =
            $this->pdo->prepare($sql);

        $consulta->execute([
            'codigo' => $codigo,
            'cliente_id' => $clienteId,
            'carrinho_id' => $carrinhoId,
            'endereco_id' => $enderecoId,
            'status' =>
                'aguardando_pagamento',
            'subtotal' =>
                number_format($subtotal, 2, '.', ''),
            'frete' =>
                number_format($frete, 2, '.', ''),
            'desconto' =>
                number_format($desconto, 2, '.', ''),
            'total' =>
                number_format($total, 2, '.', ''),
        ]);

        return [
            'id' =>
                (int) $this->pdo
                    ->lastInsertId(),
            'codigo' =>
                $codigo,
            'subtotal' =>
                $subtotal,
            'frete' =>
                $frete,
            'desconto' =>
                $desconto,
            'total' =>
                $total,
        ];
    }

    public function copiarItens(
        int $pedidoId,
        array $itens
    ): void {
        $sql = '
            INSERT INTO pedido_itens (
                pedido_id,
                produto_id,
                nome_produto,
                quantidade,
                preco_unitario,
                subtotal
            ) VALUES (
                :pedido_id,
                :produto_id,
                :nome_produto,
                :quantidade,
                :preco_unitario,
                :subtotal
            )
        ';

        $consulta =
            $this->pdo->prepare($sql);

        foreach ($itens as $item) {
            $consulta->execute([
                'pedido_id' => $pedidoId,
                'produto_id' =>
                    (int) $item['produto_id'],
                'nome_produto' =>
                    (string) $item['nome'],
                'quantidade' =>
                    (int) $item['quantidade'],
                'preco_unitario' =>
                    number_format(
                        (float) $item[
                            'preco_unitario'
                        ],
                        2,
                        '.',
                        ''
                    ),
                'subtotal' =>
                    number_format(
                        (float) $item['subtotal'],
                        2,
                        '.',
                        ''
                    ),
            ]);
        }
    }

    public function copiarEndereco(
        int $pedidoId,
        array $endereco
    ): void {
        $sql = '
            INSERT INTO pedido_enderecos (
                pedido_id,
                destinatario,
                cep,
                logradouro,
                numero,
                complemento,
                bairro,
                cidade,
                estado
            ) VALUES (
                :pedido_id,
                :destinatario,
                :cep,
                :logradouro,
                :numero,
                :complemento,
                :bairro,
                :cidade,
                :estado
            )
        ';

        $consulta =
            $this->pdo->prepare($sql);

        $consulta->execute([
            'pedido_id' => $pedidoId,
            'destinatario' =>
                $endereco['destinatario'],
            'cep' => $endereco['cep'],
            'logradouro' =>
                $endereco['logradouro'],
            'numero' => $endereco['numero'],
            'complemento' =>
                $endereco['complemento'] ?? null,
            'bairro' => $endereco['bairro'],
            'cidade' => $endereco['cidade'],
            'estado' => $endereco['estado'],
        ]);
    }

    public function marcarCarrinhoConvertido(
        int $carrinhoId
    ): void {
        $sql = '
            UPDATE carrinhos
            SET status = :status
            WHERE id = :id
              AND status = :aberto
        ';

        $consulta =
            $this->pdo->prepare($sql);

        $consulta->execute([
            'status' => 'convertido',
            'id' => $carrinhoId,
            'aberto' => 'aberto',
        ]);
    }
}
