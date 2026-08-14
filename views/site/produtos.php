<?php
declare(strict_types=1);
use App\Helpers\View;
use App\Helpers\Cpf;

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
    <?php    View::componente('header', ['categorias' => $categorias,]);  ?>
    <main class="py-5">

    <div class="container">

        <!-- ========================================================
             PRODUTOS EM DESTAQUE
        ========================================================= -->
        <section class="mb-5">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>
                    <h2 class="fw-bold mb-1">
                        Produtos em Destaque
                    </h2>

                    

                    <p class="text-muted mb-0">
                        Confira alguns produtos selecionados para você.
                    </p>
                </div>

                <a href="produtos" class="btn btn-outline-primary">
                    Ver todos
                </a>

            </div>


            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">

                <!-- PRODUTO 1 -->
                <div class="col">

                    <div class="card h-100 shadow-sm border-0">

                        <!-- Imagem -->
                        <div class="p-3 text-center">

                            <img
                                src="assets/img/produtos/abajur-led.jpg"
                                class="card-img-top img-fluid"
                                alt="Abajur LED Touch"
                                style="height: 220px; object-fit: contain;">

                        </div>


                        <div class="card-body d-flex flex-column">

                            <!-- Categoria -->
                            <div class="mb-2">

                                <span class="badge text-bg-primary">
                                    Casa e Decoração
                                </span>

                            </div>


                            <!-- Nome -->
                            <h5 class="card-title">
                                Abajur LED Touch
                            </h5>


                            <!-- Descrição -->
                            <p class="card-text text-muted small">

                                Abajur LED com acionamento por toque
                                e níveis de iluminação.

                            </p>


                            <!-- Preço antigo -->
                            <div class="mt-auto">

                                <small class="text-muted text-decoration-line-through">
                                    R$ 149,90
                                </small>


                                <!-- Preço atual -->
                                <div class="fs-4 fw-bold text-success">
                                    R$ 119,90
                                </div>


                                <!-- Parcelamento -->
                                <p class="small text-muted mb-3">
                                    ou 10x de R$ 11,99
                                </p>


                                <!-- Botões -->
                                <div class="d-grid gap-2">

                                    <a
                                        href="produto-detalhes?id=1"
                                        class="btn btn-outline-primary">

                                        Ver detalhes

                                    </a>


                                    <button
                                        type="button"
                                        class="btn btn-primary">

                                        Adicionar ao carrinho

                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- PRODUTO 2 -->
                <div class="col">

                    <div class="card h-100 shadow-sm border-0">

                        <div class="p-3 text-center">

                            <img
                                src="assets/img/produtos/notebook.jpg"
                                class="card-img-top img-fluid"
                                alt="Notebook"
                                style="height: 220px; object-fit: contain;">

                        </div>


                        <div class="card-body d-flex flex-column">

                            <div class="mb-2">

                                <span class="badge text-bg-primary">
                                    Informática
                                </span>

                            </div>


                            <h5 class="card-title">
                                Notebook 15.6"
                            </h5>


                            <p class="card-text text-muted small">

                                Notebook para estudos,
                                trabalho e tarefas do dia a dia.

                            </p>


                            <div class="mt-auto">

                                <small class="text-muted text-decoration-line-through">
                                    R$ 3.299,90
                                </small>


                                <div class="fs-4 fw-bold text-success">
                                    R$ 2.899,90
                                </div>


                                <p class="small text-muted mb-3">
                                    ou 10x de R$ 289,99
                                </p>


                                <div class="d-grid gap-2">

                                    <a
                                        href="produto-detalhes?id=2"
                                        class="btn btn-outline-primary">

                                        Ver detalhes

                                    </a>


                                    <button
                                        type="button"
                                        class="btn btn-primary">

                                        Adicionar ao carrinho

                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- PRODUTO 3 -->
                <div class="col">

                    <div class="card h-100 shadow-sm border-0">

                        <div class="p-3 text-center">

                            <img
                                src="assets/img/produtos/smartphone.jpg"
                                class="card-img-top img-fluid"
                                alt="Smartphone"
                                style="height: 220px; object-fit: contain;">

                        </div>


                        <div class="card-body d-flex flex-column">

                            <div class="mb-2">

                                <span class="badge text-bg-primary">
                                    Celulares
                                </span>

                            </div>


                            <h5 class="card-title">
                                Smartphone 256GB
                            </h5>


                            <p class="card-text text-muted small">

                                Smartphone com câmera de alta resolução,
                                256GB de armazenamento.

                            </p>


                            <div class="mt-auto">

                                <small class="text-muted text-decoration-line-through">
                                    R$ 2.199,90
                                </small>


                                <div class="fs-4 fw-bold text-success">
                                    R$ 1.899,90
                                </div>


                                <p class="small text-muted mb-3">
                                    ou 10x de R$ 189,99
                                </p>


                                <div class="d-grid gap-2">

                                    <a
                                        href="produto-detalhes?id=3"
                                        class="btn btn-outline-primary">

                                        Ver detalhes

                                    </a>


                                    <button
                                        type="button"
                                        class="btn btn-primary">

                                        Adicionar ao carrinho

                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- PRODUTO 4 -->
                <div class="col">

                    <div class="card h-100 shadow-sm border-0">

                        <div class="p-3 text-center">

                            <img
                                src="assets/img/produtos/fone.jpg"
                                class="card-img-top img-fluid"
                                alt="Fone Bluetooth"
                                style="height: 220px; object-fit: contain;">

                        </div>


                        <div class="card-body d-flex flex-column">

                            <div class="mb-2">

                                <span class="badge text-bg-primary">
                                    Acessórios
                                </span>

                            </div>


                            <h5 class="card-title">
                                Fone Bluetooth
                            </h5>


                            <p class="card-text text-muted small">

                                Fone sem fio com conexão Bluetooth
                                e bateria de longa duração.

                            </p>


                            <div class="mt-auto">

                                <small class="text-muted text-decoration-line-through">
                                    R$ 249,90
                                </small>


                                <div class="fs-4 fw-bold text-success">
                                    R$ 199,90
                                </div>


                                <p class="small text-muted mb-3">
                                    ou 10x de R$ 19,99
                                </p>


                                <div class="d-grid gap-2">

                                    <a
                                        href="produto-detalhes?id=4"
                                        class="btn btn-outline-primary">

                                        Ver detalhes

                                    </a>


                                    <button
                                        type="button"
                                        class="btn btn-primary">

                                        Adicionar ao carrinho

                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>



        <!-- ========================================================
             MAIS VENDIDOS
        ========================================================= -->
        <section>

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>

                    <h2 class="fw-bold mb-1">
                        Mais Vendidos
                    </h2>

                    <p class="text-muted mb-0">
                        Os produtos preferidos dos nossos clientes.
                    </p>

                </div>

            </div>


            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">

                <!-- PRODUTO 1 -->
                <div class="col">

                    <div class="card h-100 shadow-sm border-0">

                        <div class="p-3 text-center">

                            <img
                                src="assets/img/produtos/mouse.jpg"
                                class="card-img-top img-fluid"
                                alt="Mouse sem fio"
                                style="height: 220px; object-fit: contain;">

                        </div>


                        <div class="card-body d-flex flex-column">

                            <div class="mb-2">

                                <span class="badge text-bg-danger">
                                    Mais vendido
                                </span>

                            </div>


                            <h5 class="card-title">
                                Mouse Sem Fio
                            </h5>


                            <p class="card-text text-muted small">

                                Mouse ergonômico com conexão sem fio
                                e alta precisão.

                            </p>


                            <div class="mt-auto">

                                <div class="fs-4 fw-bold text-success">
                                    R$ 89,90
                                </div>


                                <p class="small text-muted mb-3">
                                    ou 3x de R$ 29,97
                                </p>


                                <div class="d-grid gap-2">

                                    <a
                                        href="produto-detalhes?id=5"
                                        class="btn btn-outline-primary">

                                        Ver detalhes

                                    </a>


                                    <button
                                        type="button"
                                        class="btn btn-primary">

                                        Adicionar ao carrinho

                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- PRODUTO 2 -->
                <div class="col">

                    <div class="card h-100 shadow-sm border-0">

                        <div class="p-3 text-center">

                            <img
                                src="assets/img/produtos/teclado.jpg"
                                class="card-img-top img-fluid"
                                alt="Teclado Mecânico"
                                style="height: 220px; object-fit: contain;">

                        </div>


                        <div class="card-body d-flex flex-column">

                            <div class="mb-2">

                                <span class="badge text-bg-danger">
                                    Mais vendido
                                </span>

                            </div>


                            <h5 class="card-title">
                                Teclado Mecânico
                            </h5>


                            <p class="card-text text-muted small">

                                Teclado mecânico confortável
                                para trabalho e jogos.

                            </p>


                            <div class="mt-auto">

                                <div class="fs-4 fw-bold text-success">
                                    R$ 249,90
                                </div>


                                <p class="small text-muted mb-3">
                                    ou 10x de R$ 24,99
                                </p>


                                <div class="d-grid gap-2">

                                    <a
                                        href="produto-detalhes?id=6"
                                        class="btn btn-outline-primary">

                                        Ver detalhes

                                    </a>


                                    <button
                                        type="button"
                                        class="btn btn-primary">

                                        Adicionar ao carrinho

                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- PRODUTO 3 -->
                <div class="col">

                    <div class="card h-100 shadow-sm border-0">

                        <div class="p-3 text-center">

                            <img
                                src="assets/img/produtos/smartwatch.jpg"
                                class="card-img-top img-fluid"
                                alt="Smartwatch"
                                style="height: 220px; object-fit: contain;">

                        </div>


                        <div class="card-body d-flex flex-column">

                            <div class="mb-2">

                                <span class="badge text-bg-danger">
                                    Mais vendido
                                </span>

                            </div>


                            <h5 class="card-title">
                                Smartwatch
                            </h5>


                            <p class="card-text text-muted small">

                                Relógio inteligente com monitoramento
                                de atividades físicas.

                            </p>


                            <div class="mt-auto">

                                <div class="fs-4 fw-bold text-success">
                                    R$ 399,90
                                </div>


                                <p class="small text-muted mb-3">
                                    ou 10x de R$ 39,99
                                </p>


                                <div class="d-grid gap-2">

                                    <a
                                        href="produto-detalhes?id=7"
                                        class="btn btn-outline-primary">

                                        Ver detalhes

                                    </a>


                                    <button
                                        type="button"
                                        class="btn btn-primary">

                                        Adicionar ao carrinho

                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- PRODUTO 4 -->
                <div class="col">

                    <div class="card h-100 shadow-sm border-0">

                        <div class="p-3 text-center">

                            <img
                                src="assets/img/produtos/caixa-som.jpg"
                                class="card-img-top img-fluid"
                                alt="Caixa de Som Bluetooth"
                                style="height: 220px; object-fit: contain;">

                        </div>


                        <div class="card-body d-flex flex-column">

                            <div class="mb-2">

                                <span class="badge text-bg-danger">
                                    Mais vendido
                                </span>

                            </div>


                            <h5 class="card-title">
                                Caixa de Som Bluetooth
                            </h5>


                            <p class="card-text text-muted small">

                                Caixa de som portátil com conexão
                                Bluetooth e bateria recarregável.

                            </p>


                            <div class="mt-auto">

                                <div class="fs-4 fw-bold text-success">
                                    R$ 179,90
                                </div>


                                <p class="small text-muted mb-3">
                                    ou 6x de R$ 29,98
                                </p>


                                <div class="d-grid gap-2">

                                    <a
                                        href="produto-detalhes?id=8"
                                        class="btn btn-outline-primary">

                                        Ver detalhes

                                    </a>


                                    <button
                                        type="button"
                                        class="btn btn-primary">

                                        Adicionar ao carrinho

                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>

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