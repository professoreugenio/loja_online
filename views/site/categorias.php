<?php
declare(strict_types=1);
use App\Helpers\View;

$tituloPagina = $tituloPagina
    ?? 'Loja Online';
$descricaoPagina = $descricaoPagina
    ?? 'Loja online com produtos, ofertas, atendimento ao cliente e compra segura.';
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
    <base href="/loja_online/public/">
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
    <?php

    View::componente('header', ['categorias' => $categorias,]);

    ?>
    <main>
        <div class="container">
            <div class="row g-4 py-4">

    <!-- =========================================================
         CARD 1
    ========================================================== -->
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card h-100 shadow-sm border-0">

            <img
                src="assets/img/produtos/notebook.jpg"
                class="card-img-top"
                alt="Notebook Lenovo"
                style="height: 220px; object-fit: contain;"
            >

            <div class="card-body d-flex flex-column">

                <span class="badge text-bg-primary align-self-start mb-2">
                    Informática
                </span>

                <h5 class="card-title">
                    Notebook Lenovo IdeaPad
                </h5>

                <p class="card-text text-muted small">
                    Notebook com processador Intel Core i5,
                    8GB de memória RAM e SSD de 256GB.
                </p>

                <div class="mt-auto">

                    <small class="text-decoration-line-through text-muted">
                        R$ 3.499,90
                    </small>

                    <h4 class="text-success fw-bold mb-1">
                        R$ 2.999,90
                    </h4>

                    <small class="text-muted">
                        ou 10x de R$ 299,99
                    </small>

                    <div class="d-grid gap-2 mt-3">

                        <a
                            href="produto/detalhes"
                            class="btn btn-outline-primary"
                        >
                            Ver detalhes
                        </a>

                        <button
                            type="button"
                            class="btn btn-primary"
                        >
                            Adicionar ao carrinho
                        </button>

                    </div>

                </div>

            </div>

        </div>
    </div>


    <!-- =========================================================
         CARD 2
    ========================================================== -->
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card h-100 shadow-sm border-0">

            <img
                src="assets/img/produtos/smartphone.jpg"
                class="card-img-top"
                alt="Smartphone Samsung Galaxy"
                style="height: 220px; object-fit: contain;"
            >

            <div class="card-body d-flex flex-column">

                <span class="badge text-bg-primary align-self-start mb-2">
                    Celulares
                </span>

                <h5 class="card-title">
                    Smartphone Samsung Galaxy
                </h5>

                <p class="card-text text-muted small">
                    Smartphone com 128GB de armazenamento,
                    câmera de alta resolução e tela AMOLED.
                </p>

                <div class="mt-auto">

                    <small class="text-decoration-line-through text-muted">
                        R$ 1.899,90
                    </small>

                    <h4 class="text-success fw-bold mb-1">
                        R$ 1.599,90
                    </h4>

                    <small class="text-muted">
                        ou 10x de R$ 159,99
                    </small>

                    <div class="d-grid gap-2 mt-3">

                        <a
                            href="produto/detalhes"
                            class="btn btn-outline-primary"
                        >
                            Ver detalhes
                        </a>

                        <button
                            type="button"
                            class="btn btn-primary"
                        >
                            Adicionar ao carrinho
                        </button>

                    </div>

                </div>

            </div>

        </div>
    </div>


    <!-- =========================================================
         CARD 3
    ========================================================== -->
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card h-100 shadow-sm border-0">

            <img
                src="assets/img/produtos/mouse.jpg"
                class="card-img-top"
                alt="Mouse Gamer RGB"
                style="height: 220px; object-fit: contain;"
            >

            <div class="card-body d-flex flex-column">

                <span class="badge text-bg-primary align-self-start mb-2">
                    Acessórios
                </span>

                <h5 class="card-title">
                    Mouse Gamer RGB
                </h5>

                <p class="card-text text-muted small">
                    Mouse gamer ergonômico com iluminação RGB,
                    alta precisão e botões programáveis.
                </p>

                <div class="mt-auto">

                    <small class="text-decoration-line-through text-muted">
                        R$ 199,90
                    </small>

                    <h4 class="text-success fw-bold mb-1">
                        R$ 149,90
                    </h4>

                    <small class="text-muted">
                        ou 3x de R$ 49,97
                    </small>

                    <div class="d-grid gap-2 mt-3">

                        <a
                            href="produto/detalhes"
                            class="btn btn-outline-primary"
                        >
                            Ver detalhes
                        </a>

                        <button
                            type="button"
                            class="btn btn-primary"
                        >
                            Adicionar ao carrinho
                        </button>

                    </div>

                </div>

            </div>

        </div>
    </div>


    <!-- =========================================================
         CARD 4
    ========================================================== -->
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card h-100 shadow-sm border-0">

            <img
                src="assets/img/produtos/headset.jpg"
                class="card-img-top"
                alt="Headset Gamer"
                style="height: 220px; object-fit: contain;"
            >

            <div class="card-body d-flex flex-column">

                <span class="badge text-bg-primary align-self-start mb-2">
                    Acessórios
                </span>

                <h5 class="card-title">
                    Headset Gamer USB
                </h5>

                <p class="card-text text-muted small">
                    Headset com som estéreo, microfone ajustável,
                    iluminação LED e conexão USB.
                </p>

                <div class="mt-auto">

                    <small class="text-decoration-line-through text-muted">
                        R$ 289,90
                    </small>

                    <h4 class="text-success fw-bold mb-1">
                        R$ 229,90
                    </h4>

                    <small class="text-muted">
                        ou 4x de R$ 57,48
                    </small>

                    <div class="d-grid gap-2 mt-3">

                        <a
                            href="produto/detalhes"
                            class="btn btn-outline-primary"
                        >
                            Ver detalhes
                        </a>

                        <button
                            type="button"
                            class="btn btn-primary"
                        >
                            Adicionar ao carrinho
                        </button>

                    </div>

                </div>

            </div>

        </div>
    </div>

</div>
        </div>
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