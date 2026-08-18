<?php

declare(strict_types=1);

use App\Helpers\View;

$tituloPagina = $tituloPagina
    ?? 'Loja Online';
$descricaoPagina = $descricaoPagina
    ?? 'Loja online com produtos, ofertas, atendimento ao cliente e compra segura.';
$tituloPagina = $tituloPagina   ?? 'Ofertas';
$descricaoPagina = $descricaoPagina ?? 'Loja online com produtos, ofertas, atendimento ao cliente e compra segura.';
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
    <?php View::componente('header', ['categorias' => $categorias,]);  ?>
    <main class="py-5">
        <div class="container">
            <!-- Título da página -->
            <div class="row mb-4">
                <div class="col-12">
                    <h1 class="h2 fw-bold mb-2">
                        Ofertas
                    </h1>
                    <p class="text-muted mb-0">
                        Aproveite os produtos com descontos disponíveis
                        por tempo limitado.
                    </p>
                </div>
            </div>
            <!-- Nenhuma oferta -->
            <?php if ($ofertas === []): ?>
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-info" role="alert">
                            Nenhuma oferta está disponível neste momento.
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- Produtos em oferta -->
                <div class="row g-4">
                    <?php foreach ($ofertas as $produto): ?>
                        <?php
                        $nomeProduto = (string) $produto['nome'];
                        $descricaoProduto = trim(
                            (string) ($produto['descricao'] ?? '')
                        );
                        $precoNormal = (float) $produto['preco'];
                        $desconto = (float) $produto['percentual_oferta'];
                        $precoOferta = $precoNormal-($precoNormal*$desconto/100);
                        $estoque = (int) $produto['estoque'];
                        $economia = $precoNormal - $precoOferta;
                        /*
                     * Imagem padrão
                     */
                        $imagem = trim(
                            (string) ($produto['imagem'] ?? '')
                        );
                        if ($imagem === '') {
                            $imagem = $baseUrl
                                . '/assets/img/produtos/sem-imagem.png';
                        }
                        ?>
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                            <article class="card h-100 shadow-sm border-0">
                                <!-- Imagem -->
                                <div class="position-relative">
                                    <img src="<?= htmlspecialchars($imagem, ENT_QUOTES, 'UTF-8') ?>" class="card-img-top"
                                        alt="<?= htmlspecialchars($nomeProduto, ENT_QUOTES, 'UTF-8') ?>" onerror="this.onerror=null;this.src='<?= htmlspecialchars($baseUrl . '/assets/img/produtos/sem-imagem.jpg', ENT_QUOTES, 'UTF-8') ?>';" style="height: 220px; object-fit: contain;">
                                    <span class="badge text-bg-danger position-absolute top-0 end-0 m-3">
                                        <?= number_format($desconto, 0, ',', '.') ?>% OFF
                                    </span>
                                </div>
                                <!-- Conteúdo -->
                                <div class="card-body d-flex flex-column">
                                    <!-- Categoria -->
                                    <span class="badge text-bg-secondary align-self-start mb-2">
                                        <?= htmlspecialchars(
                                            (string) $produto['categoria'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </span>
                                    <!-- Nome -->
                                    <h2 class="h5 card-title">
                                        <?= htmlspecialchars(
                                            $nomeProduto,
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </h2>
                                    <!-- Descrição -->
                                    <p class="card-text text-muted small flex-grow-1">
                                        <?= htmlspecialchars(
                                            mb_strimwidth(
                                                $descricaoProduto,
                                                0,
                                                110,
                                                '...'
                                            ),
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </p>
                                    <!-- Preços e ações -->
                                    <div class="mt-auto">
                                        <!-- Preço normal -->
                                        <small class="text-muted text-decoration-line-through">
                                            R$
                                            <?= number_format(
                                                $precoNormal,
                                                2,
                                                ',',
                                                '.'
                                            ) ?>
                                        </small>
                                        <!-- Preço da oferta -->
                                        <div class="fs-4 fw-bold text-success">
                                            R$
                                            <?= number_format(
                                                $precoOferta,
                                                2,
                                                ',',
                                                '.'
                                            ) ?>
                                        </div>
                                        <!-- Economia -->
                                        <div class="mb-2">
                                            <small class="text-success">
                                                Economize R$
                                                <?= number_format(
                                                    $economia,
                                                    2,
                                                    ',',
                                                    '.'
                                                ) ?>
                                            </small>
                                        </div>
                                        <!-- Estoque -->
                                        <?php if ($estoque > 0): ?>
                                            <small class="text-success d-block mb-3">
                                                Em estoque [ <?= $estoque ?> unid. ]
                                            </small>
                                        <?php else: ?>
                                            <small class="text-danger d-block mb-3">
                                                Produto indisponível
                                            </small>
                                        <?php endif; ?>
                                        <!-- Botões -->
                                        <div class="d-grid gap-2">
                                            <!-- Ver detalhes -->
                                            <a href="<?= htmlspecialchars(
                                                            $baseUrl
                                                                . '/produto/detalhes?prod='
                                                                . urlencode(
                                                                    $produto['id_seguro']
                                                                ),
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        ) ?>" class="btn btn-outline-primary">
                                                Ver detalhes
                                            </a>
                                            <!-- Adicionar ao carrinho -->
                                            <?php if ($estoque > 0): ?>
                                                <form action="<?= htmlspecialchars(
                                                                    $baseUrl . '/carrinho/adicionar',
                                                                    ENT_QUOTES,
                                                                    'UTF-8'
                                                                ) ?>" method="post">
                                                    <input type="hidden" name="produto" value="<?= htmlspecialchars(
                                                                                                    $produto['id_seguro'],
                                                                                                    ENT_QUOTES,
                                                                                                    'UTF-8'
                                                                                                ) ?>">
                                                    <input type="hidden" name="quantidade" value="1">
                                                    <button type="submit" class="btn btn-success w-100">
                                                        <i class="bi bi-cart-plus me-1"></i>
                                                        Adicionar ao carrinho
                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                <button type="button" class="btn btn-secondary" disabled>
                                                    Produto indisponível
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
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