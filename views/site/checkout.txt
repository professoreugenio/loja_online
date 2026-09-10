<?php

declare(strict_types=1);

use App\Helpers\View;

$tituloPagina =
    $tituloPagina
    ?? 'Finalizar Compra';

$descricaoPagina =
    $descricaoPagina
    ?? 'Confira o endereço e os valores da compra.';

$quantidadeCarrinho =
    $quantidadeCarrinho
    ?? 0;

$baseUrl =
    defined('BASE_URL')
        ? BASE_URL
        : '';

?>
<!doctype html>

<html lang="pt-BR">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1">

    <meta
        name="description"
        content="<?=
            htmlspecialchars(
                $descricaoPagina,
                ENT_QUOTES,
                'UTF-8'
            )
        ?>">

    <title>
        <?=
            htmlspecialchars(
                $tituloPagina,
                ENT_QUOTES,
                'UTF-8'
            )
        ?>
    </title>

    <base href="<?= BASE_URL ?>/">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="<?=
            htmlspecialchars(
                $baseUrl
                . '/assets/css/site.css',
                ENT_QUOTES,
                'UTF-8'
            )
        ?>">

</head>

<body>

    <?php
    require_once APP_ROOT
        . '/views/componentes/site/sections/barraSuperior.php';
    ?>

    <?php
    View::componente(
        'header',
        [
            'categorias' =>
                $categorias,

            'quantidadeCarrinho' =>
                $quantidadeCarrinho,
        ]
    );
    ?>

    <main class="py-5">

        <div class="container">

            <div class="row mb-4">

                <div class="col-12">

                    <h1 class="h2 fw-bold">
                        Finalizar compra
                    </h1>

                    <p class="text-muted mb-0">
                        Escolha o endereço de entrega
                        e confira os valores do pedido.
                    </p>

                </div>

            </div>

            <?php if ($mensagemErro): ?>

                <div class="alert alert-danger">

                    <?=
                        htmlspecialchars(
                            $mensagemErro,
                            ENT_QUOTES,
                            'UTF-8'
                        )
                    ?>

                </div>

            <?php endif; ?>

            <div class="row g-4">

                <!-- ENDEREÇOS -->
                <div class="col-12 col-lg-8">

                    <div class="card border-0 shadow-sm">

                        <div class="card-header bg-white py-3">

                            <h2 class="h5 mb-0">
                                Endereço de entrega
                            </h2>

                        </div>

                        <div class="card-body">

                            <?php if ($enderecos === []): ?>

                                <div class="alert alert-warning">

                                    Você ainda não possui
                                    um endereço cadastrado.

                                </div>

                                <a
                                    href="<?=
                                        htmlspecialchars(
                                            $baseUrl
                                            . '/cliente/enderecos',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        )
                                    ?>"
                                    class="btn btn-primary">

                                    Cadastrar endereço

                                </a>

                            <?php else: ?>

                                <form
                                    id="form-checkout"
                                    action="<?=
                                        htmlspecialchars(
                                            $baseUrl
                                            . '/checkout/finalizar',
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

                                    <?php foreach (
                                        $enderecos
                                        as $endereco
                                    ): ?>

                                        <div
                                            class="
                                                form-check
                                                border
                                                rounded
                                                p-3
                                                mb-3
                                            ">

                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="endereco"
                                                id="endereco-<?=
                                                    (int)
                                                    $endereco['id']
                                                ?>"
                                                value="<?=
                                                    htmlspecialchars(
                                                        $endereco[
                                                            'id_seguro'
                                                        ],
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    )
                                                ?>"
                                                <?=
                                                    (int)
                                                    $endereco['principal']
                                                    === 1
                                                        ? 'checked'
                                                        : ''
                                                ?>
                                                required>

                                            <label
                                                class="
                                                    form-check-label
                                                    ms-2
                                                "
                                                for="endereco-<?=
                                                    (int)
                                                    $endereco['id']
                                                ?>">

                                                <strong>

                                                    <?=
                                                        htmlspecialchars(
                                                            $endereco[
                                                                'identificacao'
                                                            ],
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        )
                                                    ?>

                                                </strong>

                                                <?php if (
                                                    (int)
                                                    $endereco['principal']
                                                    === 1
                                                ): ?>

                                                    <span
                                                        class="
                                                            badge
                                                            text-bg-primary
                                                            ms-2
                                                        ">

                                                        Principal

                                                    </span>

                                                <?php endif; ?>

                                                <br>

                                                <?=
                                                    htmlspecialchars(
                                                        $endereco[
                                                            'destinatario'
                                                        ],
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    )
                                                ?>

                                                <br>

                                                <?=
                                                    htmlspecialchars(
                                                        $endereco[
                                                            'logradouro'
                                                        ]
                                                        . ', '
                                                        . $endereco[
                                                            'numero'
                                                        ],
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    )
                                                ?>

                                                <?php if (
                                                    !empty(
                                                        $endereco[
                                                            'complemento'
                                                        ]
                                                    )
                                                ): ?>

                                                    <br>

                                                    <?=
                                                        htmlspecialchars(
                                                            $endereco[
                                                                'complemento'
                                                            ],
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        )
                                                    ?>

                                                <?php endif; ?>

                                                <br>

                                                <?=
                                                    htmlspecialchars(
                                                        $endereco[
                                                            'bairro'
                                                        ]
                                                        . ' — '
                                                        . $endereco[
                                                            'cidade'
                                                        ]
                                                        . '/'
                                                        . $endereco[
                                                            'estado'
                                                        ],
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    )
                                                ?>

                                                <br>

                                                CEP:

                                                <?=
                                                    htmlspecialchars(
                                                        $endereco['cep'],
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    )
                                                ?>

                                            </label>

                                        </div>

                                    <?php endforeach; ?>

                                </form>

                            <?php endif; ?>

                        </div>

                    </div>

                </div>

                <!-- RESUMO -->
                <div class="col-12 col-lg-4">

                    <div
                        class="card border-0 shadow-sm"
                        style="position: sticky; top: 20px;">

                        <div class="card-header bg-white py-3">

                            <h2 class="h5 mb-0">
                                Resumo da compra
                            </h2>

                        </div>

                        <div class="card-body">

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

                            <div
                                class="
                                    d-flex
                                    justify-content-between
                                    mb-3
                                ">

                                <span class="text-muted">
                                    Frete
                                </span>

                                <span>

                                    R$

                                    <?=
                                        number_format(
                                            $frete,
                                            2,
                                            ',',
                                            '.'
                                        )
                                    ?>

                                </span>

                            </div>

                            <?php if (
                                $prazoEntrega !== null
                            ): ?>

                                <div
                                    class="
                                        d-flex
                                        justify-content-between
                                        mb-3
                                    ">

                                    <span class="text-muted">
                                        Prazo
                                    </span>

                                    <span>

                                        <?=
                                            (int)
                                            $prazoEntrega
                                        ?>

                                        dias úteis

                                    </span>

                                </div>

                            <?php endif; ?>

                            <div
                                class="
                                    d-flex
                                    justify-content-between
                                    mb-3
                                ">

                                <span class="text-muted">
                                    Desconto
                                </span>

                                <span class="text-success">

                                    - R$

                                    <?=
                                        number_format(
                                            $desconto,
                                            2,
                                            ',',
                                            '.'
                                        )
                                    ?>

                                </span>

                            </div>

                            <hr>

                            <div
                                class="
                                    d-flex
                                    justify-content-between
                                    align-items-center
                                    mb-4
                                ">

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

                            <?php if (
                                $enderecos !== []
                            ): ?>

                                <button
                                    type="submit"
                                    form="form-checkout"
                                    class="
                                        btn
                                        btn-success
                                        btn-lg
                                        w-100
                                    ">

                                    Ir para o pagamento

                                </button>

                            <?php endif; ?>

                            <a
                                href="<?=
                                    htmlspecialchars(
                                        $baseUrl
                                        . '/carrinho',
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

                                Voltar ao carrinho

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </main>

    <?php View::componente('footer'); ?>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
    </script>

</body>

</html>