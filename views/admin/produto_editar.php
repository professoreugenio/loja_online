<?php

declare(strict_types=1);

use App\Helpers\View;

$baseUrl = defined('BASE_URL')
    ? rtrim(BASE_URL, '/')
    : '';

$produto = is_array($produto ?? null)
    ? $produto
    : [];

$dadosFormulario =
    is_array($dadosFormulario ?? null)
        ? $dadosFormulario
        : $produto;

$categorias =
    is_array($categorias ?? null)
        ? $categorias
        : [];

$imagemPrincipal =
    is_array($imagemPrincipal ?? null)
        ? $imagemPrincipal
        : null;

$imagemPrincipalUrl =
    $imagemPrincipal !== null
        ? trim(
            (string) (
                $imagemPrincipal['url_imagem']
                ?? ''
            )
        )
        : '';

$produtoToken =
    (string) ($produtoToken ?? '');

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

$valor = static function (
    string $campo,
    mixed $padrao = ''
) use ($dadosFormulario): mixed {
    return $dadosFormulario[$campo]
        ?? $padrao;
};

$formatarDataInput =
    static function (
        mixed $data
    ): string {
        $data = trim(
            (string) $data
        );

        if ($data === '') {
            return '';
        }

        $timestamp =
            strtotime($data);

        if ($timestamp === false) {
            return '';
        }

        return date(
            'Y-m-d\TH:i',
            $timestamp
        );
    };

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
        Editar Produto | Loja Online
    </title>

    <meta
        name="description"
        content="Editar produto no painel administrativo."
    >

    <base href="<?= BASE_URL ?>/">

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

                <!-- ==================================================
                     CABEÇALHO
                =================================================== -->
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
                                    href="admin/produtos"
                                    class="text-decoration-none"
                                >
                                    <i class="bi bi-arrow-left me-1"></i>
                                    Voltar para produtos
                                </a>
                            </div>

                            <h1 class="h3 fw-bold mb-1">
                                Editar produto
                            </h1>

                            <p class="text-secondary mb-0">
                                Atualize as informações do produto selecionado.
                            </p>
                        </div>

                        <div class="d-flex align-items-center gap-2">
                            <a
                                href="admin/produto/imagens?id=<?= rawurlencode(
                                    $produtoToken
                                ); ?>"
                                class="btn btn-outline-primary"
                            >
                                <i class="bi bi-images me-1"></i>
                                Imagens
                            </a>

                            <span
                                class="badge text-bg-light border"
                            >
                                ID protegido
                            </span>
                        </div>
                    </div>
                </section>

                <!-- ==================================================
                     MENSAGENS
                =================================================== -->
                <?php if ($erro !== ''): ?>
                    <div
                        class="alert alert-danger alert-dismissible fade show"
                        role="alert"
                    >
                        <i
                            class="bi bi-exclamation-triangle-fill me-2"
                        ></i>

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
                        <i
                            class="bi bi-check-circle-fill me-2"
                        ></i>

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

                <!-- ==================================================
                     FORMULÁRIO
                =================================================== -->
                <form
                    action="admin/produto/atualizar"
                    method="post"
                    autocomplete="off"
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

                    <div class="row g-4">

                        <!-- COLUNA PRINCIPAL -->
                        <div class="col-12 col-xl-8">

                            <!-- Dados principais -->
                            <section class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-body py-3">
                                    <h2 class="h5 fw-bold mb-0">
                                        Dados do produto
                                    </h2>
                                </div>

                                <div class="card-body">
                                    <div class="row g-3">

                                        <div class="col-12">
                                            <label
                                                for="nome"
                                                class="form-label fw-semibold"
                                            >
                                                Nome do produto
                                                <span class="text-danger">*</span>
                                            </label>

                                            <input
                                                type="text"
                                                class="form-control"
                                                id="nome"
                                                name="nome"
                                                maxlength="150"
                                                required
                                                value="<?= htmlspecialchars(
                                                    (string) $valor('nome'),
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ); ?>"
                                            >
                                        </div>

                                        <div class="col-12">
                                            <label
                                                for="slug"
                                                class="form-label fw-semibold"
                                            >
                                                Slug
                                            </label>

                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    /
                                                </span>

                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="slug"
                                                    name="slug"
                                                    maxlength="180"
                                                    value="<?= htmlspecialchars(
                                                        (string) $valor('slug'),
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    ); ?>"
                                                >
                                            </div>

                                            <div class="form-text">
                                                Identificador utilizado em URLs amigáveis.
                                                Se ficar vazio, será criado a partir do nome.
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label
                                                for="descricao"
                                                class="form-label fw-semibold"
                                            >
                                                Descrição
                                            </label>

                                            <textarea
                                                class="form-control"
                                                id="descricao"
                                                name="descricao"
                                                rows="6"
                                            ><?= htmlspecialchars(
                                                (string) $valor('descricao'),
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?></textarea>
                                        </div>

                                    </div>
                                </div>
                            </section>

                            <!-- Oferta -->
                            <section class="card border-0 shadow-sm mb-4">
                                <div
                                    class="card-header bg-body py-3
                                           d-flex justify-content-between
                                           align-items-center gap-3"
                                >
                                    <div>
                                        <h2 class="h5 fw-bold mb-1">
                                            Oferta
                                        </h2>

                                        <small class="text-secondary">
                                            Configure desconto e período promocional.
                                        </small>
                                    </div>

                                    <div class="form-check form-switch">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            role="switch"
                                            id="oferta_ativa"
                                            name="oferta_ativa"
                                            value="1"
                                            <?= (int) $valor(
                                                'oferta_ativa',
                                                0
                                            ) === 1
                                                ? 'checked'
                                                : ''; ?>
                                        >

                                        <label
                                            class="form-check-label"
                                            for="oferta_ativa"
                                        >
                                            Oferta ativa
                                        </label>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="row g-3">

                                        <div class="col-12 col-md-4">
                                            <label
                                                for="percentual_oferta"
                                                class="form-label fw-semibold"
                                            >
                                                Desconto (%)
                                            </label>

                                            <div class="input-group">
                                                <input
                                                    type="number"
                                                    class="form-control"
                                                    id="percentual_oferta"
                                                    name="percentual_oferta"
                                                    min="0"
                                                    max="100"
                                                    step="0.01"
                                                    value="<?= htmlspecialchars(
                                                        (string) $valor(
                                                            'percentual_oferta'
                                                        ),
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    ); ?>"
                                                >

                                                <span class="input-group-text">
                                                    %
                                                </span>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-4">
                                            <label
                                                for="oferta_inicio"
                                                class="form-label fw-semibold"
                                            >
                                                Início
                                            </label>

                                            <input
                                                type="datetime-local"
                                                class="form-control"
                                                id="oferta_inicio"
                                                name="oferta_inicio"
                                                value="<?= htmlspecialchars(
                                                    $formatarDataInput(
                                                        $valor('oferta_inicio')
                                                    ),
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ); ?>"
                                            >
                                        </div>

                                        <div class="col-12 col-md-4">
                                            <label
                                                for="oferta_fim"
                                                class="form-label fw-semibold"
                                            >
                                                Fim
                                            </label>

                                            <input
                                                type="datetime-local"
                                                class="form-control"
                                                id="oferta_fim"
                                                name="oferta_fim"
                                                value="<?= htmlspecialchars(
                                                    $formatarDataInput(
                                                        $valor('oferta_fim')
                                                    ),
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ); ?>"
                                            >
                                        </div>

                                    </div>
                                </div>
                            </section>

                        </div>

                        <!-- COLUNA LATERAL -->
                        <div class="col-12 col-xl-4">

                            <!-- Imagem principal -->
                            <section class="card border-0 shadow-sm mb-4">
                                <div
                                    class="card-header bg-body py-3
                                           d-flex justify-content-between
                                           align-items-center gap-2"
                                >
                                    <h2 class="h5 fw-bold mb-0">
                                        Imagem principal
                                    </h2>

                                    <a
                                        href="admin/produto/imagens?id=<?= rawurlencode(
                                            $produtoToken
                                        ); ?>"
                                        class="btn btn-sm btn-outline-primary"
                                    >
                                        <i class="bi bi-images me-1"></i>
                                        Gerenciar
                                    </a>
                                </div>

                                <div class="card-body">
                                    <?php if ($imagemPrincipalUrl !== ''): ?>
                                        <img
                                            src="<?= htmlspecialchars(
                                                $imagemPrincipalUrl,
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"
                                            class="img-fluid rounded border w-100"
                                            alt="<?= htmlspecialchars(
                                                (string) (
                                                    $imagemPrincipal['texto_alternativo']
                                                    ?? $produto['nome']
                                                    ?? 'Imagem principal do produto'
                                                ),
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"
                                            style="height: 280px; object-fit: contain;"
                                            onerror="this.onerror=null;this.src='assets/img/sem-imagem.jpg';"
                                        >

                                        <div class="mt-2 text-center">
                                            <span class="badge text-bg-success">
                                                <i class="bi bi-star-fill me-1"></i>
                                                Principal
                                            </span>
                                        </div>
                                    <?php else: ?>
                                        <div
                                            class="border rounded bg-body-tertiary
                                                   text-center text-secondary p-4"
                                        >
                                            <i class="bi bi-image fs-1 d-block mb-2"></i>

                                            <strong class="d-block">
                                                Sem imagem principal
                                            </strong>

                                            <small>
                                                Clique em Gerenciar para enviar imagens.
                                            </small>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </section>

                            <!-- Organização -->
                            <section class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-body py-3">
                                    <h2 class="h5 fw-bold mb-0">
                                        Organização
                                    </h2>
                                </div>

                                <div class="card-body">
                                    <div class="row g-3">

                                        <div class="col-12">
                                            <label
                                                for="categoria_id"
                                                class="form-label fw-semibold"
                                            >
                                                Categoria
                                                <span class="text-danger">*</span>
                                            </label>

                                            <select
                                                class="form-select"
                                                id="categoria_id"
                                                name="categoria_id"
                                                required
                                            >
                                                <option value="">
                                                    Selecione
                                                </option>

                                                <?php foreach (
                                                    $categorias
                                                    as $categoria
                                                ): ?>
                                                    <?php
                                                    $categoriaId =
                                                        (int) (
                                                            $categoria['id']
                                                            ?? 0
                                                        );
                                                    ?>

                                                    <option
                                                        value="<?= $categoriaId; ?>"
                                                        <?= (int) $valor(
                                                            'categoria_id',
                                                            0
                                                        ) === $categoriaId
                                                            ? 'selected'
                                                            : ''; ?>
                                                    >
                                                        <?= htmlspecialchars(
                                                            (string) (
                                                                $categoria['nome']
                                                                ?? ''
                                                            ),
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        ); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="col-12 col-md-6 col-xl-12">
                                            <label
                                                for="preco"
                                                class="form-label fw-semibold"
                                            >
                                                Preço
                                                <span class="text-danger">*</span>
                                            </label>

                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    R$
                                                </span>

                                                <input
                                                    type="number"
                                                    class="form-control"
                                                    id="preco"
                                                    name="preco"
                                                    min="0"
                                                    step="0.01"
                                                    required
                                                    value="<?= htmlspecialchars(
                                                        (string) $valor(
                                                            'preco',
                                                            '0.00'
                                                        ),
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    ); ?>"
                                                >
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 col-xl-12">
                                            <label
                                                for="estoque"
                                                class="form-label fw-semibold"
                                            >
                                                Estoque
                                            </label>

                                            <input
                                                type="number"
                                                class="form-control"
                                                id="estoque"
                                                name="estoque"
                                                min="0"
                                                step="1"
                                                required
                                                value="<?= htmlspecialchars(
                                                    (string) $valor(
                                                        'estoque',
                                                        0
                                                    ),
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ); ?>"
                                            >
                                        </div>

                                        <div class="col-12">
                                            <label
                                                for="status"
                                                class="form-label fw-semibold"
                                            >
                                                Status
                                            </label>

                                            <select
                                                class="form-select"
                                                id="status"
                                                name="status"
                                                required
                                            >
                                                <option
                                                    value="ativo"
                                                    <?= (string) $valor(
                                                        'status',
                                                        'ativo'
                                                    ) === 'ativo'
                                                        ? 'selected'
                                                        : ''; ?>
                                                >
                                                    Ativo
                                                </option>

                                                <option
                                                    value="inativo"
                                                    <?= (string) $valor(
                                                        'status'
                                                    ) === 'inativo'
                                                        ? 'selected'
                                                        : ''; ?>
                                                >
                                                    Inativo
                                                </option>
                                            </select>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-check form-switch">
                                                <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    role="switch"
                                                    id="destaque"
                                                    name="destaque"
                                                    value="1"
                                                    <?= (int) $valor(
                                                        'destaque',
                                                        0
                                                    ) === 1
                                                        ? 'checked'
                                                        : ''; ?>
                                                >

                                                <label
                                                    class="form-check-label fw-semibold"
                                                    for="destaque"
                                                >
                                                    Exibir como destaque
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </section>

                            <!-- Informações -->
                            <section class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-body py-3">
                                    <h2 class="h6 fw-bold mb-0">
                                        Informações do registro
                                    </h2>
                                </div>

                                <div class="card-body small">
                                    <dl class="row mb-0">
                                        <dt class="col-5">
                                            Criado
                                        </dt>

                                        <dd class="col-7 text-end">
                                            <?= htmlspecialchars(
                                                (string) (
                                                    $produto['criado_em']
                                                    ?? '-'
                                                ),
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>
                                        </dd>

                                        <dt class="col-5">
                                            Atualizado
                                        </dt>

                                        <dd class="col-7 text-end">
                                            <?= htmlspecialchars(
                                                (string) (
                                                    $produto['atualizado_em']
                                                    ?? '-'
                                                ),
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>
                                        </dd>
                                    </dl>
                                </div>
                            </section>

                        </div>

                    </div>

                    <!-- BOTÕES -->
                    <section
                        class="card border-0 shadow-sm position-sticky bottom-0"
                        style="z-index: 10;"
                    >
                        <div
                            class="card-body
                                   d-flex flex-column
                                   flex-sm-row
                                   justify-content-end
                                   gap-2"
                        >
                            <a
                                href="admin/produtos"
                                class="btn btn-outline-secondary"
                            >
                                Cancelar
                            </a>

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                <i class="bi bi-check-lg me-1"></i>
                                Salvar alterações
                            </button>
                        </div>
                    </section>

                </form>

            </div>
        </main>

        <?php View::componenteAdmin('footer'); ?>

    </div>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    ></script>

    <script>
        document.addEventListener(
            'DOMContentLoaded',
            function () {
                const anoAtual =
                    document.getElementById(
                        'anoAtual'
                    );

                if (anoAtual) {
                    anoAtual.textContent =
                        new Date().getFullYear();
                }

                const nome =
                    document.getElementById(
                        'nome'
                    );

                const slug =
                    document.getElementById(
                        'slug'
                    );

                if (nome && slug) {
                    let slugAlterado =
                        slug.value.trim() !== '';

                    slug.addEventListener(
                        'input',
                        function () {
                            slugAlterado = true;
                        }
                    );

                    nome.addEventListener(
                        'input',
                        function () {
                            if (slugAlterado) {
                                return;
                            }

                            slug.value =
                                nome.value
                                    .normalize('NFD')
                                    .replace(
                                        /[\u0300-\u036f]/g,
                                        ''
                                    )
                                    .toLowerCase()
                                    .replace(
                                        /[^a-z0-9]+/g,
                                        '-'
                                    )
                                    .replace(
                                        /^-+|-+$/g,
                                        ''
                                    );
                        }
                    );
                }

                const oferta =
                    document.getElementById(
                        'oferta_ativa'
                    );

                const percentual =
                    document.getElementById(
                        'percentual_oferta'
                    );

                const inicio =
                    document.getElementById(
                        'oferta_inicio'
                    );

                const fim =
                    document.getElementById(
                        'oferta_fim'
                    );

                function atualizarOferta() {
                    if (!oferta) {
                        return;
                    }

                    const ativo =
                        oferta.checked;

                    [
                        percentual,
                        inicio,
                        fim
                    ].forEach(
                        function (campo) {
                            if (campo) {
                                campo.disabled =
                                    !ativo;
                            }
                        }
                    );
                }

                if (oferta) {
                    atualizarOferta();

                    oferta.addEventListener(
                        'change',
                        atualizarOferta
                    );
                }
            }
        );
    </script>

</body>
</html>