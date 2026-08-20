<?php

declare(strict_types=1);

namespace App\Services;

use App\Helpers\CarrinhoSessao;
use App\Helpers\ClienteAuth;
use App\Repositories\CarrinhoRepository;
use PDO;

final class CarrinhoService
{
    private CarrinhoRepository $repository;

    public function __construct(PDO $pdo)
    {
        $this->repository =
            new CarrinhoRepository($pdo);
    }

    public function quantidade(): int
    {
        $tokenSessao =
            CarrinhoSessao::token();

        $clienteId = null;

        if (ClienteAuth::logado()) {
            $clienteId =
                (int) ClienteAuth::id();
        }

        $carrinhoId =
            $this->repository
            ->obterOuCriar(
                $clienteId,
                $tokenSessao
            );

        return $this->repository
            ->totalUnidades(
                $carrinhoId
            );
    }
}
