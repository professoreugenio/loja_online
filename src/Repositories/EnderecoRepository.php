<?php

declare(strict_types=1);

namespace App\Repositories;

use PDO;
use RuntimeException;

final class EnderecoRepository
{
    private PDO $pdo;


    public function __construct(
        PDO $pdo
    ) {
        $this->pdo = $pdo;
    }


    /**
     * Lista todos os endereços de um cliente.
     */
    public function listarPorCliente(
        int $clienteId
    ): array {

        $sql = '
            SELECT
                id,
                cliente_id,
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

            ORDER BY
                principal DESC,
                id DESC
        ';


        $consulta =
            $this->pdo
            ->prepare($sql);


        $consulta->bindValue(
            ':cliente_id',
            $clienteId,
            PDO::PARAM_INT
        );


        $consulta->execute();


        return $consulta->fetchAll();
    }


    /**
     * Busca um endereço específico pertencente ao cliente.
     */
    public function buscarPorId(
        int $id,
        int $clienteId
    ): ?array {

        $sql = '
            SELECT
                id,
                cliente_id,
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

            WHERE id = :id

              AND cliente_id = :cliente_id

            LIMIT 1
        ';


        $consulta =
            $this->pdo
            ->prepare($sql);


        $consulta->bindValue(
            ':id',
            $id,
            PDO::PARAM_INT
        );


        $consulta->bindValue(
            ':cliente_id',
            $clienteId,
            PDO::PARAM_INT
        );


        $consulta->execute();


        $endereco =
            $consulta->fetch();


        return is_array(
            $endereco
        )
            ? $endereco
            : null;
    }


    /**
     * Cadastra um novo endereço.
     *
     * Se principal = true, remove o principal anterior
     * antes de cadastrar o novo.
     */
    public function cadastrar(array $dados): bool
    {
        $sql = "INSERT INTO enderecos (cliente_id, identificacao, destinatario, cep, logradouro, numero, complemento, bairro, cidade, estado, principal) 
            VALUES (:cliente_id, :identificacao, :destinatario, :cep, :logradouro, :numero, :complemento, :bairro, :cidade, :estado, :principal)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':cliente_id', $dados['cliente_id'], \PDO::PARAM_INT);
        $stmt->bindValue(':identificacao', $dados['identificacao']);
        $stmt->bindValue(':destinatario', $dados['destinatario']);
        $stmt->bindValue(':cep', $dados['cep']);
        $stmt->bindValue(':logradouro', $dados['logradouro']);
        $stmt->bindValue(':numero', $dados['numero']);
        $stmt->bindValue(':complemento', $dados['complemento']);
        $stmt->bindValue(':bairro', $dados['bairro']);
        $stmt->bindValue(':cidade', $dados['cidade']);
        $stmt->bindValue(':estado', $dados['estado']);
        $stmt->bindValue(':principal', $dados['principal'], \PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function desmarcarPrincipaisDoCliente(int $clienteId): bool
    {
        $sql = "UPDATE enderecos SET principal = 0 WHERE cliente_id = :cliente_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':cliente_id', $clienteId, \PDO::PARAM_INT);

        return $stmt->execute();
    }


    /**
     * Mantém compatibilidade com o cadastro
     * do endereço principal utilizado atualmente.
     */
    public function cadastrarPrincipal(
        int $clienteId,
        array $dados
    ): int {

        $dados['identificacao'] =
            'Endereço principal';

        $dados['principal'] =
            true;


        return $this->cadastrar(
            $clienteId,
            [
                'identificacao' =>
                $dados['identificacao'],

                'destinatario' =>
                $dados['nome'],

                'cep' =>
                $dados['cep'],

                'logradouro' =>
                $dados['logradouro'],

                'numero' =>
                $dados['numero'],

                'complemento' =>
                $dados['complemento'] ?? '',

                'bairro' =>
                $dados['bairro'],

                'cidade' =>
                $dados['cidade'],

                'estado' =>
                $dados['estado'],

                'principal' =>
                true,
            ]
        );
    }


    /**
     * Atualiza um endereço pertencente ao cliente.
     */
    public function buscarPorIdECliente(int $id, int $clienteId): ?array
    {
        $sql = "SELECT * FROM enderecos WHERE id = :id AND cliente_id = :cliente_id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->bindValue(':cliente_id', $clienteId, \PDO::PARAM_INT);
        $stmt->execute();

        $resultado = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $resultado ?: null;
    }

    public function atualizar(int $id, int $clienteId, array $dados): bool
    {
        $sql = "UPDATE enderecos 
            SET identificacao = :identificacao,
                destinatario = :destinatario,
                cep = :cep,
                logradouro = :logradouro,
                numero = :numero,
                complemento = :complemento,
                bairro = :bairro,
                cidade = :cidade,
                estado = :estado
            WHERE id = :id AND cliente_id = :cliente_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':identificacao', $dados['identificacao']);
        $stmt->bindValue(':destinatario', $dados['destinatario']);
        $stmt->bindValue(':cep', $dados['cep']);
        $stmt->bindValue(':logradouro', $dados['logradouro']);
        $stmt->bindValue(':numero', $dados['numero']);
        $stmt->bindValue(':complemento', $dados['complemento']);
        $stmt->bindValue(':bairro', $dados['bairro']);
        $stmt->bindValue(':cidade', $dados['cidade']);
        $stmt->bindValue(':estado', $dados['estado']);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->bindValue(':cliente_id', $clienteId, \PDO::PARAM_INT);

        return $stmt->execute();
    }




