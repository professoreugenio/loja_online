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
    <?php View::componente('header', ['categorias' => $categorias,]);  ?>
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
                    <?php foreach ($produtosDestaque as $produto): ?>
                        <?php


                        $nomeProduto = (string) $produto['nome'];
                        $descricaoProduto = trim(
                            (string) ($produto['descricao'] ?? '')
                        );
                        $precoNormal = (float) $produto['preco'];
                        $categoria = (float) $produto['categoria'];
                        $desconto = (float) $produto['percentual_oferta'];
                        $precoOferta = $precoNormal - ($precoNormal * $desconto / 100);
                        $estoque = (int) $produto['estoque'];
                        $economia = $precoNormal - $precoOferta;


                        $imagem = trim(
                            (string) ($produto['imagem'] ?? '')
                        );
                        if ($imagem === '') {
                            $imagem = $baseUrl
                                . '/assets/img/produtos/sem-imagem.png';
                        }
                        ?>
                        <div class="col">
                            <div class="card h-100 shadow-sm border-0">
                                <!-- Imagem -->
                                <div class="p-3 text-center">
                                    <img
                                        src="<?= htmlspecialchars($imagem, ENT_QUOTES, 'UTF-8') ?>"
                                        class="card-img-top img-fluid"
                                        alt="<?= htmlspecialchars($nomeProduto, ENT_QUOTES, 'UTF-8') ?>"
                                        onerror="
    this.onerror=null;
    this.src='<?=
                        htmlspecialchars(
                            $baseUrl
                                . '/assets/img/produtos/sem-imagem.jpg',
                            ENT_QUOTES,
                            'UTF-8'
                        )
                ?>';
"

                                        style="height: 220px; object-fit: contain;">
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <!-- Categoria -->
                                    <div class="mb-2">
                                        <span class="badge text-bg-primary">
                                            <?= $categoria ?>
                                        </span>
                                    </div>
                                    <!-- Nome -->
                                    <h5 class="card-title">
                                        <?= $nomeProduto; ?>
                                    </h5>
                                    <!-- Descrição -->
                                    <p class="card-text text-muted small">
                                        <?= $descricaoProduto; ?>

                                    </p>
                                    <!-- Preço antigo -->
                                    <div class="mt-auto">
                                        <small class="text-muted text-decoration-line-through">
                                            <?php

                                            if ($desconto): ?>
                                                R$ <?= $precoNormal ?>
                                            <?php endif; ?>
                                        </small>
                                        <!-- Preço atual -->
                                        <div class="fs-4 fw-bold text-success">
                                            R$ <?= $precoOferta ?>
                                        </div>
                                        <!-- Parcelamento -->

                                        <?php
                                        $valor = $precoOferta ?? $precoNormal;
                                        $quantidadeParcelas = 10;
                                        $valorParcela =
                                            $valor / $quantidadeParcelas;
                                        ?>
                                        <p class="small text-muted mb-3">
                                            ou <?= $quantidadeParcelas ?>x de R$ <?= $valorParcela ?>
                                        </p>
                                        <!-- Botões -->
                                        <div class="d-grid gap-2">
                                            <a
                                                href="<?=
                                                        htmlspecialchars(
                                                            $baseUrl
                                                                . '/produto/detalhes?prod='
                                                                . urlencode(
                                                                    $produto['id_seguro']
                                                                ),
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        )
                                                        ?>"
                                                class="btn btn-outline-primary">

                                                Ver detalhes

                                            </a>

                                            <form
                                                action="<?=
                                                        htmlspecialchars(
                                                            $baseUrl
                                                                . '/carrinho/adicionar',
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        )
                                                        ?>"
                                                method="post">


                                                <input
                                                    type="hidden"
                                                    name="csrf_token"
                                                    value="<?=
                                                            htmlspecialchars(
                                                                $csrfCarrinho,
                                                                ENT_QUOTES,
                                                                'UTF-8'
                                                            )
                                                            ?>">


                                                <input
                                                    type="hidden"
                                                    name="produto"
                                                    value="<?=
                                                            htmlspecialchars(
                                                                $produto['id_seguro'],
                                                                ENT_QUOTES,
                                                                'UTF-8'
                                                            )
                                                            ?>">


                                                <input
                                                    type="hidden"
                                                    name="quantidade"
                                                    value="1">


                                                <button
                                                    type="submit"
                                                    class="
            btn
            btn-primary
            w-100
        ">

                                                    Adicionar ao carrinho

                                                </button>


                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
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
                    <?php foreach ($maisVendidos as $produto): ?>
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
                                        <?=
                                        htmlspecialchars(
                                            $produto['nome'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        )
                                        ?>
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
                                                href="produto/detalhes?id=5"
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
                    <?php endforeach; ?>
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