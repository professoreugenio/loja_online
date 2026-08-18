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

                <h1>

                    <?=
                    htmlspecialchars(
                        $categoria['nome'],
                        ENT_QUOTES,
                        'UTF-8'
                    )
                    ?>

                </h1>

                <?php if (
                    !empty($categoria['descricao'])
                ): ?>

                    <p>

                        <?=
                        htmlspecialchars(
                            $categoria['descricao'],
                            ENT_QUOTES,
                            'UTF-8'
                        )
                        ?>

                    </p>

                <?php endif; ?>


                <!-- =========================================================
         CARD 1
    ========================================================== -->

                <?php if ($produtos === []): ?>

                    <div
                        class="alert alert-info"
                        role="alert">

                        Nenhum produto foi encontrado
                        nesta categoria.

                    </div>

                <?php else: ?>

                    <?php foreach ($produtos as $produto): ?>
                        <?php
                        $imagem = trim(
                            (string) ($produto['imgcategoria'] ?? '')
                        );
                        if ($imagem === '') {
                            $imagem = $baseUrl
                                . '/assets/img/produtos/sem-imagem.png';
                        }

                        $desconto = (float) $produto['percentual_oferta'];
                        $precoNormal = (float) $produto['preco'];
                        $precoOferta = $precoNormal - ($precoNormal * $desconto / 100);;
                        $economia = $precoNormal - $precoOferta; ?>
                        <div class="col-12 col-sm-6 col-lg-3">
                            <div class="card h-100 shadow-sm border-0">

                                <img
                                    src="assets/img/produtos/notebook.jpg"
                                    class="card-img-top"
                                    alt="<?= htmlspecialchars($produto['nome'], ENT_QUOTES, 'UTF-8') ?>" onerror="this.onerror=null;this.src='<?= htmlspecialchars($baseUrl . '/assets/img/produtos/sem-imagem.png', ENT_QUOTES, 'UTF-8') ?>';"
                                    style="height: 220px; object-fit: contain;">

                                <div class="card-body d-flex flex-column">

                                    <span class="badge text-bg-primary align-self-start mb-2">
                                        <?= htmlspecialchars($categoria['nome'], ENT_QUOTES, 'UTF-8'); ?>
                                    </span>

                                    <h5 class="card-title">
                                        <?= htmlspecialchars($produto['nome'], ENT_QUOTES, 'UTF-8'); ?>
                                    </h5>

                                    <p class="card-text text-muted small">
                                        <?= htmlspecialchars($produto['descricao'], ENT_QUOTES, 'UTF-8'); ?>
                                    </p>

                                    <div class="mt-auto">

                                        <small class="text-decoration-line-through text-muted">
                                            <?= number_format(
                                                (float)$precoNormal,
                                                2,
                                                ',',
                                                '.'
                                            ) ?>
                                        </small>

                                        <h4 class="text-success fw-bold mb-1">
                                            R$ <?=
                                                number_format(
                                                    (float)
                                                    $precoOferta,
                                                    2,
                                                    ',',
                                                    '.'
                                                )
                                                ?>
                                        </h4>

                                        <small class="text-muted">
                                            <?php $parcelas = 10;
                                            $preco =  $produto['preco'];
                                            $valorParcela = $preco / $parcelas;

                                            ?>
                                            ou <?= $parcelas ?>x de R$ <?= number_format($valorParcela, 2, ',', '.') ?>
                                        </small>

                                        <div class="d-grid gap-2 mt-3">

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

                <?php endif; ?>






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