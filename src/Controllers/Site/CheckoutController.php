<?php

declare(strict_types=1);

namespace App\Controllers\Site;

use App\Helpers\CarrinhoSessao;
use App\Helpers\ClienteAuth;
use App\Helpers\CsrfCarrinho;
use App\Helpers\IdSeguro;
use App\Repositories\CarrinhoRepository;
use App\Repositories\CategoriaRepository;
use App\Repositories\ClienteRepository;
use App\Repositories\EnderecoRepository;
use App\Services\CheckoutService;
use InvalidArgumentException;
use PDO;
use RuntimeException;
use Throwable;

final class CheckoutController
{
    private PDO $pdo;

    private CarrinhoRepository
        $carrinhoRepository;

    private EnderecoRepository
        $enderecoRepository;

    private ClienteRepository
        $clienteRepository;

    private CategoriaRepository
        $categoriaRepository;

    private CheckoutService
        $checkoutService;

    /*
    |--------------------------------------------------------------------------
    | Construtor
    |--------------------------------------------------------------------------
    */
    public function __construct()
    {
        require_once APP_ROOT
            . '/database/conexao.php';

        $this->pdo =
            \Config::connect();

        $this->carrinhoRepository =
            new CarrinhoRepository(
                $this->pdo
            );

        $this->enderecoRepository =
            new EnderecoRepository(
                $this->pdo
            );

        $this->clienteRepository =
            new ClienteRepository(
                $this->pdo
            );

        $this->categoriaRepository =
            new CategoriaRepository(
                $this->pdo
            );

        /*
        |--------------------------------------------------------------------------
        | O CheckoutService receberá a conexão PDO
        |--------------------------------------------------------------------------
        */
        $this->checkoutService =
            new CheckoutService(
                $this->pdo
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Exibir checkout
    |--------------------------------------------------------------------------
    */
    public function index(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Exige autenticação
        |--------------------------------------------------------------------------
        */
        ClienteAuth::exigirLogin();

        $clienteId =
            (int) ClienteAuth::id();

        /*
        |--------------------------------------------------------------------------
        | 2. Localiza o carrinho aberto
        |--------------------------------------------------------------------------
        */
        $tokenSessao =
            CarrinhoSessao::token();

        $carrinho =
            $this->carrinhoRepository
            ->buscarAbertoPorToken(
                $tokenSessao
            );

        if ($carrinho === null) {
            $this->voltarCarrinhoComErro(
                'Nenhum carrinho aberto foi encontrado.'
            );
        }

        $carrinhoId =
            (int) $carrinho['id'];

        /*
        |--------------------------------------------------------------------------
        | 3. Lista os itens
        |--------------------------------------------------------------------------
        */
        $itens =
            $this->carrinhoRepository
            ->listarItens(
                $carrinhoId
            );

        if ($itens === []) {
            $this->voltarCarrinhoComErro(
                'O carrinho está vazio.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 4. Recupera o frete
        |--------------------------------------------------------------------------
        */
        $resumoCarrinho =
            $this->carrinhoRepository
            ->buscarResumo(
                $carrinhoId
            );

        if ($resumoCarrinho === null) {
            $this->voltarCarrinhoComErro(
                'Não foi possível consultar o carrinho.'
            );
        }

        $cepFrete =
            trim(
                (string) (
                    $resumoCarrinho['cep_frete']
                    ?? ''
                )
            );

        $freteCalculado =
            $cepFrete !== ''
            &&
            $resumoCarrinho['frete_faixa_id']
                !== null;

        if (!$freteCalculado) {
            $this->voltarCarrinhoComErro(
                'Calcule o frete antes de finalizar a compra.'
            );
        }

        $frete =
            (float) (
                $resumoCarrinho['frete']
                ?? 0
            );

        $prazoEntrega =
            isset(
                $resumoCarrinho['prazo_entrega']
            )
                ? (int)
                    $resumoCarrinho[
                        'prazo_entrega'
                    ]
                : null;

        /*
        |--------------------------------------------------------------------------
        | 5. Calcula o subtotal no servidor
        |--------------------------------------------------------------------------
        */
        $subtotal = 0.0;

        foreach ($itens as $item) {
            $subtotal +=
                (float)
                $item['preco_unitario']
                *
                (int)
                $item['quantidade'];
        }

        $desconto = 0.0;

        $total =
            $subtotal
            + $frete
            - $desconto;

        /*
        |--------------------------------------------------------------------------
        | 6. Consulta o cliente
        |--------------------------------------------------------------------------
        */
        $cliente =
            $this->clienteRepository
            ->buscarPorId(
                $clienteId
            );

        if ($cliente === null) {
            ClienteAuth::sair();

            header(
                'Location: '
                . BASE_URL
                . '/cliente/login'
            );

            exit;
        }

        /*
        |--------------------------------------------------------------------------
        | 7. Lista os endereços do cliente
        |--------------------------------------------------------------------------
        */
        $enderecos =
            $this->enderecoRepository
            ->listarPorCliente(
                $clienteId
            );

        /*
        |--------------------------------------------------------------------------
        | 8. Gera IDs protegidos para os endereços
        |--------------------------------------------------------------------------
        */
        foreach ($enderecos as &$endereco) {
            $endereco['id_seguro'] =
                IdSeguro::criptografar(
                    (int) $endereco['id']
                );
        }

        unset($endereco);

        /*
        |--------------------------------------------------------------------------
        | 9. Dados do header
        |--------------------------------------------------------------------------
        */
        $quantidadeCarrinho =
            $this->carrinhoRepository
            ->totalUnidades(
                $carrinhoId
            );

        $categorias =
            $this->categoriaRepository
            ->listarAtivas();

        foreach ($categorias as &$categoria) {
            $categoria['id_seguro'] =
                IdSeguro::criptografar(
                    (int) $categoria['id']
                );
        }

        unset($categoria);

        /*
        |--------------------------------------------------------------------------
        | 10. Proteção CSRF
        |--------------------------------------------------------------------------
        */
        $csrfToken =
            CsrfCarrinho::gerar();

        /*
        |--------------------------------------------------------------------------
        | 11. Mensagens
        |--------------------------------------------------------------------------
        */
        $mensagemErro =
            $_SESSION['checkout_erro']
            ?? null;

        $mensagemSucesso =
            $_SESSION['checkout_sucesso']
            ?? null;

        unset(
            $_SESSION['checkout_erro'],
            $_SESSION['checkout_sucesso']
        );

        /*
        |--------------------------------------------------------------------------
        | 12. SEO
        |--------------------------------------------------------------------------
        */
        $tituloPagina =
            'Finalizar Compra';

        $descricaoPagina =
            'Confira o endereço, o frete '
            . 'e o total antes do pagamento.';

        /*
        |--------------------------------------------------------------------------
        | 13. Carrega a view
        |--------------------------------------------------------------------------
        */
        $arquivoView =
            APP_ROOT
            . '/views/site/checkout.php';

        if (!is_file($arquivoView)) {
            throw new RuntimeException(
                'A página de checkout '
                . 'não foi encontrada.'
            );
        }

        require $arquivoView;
    }

    /*
    |--------------------------------------------------------------------------
    | Criar pedido e iniciar pagamento
    |--------------------------------------------------------------------------
    */
    public function finalizar(): void
    {
        ClienteAuth::exigirLogin();

        /*
        |--------------------------------------------------------------------------
        | 1. Aceita somente POST
        |--------------------------------------------------------------------------
        */
        if (
            strtoupper(
                $_SERVER['REQUEST_METHOD']
                ?? 'GET'
            ) !== 'POST'
        ) {
            http_response_code(405);
            exit('Método não permitido.');
        }

        /*
        |--------------------------------------------------------------------------
        | 2. Valida CSRF
        |--------------------------------------------------------------------------
        */
        $csrfToken =
            isset($_POST['csrf_token'])
                ? (string)
                    $_POST['csrf_token']
                : null;

        if (
            !CsrfCarrinho::validar(
                $csrfToken
            )
        ) {
            http_response_code(403);
            exit('Solicitação inválida.');
        }

        /*
        |--------------------------------------------------------------------------
        | 3. Cliente autenticado
        |--------------------------------------------------------------------------
        */
        $clienteId =
            (int) ClienteAuth::id();

        /*
        |--------------------------------------------------------------------------
        | 4. Recebe o endereço criptografado
        |--------------------------------------------------------------------------
        */
        $enderecoToken =
            trim(
                (string) (
                    $_POST['endereco']
                    ?? ''
                )
            );

        if ($enderecoToken === '') {
            $this->voltarCheckoutComErro(
                'Selecione um endereço para entrega.'
            );
        }

        $enderecoId =
            IdSeguro::descriptografar(
                $enderecoToken
            );

        if (
            $enderecoId === null
            ||
            $enderecoId < 1
        ) {
            $this->voltarCheckoutComErro(
                'O endereço selecionado é inválido.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 5. Confirma que o endereço pertence ao cliente
        |--------------------------------------------------------------------------
        */
        $endereco =
            $this->enderecoRepository
            ->buscarPorId(
                (int) $enderecoId,
                $clienteId
            );

        if ($endereco === null) {
            $this->voltarCheckoutComErro(
                'O endereço não foi encontrado.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 6. Token do carrinho
        |--------------------------------------------------------------------------
        */
        $tokenCarrinho =
            CarrinhoSessao::token();

        try {
            /*
            |--------------------------------------------------------------------------
            | 7. O Service executa o processo completo
            |--------------------------------------------------------------------------
            */
            $resultado =
                $this->checkoutService
                ->finalizar(
                    $clienteId,
                    (int) $enderecoId,
                    $tokenCarrinho
                );

            $urlPagamento =
                trim(
                    (string) (
                        $resultado[
                            'url_pagamento'
                        ]
                        ?? ''
                    )
                );

            if ($urlPagamento === '') {
                throw new RuntimeException(
                    'A URL de pagamento '
                    . 'não foi gerada.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | 8. Renova o CSRF
            |--------------------------------------------------------------------------
            */
            CsrfCarrinho::renovar();

            /*
            |--------------------------------------------------------------------------
            | 9. Redireciona ao Mercado Pago
            |--------------------------------------------------------------------------
            */
            header(
                'Location: '
                . $urlPagamento
            );

            exit;
        } catch (
            InvalidArgumentException
            | RuntimeException $erro
        ) {
            $this->voltarCheckoutComErro(
                $erro->getMessage()
            );
        } catch (Throwable $erro) {
            /*
            |--------------------------------------------------------------------------
            | Em produção, registre o erro em log.
            | Não exiba Access Token ou dados internos.
            |--------------------------------------------------------------------------
            */
            $this->voltarCheckoutComErro(
                'Não foi possível iniciar '
                . 'o pagamento. Tente novamente.'
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Retorno do Mercado Pago
    |--------------------------------------------------------------------------
    */
    public function retorno(): void
    {
        ClienteAuth::exigirLogin();

        $clienteId =
            (int) ClienteAuth::id();

        /*
        |--------------------------------------------------------------------------
        | Dados recebidos pela URL
        |--------------------------------------------------------------------------
        |
        | Esses dados não devem aprovar diretamente o pedido.
        |
        */
        $pagamentoId =
            trim(
                (string) (
                    $_GET['payment_id']
                    ?? $_GET['collection_id']
                    ?? ''
                )
            );

        $referenciaExterna =
            trim(
                (string) (
                    $_GET['external_reference']
                    ?? ''
                )
            );

        $resultadoRetorno =
            trim(
                (string) (
                    $_GET['resultado']
                    ?? 'pendente'
                )
            );

        $statusInformado =
            trim(
                (string) (
                    $_GET['status']
                    ?? ''
                )
            );

        /*
        |--------------------------------------------------------------------------
        | Resultado padrão
        |--------------------------------------------------------------------------
        */
        $pagamento = null;

        $mensagem =
            'O pagamento está sendo processado.';

        $tipoAlerta =
            'warning';

        try {
            /*
            |--------------------------------------------------------------------------
            | Consulta segura no Service
            |--------------------------------------------------------------------------
            |
            | O Service deve consultar o pagamento na API
            | e localizar o pedido pertencente ao cliente.
            |
            */
            if ($pagamentoId !== '') {
                $pagamento =
                    $this->checkoutService
                    ->consultarRetorno(
                        $clienteId,
                        $pagamentoId,
                        $referenciaExterna
                    );

                $statusReal =
                    (string) (
                        $pagamento['status']
                        ?? ''
                    );

                if ($statusReal === 'approved') {
                    $mensagem =
                        'Pagamento aprovado com sucesso.';

                    $tipoAlerta =
                        'success';
                } elseif (
                    in_array(
                        $statusReal,
                        [
                            'pending',
                            'in_process',
                        ],
                        true
                    )
                ) {
                    $mensagem =
                        'O pagamento está '
                        . 'sendo processado.';

                    $tipoAlerta =
                        'warning';
                } elseif (
                    in_array(
                        $statusReal,
                        [
                            'rejected',
                            'cancelled',
                        ],
                        true
                    )
                ) {
                    $mensagem =
                        'O pagamento não '
                        . 'foi concluído.';

                    $tipoAlerta =
                        'danger';
                }
            }
        } catch (Throwable $erro) {
            /*
            |--------------------------------------------------------------------------
            | Não aprovamos pelo valor recebido na URL
            |--------------------------------------------------------------------------
            */
            $mensagem =
                'Recebemos seu retorno, '
                . 'mas ainda estamos confirmando '
                . 'o pagamento.';

            $tipoAlerta =
                'warning';
        }

        /*
        |--------------------------------------------------------------------------
        | Dados do header
        |--------------------------------------------------------------------------
        */
        $categorias =
            $this->categoriaRepository
            ->listarAtivas();

        foreach ($categorias as &$categoria) {
            $categoria['id_seguro'] =
                IdSeguro::criptografar(
                    (int) $categoria['id']
                );
        }

        unset($categoria);

        $quantidadeCarrinho = 0;

        $tituloPagina =
            'Resultado do Pagamento';

        $descricaoPagina =
            'Acompanhe o resultado '
            . 'do pagamento do seu pedido.';

        /*
        |--------------------------------------------------------------------------
        | Carrega a view
        |--------------------------------------------------------------------------
        */
        $arquivoView =
            APP_ROOT
            . '/views/site/pagamento_retorno.php';

        if (!is_file($arquivoView)) {
            throw new RuntimeException(
                'A página de retorno '
                . 'não foi encontrada.'
            );
        }

        require $arquivoView;
    }

    /*
    |--------------------------------------------------------------------------
    | Voltar para o carrinho
    |--------------------------------------------------------------------------
    */
    private function voltarCarrinhoComErro(
        string $mensagem
    ): never {
        $_SESSION['carrinho_erro'] =
            $mensagem;

        header(
            'Location: '
            . BASE_URL
            . '/carrinho'
        );

        exit;
    }

    /*
    |--------------------------------------------------------------------------
    | Voltar para o checkout
    |--------------------------------------------------------------------------
    */
    private function voltarCheckoutComErro(
        string $mensagem
    ): never {
        $_SESSION['checkout_erro'] =
            $mensagem;

        header(
            'Location: '
            . BASE_URL
            . '/checkout'
        );

        exit;
    }
}