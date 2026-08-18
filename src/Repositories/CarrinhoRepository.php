<?php
declare(strict_types=1);
namespace App\Repositories;
use PDO;
final class CarrinhoRepository
{
    private PDO $pdo;
    public function __construct(
        PDO $pdo
    ) {
        $this->pdo = $pdo;
    }
    public function buscarAbertoPorToken(
        string $tokenSessao
    ): ?array {
        $sql = '
        SELECT
            id,
            cliente_id,
            token_sessao,
            status
        FROM carrinhos
        WHERE token_sessao =
            :token_sessao
          AND status =
            :status
        LIMIT 1
    ';
        $consulta =
            $this->pdo
            ->prepare($sql);
        $consulta->execute([
            'token_sessao' =>
            $tokenSessao,
            'status' =>
            'aberto',
        ]);
        $carrinho =
            $consulta->fetch();
        return is_array(
            $carrinho
        )
            ? $carrinho
            : null;
    }
    private function criar(
        ?int $clienteId,
        string $tokenSessao
    ): int {
        $sql = '
        INSERT INTO carrinhos (
            cliente_id,
            token_sessao,
            status
        ) VALUES (
            :cliente_id,
            :token_sessao,
            :status
        )
    ';
        $consulta =
            $this->pdo
            ->prepare($sql);
        if ($clienteId === null) {
            $consulta->bindValue(
                ':cliente_id',
                null,
                PDO::PARAM_NULL
            );
        } else {
            $consulta->bindValue(
                ':cliente_id',
                $clienteId,
                PDO::PARAM_INT
            );
        }
        $consulta->bindValue(
            ':token_sessao',
            $tokenSessao,
            PDO::PARAM_STR
        );
        $consulta->bindValue(
            ':status',
            'aberto',
            PDO::PARAM_STR
        );
        $consulta->execute();
        return (int)
        $this->pdo
            ->lastInsertId();
    }
    private function vincularCliente(
        int $carrinhoId,
        int $clienteId
    ): void {
        $sql = '
        UPDATE carrinhos
        SET cliente_id =
            :cliente_id
        WHERE id =
            :carrinho_id
          AND cliente_id
            IS NULL
    ';
        $consulta =
            $this->pdo
            ->prepare($sql);
        $consulta->execute([
            'cliente_id' =>
            $clienteId,
            'carrinho_id' =>
            $carrinhoId,
        ]);
    }
    public function obterOuCriar(
        ?int $clienteId,
        string $tokenSessao
    ): int {
        $carrinho =
            $this->buscarAbertoPorToken(
                $tokenSessao
            );
        if ($carrinho !== null) {
            $carrinhoId =
                (int)
                $carrinho['id'];
            if (
                $clienteId !== null
                &&
                $carrinho['cliente_id'] === null
            ) {
                $this->vincularCliente(
                    $carrinhoId,
                    $clienteId
                );
            }
            return $carrinhoId;
        }
        return $this->criar(
            $clienteId,
            $tokenSessao
        );
    }
    public function quantidadeDoProduto(
        int $carrinhoId,
        int $produtoId
    ): int {
        $sql = '
        SELECT quantidade
        FROM carrinho_itens
        WHERE carrinho_id =
            :carrinho_id
          AND produto_id =
            :produto_id
        LIMIT 1
    ';
        $consulta =
            $this->pdo
            ->prepare($sql);
        $consulta->execute([
            'carrinho_id' =>
            $carrinhoId,
            'produto_id' =>
            $produtoId,
        ]);
        $quantidade =
            $consulta->fetchColumn();
        return $quantidade === false
            ? 0
            : (int) $quantidade;
    }
    public function salvarItem(
        int $carrinhoId,
        int $produtoId,
        int $quantidade,
        float $precoUnitario
    ): void {
        $sql = '
        INSERT INTO carrinho_itens (
            carrinho_id,
            produto_id,
            quantidade,
            preco_unitario
        ) VALUES (
            :carrinho_id,
            :produto_id,
            :quantidade,
            :preco_unitario
        )
        ON DUPLICATE KEY UPDATE
            quantidade =
                VALUES(quantidade),
            preco_unitario =
                VALUES(preco_unitario)
    ';
        $consulta =
            $this->pdo
            ->prepare($sql);
        $consulta->execute([
            'carrinho_id' =>
            $carrinhoId,
            'produto_id' =>
            $produtoId,
            'quantidade' =>
            $quantidade,
            'preco_unitario' =>
            number_format(
                $precoUnitario,
                2,
                '.',
                ''
            ),
        ]);
    }
    public function atualizarQuantidade(
        int $carrinhoId,
        int $produtoId,
        int $quantidade
    ): void {
        $sql = '
        UPDATE carrinho_itens
        SET quantidade =
            :quantidade
        WHERE carrinho_id =
            :carrinho_id
          AND produto_id =
            :produto_id
    ';
        $consulta =
            $this->pdo
            ->prepare($sql);
        $consulta->execute([
            'quantidade' =>
            $quantidade,
            'carrinho_id' =>
            $carrinhoId,
            'produto_id' =>
            $produtoId,
        ]);
    }
    public function removerItem(
        int $carrinhoId,
        int $produtoId
    ): void {
        $sql = '
        DELETE FROM carrinho_itens
        WHERE carrinho_id =
            :carrinho_id
          AND produto_id =
            :produto_id
    ';
        $consulta =
            $this->pdo
            ->prepare($sql);
        $consulta->execute([
            'carrinho_id' =>
            $carrinhoId,
            'produto_id' =>
            $produtoId,
        ]);
    }
    public function listarItens(
        int $carrinhoId
    ): array {
        $sql = '
        SELECT
            ci.produto_id,
            ci.quantidade,
            ci.preco_unitario,
            p.nome,
            p.descricao,
            p.estoque,
            p.status,
            c.nome AS categoria,
            (
                ci.quantidade
                *
                ci.preco_unitario
            ) AS subtotal,
            (
                SELECT
                    pi.url_imagem
                FROM produto_imagens pi
                WHERE
                    pi.produto_id =
                        p.id
                ORDER BY
                    pi.principal DESC,
                    pi.ordem ASC,
                    pi.id ASC
                LIMIT 1
            ) AS imagem
        FROM carrinho_itens ci
        INNER JOIN produtos p
            ON p.id =
                ci.produto_id
        INNER JOIN categorias c
            ON c.id =
                p.categoria_id
        WHERE ci.carrinho_id =
            :carrinho_id
        ORDER BY
            ci.criado_em ASC
    ';
        $consulta =
            $this->pdo
            ->prepare($sql);
        $consulta->execute([
            'carrinho_id' =>
            $carrinhoId,
        ]);
        return
            $consulta->fetchAll();
    }
}
