<?php

declare(strict_types=1);

use App\Helpers\View;

$tituloPagina =
    $tituloPagina
    ?? 'Fale conosco';
$descricaoPagina =
    $descricaoPagina
    ?? 'Entre em contato com nossa equipe.';
$quantidadeCarrinho =
    $quantidadeCarrinho
    ?? 0;
$baseUrl =
    defined('BASE_URL')
    ? BASE_URL
    : '';
$mensagemSucesso =
    $mensagemSucesso
    ?? null;
$mensagemErro =
    $mensagemErro
    ?? null;
$dadosAntigos =
    is_array($dadosAntigos ?? null)
    ? $dadosAntigos
    : [];
?>
<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta
    name="description"
    content="<?=
        htmlspecialchars(
            $descricaoPagina,
            ENT_QUOTES,
            'UTF-8'
        )
    ?>">

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
            <div class="row justify-content-center mb-5">
                <div class="col-12 col-lg-8 text-center">
                    <span class="badge text-bg-primary mb-3">
                        Atendimento
                    </span>
                    <h1 class="display-6 fw-bold mb-3">
                        Fale conosco
                    </h1>
                    <p class="lead text-muted mb-0">
                        Envie sua dúvida, sugestão ou
                        solicitação para nossa equipe.
                    </p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-12 col-lg-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4 p-lg-5">
                            <?php if ($mensagemSucesso): ?>
                                <div
                                    class="alert alert-success"
                                    role="alert">
                                    <?=
                                    htmlspecialchars(
                                        $mensagemSucesso,
                                        ENT_QUOTES,
                                        'UTF-8'
                                    )
                                    ?>
                                </div>
                            <?php endif; ?>
                            <?php if ($mensagemErro): ?>
                                <div
                                    class="alert alert-danger"
                                    role="alert">
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
                                                . '/ajuda/contato/enviar',
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
                                <div
                                    class="d-none"
                                    aria-hidden="true">
                                    <label for="website">
                                        Não preencha
                                    </label>
                                    <input
                                        type="text"
                                        id="website"
                                        name="website"
                                        tabindex="-1"
                                        autocomplete="off">
                                </div>
                                <div class="row g-3">
                                    <div class="col-12 col-md-6">
                                        <label
                                            for="nome"
                                            class="form-label">
                                            Nome completo
                                        </label>
                                        <input
                                            type="text"
                                            id="nome"
                                            name="nome"
                                            class="form-control"
                                            maxlength="150"
                                            value="<?=
                                                    htmlspecialchars(
                                                        $dadosAntigos['nome']
                                                            ?? '',
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    )
                                                    ?>"
                                            required>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label
                                            for="email"
                                            class="form-label">
                                            E-mail
                                        </label>
                                        <input
                                            type="email"
                                            id="email"
                                            name="email"
                                            class="form-control"
                                            maxlength="180"
                                            value="<?=
                                                    htmlspecialchars(
                                                        $dadosAntigos['email']
                                                            ?? '',
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    )
                                                    ?>"
                                            required>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label
                                            for="telefone"
                                            class="form-label">
                                            Telefone
                                        </label>
                                        <input
                                            type="tel"
                                            id="telefone"
                                            name="telefone"
                                            class="form-control"
                                            maxlength="20"
                                            placeholder="(85) 99999-9999"
                                            value="<?=
                                                    htmlspecialchars(
                                                        $dadosAntigos['telefone']
                                                            ?? '',
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    )
                                                    ?>">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label
                                            for="pedido"
                                            class="form-label">
                                            Código do pedido
                                        </label>
                                        <input
                                            type="text"
                                            id="pedido"
                                            name="pedido"
                                            class="form-control"
                                            maxlength="40"
                                            placeholder="Opcional"
                                            value="<?=
                                                    htmlspecialchars(
                                                        $dadosAntigos['pedido']
                                                            ?? '',
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    )
                                                    ?>">
                                    </div>
                                    <div class="col-12">
                                        <label
                                            for="assunto"
                                            class="form-label">
                                            Assunto
                                        </label>
                                        <select
                                            id="assunto"
                                            name="assunto"
                                            class="form-select"
                                            required>
                                            <option value="">
                                                Selecione
                                            </option>
                                            <?php
                                            $assuntos = [
                                                'Pedido',
                                                'Pagamento',
                                                'Entrega',
                                                'Troca ou devolução',
                                                'Produto',
                                                'Outros',
                                            ];
                                            foreach (
                                                $assuntos as $assunto
                                            ):
                                            ?>
                                                <option
                                                    value="<?=
                                                            htmlspecialchars(
                                                                $assunto,
                                                                ENT_QUOTES,
                                                                'UTF-8'
                                                            )
                                                            ?>"
                                                    <?=
                                                    ($dadosAntigos['assunto'] ?? '')
                                                        === $assunto
                                                        ? 'selected'
                                                        : ''
                                                    ?>>
                                                    <?=
                                                    htmlspecialchars(
                                                        $assunto,
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    )
                                                    ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label
                                            for="mensagem"
                                            class="form-label">
                                            Mensagem
                                        </label>
                                        <textarea
                                            id="mensagem"
                                            name="mensagem"
                                            class="form-control"
                                            rows="7"
                                            minlength="10"
                                            maxlength="3000"
                                            required><?=
                                                        htmlspecialchars(
                                                            $dadosAntigos['mensagem']
                                                                ?? '',
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        )
                                                        ?></textarea>
                                        <div class="form-text">
                                            Máximo de 3.000 caracteres.
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input
                                                type="checkbox"
                                                id="aceite"
                                                name="aceite"
                                                value="1"
                                                class="form-check-input"
                                                required>
                                            <label
                                                for="aceite"
                                                class="form-check-label">
                                                Autorizo o uso dos dados
                                                para responder esta mensagem.
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button
                                            type="submit"
                                            class="btn btn-primary btn-lg">
                                            Enviar mensagem
                                        </button>
                                        <a
                                            href="<?=
                                                    htmlspecialchars(
                                                        $baseUrl
                                                            . '/ajuda/central',
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    )
                                                    ?>"
                                            class="btn btn-outline-secondary btn-lg">
                                            Voltar
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <aside class="col-12 col-lg-4">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h2 class="h5 fw-bold">
                                Antes de enviar
                            </h2>
                            <ul class="text-muted mb-0">
                                <li>Informe um e-mail válido;</li>
                                <li>Descreva sua dúvida claramente;</li>
                                <li>Informe o pedido, se existir;</li>
                                <li>Não envie senhas ou dados bancários.</li>
                            </ul>
                        </div>
                    </div>
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h2 class="h5 fw-bold">
                                Dúvidas rápidas
                            </h2>
                            <p class="text-muted">
                                Consulte também as perguntas frequentes.
                            </p>
                            <a
                                href="<?=
                                        htmlspecialchars(
                                            $baseUrl
                                                . '/ajuda/perguntas',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        )
                                        ?>"
                                class="btn btn-outline-primary w-100">
                                Ver perguntas frequentes
                            </a>
                        </div>
                    </div>
                </aside>
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