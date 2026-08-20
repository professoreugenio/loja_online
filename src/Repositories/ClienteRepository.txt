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


    /*
    |--------------------------------------------------------------------------
    | Verifica se o e-mail já está cadastrado
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | Verifica se o CPF já está cadastrado
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | Cadastra o cliente
    |--------------------------------------------------------------------------
    */

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
            $dados['data_nascimento'],

            'telefone' =>
            $dados['telefone'],

            'email' =>
            strtolower(
                trim(
                    $dados['email']
                )
            ),

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


    /*
    |--------------------------------------------------------------------------
    | Busca cliente ativo pelo e-mail
    |--------------------------------------------------------------------------
    |
    | Utilizado durante o login.
    |
    */

    public function buscarAtivoPorEmail(
        string $email
    ): ?array {

        $sql = '
            SELECT
                id,
                nome,
                email,
                senha_hash,
                foto_url,
                email_verificado,
                status,
                ultimo_acesso

            FROM clientes

            WHERE email = :email
              AND status = :status

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

            'status' =>
            'ativo',
        ]);


        $cliente =
            $consulta->fetch();


        return is_array($cliente)
            ? $cliente
            : null;
    }


    /*
    |--------------------------------------------------------------------------
    | Busca cliente pelo ID
    |--------------------------------------------------------------------------
    */

    public function buscarPorId(
        int $clienteId
    ): ?array {

        $sql = '
            SELECT
                id,
                nome,
                cpf,
                data_nascimento,
                telefone,
                email,
                foto_url,
                email_verificado,
                status,
                newsletter,
                ultimo_acesso,
                criado_em,
                atualizado_em

            FROM clientes

            WHERE id = :id
              AND status = :status

            LIMIT 1
        ';


        $consulta =
            $this->pdo
            ->prepare($sql);


        $consulta->execute([
            'id' =>
            $clienteId,

            'status' =>
            'ativo',
        ]);


        $cliente =
            $consulta->fetch();


        return is_array($cliente)
            ? $cliente
            : null;
    }


    /*
    |--------------------------------------------------------------------------
    | Registra o último acesso do cliente
    |--------------------------------------------------------------------------
    */

    public function registrarUltimoAcesso(
        int $clienteId
    ): void {

        $sql = '
            UPDATE clientes

            SET ultimo_acesso = NOW()

            WHERE id = :id
        ';


        $consulta =
            $this->pdo
            ->prepare($sql);


        $consulta->execute([
            'id' =>
            $clienteId,
        ]);
    }

    public function emailExisteParaOutroCliente(
    string $email,
    int $clienteId
): bool {

    $sql = '
        SELECT id

        FROM clientes

        WHERE email = :email
          AND id <> :id

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

        'id' =>
            $clienteId,
    ]);


    return
        $consulta->fetch()
        !== false;
}


public function cpfExisteParaOutroCliente(
    string $cpf,
    int $clienteId
): bool {

    $sql = '
        SELECT id

        FROM clientes

        WHERE cpf = :cpf
          AND id <> :id

        LIMIT 1
    ';


    $consulta =
        $this->pdo
            ->prepare($sql);


    $consulta->execute([

        'cpf' =>
            $cpf,

        'id' =>
            $clienteId,
    ]);


    return
        $consulta->fetch()
        !== false;
}

public function atualizarPerfil(
    int $clienteId,
    array $dados
): void {

    $sql = '
        UPDATE clientes

        SET
            nome = :nome,
            cpf = :cpf,
            data_nascimento = :data_nascimento,
            telefone = :telefone,
            email = :email,
            atualizado_em = NOW()

        WHERE id = :id
          AND status = :status
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
            strtolower(
                trim(
                    $dados['email']
                )
            ),

        'id' =>
            $clienteId,

        'status' =>
            'ativo',
    ]);
}
}
