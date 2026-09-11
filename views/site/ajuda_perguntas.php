<?php
declare(strict_types=1);
use App\Helpers\View;
$tituloPagina = $tituloPagina   ?? 'Ajuda Perguntas';
$descricaoPagina = $descricaoPagina ?? 'Loja online com produtos, ofertas, atendimento ao cliente e compra segura.';
$quantidadeCarrinho = $quantidadeCarrinho ?? 0;
$baseUrl = defined('BASE_URL') ? BASE_URL : ''; ?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta
        name="description"
        content="">
    <title><?= htmlspecialchars($tituloPagina, ENT_QUOTES, 'UTF-8');  ?></title>
    <!--
        Caminho-base das rotas no XAMPP.
        Quando o projeto funcionar sem /public, altere para:
        <base href="/loja_online/">
    -->
    <base href="<?= BASE_URL ?>/">
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous">
    <link rel="stylesheet" href="<?= htmlspecialchars($baseUrl . '/assets/css/site.css', ENT_QUOTES, 'UTF-8') ?>">
</head>
<body>
    <!-- ============================================================
         1. BARRA SUPERIOR
    ============================================================= -->
    <?php require_once APP_ROOT  . '/views/componentes/site/sections/barraSuperior.php'; ?>
    <!-- ============================================================
         2. MENU PRINCIPAL
    ============================================================= -->
    <?php View::componente('header', ['categorias' => $categorias, 'quantidadeCarrinho' => $quantidadeCarrinho,]); ?>
    <main class="py-5 bg-body-tertiary">
    <section class="container">
        <!-- TÍTULO -->
        <div class="row justify-content-center mb-5">
            <div class="col-12 col-lg-8 text-center">
                <span class="badge text-bg-primary mb-3">
                    Tire suas dúvidas
                </span>
                <h1 class="display-6 fw-bold mb-3">
                    Perguntas Frequentes
                </h1>
                <p class="lead text-muted mb-0">
                    Consulte as respostas para as dúvidas
                    mais comuns sobre compras, pagamentos e entregas.
                </p>
            </div>
        </div>
        <!-- PERGUNTAS -->
        <div class="row justify-content-center">
            <div class="col-12 col-lg-9">
                <div
                    class="accordion shadow-sm"
                    id="accordionPerguntas">
                    <!-- PERGUNTA 1 -->
                    <div class="accordion-item">
                        <h2
                            class="accordion-header"
                            id="perguntaUm">
                            <button
                                class="accordion-button"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#respostaUm"
                                aria-expanded="true"
                                aria-controls="respostaUm">
                                Como faço para comprar um produto?
                            </button>
                        </h2>
                        <div
                            id="respostaUm"
                            class="
                                accordion-collapse
                                collapse
                                show
                            "
                            aria-labelledby="perguntaUm"
                            data-bs-parent="#accordionPerguntas">
                            <div class="accordion-body">
                                Escolha o produto, informe a quantidade,
                                clique em adicionar ao carrinho, calcule
                                o frete e selecione a opção para finalizar
                                a compra.
                            </div>
                        </div>
                    </div>
                    <!-- PERGUNTA 2 -->
                    <div class="accordion-item">
                        <h2
                            class="accordion-header"
                            id="perguntaDois">
                            <button
                                class="
                                    accordion-button
                                    collapsed
                                "
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#respostaDois"
                                aria-expanded="false"
                                aria-controls="respostaDois">
                                Quais meios de pagamento são aceitos?
                            </button>
                        </h2>
                        <div
                            id="respostaDois"
                            class="
                                accordion-collapse
                                collapse
                            "
                            aria-labelledby="perguntaDois"
                            data-bs-parent="#accordionPerguntas">
                            <div class="accordion-body">
                                Os meios de pagamento disponíveis
                                serão apresentados no ambiente seguro
                                do Mercado Pago durante a finalização
                                da compra.
                            </div>
                        </div>
                    </div>
                    <!-- PERGUNTA 3 -->
                    <div class="accordion-item">
                        <h2
                            class="accordion-header"
                            id="perguntaTres">
                            <button
                                class="
                                    accordion-button
                                    collapsed
                                "
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#respostaTres"
                                aria-expanded="false"
                                aria-controls="respostaTres">
                                Como o valor do frete é calculado?
                            </button>
                        </h2>
                        <div
                            id="respostaTres"
                            class="
                                accordion-collapse
                                collapse
                            "
                            aria-labelledby="perguntaTres"
                            data-bs-parent="#accordionPerguntas">
                            <div class="accordion-body">
                                O frete é calculado com base no CEP
                                informado e nas regras de entrega
                                cadastradas pela loja.
                            </div>
                        </div>
                    </div>
                    <!-- PERGUNTA 4 -->
                    <div class="accordion-item">
                        <h2
                            class="accordion-header"
                            id="perguntaQuatro">
                            <button
                                class="
                                    accordion-button
                                    collapsed
                                "
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#respostaQuatro"
                                aria-expanded="false"
                                aria-controls="respostaQuatro">
                                Como acompanho meu pedido?
                            </button>
                        </h2>
                        <div
                            id="respostaQuatro"
                            class="
                                accordion-collapse
                                collapse
                            "
                            aria-labelledby="perguntaQuatro"
                            data-bs-parent="#accordionPerguntas">
                            <div class="accordion-body">
                                Entre na sua conta e acesse a página
                                Meus pedidos. Nela, você poderá conferir
                                o status da compra e as informações
                                disponíveis para rastreamento.
                            </div>
                        </div>
                    </div>
                    <!-- PERGUNTA 5 -->
                    <div class="accordion-item">
                        <h2
                            class="accordion-header"
                            id="perguntaCinco">
                            <button
                                class="
                                    accordion-button
                                    collapsed
                                "
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#respostaCinco"
                                aria-expanded="false"
                                aria-controls="respostaCinco">
                                Posso alterar o endereço depois da compra?
                            </button>
                        </h2>
                        <div
                            id="respostaCinco"
                            class="
                                accordion-collapse
                                collapse
                            "
                            aria-labelledby="perguntaCinco"
                            data-bs-parent="#accordionPerguntas">
                            <div class="accordion-body">
                                A alteração dependerá do status do
                                pedido. Entre em contato com o atendimento
                                o mais rapidamente possível. Depois do
                                envio, a alteração poderá não ser permitida.
                            </div>
                        </div>
                    </div>
                    <!-- PERGUNTA 6 -->
                    <div class="accordion-item">
                        <h2
                            class="accordion-header"
                            id="perguntaSeis">
                            <button
                                class="
                                    accordion-button
                                    collapsed
                                "
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#respostaSeis"
                                aria-expanded="false"
                                aria-controls="respostaSeis">
                                Como solicitar uma troca ou devolução?
                            </button>
                        </h2>
                        <div
                            id="respostaSeis"
                            class="
                                accordion-collapse
                                collapse
                            "
                            aria-labelledby="perguntaSeis"
                            data-bs-parent="#accordionPerguntas">
                            <div class="accordion-body">
                                Acesse a página Trocas e devoluções,
                                confira as condições e entre em contato
                                informando o código do pedido e o motivo
                                da solicitação.
                            </div>
                        </div>
                    </div>
                </div>
                <!-- CONTATO -->
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-body p-4 text-center">
                        <h2 class="h5 fw-bold">
                            Não encontrou sua resposta?
                        </h2>
                        <p class="text-muted">
                            Nossa equipe poderá ajudar com
                            dúvidas específicas sobre sua compra.
                        </p>
                        <a
                            href="<?=
                                htmlspecialchars(
                                    $baseUrl
                                    . '/ajuda/contato',
                                    ENT_QUOTES,
                                    'UTF-8'
                                )
                            ?>"
                            class="btn btn-primary">
                            Falar com o atendimento
                        </a>
                    </div>
                </div>
                <div class="mt-4 text-center">
                    <a
                        href="<?=
                            htmlspecialchars(
                                $baseUrl
                                . '/ajuda/central',
                                ENT_QUOTES,
                                'UTF-8'
                            )
                        ?>"
                        class="btn btn-outline-secondary">
                        ← Voltar para a Central de Ajuda
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>
    <!-- ============================================================
         9. RODAPÉ
    ============================================================= -->
    <?php View::componente('footer'); ?>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>
</html>