    /**
     * Exclui um endereço pertencente ao cliente.
     */
   public function excluir(int $id, int $clienteId): bool
{
    $sql = "DELETE FROM enderecos WHERE id = :id AND cliente_id = :cliente_id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
    $stmt->bindValue(':cliente_id', $clienteId, \PDO::PARAM_INT);

    return $stmt->execute();
}


    /**
     * Define um endereço como principal.
     *
     * Primeiro remove o principal atual
     * e depois define o endereço informado.
     */
    public function definirPrincipal(
        int $id,
        int $clienteId
    ): bool {

        $this->pdo->beginTransaction();


        try {

            /*
             * Confirma que o endereço pertence
             * ao cliente.
             */
            $endereco =
                $this->buscarPorId(
                    $id,
                    $clienteId
                );


            if ($endereco === null) {

                $this->pdo->rollBack();

                return false;
            }


            /*
             * Remove o principal atual.
             */
            $this->removerPrincipal(
                $clienteId
            );


            /*
             * Define o endereço escolhido
             * como principal.
             */
            $sql = '
                UPDATE enderecos

                SET principal = 1

                WHERE id = :id

                  AND cliente_id = :cliente_id
            ';


            $consulta =
                $this->pdo
                ->prepare($sql);


            $consulta->execute([

                'id' =>
                $id,

                'cliente_id' =>
                $clienteId,
            ]);


            $alterado =
                $consulta->rowCount() > 0;


            $this->pdo->commit();


            return $alterado;
        } catch (\Throwable $e) {

            if (
                $this->pdo
                ->inTransaction()
            ) {
                $this->pdo->rollBack();
            }


            throw $e;
        }
    }


    /**
     * Remove o endereço principal atual do cliente.
     */
    private function removerPrincipal(
        int $clienteId
    ): void {

        $sql = '
            UPDATE enderecos

            SET principal = 0

            WHERE cliente_id = :cliente_id

              AND principal = 1
        ';


        $consulta =
            $this->pdo
            ->prepare($sql);


        $consulta->execute([

            'cliente_id' =>
            $clienteId,
        ]);
    }


    /**
     * Conta a quantidade de endereços
     * cadastrados para o cliente.
     */
    public function contarPorCliente(
        int $clienteId
    ): int {

        $sql = '
            SELECT COUNT(*)

            FROM enderecos

            WHERE cliente_id = :cliente_id
        ';


        $consulta =
            $this->pdo
            ->prepare($sql);


        $consulta->bindValue(
            ':cliente_id',
            $clienteId,
            PDO::PARAM_INT
        );


        $consulta->execute();


        return (int)
        $consulta
            ->fetchColumn();
    }


    /**
     * Busca o endereço principal do cliente.
     */
    public function buscarPrincipalPorCliente(
        int $clienteId
    ): ?array {

        $sql = '
            SELECT
                id,
                cliente_id,
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

              AND principal = 1

            ORDER BY id DESC

            LIMIT 1
        ';


        $consulta =
            $this->pdo
            ->prepare($sql);


        $consulta->bindValue(
            ':cliente_id',
            $clienteId,
            PDO::PARAM_INT
        );


        $consulta->execute();


        $endereco =
            $consulta->fetch();


        return is_array(
            $endereco
        )
            ? $endereco
            : null;
    }
}
