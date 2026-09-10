<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\CarrinhoRepository;
use App\Repositories\CheckoutRepository;
use App\Repositories\ClienteRepository;
use App\Repositories\EnderecoRepository;
use App\Repositories\PagamentoRepository;
use InvalidArgumentException;
use PDO;
use RuntimeException;
use Throwable;

final class CheckoutService
{
    private PDO $pdo;

    private CarrinhoRepository
        $carrinhoRepository;

    private EnderecoRepository
        $enderecoRepository;

    private ClienteRepository
        $clienteRepository;

    private CheckoutRepository
        $checkoutRepository;

    private PagamentoRepository
        $pagamentoRepository;

    private MercadoPagoService
        $mercadoPagoService;

    /*
    |--------------------------------------------------------------------------
    | Construtor
    |--------------------------------------------------------------------------
    */
    public function __construct(
        PDO $pdo
    ) {
        $this->pdo =
            $pdo;

        $this->carrinhoRepository =
            new CarrinhoRepository(
                $pdo
            );

        $this->enderecoRepository =
            new EnderecoRepository(
                $pdo
            );

        $this->clienteRepository =
            new ClienteRepository(
                $pdo
            );

        $this->checkoutRepository =
            new CheckoutRepository(
                $pdo
            );

        $this->pagamentoRepository =
            new PagamentoRepository(
                $pdo
            );

        $this->mercadoPagoService =
            new MercadoPagoService();
    }

