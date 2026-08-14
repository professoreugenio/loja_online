<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\ClienteRepository;
use App\Repositories\EnderecoRepository;
use PDO;
use RuntimeException;
use Throwable;

final class ClienteCadastroService
{
    private PDO $pdo;

    private ClienteRepository
        $clienteRepository;

    private EnderecoRepository
        $enderecoRepository;


    public function __construct(
        PDO $pdo,
        ClienteRepository
            $clienteRepository,
        EnderecoRepository
            $enderecoRepository
    ) {
        $this->pdo =
            $pdo;

        $this->clienteRepository =
            $clienteRepository;

        $this->enderecoRepository =
            $enderecoRepository;
    }


    public function cadastrar(
        array $dados
    ): int {

        if (
            $this->clienteRepository
                ->emailExiste(
                    $dados['email']
                )
        ) {
            throw new RuntimeException(
                'Este e-mail já está cadastrado.'
            );
        }


        if (
            $this->clienteRepository
                ->cpfExiste(
                    $dados['cpf']
                )
        ) {
            throw new RuntimeException(
                'Este CPF já está cadastrado.'
            );
        }


        $senhaHash =
            password_hash(
                $dados['senha'],
                PASSWORD_DEFAULT
            );


        $dadosCliente = $dados;

        $dadosCliente['senha_hash'] =
            $senhaHash;


        $this->pdo
            ->beginTransaction();


        try {

            $clienteId =
                $this->clienteRepository
                    ->cadastrar(
                        $dadosCliente
                    );


            $this->enderecoRepository
                ->cadastrarPrincipal(
                    $clienteId,
                    $dados
                );


            $this->pdo
                ->commit();


            return $clienteId;

        } catch (Throwable $erro) {

            if (
                $this->pdo
                    ->inTransaction()
            ) {
                $this->pdo
                    ->rollBack();
            }


            throw $erro;
        }
    }
}
