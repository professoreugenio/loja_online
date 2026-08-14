<?php

declare(strict_types=1);

namespace App\Repositories;

use PDO;

final class ClienteRepository
{
    private PDO $pdo;


    public function __construct(
        PDO $pdo
    ) {
        $this->pdo = $pdo;
    }


    public function emailExiste(
        string $email
    ): bool {

        $sql = '
            SELECT id
            FROM clientes
            WHERE email = :email
            LIMIT 1
        ';


        $consulta =
            $this->pdo
                ->prepare($sql);


        $consulta->execute([
            'email' =>
                strtolower(
                    trim($email)
                ),
        ]);


        return
            $consulta->fetch()
            !== false;
    }


    public function cpfExiste(
        string $cpf
    ): bool {

        $sql = '
            SELECT id
            FROM clientes
            WHERE cpf = :cpf
            LIMIT 1
        ';


        $consulta =
            $this->pdo
                ->prepare($sql);


        $consulta->execute([
            'cpf' => $cpf,
        ]);


        return
            $consulta->fetch()
            !== false;
    }


    public function cadastrar(
        array $dados
    ): int {

        $sql = '
            INSERT INTO clientes (
                google_sub,
                nome,
                cpf,
                data_nascimento,
                telefone,
                email,
                senha_hash,
                foto_url,
                email_verificado,
                status,
                newsletter,
                aceitou_termos_em
            ) VALUES (
                NULL,
                :nome,
                :cpf,
                :data_nascimento,
                :telefone,
                :email,
                :senha_hash,
                NULL,
                0,
                :status,
                :newsletter,
                NOW()
            )
        ';


        $consulta =
            $this->pdo
                ->prepare($sql);


        $consulta->execute([
            'nome' =>
                $dados['nome'],

            'cpf' =>
                $dados['cpf'],

            'data_nascimento' =>
                $dados[
                    'data_nascimento'
                ],

            'telefone' =>
                $dados['telefone'],

            'email' =>
                $dados['email'],

            'senha_hash' =>
                $dados['senha_hash'],

            'status' =>
                'ativo',

            'newsletter' =>
                $dados['newsletter'],
        ]);


        return (int)
            $this->pdo
                ->lastInsertId();
    }
}
