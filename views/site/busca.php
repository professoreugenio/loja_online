<?php

declare(strict_types=1);

use App\Helpers\View;

$tituloPagina = $tituloPagina   ?? 'Busca';
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
    ============================================================= -->
    <?php require_once APP_ROOT  . '/views/componentes/site/sections/barraSuperior.php'; ?>
    <!-- ============================================================
         2. MENU PRINCIPAL
    ============================================================= -->
    <?php View::componente('header', ['categorias' => $categorias,]); ?>
    <main class="py-5">
        <div class="container">

            <!-- =====================================================
             TÍTULO DA PÁGINA
        ====================================================== -->
            <div class="row mb-4">
                <div class="col-12">
                    <h1 class="h2 fw-bold mb-2">
                        Resultados da busca
                    </h1>

                    <p class="text-muted mb-0">
                        Confira os produtos encontrados para sua pesquisa.
                    </p>
                </div>
            </div>

            <!-- =====================================================
             CAMPO DE BUSCA
        ====================================================== -->
            <div class="row mb-5">
                <div class="col-12 col-lg-8">

                    <div
                        class="
        alert
        alert-light
        border
    ">

                        Digite um nome, descrição ou
                        categoria para pesquisar.

                    </div>


                    <form action="<?=
                                    htmlspecialchars(
                                        $baseUrl
                                            . '/buscar',
                                        ENT_QUOTES,
                                        'UTF-8'
                                    )
                                    ?>" method="get">
                        <div class="input-group input-group-lg">

                            <input
                                type="search"
                                name="q"
                                class="form-control"

                                value="<?=
                                        htmlspecialchars(
                                            $termo,
                                            ENT_QUOTES,
                                            'UTF-8'
                                        )
                                        ?>"
                                placeholder="Digite o nome do produto...">

                            <button
                                type="submit"
                                class="btn btn-primary">
                                Buscar
                            </button>

                        </div>
                    </form>

                </div>
            </div>

            <!-- =====================================================
             INFORMAÇÕES DA BUSCA
        ====================================================== -->

            <?php if (
                $termo !== ''
                &&
                $produtos === []
            ): ?>

                <div
                    class="
            alert
            alert-light
            border
            text-center
            py-5
        "
                    role="alert">

                    <h2
                        class="
                h4
                fw-bold
                mb-3
            ">

                        Nenhum produto encontrado

                    </h2>


                    <p
                        class="
                text-muted
                mb-0
            ">

                        Tente realizar uma nova busca
                        utilizando outro nome,
                        descrição ou categoria.

                    </p>

                </div>

            <?php endif; ?>


            <div class="row mb-4">
                <div class="col-12">

                    <div
                        class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <?php if (
                            $termo !== ''
                        ): ?>

                            <p class="mb-0">

                                Resultado da busca por:

                                <strong>

                                    "<?=
                                        htmlspecialchars(
                                            $termo,
                                            ENT_QUOTES,
                                            'UTF-8'
                                        )
                                        ?>"

                                </strong>

                            </p>


                            <span
                                class="
            badge
            text-bg-secondary
        ">

                                <?=
                                $totalResultados
                                ?>

                                produto(s) encontrado(s)

                            </span>

                        <?php endif; ?>

                    </div>

                </div>
            </div>

            <!-- =====================================================
             CARDS DOS PRODUTOS
        ====================================================== -->




            <!-- =====================================================
     CARDS DOS PRODUTOS
