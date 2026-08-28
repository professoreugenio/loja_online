<?php

declare(strict_types=1);

namespace App\Repositories;

use PDO;

final class AdminRepository
{
    private const LIMITE_ESTOQUE_BAIXO = 10;

    public function __construct(
        private PDO $pdo
    ) {
    }

    /**
     * Retorna os principais indicadores do painel.
     *
     * Observação:
     * O banco atual não possui tabelas "notificacoes" e "contatos".
     * Por isso, esses dois números não são consultados aqui.
     */
    public function obterIndicadores(): array
    {
        $sql = "
            SELECT
                (
                    SELECT COUNT(*)
                    FROM produtos
                ) AS total_produtos,

                (
                    SELECT COUNT(*)
                    FROM produtos
                    WHERE criado_em >= DATE_FORMAT(CURRENT_DATE, '%Y-%m-01')
                      AND criado_em < DATE_FORMAT(
                            DATE_ADD(CURRENT_DATE, INTERVAL 1 MONTH),
                            '%Y-%m-01'
                      )
                ) AS produtos_mes,

                (
                    SELECT COUNT(*)
                    FROM clientes
                ) AS total_clientes,

                (
                    SELECT COUNT(*)
                    FROM clientes
                    WHERE criado_em >= DATE_FORMAT(CURRENT_DATE, '%Y-%m-01')
                      AND criado_em < DATE_FORMAT(
                            DATE_ADD(CURRENT_DATE, INTERVAL 1 MONTH),
                            '%Y-%m-01'
                      )
                ) AS clientes_mes,

                (
                    SELECT COUNT(*)
                    FROM pedidos
                    WHERE status NOT IN ('entregue', 'cancelado')
                ) AS pedidos_pendentes,

                (
                    SELECT COUNT(*)
                    FROM pedidos
                    WHERE status = 'aguardando_pagamento'
                ) AS pedidos_aguardando_pagamento,

                (
                    SELECT COUNT(*)
                    FROM produtos
                    WHERE status = 'ativo'
                      AND estoque <= " . self::LIMITE_ESTOQUE_BAIXO . "
                ) AS estoque_baixo,

                (
                    SELECT COUNT(*)
                    FROM carrinhos
                    WHERE status = 'aberto'
                ) AS carrinhos_ativos,

                (
                    SELECT COUNT(*)
                    FROM carrinhos
                    WHERE status = 'aberto'
                      AND DATE(criado_em) = CURRENT_DATE
                ) AS carrinhos_hoje,

                (
                    SELECT COALESCE(SUM(valor), 0)
                    FROM pagamentos
                    WHERE status = 'aprovado'
                      AND COALESCE(aprovado_em, criado_em)
                          >= DATE_FORMAT(CURRENT_DATE, '%Y-%m-01')
                      AND COALESCE(aprovado_em, criado_em)
                          < DATE_FORMAT(
                                DATE_ADD(CURRENT_DATE, INTERVAL 1 MONTH),
                                '%Y-%m-01'
                            )
                ) AS pagamentos_mes
        ";

        $dados = $this->pdo
            ->query($sql)
            ->fetch(PDO::FETCH_ASSOC);

        if (!is_array($dados)) {
            return $this->indicadoresVazios();
        }

        return [
            'total_produtos' => (int) ($dados['total_produtos'] ?? 0),
            'produtos_mes' => (int) ($dados['produtos_mes'] ?? 0),
            'total_clientes' => (int) ($dados['total_clientes'] ?? 0),
            'clientes_mes' => (int) ($dados['clientes_mes'] ?? 0),
            'pedidos_pendentes' => (int) ($dados['pedidos_pendentes'] ?? 0),
            'pedidos_aguardando_pagamento' =>
                (int) ($dados['pedidos_aguardando_pagamento'] ?? 0),
            'estoque_baixo' => (int) ($dados['estoque_baixo'] ?? 0),
            'carrinhos_ativos' => (int) ($dados['carrinhos_ativos'] ?? 0),
            'carrinhos_hoje' => (int) ($dados['carrinhos_hoje'] ?? 0),
            'pagamentos_mes' => (float) ($dados['pagamentos_mes'] ?? 0),
        ];
    }

    public function listarPedidosRecentes(
        int $limite = 5
    ): array {
        $limite = max(1, min($limite, 20));

        $sql = "
            SELECT
                p.id,
                p.codigo,
                p.status,
                p.total,
                p.criado_em,
                c.nome AS cliente_nome
            FROM pedidos AS p
            INNER JOIN clientes AS c
                ON c.id = p.cliente_id
            ORDER BY p.criado_em DESC, p.id DESC
            LIMIT {$limite}
        ";

        $dados = $this->pdo
            ->query($sql)
            ->fetchAll(PDO::FETCH_ASSOC);

        return is_array($dados) ? $dados : [];
    }

    public function listarEstoqueBaixo(
        int $limite = 5
    ): array {
        $limite = max(1, min($limite, 20));

        $sql = "
            SELECT
                id,
                nome,
                estoque
            FROM produtos
            WHERE status = 'ativo'
              AND estoque <= " . self::LIMITE_ESTOQUE_BAIXO . "
            ORDER BY estoque ASC, nome ASC
            LIMIT {$limite}
        ";

        $dados = $this->pdo
            ->query($sql)
            ->fetchAll(PDO::FETCH_ASSOC);

        return is_array($dados) ? $dados : [];
    }

    private function indicadoresVazios(): array
    {
        return [
            'total_produtos' => 0,
            'produtos_mes' => 0,
            'total_clientes' => 0,
            'clientes_mes' => 0,
            'pedidos_pendentes' => 0,
            'pedidos_aguardando_pagamento' => 0,
            'estoque_baixo' => 0,
            'carrinhos_ativos' => 0,
            'carrinhos_hoje' => 0,
            'pagamentos_mes' => 0.0,
        ];
    }