    /*
    |--------------------------------------------------------------------------
    | Finalizar a compra
    |--------------------------------------------------------------------------
    */
    public function finalizar(
        int $clienteId,
        int $enderecoId,
        string $tokenCarrinho
    ): array {
        /*
        |--------------------------------------------------------------------------
        | 1. Valida os dados principais
        |--------------------------------------------------------------------------
        */
        if ($clienteId < 1) {
            throw new InvalidArgumentException(
                'Cliente inválido.'
            );
        }

        if ($enderecoId < 1) {
            throw new InvalidArgumentException(
                'Endereço inválido.'
            );
        }

        if (trim($tokenCarrinho) === '') {
            throw new InvalidArgumentException(
                'Carrinho inválido.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 2. Consulta o cliente
        |--------------------------------------------------------------------------
        */
        $cliente =
            $this->clienteRepository
            ->buscarPorId(
                $clienteId
            );

        if ($cliente === null) {
            throw new RuntimeException(
                'Cliente não encontrado '
                . 'ou inativo.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 3. Confirma que o endereço pertence ao cliente
        |--------------------------------------------------------------------------
        */
        $endereco =
            $this->enderecoRepository
            ->buscarPorId(
                $enderecoId,
                $clienteId
            );

        if ($endereco === null) {
            throw new RuntimeException(
                'O endereço selecionado '
                . 'não pertence ao cliente.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 4. Obtém ou vincula o carrinho ao cliente
        |--------------------------------------------------------------------------
        */
        $carrinhoId =
            $this->carrinhoRepository
            ->obterOuCriar(
                $clienteId,
                $tokenCarrinho
            );

        /*
        |--------------------------------------------------------------------------
        | 5. Consulta o carrinho
        |--------------------------------------------------------------------------
        */
        $carrinho =
            $this->carrinhoRepository
            ->buscarResumo(
                $carrinhoId
            );

        if ($carrinho === null) {
            throw new RuntimeException(
                'Carrinho aberto '
                . 'não encontrado.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 6. Verifica o proprietário do carrinho
        |--------------------------------------------------------------------------
        */
        $carrinhoClienteId =
            isset($carrinho['cliente_id'])
                ? (int)
                    $carrinho['cliente_id']
                : 0;

        if (
            $carrinhoClienteId > 0
            &&
            $carrinhoClienteId !== $clienteId
        ) {
            throw new RuntimeException(
                'O carrinho não pertence '
                . 'ao cliente autenticado.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 7. Lista os itens
        |--------------------------------------------------------------------------
        */
        $itens =
            $this->carrinhoRepository
            ->listarItens(
                $carrinhoId
            );

        if ($itens === []) {
            throw new RuntimeException(
                'O carrinho está vazio.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 8. Verifica o frete
        |--------------------------------------------------------------------------
        */
        $cepFrete =
            preg_replace(
                '/\D/',
                '',
                (string) (
                    $carrinho['cep_frete']
                    ?? ''
                )
            );

        $cepEndereco =
            preg_replace(
                '/\D/',
                '',
                (string) $endereco['cep']
            );

        if (
            !is_string($cepFrete)
            ||
            strlen($cepFrete) !== 8
        ) {
            throw new RuntimeException(
                'Calcule o frete antes '
                . 'de finalizar a compra.'
            );
        }

        if (
            !is_string($cepEndereco)
            ||
            strlen($cepEndereco) !== 8
        ) {
            throw new RuntimeException(
                'O CEP do endereço '
                . 'é inválido.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 9. Compara o CEP do endereço com o CEP calculado
        |--------------------------------------------------------------------------
        */
        if ($cepFrete !== $cepEndereco) {
            throw new RuntimeException(
                'O CEP do endereço selecionado '
                . 'é diferente do CEP usado '
                . 'no cálculo do frete. '
                . 'Volte ao carrinho e recalcule.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 10. Recupera o valor do frete
        |--------------------------------------------------------------------------
        */
        $frete =
            (float) (
                $carrinho['frete']
                ?? 0
            );

        if ($frete < 0) {
            throw new RuntimeException(
                'O valor do frete é inválido.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 11. Recalcula e valida os itens
        |--------------------------------------------------------------------------
        */
        $subtotal = 0.0;

        $itensPedido = [];

        foreach ($itens as $item) {
            $produtoId =
                (int) (
                    $item['produto_id']
                    ?? 0
                );

            $quantidade =
                (int) (
                    $item['quantidade']
                    ?? 0
                );

            $estoque =
                (int) (
                    $item['estoque']
                    ?? 0
                );

            $status =
                (string) (
                    $item['status']
                    ?? ''
                );

            $precoUnitario =
                (float) (
                    $item['preco_unitario']
                    ?? 0
                );

            if (
                $produtoId < 1
                ||
                $quantidade < 1
                ||
                $precoUnitario <= 0
            ) {
                throw new RuntimeException(
                    'O carrinho possui '
                    . 'um item inválido.'
                );
            }

            if ($status !== 'ativo') {
                throw new RuntimeException(
                    'O produto '
                    . $item['nome']
                    . ' não está mais disponível.'
                );
            }

            if ($quantidade > $estoque) {
                throw new RuntimeException(
                    'Estoque insuficiente para '
                    . $item['nome']
                    . '.'
                );
            }

            $subtotalItem =
                round(
                    $precoUnitario
                    * $quantidade,
                    2
                );

            $subtotal +=
                $subtotalItem;

            /*
            |--------------------------------------------------------------------------
            | Prepara a cópia dos itens para o pedido
            |--------------------------------------------------------------------------
            */
            $itensPedido[] = [
                'produto_id' =>
                    $produtoId,

                'nome' =>
                    (string) $item['nome'],

                'nome_produto' =>
                    (string) $item['nome'],

                'quantidade' =>
                    $quantidade,

                'preco_unitario' =>
                    $precoUnitario,

                'subtotal' =>
                    $subtotalItem,
            ];
        }

        $subtotal =
            round(
                $subtotal,
                2
            );

        $desconto = 0.0;

        $total =
            round(
                $subtotal
                + $frete
                - $desconto,
                2
            );

        if ($total <= 0) {
            throw new RuntimeException(
                'O valor total do pedido '
                . 'é inválido.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 12. Inicia a transação
        |--------------------------------------------------------------------------
        */
        $this->pdo
            ->beginTransaction();

        try {
            /*
            |--------------------------------------------------------------------------
            | 13. Cria o pedido
            |--------------------------------------------------------------------------
            */
            $pedido =
                $this->checkoutRepository
                ->criarPedido(
                    $carrinhoId,
                    $clienteId,
                    $enderecoId,
                    $subtotal,
                    $frete,
                    $desconto,
                    $total
                );

            $pedidoId =
                (int) $pedido['id'];

            /*
            |--------------------------------------------------------------------------
            | 14. Copia os itens
            |--------------------------------------------------------------------------
            */
            $this->checkoutRepository
                ->copiarItens(
                    $pedidoId,
                    $itensPedido
                );

            /*
            |--------------------------------------------------------------------------
            | 15. Copia o endereço
            |--------------------------------------------------------------------------
            */
            $this->checkoutRepository
                ->copiarEndereco(
                    $pedidoId,
                    $endereco
                );

            /*
            |--------------------------------------------------------------------------
            | 16. Cria o registro inicial do pagamento
            |--------------------------------------------------------------------------
            */
            $pagamentoId =
                $this->pagamentoRepository
                ->criarPendente(
                    $pedidoId,
                    $total
                );

            /*
            |--------------------------------------------------------------------------
            | 17. Cria a preferência no Mercado Pago
            |--------------------------------------------------------------------------
            */
            $preferencia =
                $this->mercadoPagoService
                ->criarPreferencia(
                    $pedido,
                    $itensPedido,
                    $cliente,
                    $endereco
                );

            $preferenciaId =
                trim(
                    (string) (
                        $preferencia['id']
                        ?? ''
                    )
                );

            /*
            |--------------------------------------------------------------------------
            | Ambiente de produção
            |--------------------------------------------------------------------------
            */
            $urlPagamento =
                trim(
                    (string) (
                        $preferencia['init_point']
                        ?? ''
                    )
                );

            /*
            |--------------------------------------------------------------------------
            | Ambiente de testes
            |--------------------------------------------------------------------------
            */
            $usarSandbox =
                filter_var(
                    $_ENV[
                        'MERCADO_PAGO_USE_SANDBOX'
                    ]
                    ?? true,
                    FILTER_VALIDATE_BOOLEAN
                );

            if (
                $usarSandbox
                &&
                !empty(
                    $preferencia[
                        'sandbox_init_point'
                    ]
                )
            ) {
                $urlPagamento =
                    trim(
                        (string)
                        $preferencia[
                            'sandbox_init_point'
                        ]
                    );
            }

            if (
                $preferenciaId === ''
                ||
                $urlPagamento === ''
            ) {
                throw new RuntimeException(
                    'O Mercado Pago não retornou '
                    . 'os dados da preferência.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | 18. Salva os dados da preferência
            |--------------------------------------------------------------------------
            */
            $this->pagamentoRepository
                ->salvarPreferencia(
                    $pagamentoId,
                    $preferenciaId,
                    $urlPagamento
                );

            /*
            |--------------------------------------------------------------------------
            | 19. Converte o carrinho
            |--------------------------------------------------------------------------
            */
            $this->checkoutRepository
                ->marcarCarrinhoConvertido(
                    $carrinhoId
                );

            /*
            |--------------------------------------------------------------------------
            | 20. Confirma a transação
            |--------------------------------------------------------------------------
            */
            $this->pdo
                ->commit();

            return [
                'pedido_id' =>
                    $pedidoId,

                'pedido_codigo' =>
                    (string) $pedido['codigo'],

                'pagamento_id' =>
                    $pagamentoId,

                'preferencia_id' =>
                    $preferenciaId,

                'url_pagamento' =>
                    $urlPagamento,
            ];
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

    /*
    |--------------------------------------------------------------------------
    | Consultar pagamento no retorno
    |--------------------------------------------------------------------------
    */
    public function consultarRetorno(
        int $clienteId,
        string $pagamentoId,
        string $referenciaExterna
    ): array {
        if ($clienteId < 1) {
            throw new InvalidArgumentException(
                'Cliente inválido.'
            );
        }

        $pagamentoId =
            trim(
                $pagamentoId
            );

        if ($pagamentoId === '') {
            throw new InvalidArgumentException(
                'Pagamento não informado.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Consulta diretamente a API
        |--------------------------------------------------------------------------
        */
        $pagamento =
            $this->mercadoPagoService
            ->consultarPagamento(
                $pagamentoId
            );

        /*
        |--------------------------------------------------------------------------
        | Confere a referência externa
        |--------------------------------------------------------------------------
        */
        $referenciaRecebida =
            trim(
                (string) (
                    $pagamento[
                        'external_reference'
                    ]
                    ?? ''
                )
            );

        if (
            $referenciaExterna !== ''
            &&
            $referenciaRecebida !== ''
            &&
            !hash_equals(
                $referenciaRecebida,
                $referenciaExterna
            )
        ) {
            throw new RuntimeException(
                'A referência do pagamento '
                . 'não corresponde ao pedido.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | A vinculação definitiva ao cliente deverá ser confirmada
        | pelo PedidoRepository na etapa do webhook.
        |--------------------------------------------------------------------------
        */
        return $pagamento;
    }
}