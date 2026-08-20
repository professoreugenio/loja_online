<?php

declare(strict_types=1);

namespace App\Repositories;

use PDO;

final class EnderecoRepository
{
    private PDO $pdo;


    public function __construct(
        PDO $pdo
    ) {
        $this->pdo = $pdo;
    }


    public function cadastrarPrincipal(
        int $clienteId,
        array $dados
    ): int {

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
                1
            )
        ';


        $consulta =
            $this->pdo
            ->prepare($sql);


        $consulta->execute([
            'cliente_id' =>
            $clienteId,

            'identificacao' =>
            'Endereço principal',

            'destinatario' =>
            $dados['nome'],

            'cep' =>
            $dados['cep'],

            'logradouro' =>
            $dados['logradouro'],

            'numero' =>
            $dados['numero'],

            'complemento' =>
            $dados['complemento']
                !== ''
                ? $dados['complemento']
                : null,

            'bairro' =>
            $dados['bairro'],

            'cidade' =>
            $dados['cidade'],

            'estado' =>
            $dados['estado'],
        ]);


        return (int)
        $this->pdo
            ->lastInsertId();
    }

    public function contarPorCliente(
        int $clienteId
    ): int {

        $sql = '
        SELECT COUNT(*)

        FROM enderecos

        WHERE cliente_id =
            :cliente_id
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

    public function buscarPrincipalPorCliente(
        int $clienteId
    ): ?array {

        $sql = '
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
            principal

        FROM enderecos

        WHERE cliente_id =
            :cliente_id

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
