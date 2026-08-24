<?php

declare(strict_types=1);

use App\Helpers\View;

$baseUrl = defined('BASE_URL')
    ? rtrim(BASE_URL, '/')
    : '';

$produto = is_array($produto ?? null)
    ? $produto
    : [];

$produtoToken =
    (string) ($produtoToken ?? '');

$imagens = is_array($imagens ?? null)
    ? $imagens
    : [];

$csrfToken =
    (string) ($csrfToken ?? '');

$erro =
    isset($erro)
        ? (string) $erro
        : '';

$sucesso =
    isset($sucesso)
        ? (string) $sucesso
        : '';

?>
<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>
        Imagens do Produto | Loja Online
    </title>

    <meta
        name="description"
        content="Gerenciamento das imagens do produto."
    >

    <base href="/loja_online/public/">

    <link
        rel="icon"
        href="assets/img/favicon.ico"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="<?= htmlspecialchars(
            $baseUrl . '/assets/css/admin.css',
            ENT_QUOTES,
            'UTF-8'
        ); ?>"
    >
</head>

<body>

    <?php View::componenteAdmin('aside'); ?>

    <div
        class="offcanvas offcanvas-start offcanvas-dashboard"
        tabindex="-1"
        id="menuMobile"
    >
        <div class="offcanvas-header border-bottom border-secondary">
            <div>
                <h2 class="offcanvas-title h5 mb-0">
                    Loja Online
                </h2>

                <small class="text-white-50">
                    Painel administrativo
                </small>
            </div>

            <button
                class="btn-close"
                type="button"
                data-bs-dismiss="offcanvas"
                aria-label="Fechar menu"
            ></button>
        </div>

        <div class="offcanvas-body">
            <nav
                class="sidebar-nav p-0"
                aria-label="Menu móvel"
            >
                <a
                    class="sidebar-link"
                    href="admin"
                >
                    <i class="bi bi-grid-1x2-fill"></i>
                    Dashboard
                </a>

                <a
                    class="sidebar-link active"
                    href="admin/produtos"
                >
                    <i class="bi bi-box-seam-fill"></i>
                    Produtos
                </a>

                <a
                    class="sidebar-link"
                    href="admin/categorias"
                >
                    <i class="bi bi-tags-fill"></i>
                    Categorias
                </a>
            </nav>
        </div>
    </div>

    <div class="main-wrapper">

        <?php View::componenteAdmin('header'); ?>

        <main class="content-area">
            <div class="container-fluid p-0">

                <!-- CABEÇALHO -->
                <section class="mb-4">
                    <div
                        class="d-flex flex-column
                               flex-md-row
                               justify-content-between
                               align-items-md-center
                               gap-3"
                    >
                        <div>
                            <div class="mb-2">
                                <a
                                    href="admin/produto/editar?id=<?= rawurlencode(
                                        $produtoToken
                                    ); ?>"
                                    class="text-decoration-none"
                                >
                                    <i class="bi bi-arrow-left me-1"></i>
                                    Voltar para editar produto
                                </a>
                            </div>

                            <h1 class="h3 fw-bold mb-1">
                                Imagens do produto
                            </h1>

                            <p class="text-secondary mb-0">
                                <?= htmlspecialchars(
                                    (string) (
                                        $produto['nome']
                                        ?? 'Produto'
                                    ),
                                    ENT_QUOTES,
                                    'UTF-8'
                                ); ?>
                            </p>
                        </div>

                        <span class="badge text-bg-light border">
                            <?= number_format(
                                count($imagens),
                                0,
                                ',',
                                '.'
                            ); ?>
                            <?= count($imagens) === 1
                                ? 'imagem'
                                : 'imagens'; ?>
                        </span>
                    </div>
                </section>

                <!-- MENSAGENS -->
                <?php if ($erro !== ''): ?>
                    <div
                        class="alert alert-danger alert-dismissible fade show"
                        role="alert"
                    >
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>

                        <?= htmlspecialchars(
                            $erro,
                            ENT_QUOTES,
                            'UTF-8'
                        ); ?>

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="alert"
                            aria-label="Fechar"
                        ></button>
                    </div>
                <?php endif; ?>

                <?php if ($sucesso !== ''): ?>
                    <div
                        class="alert alert-success alert-dismissible fade show"
                        role="alert"
                    >
                        <i class="bi bi-check-circle-fill me-2"></i>

                        <?= htmlspecialchars(
                            $sucesso,
                            ENT_QUOTES,
                            'UTF-8'
                        ); ?>

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="alert"
                            aria-label="Fechar"
                        ></button>
                    </div>
                <?php endif; ?>

                <!-- UPLOAD -->
                <section class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-body py-3">
                        <h2 class="h5 fw-bold mb-1">
                            Enviar imagens
                        </h2>

                        <small class="text-secondary">
                            Selecione uma ou várias imagens.
                        </small>
                    </div>

                    <div class="card-body">
                        <form
                            action="admin/produto/imagens/upload"
                            method="post"
                            enctype="multipart/form-data"
                        >
                            <input
                                type="hidden"
                                name="id"
                                value="<?= htmlspecialchars(
                                    $produtoToken,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ); ?>"
                            >

                            <input
                                type="hidden"
                                name="csrf_token"
                                value="<?= htmlspecialchars(
                                    $csrfToken,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ); ?>"
                            >

                            <div class="row g-3 align-items-end">

                                <div class="col-12 col-lg-9">
                                    <label
                                        for="imagens"
                                        class="form-label fw-semibold"
                                    >
                                        Imagens
                                    </label>

                                    <input
                                        type="file"
                                        class="form-control"
                                        id="imagens"
                                        name="imagens[]"
                                        accept="image/jpeg,image/png,image/webp"
                                        multiple
                                        required
                                    >

                                    <div class="form-text">
                                        Formatos: JPG, PNG ou WebP.
                                        A imagem pode ser enviada em qualquer largura.
                                        O servidor ajustará automaticamente para
                                        <strong>1024 px de largura</strong>, manterá a proporção,
                                        converterá para WebP e comprimirá para até
                                        <strong>120 KB</strong>.
                                    </div>
                                </div>

                                <div class="col-12 col-lg-3">
                                    <div class="d-grid">
                                        <button
                                            type="submit"
                                            class="btn btn-primary"
                                        >
                                            <i class="bi bi-cloud-arrow-up me-1"></i>
                                            Enviar imagens
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </section>

                <!-- LISTA -->
                <section>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h2 class="h5 fw-bold mb-1">
                                Imagens cadastradas
                            </h2>

                            <small class="text-secondary">
                                A imagem principal é exibida nas telas do produto.
                            </small>
                        </div>
                    </div>

                    <?php if ($imagens === []): ?>

                        <div class="card border-0 shadow-sm">
                            <div class="card-body py-5 text-center">
                                <i class="bi bi-images display-5 text-secondary"></i>

                                <h3 class="h5 mt-3">
                                    Nenhuma imagem cadastrada
                                </h3>

                                <p class="text-secondary mb-0">
                                    Utilize o formulário acima para enviar as primeiras imagens.
                                </p>
                            </div>
                        </div>

                    <?php else: ?>

                        <div class="row g-3">
                            <?php foreach ($imagens as $imagem): ?>
                                <?php
                                $imagemToken =
                                    (string) (
                                        $imagem['id_seguro']
                                        ?? ''
                                    );

                                $urlImagem =
                                    (string) (
                                        $imagem['url_imagem']
                                        ?? ''
                                    );

                                $principal =
                                    (int) (
                                        $imagem['principal']
                                        ?? 0
                                    ) === 1;
                                ?>

                                <div class="col-12 col-sm-6 col-lg-4 col-xxl-3">
                                    <article class="card h-100 border-0 shadow-sm">

                                        <div class="position-relative">
                                            <img
                                                src="<?= htmlspecialchars(
                                                    $urlImagem,
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ); ?>"
                                                class="card-img-top border-bottom"
                                                alt="<?= htmlspecialchars(
                                                    (string) (
                                                        $imagem['texto_alternativo']
                                                        ?? $produto['nome']
                                                        ?? 'Imagem do produto'
                                                    ),
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ); ?>"
                                                style="height: 240px; object-fit: contain;"
                                                onerror="this.onerror=null;this.src='assets/img/sem-imagem.jpg';"
                                            >

                                            <?php if ($principal): ?>
                                                <span
                                                    class="position-absolute top-0 start-0
                                                           m-2 badge text-bg-success"
                                                >
                                                    <i class="bi bi-star-fill me-1"></i>
                                                    Principal
                                                </span>
                                            <?php endif; ?>
                                        </div>

                                        <div class="card-body">
                                            <div class="small text-secondary mb-3">
                                                Ordem:
                                                <strong>
                                                    <?= (int) (
                                                        $imagem['ordem']
                                                        ?? 0
                                                    ); ?>
                                                </strong>
                                            </div>

                                            <div class="d-grid gap-2">

                                                <?php if (!$principal): ?>
                                                    <form
                                                        action="admin/produto/imagens/principal"
                                                        method="post"
                                                    >
                                                        <input
                                                            type="hidden"
                                                            name="id"
                                                            value="<?= htmlspecialchars(
                                                                $produtoToken,
                                                                ENT_QUOTES,
                                                                'UTF-8'
                                                            ); ?>"
                                                        >

                                                        <input
                                                            type="hidden"
                                                            name="imagem_id"
                                                            value="<?= htmlspecialchars(
                                                                $imagemToken,
                                                                ENT_QUOTES,
                                                                'UTF-8'
                                                            ); ?>"
                                                        >

                                                        <input
                                                            type="hidden"
                                                            name="csrf_token"
                                                            value="<?= htmlspecialchars(
                                                                $csrfToken,
                                                                ENT_QUOTES,
                                                                'UTF-8'
                                                            ); ?>"
                                                        >

                                                        <button
                                                            type="submit"
                                                            class="btn btn-outline-success w-100"
                                                        >
                                                            <i class="bi bi-star me-1"></i>
                                                            Tornar principal
                                                        </button>
                                                    </form>
                                                <?php else: ?>
                                                    <button
                                                        type="button"
                                                        class="btn btn-success"
                                                        disabled
                                                    >
                                                        <i class="bi bi-star-fill me-1"></i>
                                                        Imagem principal
                                                    </button>
                                                <?php endif; ?>

                                                <form
                                                    action="admin/produto/imagens/excluir"
                                                    method="post"
                                                    onsubmit="return confirm('Deseja realmente excluir esta imagem?');"
                                                >
                                                    <input
                                                        type="hidden"
                                                        name="id"
                                                        value="<?= htmlspecialchars(
                                                            $produtoToken,
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        ); ?>"
                                                    >

                                                    <input
                                                        type="hidden"
                                                        name="imagem_id"
                                                        value="<?= htmlspecialchars(
                                                            $imagemToken,
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        ); ?>"
                                                    >

                                                    <input
                                                        type="hidden"
                                                        name="csrf_token"
                                                        value="<?= htmlspecialchars(
                                                            $csrfToken,
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        ); ?>"
                                                    >

                                                    <button
                                                        type="submit"
                                                        class="btn btn-outline-danger w-100"
                                                    >
                                                        <i class="bi bi-trash me-1"></i>
                                                        Excluir
                                                    </button>
                                                </form>

                                            </div>
                                        </div>

                                    </article>
                                </div>

                            <?php endforeach; ?>
                        </div>

                    <?php endif; ?>
                </section>

            </div>
        </main>

        <?php View::componenteAdmin('footer'); ?>

    </div>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    ></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const anoAtual =
                document.getElementById('anoAtual');

            if (anoAtual) {
                anoAtual.textContent =
                    new Date().getFullYear();
            }

            const input =
                document.getElementById('imagens');

            if (input) {
                input.addEventListener('change', function () {
                    if (this.files.length > 20) {
                        alert(
                            'Selecione no máximo 20 imagens por envio.'
                        );

                        this.value = '';
                    }
                });
            }
        });
    </script>

</body>
</html>