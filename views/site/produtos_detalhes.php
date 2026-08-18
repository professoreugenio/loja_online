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
    <main>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <main class="py-4">

                        <div class="container">

                            <!-- ============================================================
             1. BREADCRUMB
        ============================================================= -->
                            <nav aria-label="breadcrumb" class="mb-4">
                                <ol class="breadcrumb">

                                    <li class="breadcrumb-item">
                                        <a href="./" class="text-decoration-none">
                                            Início
                                        </a>
                                    </li>

                                    <li class="breadcrumb-item">
                                        <a href="produtos" class="text-decoration-none">
                                            Produtos
                                        </a>
                                    </li>

                                    <li
                                        class="breadcrumb-item active"
                                        aria-current="page">
                                        Notebook Gamer
                                    </li>

                                </ol>
                            </nav>


                            <!-- ============================================================
             2. DETALHES PRINCIPAIS DO PRODUTO
        ============================================================= -->
                            <section class="mb-5">

                                <?php

                                $imagem =
                                    trim(
                                        (string) (
                                            $produto['imagem']
                                            ?? ''
                                        )
                                    );


                                $imagemPadrao =
                                    $baseUrl
                                    . '/assets/img/produtos/'
                                    . 'sem-imagem.png';


                                if ($imagem === '') {

                                    $imagem =
                                        $imagemPadrao;
                                } elseif (
                                    !str_starts_with(
                                        $imagem,
                                        'http://'
                                    )
                                    &&
                                    !str_starts_with(
                                        $imagem,
                                        'https://'
                                    )
                                    &&
                                    !str_starts_with(
                                        $imagem,
                                        '/'
                                    )
                                ) {

                                    $imagem =
                                        $baseUrl
                                        . '/assets/img/produtos/'
                                        . $imagem;
                                }

                                ?>


                                <div class="row g-5">

                                    <!-- ====================================================
                     IMAGEM DO PRODUTO
                ===================================================== -->
                                    <div class="col-12 col-md-6">

                                        <div
                                            class="border rounded-4 p-4 bg-white text-center">

                                            <img
                                                src="<?=
                                                        htmlspecialchars(
                                                            $imagem,
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        )
                                                        ?>"

                                                alt="<?=
                                                        htmlspecialchars(
                                                            $produto['nome'],
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        )
                                                        ?>"

                                                class="img-fluid"

                                                onerror="
        this.onerror=null;this.src='<?= htmlspecialchars(
                                        $imagemPadrao,
                                        ENT_QUOTES,
                                        'UTF-8'
                                    )
                                    ?>';
    "
                                                class="img-fluid"
                                                style="max-height: 450px; object-fit: contain;">

                                        </div>

                                    </div>


                                    <!-- ====================================================
                     INFORMAÇÕES DO PRODUTO
                ===================================================== -->

                                    <?php

                                    $precoNormal =
                                        (float)
                                        $produto['preco'];


                                    $precoOferta =
                                        $produto['preco_oferta']
                                        !== null

                                        ? (float)
                                        $produto['preco_oferta']

                                        : null;


                                    $temOferta =
                                        $precoOferta !== null;

                                    ?>


                                    <div class="col-12 col-md-6">

                                        <!-- Categoria -->
                                        <span class="badge text-bg-secondary mb-3">
                                            <?=
                                            htmlspecialchars(
                                                $produto['categoria'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            )
                                            ?>
                                        </span>


                                        <!-- Nome -->
                                        <h1 class="h2 fw-bold mb-3">
                                            <?=
                                            htmlspecialchars(
                                                $produto['nome'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            )
                                            ?>
                                        </h1>


                                        <!-- Código -->
                                        <p class="text-muted small mb-3">
                                            Código do produto:
                                            <strong>
                                                PROD-<?=
                                                        str_pad(
                                                            (string)
                                                            $produto['id'],
                                                            6,
                                                            '0',
                                                            STR_PAD_LEFT
                                                        )
                                                        ?>



                                            </strong>
                                        </p>


                                        <!-- Avaliação -->
                                        <div class="mb-3">

                                            <span class="text-warning">
                                                ★★★★★
                                            </span>

                                            <span class="text-muted ms-2">
                                                4.8 (125 avaliações)
                                            </span>

                                        </div>


                                        <hr>


                                        <!-- =================================================
                         PREÇO
                    ================================================== -->
                                        <div class="mb-4">

                                            <?php if ($temOferta): ?>


                                                <div class="mb-2">

                                                    <span
                                                        class="
                text-decoration-line-through
                text-muted
            ">

                                                        R$

                                                        <?=
                                                        number_format(
                                                            $precoNormal,
                                                            2,
                                                            ',',
                                                            '.'
                                                        )
                                                        ?>

                                                    </span>


                                                    <span
                                                        class="
                badge
                text-bg-danger
                ms-2
            ">

                                                        <?=
                                                        number_format(
                                                            (float)
                                                            $produto['percentual_oferta'],
                                                            0,
                                                            ',',
                                                            '.'
                                                        )
                                                        ?>% OFF

                                                    </span>

                                                </div>


                                                <div
                                                    class="
            display-6
            fw-bold
            text-success
        ">

                                                    R$

                                                    <?=
                                                    number_format(
                                                        $precoOferta,
                                                        2,
                                                        ',',
                                                        '.'
                                                    )
                                                    ?>

                                                </div>


                                            <?php endif; ?>



                                            <?php if (!$temOferta): ?>

                                                <div
                                                    class="
            display-6
            fw-bold
            text-success
        ">

                                                    R$

                                                    <?=
                                                    number_format(
                                                        $precoNormal,
                                                        2,
                                                        ',',
                                                        '.'
                                                    )
                                                    ?>

                                                </div>

                                            <?php endif; ?>



                                            <p class="text-muted mb-0">
                                                ou 10x de
                                                <strong>
                                                    <?php

                                                    $valor = $precoOferta ?? $precoNormal;
                                                    $parcelas = $valor / 10;

                                                    ?>

                                                    R$

                                                    <?=
                                                    number_format(
                                                        $parcelas,
                                                        2,
                                                        ',',
                                                        '.'
                                                    )
                                                    ?>
                                                </strong>
                                                sem juros
                                            </p>

                                        </div>


                                        <!-- =================================================
                         ESTOQUE
                    ================================================== -->
                                        <?php if (
                                            (int)
                                            $produto['estoque']
                                            > 0
                                        ): ?>

                                            <span
                                                class="
            badge
            text-bg-success
        ">

                                                Produto disponível

                                            </span>


                                            <small
                                                class="
            text-muted
            ms-2
        ">

                                                <?=
                                                (int)
                                                $produto['estoque']
                                                ?>

                                                unidades em estoque

                                            </small>


                                        <?php else: ?>


                                            <span
                                                class="
            badge
            text-bg-danger
        ">

                                                Produto indisponível

                                            </span>


                                        <?php endif; ?>



                                        <!-- =================================================
                         QUANTIDADE
                    ================================================== -->
                                        <div class="mb-4">

                                            <label
                                                for="quantidade"
                                                class="form-label fw-semibold">
                                                Quantidade
                                            </label>

                                            <div style="max-width: 130px;">

                                                <input
                                                    type="number"
                                                    class="form-control"
                                                    id="quantidade"
                                                    name="quantidade"
                                                    value="1"
                                                    min="1"

                                                    max="<?=
                                                            max(
                                                                1,
                                                                (int)
                                                                $produto['estoque']
                                                            )
                                                            ?>"

                                                    <?=
                                                    (int)
                                                    $produto['estoque']
                                                        <= 0
                                                        ? 'disabled'
                                                        : ''
                                                    ?>>

                                            </div>

                                        </div>


                                        <!-- =================================================
                         BOTÕES
                    ================================================== -->
                                        <div class="d-grid gap-2">

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


                                                <label
                                                    for="quantidade"
                                                    class="
            form-label
            fw-semibold
        ">

                                                    Quantidade

                                                </label>


                                                <input
                                                    type="number"
                                                    class="form-control"
                                                    id="quantidade"
                                                    name="quantidade"
                                                    value="1"
                                                    min="1"
                                                    max="<?=
                                                            (int)
                                                            $produto['estoque']
                                                            ?>">


                                                <button
                                                    type="submit"
                                                    class="
            btn
            btn-primary
            btn-lg
            w-100
            mt-3
        ">

                                                    Adicionar ao carrinho

                                                </button>


                                            </form>



                                            <button
                                                type="button"
                                                class="btn btn-success btn-lg">

                                                Comprar agora

                                            </button>

                                        </div>


                                        <hr class="my-4">


                                        <!-- =================================================
                         INFORMAÇÕES ADICIONAIS
                    ================================================== -->
                                        <div class="row g-3">

                                            <div class="col-12 col-sm-6">



                                            </div>


                                            <div class="col-12 col-sm-6">

                                                <div class="border rounded p-3 h-100">

                                                    <strong>
                                                        🔒 Compra segura
                                                    </strong>

                                                    <div class="small text-muted mt-1">
                                                        Ambiente protegido para sua compra.
                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </section>


                            <!-- ============================================================
             3. DESCRIÇÃO DO PRODUTO
        ============================================================= -->
                            <section class="mb-5">

                                <div class="card border-0 shadow-sm">

                                    <div class="card-body p-4">

                                        <h2 class="h4 fw-bold mb-3">
                                            Descrição do produto
                                        </h2>

                                        <p class="mb-0">

                                            <?=
                                            nl2br(
                                                htmlspecialchars(
                                                    (string)
                                                    $produto['descricao'],
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                )
                                            )
                                            ?>

                                        </p>




                                    </div>

                                </div>

                            </section>





                            <!-- ============================================================
             5. FORMAS DE PAGAMENTO
        ============================================================= -->
                            <section class="mb-5">

                                <div class="card border-0 shadow-sm">

                                    <div class="card-body p-4">

                                        <h2 class="h4 fw-bold mb-4">
                                            Formas de pagamento
                                        </h2>

                                        <div class="row g-3">

                                            <div class="col-12 col-md-4">

                                                <div class="border rounded p-3 h-100">

                                                    <strong>
                                                        💳 Cartão de crédito
                                                    </strong>

                                                    <p class="small text-muted mb-0 mt-2">
                                                        Parcele sua compra em até 10x sem juros.
                                                    </p>

                                                </div>

                                            </div>


                                            <div class="col-12 col-md-4">

                                                <div class="border rounded p-3 h-100">

                                                    <strong>
                                                        ⚡ PIX
                                                    </strong>

                                                    <p class="small text-muted mb-0 mt-2">
                                                        Pagamento rápido e confirmação imediata.
                                                    </p>

                                                </div>

                                            </div>


                                            <div class="col-12 col-md-4">

                                                <div class="border rounded p-3 h-100">

                                                    <strong>
                                                        🧾 Boleto
                                                    </strong>

                                                    <p class="small text-muted mb-0 mt-2">
                                                        Pagamento através de boleto bancário.
                                                    </p>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </section>




                        </div>

                    </main>
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