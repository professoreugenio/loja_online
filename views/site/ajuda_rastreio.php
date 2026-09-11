<?php
declare(strict_types=1);
use App\Helpers\View;
$tituloPagina = $tituloPagina   ?? 'Ajuda Rastreio';
$descricaoPagina = $descricaoPagina ?? 'Loja online com produtos, ofertas, atendimento ao cliente e compra segura.';
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
    <title><?= htmlspecialchars($tituloPagina, ENT_QUOTES, 'UTF-8');  ?></title>
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
    ============================================================= -->
    <?php require_once APP_ROOT  . '/views/componentes/site/sections/barraSuperior.php'; ?>
    <!-- ============================================================
         2. MENU PRINCIPAL
    ============================================================= -->
    <?php View::componente('header', ['categorias' => $categorias, 'quantidadeCarrinho' => $quantidadeCarrinho,]); ?>
    <main class="py-5 bg-body-tertiary">
    <section class="container">
        <!-- TÍTULO -->
        <div class="row justify-content-center mb-5">
            <div class="col-12 col-lg-8 text-center">
                <span class="badge text-bg-success mb-3">
                    Acompanhe sua entrega
                </span>
                <h1 class="display-6 fw-bold mb-3">
                    Rastrear Pedido
                </h1>
                <p class="lead text-muted mb-0">
                    Informe o código do pedido para consultar
                    o andamento da sua compra.
                </p>
            </div>
        </div>
        <div class="row justify-content-center g-4">
            <div class="col-12 col-lg-8">
                <!-- FORMULÁRIO -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 p-lg-5">
                        <?php if (
                            !empty($mensagemErro)
                        ): ?>
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
                        <form
                            action="<?=
                                htmlspecialchars(
                                    $baseUrl
                                    . '/ajuda/rastreio',
                                    ENT_QUOTES,
                                    'UTF-8'
                                )
                            ?>"
                            method="get">
                            <label
                                for="codigo"
                                class="form-label fw-semibold">
                                Código do pedido
                            </label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text">
                                    📦
                                </span>
                                <input
                                    type="text"
                                    id="codigo"
                                    name="codigo"
                                    class="form-control"
                                    placeholder="Ex.: PED-20260911-ABC123"
                                    maxlength="40"
                                    value="<?=
                                        htmlspecialchars(
                                            (string) (
                                                $_GET['codigo']
                                                ?? ''
                                            ),
                                            ENT_QUOTES,
                                            'UTF-8'
                                        )
                                    ?>"
                                    required>
                                <button
                                    type="submit"
                                    class="btn btn-success">
                                    Consultar
                                </button>
                            </div>
                            <div class="form-text mt-2">
                                O código pode ser encontrado
                                nos detalhes do pedido.
                            </div>
                        </form>
                    </div>
                </div>
                <!-- RESULTADO -->
                <?php if (
                    !empty($pedido)
                    &&
                    is_array($pedido)
                ): ?>
                    <div class="card border-0 shadow-sm mt-4">
                        <div class="card-header bg-white py-3">
                            <div
                                class="
                                    d-flex
                                    justify-content-between
                                    align-items-center
                                    flex-wrap
                                    gap-2
                                ">
                                <h2 class="h5 mb-0">
                                    Pedido
                                    <?=
                                        htmlspecialchars(
                                            $pedido['codigo'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        )
                                    ?>
                                </h2>
                                <span class="badge text-bg-primary">
                                    <?=
                                        htmlspecialchars(
                                            $pedido[
                                                'status_formatado'
                                            ]
                                            ?? $pedido['status'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        )
                                    ?>
                                </span>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <div class="col-12 col-md-4">
                                    <small
                                        class="
                                            text-muted
                                            d-block
                                        ">
                                        Data do pedido
                                    </small>
                                    <strong>
                                        <?=
                                            htmlspecialchars(
                                                $pedido[
                                                    'criado_em_formatado'
                                                ]
                                                ?? $pedido['criado_em'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            )
                                        ?>
                                    </strong>
                                </div>
                                <div class="col-12 col-md-4">
                                    <small
                                        class="
                                            text-muted
                                            d-block
                                        ">
                                        Total
                                    </small>
                                    <strong>
                                        R$
                                        <?=
                                            number_format(
                                                (float)
                                                $pedido['total'],
                                                2,
                                                ',',
                                                '.'
                                            )
                                        ?>
                                    </strong>
                                </div>
                                <div class="col-12 col-md-4">
                                    <small
                                        class="
                                            text-muted
                                            d-block
                                        ">
                                        Código de rastreio
                                    </small>
                                    <strong>
                                        <?=
                                            htmlspecialchars(
                                                $pedido[
                                                    'codigo_rastreio'
                                                ]
                                                ?? 'Ainda não disponível',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            )
                                        ?>
                                    </strong>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <!-- ORIENTAÇÕES -->
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-body p-4">
                        <h2 class="h5 fw-bold mb-3">
                            Etapas do pedido
                        </h2>
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <strong>
                                        1. Pagamento
                                    </strong>
                                    <p class="text-muted small mb-0 mt-2">
                                        A loja aguarda a confirmação
                                        segura do pagamento.
                                    </p>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <strong>
                                        2. Separação
                                    </strong>
                                    <p class="text-muted small mb-0 mt-2">
                                        Os produtos são preparados
                                        para a entrega.
                                    </p>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <strong>
                                        3. Envio
                                    </strong>
                                    <p class="text-muted small mb-0 mt-2">
                                        O pedido é entregue à
                                        transportadora.
                                    </p>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <strong>
                                        4. Entrega
                                    </strong>
                                    <p class="text-muted small mb-0 mt-2">
                                        O pedido chega ao endereço
                                        informado na compra.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4 text-center">
                    <a
                        href="<?=
                            htmlspecialchars(
                                $baseUrl
                                . '/ajuda/central',
                                ENT_QUOTES,
                                'UTF-8'
                            )
                        ?>"
                        class="btn btn-outline-secondary">
                        ← Voltar para a Central de Ajuda
                    </a>
                </div>
            </div>
        </div>
    </section>
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