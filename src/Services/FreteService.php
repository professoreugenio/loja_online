<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\FreteRepository;
use InvalidArgumentException;
use RuntimeException;

final class FreteService
{
    private FreteRepository $repository;

    public function __construct(
        FreteRepository $repository
    ) {
        $this->repository =
            $repository;
    }

    public function calcular(
        string $cepInformado
    ): array {
        $cep =
            preg_replace(
                '/\D/',
                '',
                $cepInformado
            );

        if (
            !is_string($cep)
            ||
            !preg_match(
                '/^\d{8}$/',
                $cep
            )
        ) {
            throw new InvalidArgumentException(
                'Informe um CEP válido com 8 números.'
            );
        }

        $regra =
            $this->repository
            ->buscarPorCep(
                (int) $cep
            );

        if ($regra === null) {
            throw new RuntimeException(
                'Ainda não realizamos entregas para esse CEP.'
            );
        }

        return [
            'faixa_id' =>
                (int) $regra['id'],

            'nome' =>
                (string) $regra['nome'],

            'cep' =>
                $cep,

            'valor' =>
                (float) $regra['valor'],

            'prazo_dias' =>
                (int) $regra['prazo_dias'],
        ];
    }
}
