<?php

declare(strict_types=1);

namespace App\Services;

use RuntimeException;

final class MercadoPagoService
{
    private string $accessToken;

    public function __construct()
    {
        $token =
            trim(
                (string) (
                    $_ENV[
                        'MERCADO_PAGO_ACCESS_TOKEN'
                    ]
                    ?? ''
                )
            );

        if ($token === '') {
            throw new RuntimeException(
                'MERCADO_PAGO_ACCESS_TOKEN não configurado.'
            );
        }

        $this->accessToken = $token;
    }

    public function criarPreferencia(
        array $pedido,
        array $itens,
        array $cliente,
        array $endereco
    ): array {
        $appUrl =
            rtrim(
                (string) (
                    $_ENV['APP_URL']
                    ?? ''
                ),
                '/'
            );

        if ($appUrl === '') {
            throw new RuntimeException(
                'APP_URL não configurada.'
            );
        }

        $itensMercadoPago = [];

        foreach ($itens as $item) {
            $itensMercadoPago[] = [
                'id' =>
                    (string) $item['produto_id'],
                'title' =>
                    (string) $item['nome_produto'],
                'quantity' =>
                    (int) $item['quantidade'],
                'currency_id' =>
                    'BRL',
                'unit_price' =>
                    (float) $item['preco_unitario'],
            ];
        }

        $dados = [
            'items' =>
                $itensMercadoPago,

            'payer' => [
                'name' =>
                    (string) $cliente['nome'],
                'email' =>
                    (string) $cliente['email'],
            ],

            'shipments' => [
                'cost' =>
                    (float) $pedido['frete'],
                'mode' =>
                    'not_specified',
            ],

            'external_reference' =>
                (string) $pedido['codigo'],

            'back_urls' => [
                'success' =>
                    $appUrl
                    . '/checkout/retorno'
                    . '?resultado=sucesso',

                'pending' =>
                    $appUrl
                    . '/checkout/retorno'
                    . '?resultado=pendente',

                'failure' =>
                    $appUrl
                    . '/checkout/retorno'
                    . '?resultado=falha',
            ],

            'auto_return' =>
                'approved',

            'notification_url' =>
                $appUrl
                . '/mercadopago/webhook',

            'metadata' => [
                'pedido_id' =>
                    (int) $pedido['id'],
                'pedido_codigo' =>
                    (string) $pedido['codigo'],
            ],
        ];

        return $this->requisitar(
            'POST',
            '/checkout/preferences',
            $dados,
            bin2hex(random_bytes(16))
        );
    }

    public function consultarPagamento(
        string $pagamentoId
    ): array {
        return $this->requisitar(
            'GET',
            '/v1/payments/'
                . rawurlencode($pagamentoId)
        );
    }

    private function requisitar(
        string $metodo,
        string $caminho,
        ?array $dados = null,
        ?string $idempotencia = null
    ): array {
        $curl =
            curl_init(
                'https://api.mercadopago.com'
                . $caminho
            );

        if ($curl === false) {
            throw new RuntimeException(
                'Não foi possível iniciar o cURL.'
            );
        }

        $cabecalhos = [
            'Authorization: Bearer '
                . $this->accessToken,
            'Content-Type: application/json',
            'Accept: application/json',
        ];

        if ($idempotencia !== null) {
            $cabecalhos[] =
                'X-Idempotency-Key: '
                . $idempotencia;
        }

        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $metodo,
            CURLOPT_HTTPHEADER => $cabecalhos,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 30,
        ]);

        if ($dados !== null) {
            $json =
                json_encode(
                    $dados,
                    JSON_UNESCAPED_UNICODE
                    | JSON_UNESCAPED_SLASHES
                    | JSON_THROW_ON_ERROR
                );

            curl_setopt(
                $curl,
                CURLOPT_POSTFIELDS,
                $json
            );
        }

        $resposta =
            curl_exec($curl);

        $erroCurl =
            curl_error($curl);

        $statusHttp =
            (int) curl_getinfo(
                $curl,
                CURLINFO_HTTP_CODE
            );

        curl_close($curl);

        if ($resposta === false) {
            throw new RuntimeException(
                'Falha de comunicação: '
                . $erroCurl
            );
        }

        $resultado =
            json_decode(
                $resposta,
                true
            );

        if (
            $statusHttp < 200
            || $statusHttp >= 300
            || !is_array($resultado)
        ) {
            throw new RuntimeException(
                'O Mercado Pago não aceitou a solicitação.'
            );
        }

        return $resultado;
    }
}
