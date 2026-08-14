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
                        ? $dados[
                            'complemento'
                        ]
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
}
