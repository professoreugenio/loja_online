<?php
declare(strict_types=1);
use App\Helpers\View;
$tituloPagina = $tituloPagina   ?? 'Ajuda Trocas';
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
                <span class="badge text-bg-warning mb-3">
                    Atendimento pós-compra
                </span>
                <h1 class="display-6 fw-bold mb-3">
                    Trocas e Devoluções
                </h1>
                <p class="lead text-muted mb-0">
                    Consulte as orientações para solicitar
                    a troca ou devolução de um produto.
                </p>
            </div>
        </div>
        <!-- PASSOS -->
        <div class="row g-4 mb-5">
            <div class="col-12 col-md-4">
                <article class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <span
                            class="
                                badge
                                rounded-pill
                                text-bg-primary
                                fs-6
                                mb-3
                            ">
                            1
                        </span>
                        <h2 class="h5 fw-bold">
                            Separe as informações
                        </h2>
                        <p class="text-muted mb-0">
                            Tenha em mãos o código do pedido,
                            o nome do produto e o motivo da
                            solicitação.
                        </p>
                    </div>
                </article>
            </div>
            <div class="col-12 col-md-4">
                <article class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <span
                            class="
                                badge
                                rounded-pill
                                text-bg-primary
                                fs-6
                                mb-3
                            ">
                            2
                        </span>
                        <h2 class="h5 fw-bold">
                            Entre em contato
                        </h2>
                        <p class="text-muted mb-0">
                            Envie a solicitação para a equipe
                            de atendimento e aguarde as
                            instruções.
                        </p>
                    </div>
                </article>
            </div>
            <div class="col-12 col-md-4">
                <article class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <span
                            class="
                                badge
                                rounded-pill
                                text-bg-primary
                                fs-6
                                mb-3
                            ">
                            3
                        </span>
                        <h2 class="h5 fw-bold">
                            Aguarde a análise
                        </h2>
                        <p class="text-muted mb-0">
                            A equipe verificará o pedido e
                            informará os próximos passos
                            para envio ou coleta.
                        </p>
                    </div>
                </article>
            </div>
        </div>
        <div class="row g-4">
            <!-- CONDIÇÕES -->
            <div class="col-12 col-lg-7">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3">
                        <h2 class="h5 mb-0">
                            Condições para análise
                        </h2>
                    </div>
                    <div class="card-body p-4">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item px-0">
                                O produto deverá ser enviado
                                conforme as orientações fornecidas
                                pelo atendimento.
                            </li>
                            <li class="list-group-item px-0">
                                Sempre que possível, mantenha a
                                embalagem original e os acessórios.
                            </li>
                            <li class="list-group-item px-0">
                                Produtos danificados por uso
                                inadequado poderão não ser aceitos.
                            </li>
                            <li class="list-group-item px-0">
                                A solicitação deverá conter o
                                código do pedido.
                            </li>
                            <li class="list-group-item px-0">
                                O produto será analisado antes
                                da conclusão da troca.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- INFORMAÇÕES NECESSÁRIAS -->
            <div class="col-12 col-lg-5">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3">
                        <h2 class="h5 mb-0">
                            Informe no atendimento
                        </h2>
                    </div>
                    <div class="card-body p-4">
                        <ul class="mb-4">
                            <li>Código do pedido;</li>
                            <li>Nome do produto;</li>
                            <li>Motivo da solicitação;</li>
                            <li>Descrição do problema;</li>
                            <li>Fotos, quando necessário.</li>
                        </ul>
                        <a
                            href="<?=
                                htmlspecialchars(
                                    $baseUrl
                                    . '/ajuda/contato',
                                    ENT_QUOTES,
                                    'UTF-8'
                                )
                            ?>"
                            class="btn btn-primary w-100">
                            Solicitar atendimento
                        </a>
                        <a
                            href="<?=
                                htmlspecialchars(
                                    $baseUrl
                                    . '/cliente/pedidos',
                                    ENT_QUOTES,
                                    'UTF-8'
                                )
                            ?>"
                            class="
                                btn
                                btn-outline-secondary
                                w-100
                                mt-2
                            ">
                            Consultar meus pedidos
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- ALERTA -->
        <div class="alert alert-info mt-4 mb-0">
            <strong>Atenção:</strong>
            os prazos e condições definitivos devem ser
            configurados pela empresa de acordo com sua política
            comercial e com a legislação aplicável.
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