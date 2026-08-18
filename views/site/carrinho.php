<?php

declare(strict_types=1);

use App\Helpers\View;

$tituloPagina = $tituloPagina   ?? 'Carrinho';
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

            <!-- TÍTULO DA PÁGINA -->
            <div class="row mb-4">
                <div class="col-12">
                    <h1 class="h2 fw-bold mb-2">
                        Carrinho de Compras
                    </h1>

                    <p class="text-muted mb-0">
                        Confira os produtos adicionados ao seu carrinho antes de finalizar a compra.
                    </p>
                </div>
            </div>

            <div class="row g-4">

                <!-- =====================================================
                 PRODUTOS DO CARRINHO
            ====================================================== -->
                <div class="col-12 col-lg-8">

                    <div class="card border-0 shadow-sm">

                        <div class="card-header bg-white py-3">
                            <h2 class="h5 mb-0">
                                Produtos
                            </h2>
                        </div>

                        <div class="card-body">


                            <?php if (
                                $mensagemSucesso
                            ): ?>

                                <div
                                    class="
            alert
            alert-success
        ">

                                    <?=
                                    htmlspecialchars(
                                        $mensagemSucesso,
                                        ENT_QUOTES,
                                        'UTF-8'
                                    )
                                    ?>

                                </div>

                            <?php endif; ?>


                            <?php if (
                                $mensagemErro
                            ): ?>

                                <div
                                    class="
            alert
            alert-danger
        ">

                                    <?=
                                    htmlspecialchars(
                                        $mensagemErro,
                                        ENT_QUOTES,
                                        'UTF-8'
                                    )
                                    ?>

                                </div>

                            <?php endif; ?>


                            <?php foreach ($itens as $item): ?>

                                <?php

                                $imagem =
                                    trim(
                                        (string) (
                                            $item['imagem']
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


                                <?php if ($itens === []): ?>

                                    <div class="text-center py-5">

                                        <h2 class="h4">
                                            Seu carrinho está vazio
                                        </h2>

                                        <p class="text-muted">
                                            Adicione produtos para
                                            continuar sua compra.
                                        </p>

                                        <a
                                            href="<?=
                                                    htmlspecialchars(
                                                        $baseUrl
                                                            . '/produtos',
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    )
                                                    ?>"
                                            class="btn btn-primary">
                                            Ver produtos
                                        </a>

                                    </div>

                                <?php endif; ?>


                                <div
                                    class="
                row
                align-items-center
                g-3
                py-3
                border-bottom
            ">

                                    <!-- ================================================
                 IMAGEM
            ================================================= -->
                                    <div
                                        class="
                    col-4
                    col-md-2
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
                        img-fluid
                        rounded
                    "
                                            alt="<?=
                                                    htmlspecialchars(
                                                        $item['nome'],
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    )
                                                    ?>"
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
                        height: 100px;
                        width: 100%;
                        object-fit: contain;
                    ">

                                    </div>


                                    <!-- ================================================
                 INFORMAÇÕES DO PRODUTO
            ================================================= -->
                                    <div
                                        class="
                    col-8
                    col-md-3
                ">

                                        <h3
                                            class="
                        h6
                        fw-bold
                        mb-1
                    ">
                                            <?=
                                            htmlspecialchars(
                                                $item['nome'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            )
                                            ?>
                                        </h3>

                                        <p
                                            class="
                        text-muted
                        small
                        mb-1
                    ">
                                            <?=
                                            htmlspecialchars(
                                                mb_strimwidth(
                                                    (string) $item['descricao'],
                                                    0,
                                                    70,
                                                    '...'
                                                ),
                                                ENT_QUOTES,
                                                'UTF-8'
                                            )
                                            ?>
                                        </p>

                                        <a
                                            href="<?=
                                                    htmlspecialchars(
                                                        $baseUrl
                                                            . '/produto/detalhes?prod='
                                                            . urlencode(
                                                                $item['id_seguro']
                                                            ),
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    )
                                                    ?>"
                                            class="
                        small
                        text-decoration-none
                    ">
                                            Ver produto
                                        </a>

                                    </div>


                                    <!-- ================================================
                 QUANTIDADE
            ================================================= -->
                                    <div
                                        class="
                    col-6
                    col-md-3
                ">

                                        <form
                                            action="<?=
                                                    htmlspecialchars(
                                                        $baseUrl
                                                            . '/carrinho/atualizar',
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
                                                            $csrfToken,
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        )
                                                        ?>">

                                            <input
                                                type="hidden"
                                                name="produto"
                                                value="<?=
                                                        htmlspecialchars(
                                                            $item['id_seguro'],
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        )
                                                        ?>">

                                            <label
                                                class="
                            form-label
                            small
                        ">
                                                Quantidade
                                            </label>

                                            <div
                                                class="
                            input-group
                            input-group-sm
                        ">

                                                <input
                                                    type="number"
                                                    name="quantidade"
                                                    class="
                                form-control
                                text-center
                            "
                                                    value="<?=
                                                            (int) $item['quantidade']
                                                            ?>"
                                                    min="1"
                                                    max="<?=
                                                            max(
                                                                1,
                                                                (int) $item['estoque']
                                                            )
                                                            ?>">

                                                <button
                                                    type="submit"
                                                    class="
                                btn
                                btn-outline-secondary
                            ">
                                                    Atualizar
                                                </button>

                                            </div>

                                        </form>

                                    </div>


                                    <!-- ================================================
                 PREÇO
            ================================================= -->
                                    <div
                                        class="
                    col-6
                    col-md-2
                    text-md-end
                ">

                                        <small
                                            class="
                        text-muted
                        d-block
                    ">
                                            Unitário
                                        </small>

                                        <strong>
                                            R$
                                            <?=
                                            number_format(
                                                (float) $item['preco_unitario'],
                                                2,
                                                ',',
                                                '.'
                                            )
                                            ?>
                                        </strong>

                                        <small
                                            class="
                        text-muted
                        d-block
                        mt-1
                    ">
                                            Subtotal:

                                            R$
                                            <?=
                                            number_format(
                                                (float) $item['subtotal'],
                                                2,
                                                ',',
                                                '.'
                                            )
                                            ?>
                                        </small>

                                    </div>


                                    <!-- ================================================
                 REMOVER
            ================================================= -->
                                    <div
                                        class="
                    col-12
                    col-md-2
                    text-md-end
                ">

                                        <form
                                            action="<?=
                                                    htmlspecialchars(
                                                        $baseUrl
                                                            . '/carrinho/remover',
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
                                                            $csrfToken,
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        )
                                                        ?>">

                                            <input
                                                type="hidden"
                                                name="produto"
                                                value="<?=
                                                        htmlspecialchars(
                                                            $item['id_seguro'],
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        )
                                                        ?>">

                                            <button
                                                type="submit"
                                                class="
                            btn
                            btn-outline-danger
                            btn-sm
                        ">
                                                Remover
                                            </button>

                                        </form>

                                    </div>

                                </div>

                            <?php endforeach; ?>

                        </div>

                    </div>





                    <!-- =================================================
                     CALCULAR FRETE
                ================================================== -->
                    <div class="card border-0 shadow-sm mt-4">

                        <div class="card-body">

                            <h2 class="h5 mb-3">
                                Calcular frete
                            </h2>

                            <div class="row g-2">

                                <div class="col-12 col-md-8">

                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Digite seu CEP"
                                        maxlength="9">

                                </div>

                                <div class="col-12 col-md-4">

                                    <button
                                        type="button"
                                        class="btn btn-outline-secondary w-100">
                                        Calcular frete
                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>


                    <!-- CONTINUAR COMPRANDO -->
                    <div class="mt-4">

                        <a
                            href="produtos"
                            class="btn btn-outline-secondary">
                            ← Continuar comprando
                        </a>

                    </div>

                </div>


                <!-- =====================================================
                 RESUMO DO PEDIDO
            ====================================================== -->
                <div class="col-12 col-lg-4">

                    <div
                        class="card border-0 shadow-sm"
                        style="position: sticky; top: 20px;">

                        <div class="card-header bg-white py-3">

                            <h2 class="h5 mb-0">
                                Resumo do Pedido
                            </h2>

                        </div>

                        <div class="card-body">

                            <!-- Subtotal -->
                            <div
                                class="
        d-flex
        justify-content-between
        mb-3
    ">

                                <span class="text-muted">

                                    Subtotal

                                </span>


                                <span>

                                    R$

                                    <?=
                                    number_format(
                                        $subtotal,
                                        2,
                                        ',',
                                        '.'
                                    )
                                    ?>

                                </span>

                            </div>



                            <!-- Desconto -->
                            <div class="d-flex justify-content-between mb-3">

                                <span class="text-muted">
                                    Desconto
                                </span>

                                <span class="text-success">
                                    - R$ 0,00
                                </span>

                            </div>


                            <!-- Frete -->
                            <div class="d-flex justify-content-between mb-3">

                                <span class="text-muted">
                                    Frete
                                </span>

                                <span>
                                    A calcular
                                </span>

                            </div>


                            <hr>


                            <!-- TOTAL -->
                            <div class="d-flex justify-content-between align-items-center mb-2">

                                <strong class="fs-5">
                                    Total
                                </strong>

                                <strong
                                    class="
        fs-4
        text-primary
    ">

                                    R$

                                    <?=
                                    number_format(
                                        $total,
                                        2,
                                        ',',
                                        '.'
                                    )
                                    ?>

                                </strong>


                            </div>


                            <!-- Parcelamento -->
                            <p
                                class="
        text-muted
        small
        text-end
        mb-4
    ">

                                ou

                                <?=
                                $quantidadeParcelas
                                ?>x

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



                            <!-- FINALIZAR -->
                            <div class="d-grid">

                                <a
                                    href="checkout"
                                    class="btn btn-success btn-lg">
                                    Finalizar Compra
                                </a>

                            </div>


                            <!-- Compra segura -->
                            <div class="text-center mt-3">

                                <small class="text-muted">
                                    Compra segura e protegida
                                </small>

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
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>