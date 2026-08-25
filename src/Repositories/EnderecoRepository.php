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
    public function cadastrar(
        int $clienteId,
        array $dados
    ): int {

        $principal =
            !empty($dados['principal']);


        $this->pdo->beginTransaction();


        try {

            if ($principal) {

                $this->removerPrincipal(
                    $clienteId
                );
            }


            $sql = '
                INSERT INTO enderecos (
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
                    principal
                ) VALUES (
                    :cliente_id,
                    :identificacao,
                    :destinatario,
                    :cep,
                    :logradouro,
                    :numero,
                    :complemento,
                    :bairro,
                    :cidade,
                    :estado,
                    :principal
                )
            ';


            $consulta =
                $this->pdo
                ->prepare($sql);


            $consulta->execute([

                'cliente_id' =>
                    $clienteId,

                'identificacao' =>
                    $dados['identificacao']
                    ?? 'Endereço',

                'destinatario' =>
                    $dados['destinatario'],

                'cep' =>
                    $dados['cep'],

                'logradouro' =>
                    $dados['logradouro'],

                'numero' =>
                    $dados['numero'],

                'complemento' =>
                    !empty($dados['complemento'])
                    ? $dados['complemento']
                    : null,

                'bairro' =>
                    $dados['bairro'],

                'cidade' =>
                    $dados['cidade'],

                'estado' =>
                    $dados['estado'],

                'principal' =>
                    $principal ? 1 : 0,
            ]);


            $id =
                (int)
                $this->pdo
                    ->lastInsertId();


            $this->pdo->commit();


            return $id;

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
    public function atualizar(
        int $id,
        int $clienteId,
        array $dados
    ): bool {

        $principal =
            !empty($dados['principal']);


        $this->pdo->beginTransaction();


        try {

            /*
             * Confirma que o endereço pertence
             * ao cliente autenticado.
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
             * Se o endereço será principal,
             * retiramos o principal anterior.
             */
            if ($principal) {

                $this->removerPrincipal(
                    $clienteId
                );
            }


            /*
             * Se o endereço atualmente principal
             * está sendo alterado para não principal,
             * verificamos se ele é o único.
             *
             * Nesse caso podemos manter o registro
             * como não principal.
             */
            $sql = '
                UPDATE enderecos

                SET
                    identificacao = :identificacao,
                    destinatario = :destinatario,
                    cep = :cep,
                    logradouro = :logradouro,
                    numero = :numero,
                    complemento = :complemento,
                    bairro = :bairro,
                    cidade = :cidade,
                    estado = :estado,
                    principal = :principal

                WHERE id = :id

                  AND cliente_id = :cliente_id
            ';


            $consulta =
                $this->pdo
                ->prepare($sql);


            $consulta->execute([

                'identificacao' =>
                    $dados['identificacao']
                    ?? 'Endereço',

                'destinatario' =>
                    $dados['destinatario'],

                'cep' =>
                    $dados['cep'],

                'logradouro' =>
                    $dados['logradouro'],

                'numero' =>
                    $dados['numero'],

                'complemento' =>
                    !empty($dados['complemento'])
                    ? $dados['complemento']
                    : null,

                'bairro' =>
                    $dados['bairro'],

                'cidade' =>
                    $dados['cidade'],

                'estado' =>
                    $dados['estado'],

                'principal' =>
                    $principal ? 1 : 0,

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
     * Exclui um endereço pertencente ao cliente.
     */
    public function excluir(
        int $id,
        int $clienteId
    ): bool {

        /*
         * Primeiro verifica se o endereço existe
         * e pertence ao cliente.
         */
        $endereco =
            $this->buscarPorId(
                $id,
                $clienteId
            );


        if ($endereco === null) {

            return false;
        }


        /*
         * Não permite excluir o endereço principal
         * diretamente.
         *
         * Isso evita que o cliente fique sem endereço
         * principal quando houver outros endereços.
         */
        if (
            (int) $endereco['principal'] === 1
        ) {

            throw new RuntimeException(
                'Não é possível excluir o endereço principal. Defina outro endereço como principal antes de excluí-lo.'
            );
        }


        $sql = '
            DELETE FROM enderecos

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


        return $consulta->rowCount() > 0;
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