    public function listarClientes(string $busca = '', string $status = ''): array
    {
        $busca = trim($busca);
        $status = trim($status);

        $sql = "
            SELECT
                id,
                nome,
                cpf,
                email,
                telefone,
                status,
                criado_em
            FROM clientes
            WHERE 1 = 1
        ";

        $params = [];

        if ($busca !== '') {
            /*
             * Não reutilizamos o mesmo placeholder várias vezes.
             * A conexão do projeto usa prepared statements nativos
             * (ATTR_EMULATE_PREPARES = false).
             */
            $sql .= "
                AND (
                    nome LIKE :busca_nome
                    OR email LIKE :busca_email
                    OR cpf LIKE :busca_cpf
                )
            ";

            $cpfSomenteNumeros = preg_replace('/\D+/', '', $busca) ?? '';

            $params['busca_nome'] = '%' . $busca . '%';
            $params['busca_email'] = '%' . $busca . '%';
            $params['busca_cpf'] = '%' . (
                $cpfSomenteNumeros !== ''
                    ? $cpfSomenteNumeros
                    : $busca
            ) . '%';
        }

        if (in_array($status, ['ativo', 'inativo', 'bloqueado'], true)) {
            $sql .= " AND status = :status";
            $params['status'] = $status;
        }

        $sql .= " ORDER BY id DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return is_array($clientes) ? $clientes : [];
    }

    public function buscarClientePorId(int $id): ?array
    {
        $sql = "SELECT * FROM clientes WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

        return $cliente ?: null;
    }

    public function inativarCliente(int $id): bool
    {
        $sql = "
            UPDATE clientes
            SET
                status = 'inativo',
                atualizado_em = CURRENT_TIMESTAMP
            WHERE id = :id
              AND status <> 'inativo'
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function ativarCliente(int $id): bool
    {
        $sql = "
            UPDATE clientes
            SET
                status = 'ativo',
                atualizado_em = CURRENT_TIMESTAMP
            WHERE id = :id
              AND status = 'inativo'
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function listarEnderecosCliente(int $clienteId): array
    {
        $sql = "
            SELECT
                id,
                identificacao,
                destinatario,
                cep,
                logradouro,
                numero,
                complemento,
                bairro,
                cidade,
                estado,
                principal,
                criado_em,
                atualizado_em
            FROM enderecos
            WHERE cliente_id = :cliente_id
            ORDER BY principal DESC, id DESC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':cliente_id', $clienteId, PDO::PARAM_INT);
        $stmt->execute();

        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return is_array($dados) ? $dados : [];
    }

    public function listarPedidosCliente(int $clienteId): array
    {
        $sql = "
            SELECT
                id,
                codigo,
                status,
                subtotal,
                frete,
                desconto,
                total,
                observacao,
                criado_em,
                atualizado_em
            FROM pedidos
            WHERE cliente_id = :cliente_id
            ORDER BY criado_em DESC, id DESC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':cliente_id', $clienteId, PDO::PARAM_INT);
        $stmt->execute();

        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return is_array($dados) ? $dados : [];
    }

    public function listarCarrinhosAbertosCliente(int $clienteId): array
    {
        $sql = "
            SELECT
                c.id,
                c.status,
                c.criado_em,
                c.atualizado_em,
                COALESCE(SUM(ci.quantidade), 0) AS total_unidades,
                COALESCE(SUM(ci.quantidade * ci.preco_unitario), 0) AS total_carrinho
            FROM carrinhos AS c
            LEFT JOIN carrinho_itens AS ci
                ON ci.carrinho_id = c.id
            WHERE c.cliente_id = :cliente_id
              AND c.status = 'aberto'
            GROUP BY
                c.id,
                c.status,
                c.criado_em,
                c.atualizado_em
            ORDER BY c.atualizado_em DESC, c.id DESC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':cliente_id', $clienteId, PDO::PARAM_INT);
        $stmt->execute();

        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return is_array($dados) ? $dados : [];
    }

    public function buscarCarrinhoAbertoPorId(int $carrinhoId): ?array
    {
        $sql = "
            SELECT
                c.id,
                c.cliente_id,
                c.status,
                c.criado_em,
                c.atualizado_em,
                cl.nome AS cliente_nome,
                cl.email AS cliente_email,
                cl.cpf AS cliente_cpf
            FROM carrinhos AS c
            INNER JOIN clientes AS cl
                ON cl.id = c.cliente_id
            WHERE c.id = :carrinho_id
              AND c.status = 'aberto'
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':carrinho_id', $carrinhoId, PDO::PARAM_INT);
        $stmt->execute();

        $carrinho = $stmt->fetch(PDO::FETCH_ASSOC);

        return is_array($carrinho) ? $carrinho : null;
    }

    public function listarItensCarrinho(int $carrinhoId): array
    {
        $sql = "
            SELECT
                ci.id,
                ci.produto_id,
                ci.quantidade,
                ci.preco_unitario,
                (ci.quantidade * ci.preco_unitario) AS subtotal,
                p.nome AS produto_nome,
                p.status AS produto_status,
                p.estoque,
                cat.nome AS categoria_nome
            FROM carrinho_itens AS ci
            INNER JOIN produtos AS p
                ON p.id = ci.produto_id
            LEFT JOIN categorias AS cat
                ON cat.id = p.categoria_id
            WHERE ci.carrinho_id = :carrinho_id
            ORDER BY ci.criado_em ASC, ci.id ASC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':carrinho_id', $carrinhoId, PDO::PARAM_INT);
        $stmt->execute();

        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return is_array($dados) ? $dados : [];
    }
}