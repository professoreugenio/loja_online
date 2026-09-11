<?php
declare(strict_types=1);
use App\Helpers\View;
$tituloPagina = $tituloPagina
    ?? 'Loja Online';
$descricaoPagina = $descricaoPagina
    ?? 'Loja online com produtos, ofertas, atendimento ao cliente e compra segura.';
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
    <title><?=
            htmlspecialchars(
                $tituloPagina,
                ENT_QUOTES,
                'UTF-8'
            )
            ?></title>
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
    =====================   ======================================== -->
    <?php //require_once APP_ROOT  . '/views/componentes/site/sections/barraSuperior.php'; 
    ?>
    <?php View::componente('sections/barraSuperior'); ?>
    <!-- ============================================================
         2. MENU PRINCIPAL
    ============================================================= -->
    <?php //require_once APP_ROOT  . '/views/componentes/site/header.php'; 
    ?>
    <?php //View::componente('header');
    ?>
    <?php View::componente('header', ['categorias' => $categorias, 'quantidadeCarrinho' => $quantidadeCarrinho,]); ?>
    <main class="py-5 bg-body-tertiary">
    <section class="container">
        <!-- TÍTULO -->
        <div class="row justify-content-center mb-5">
            <div class="col-12 col-lg-8 text-center">
                <span class="badge text-bg-primary mb-3">
                    Atendimento
                </span>
                <h1 class="display-6 fw-bold mb-3">
                    Central de Ajuda
                </h1>
                <p class="lead text-muted mb-0">
                    Encontre respostas sobre pedidos,
                    pagamentos, entregas, trocas e devoluções.
                </p>
            </div>
        </div>
        <!-- ATALHOS -->
        <div class="row g-4 mb-5">
            <!-- PERGUNTAS FREQUENTES -->
            <div class="col-12 col-md-6 col-xl-3">
                <article class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div
                            class="
                                bg-primary-subtle
                                text-primary
                                rounded-circle
                                d-inline-flex
                                align-items-center
                                justify-content-center
                                fs-2
                                mb-3
                            "
                            style="width: 64px; height: 64px;">
                            ❓
                        </div>
                        <h2 class="h5 fw-bold">
                            Perguntas frequentes
                        </h2>
                        <p class="text-muted">
                            Consulte respostas para as
                            principais dúvidas sobre a loja.
                        </p>
                        <a
                            href="<?=
                                htmlspecialchars(
                                    $baseUrl
                                    . '/ajuda/perguntas',
                                    ENT_QUOTES,
                                    'UTF-8'
                                )
                            ?>"
                            class="
                                btn
                                btn-outline-primary
                                stretched-link
                            ">
                            Ver perguntas
                        </a>
                    </div>
                </article>
            </div>
            <!-- RASTREIO -->
            <div class="col-12 col-md-6 col-xl-3">
                <article class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div
                            class="
                                bg-success-subtle
                                text-success
                                rounded-circle
                                d-inline-flex
                                align-items-center
                                justify-content-center
                                fs-2
                                mb-3
                            "
                            style="width: 64px; height: 64px;">
                            📦
                        </div>
                        <h2 class="h5 fw-bold">
                            Rastrear pedido
                        </h2>
                        <p class="text-muted">
                            Acompanhe o andamento e a
                            entrega do seu pedido.
                        </p>
                        <a
                            href="<?=
                                htmlspecialchars(
                                    $baseUrl
                                    . '/ajuda/rastreio',
                                    ENT_QUOTES,
                                    'UTF-8'
                                )
                            ?>"
                            class="
                                btn
                                btn-outline-success
                                stretched-link
                            ">
                            Rastrear pedido
                        </a>
                    </div>
                </article>
            </div>
            <!-- TROCAS -->
            <div class="col-12 col-md-6 col-xl-3">
                <article class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div
                            class="
                                bg-warning-subtle
                                text-warning-emphasis
                                rounded-circle
                                d-inline-flex
                                align-items-center
                                justify-content-center
                                fs-2
                                mb-3
                            "
                            style="width: 64px; height: 64px;">
                            🔄
                        </div>
                        <h2 class="h5 fw-bold">
                            Trocas e devoluções
                        </h2>
                        <p class="text-muted">
                            Entenda como solicitar a troca
                            ou devolução de um produto.
                        </p>
                        <a
                            href="<?=
                                htmlspecialchars(
                                    $baseUrl
                                    . '/ajuda/trocas',
                                    ENT_QUOTES,
                                    'UTF-8'
                                )
                            ?>"
                            class="
                                btn
                                btn-outline-warning
                                stretched-link
                            ">
                            Consultar regras
                        </a>
                    </div>
                </article>
            </div>
            <!-- CONTATO -->
            <div class="col-12 col-md-6 col-xl-3">
                <article class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div
                            class="
                                bg-info-subtle
                                text-info-emphasis
                                rounded-circle
                                d-inline-flex
                                align-items-center
                                justify-content-center
                                fs-2
                                mb-3
                            "
                            style="width: 64px; height: 64px;">
                            💬
                        </div>
                        <h2 class="h5 fw-bold">
                            Fale conosco
                        </h2>
                        <p class="text-muted">
                            Entre em contato com nossa
                            equipe de atendimento.
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
                            class="
                                btn
                                btn-outline-info
                                stretched-link
                            ">
                            Entrar em contato
                        </a>
                    </div>
                </article>
            </div>
        </div>
        <!-- AJUDA COM O PEDIDO -->
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 p-lg-5">
                        <div
                            class="
                                row
                                align-items-center
                                g-4
                            ">
                            <div class="col-12 col-lg-8">
                                <h2 class="h4 fw-bold mb-2">
                                    Precisa de ajuda com uma compra?
                                </h2>
                                <p class="text-muted mb-0">
                                    Entre na sua conta para consultar
                                    pedidos, pagamentos e informações
                                    sobre a entrega.
                                </p>
                            </div>
                            <div class="col-12 col-lg-4 text-lg-end">
                                <a
                                    href="<?=
                                        htmlspecialchars(
                                            $baseUrl
                                            . '/cliente/pedidos',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        )
                                    ?>"
                                    class="btn btn-primary btn-lg">
                                    Meus pedidos
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
    <!-- ============================================================
         9. RODAPÉ
    ============================================================= -->
    <?php View::componente('footer'); ?>
    <?php //require_once __DIR__ . '/../layouts/site/footer.php'; 
    ?>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>
</html>