====================================================== -->

            <?php if ($produtos !== []): ?>

                <div class="row g-4">

                    <?php foreach ($produtos as $produto): ?>

                        <?php

                        /*
            |--------------------------------------------------------------------------
            | Dados básicos do produto
            |--------------------------------------------------------------------------
            */

                        $nomeProduto =
                            (string) $produto['nome'];


                        $descricaoProduto =
                            trim(
                                (string) (
                                    $produto['descricao']
                                    ?? ''
                                )
                            );


                        /*
            |--------------------------------------------------------------------------
            | Preço
            |--------------------------------------------------------------------------
            */

                        $precoNormal =
                            (float) $produto['preco'];


                        $precoOferta =
                            isset($produto['preco_oferta'])
                            && $produto['preco_oferta'] !== null
                            ? (float) $produto['preco_oferta']
                            : null;


                        $temOferta =
                            $precoOferta !== null;


                        /*
            |--------------------------------------------------------------------------
            | Percentual da oferta
            |--------------------------------------------------------------------------
            */

                        $percentualOferta =
                            (float) (
                                $produto['percentual_oferta']
                                ?? 0
                            );


                        /*
            |--------------------------------------------------------------------------
            | Valor para parcelamento
            |--------------------------------------------------------------------------
            */

                        $valorParcelar =
                            $temOferta
                            ? $precoOferta
                            : $precoNormal;


                        /*
            |--------------------------------------------------------------------------
            | Parcelas
            |--------------------------------------------------------------------------
            */

                        $quantidadeParcelas = 10;


                        $valorParcela =
                            $valorParcelar
                            / $quantidadeParcelas;


                        /*
            |--------------------------------------------------------------------------
            | Imagem
            |--------------------------------------------------------------------------
            */

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


                        <!-- =================================================
                 PRODUTO
            ================================================== -->

                        <div
                            class="
                    col-12
                    col-sm-6
                    col-lg-4
                    col-xl-3
                ">

                            <div
                                class="
                        card
                        h-100
                        shadow-sm
                        border-0
                    ">


                                <!-- =========================================
                         IMAGEM
                    ========================================== -->

                                <div
                                    class="
                            position-relative
                            p-3
                            text-center
                        ">

                                    <img
                                        src="<?=
                                                htmlspecialchars(
                                                    $imagem,
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                )
                                                ?>"
                                        class="
                                card-img-top
                                img-fluid
                            "
                                        alt="<?=
                                                htmlspecialchars(
                                                    $nomeProduto,
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                )
                                                ?>"
                                        loading="lazy"
                                        onerror="
                                this.onerror=null;
                                this.src='<?=
                                            htmlspecialchars(
                                                $imagemPadrao,
                                                ENT_QUOTES,
                                                'UTF-8'
                                            )
                                            ?>';
                            "
                                        style="
                                height: 220px;
                                object-fit: contain;
                            ">


                                    <!-- DESCONTO -->

                                    <?php if ($temOferta): ?>

                                        <span
                                            class="
                                    badge
                                    text-bg-danger
                                    position-absolute
                                    top-0
                                    end-0
                                    m-3
                                ">

                                            <?=
                                            number_format(
                                                $percentualOferta,
                                                0,
                                                ',',
                                                '.'
                                            )
                                            ?>% OFF

                                        </span>

                                    <?php endif; ?>

                                </div>


                                <!-- =========================================
                         CORPO DO CARD
                    ========================================== -->

                                <div
                                    class="
                            card-body
                            d-flex
                            flex-column
                        ">


                                    <!-- CATEGORIA -->

                                    <div class="mb-2">

                                        <span
                                            class="
                                    badge
                                    text-bg-primary
                                ">

                                            <?=
                                            htmlspecialchars(
                                                (string) $produto['categoria'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            )
                                            ?>

                                        </span>

                                    </div>


                                    <!-- NOME -->

                                    <h2
                                        class="
                                h5
                                card-title
                                fw-semibold
                            ">

                                        <?=
                                        htmlspecialchars(
                                            $nomeProduto,
                                            ENT_QUOTES,
                                            'UTF-8'
                                        )
                                        ?>

                                    </h2>


                                    <!-- DESCRIÇÃO -->

                                    <p
                                        class="
                                card-text
                                text-muted
                                small
                            ">

                                        <?=
                                        htmlspecialchars(
                                            mb_strimwidth(
                                                $descricaoProduto,
                                                0,
                                                120,
                                                '...'
                                            ),
                                            ENT_QUOTES,
                                            'UTF-8'
                                        )
                                        ?>

                                    </p>


                                    <!-- =====================================
                             PREÇO
                        ====================================== -->

                                    <div class="mt-auto">


                                        <?php if ($temOferta): ?>

                                            <!-- PREÇO NORMAL -->

                                            <div class="mb-1">

                                                <small
                                                    class="
                                            text-muted
                                            text-decoration-line-through
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

                                                </small>

                                            </div>


                                            <!-- PREÇO PROMOCIONAL -->

                                            <div
                                                class="
                                        fs-4
                                        fw-bold
                                        text-success
                                        mb-1
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


                                        <?php else: ?>


                                            <!-- PREÇO NORMAL -->

                                            <div
                                                class="
                                        fs-4
                                        fw-bold
                                        text-primary
                                        mb-1
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


                                        <!-- =====================================
                                 PARCELAMENTO
                            ====================================== -->

                                        <p
                                            class="
                                    text-muted
                                    small
                                    mb-3
                                ">

                                            ou

                                            <strong>

                                                <?= $quantidadeParcelas ?>x

                                            </strong>

                                            de

                                            <strong>

                                                R$

                                                <?=
                                                number_format(
                                                    $valorParcela,
                                                    2,
                                                    ',',
                                                    '.'
                                                )
                                                ?>

                                            </strong>

                                            sem juros

                                        </p>


                                        <!-- =====================================
                                 BOTÕES
                            ====================================== -->

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
                                                class="
                                        btn
                                        btn-outline-primary
                                    ">

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

            <?php endif; ?>


            <!-- =====================================================
             EXEMPLO: NENHUM RESULTADO
             Exibir este bloco quando não houver produtos.
        ====================================================== -->
            <!--
        <div class="row">
            <div class="col-12">

                <div
                    class="alert alert-light border text-center py-5"
                    role="alert"
                >
                    <h2 class="h4 fw-bold mb-3">
                        Nenhum produto encontrado
                    </h2>

                    <p class="text-muted mb-0">
                        Tente realizar uma nova busca utilizando
                        outro nome ou palavra-chave.
                    </p>
                </div>

            </div>
        </div>
        -->

        </div>
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