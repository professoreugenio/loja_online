<?php

declare(strict_types=1);

use App\Helpers\View;

$baseUrl = defined('BASE_URL') ? BASE_URL : '';

$produtos = is_array($produtos ?? null) ? $produtos : [];
$categorias = is_array($categorias ?? null) ? $categorias : [];
$filtros = is_array($filtros ?? null) ? $filtros : [];

$busca = trim((string) ($filtros['q'] ?? ''));
$categoriaSelecionada = (int) ($filtros['categoria'] ?? 0);
$destaqueSelecionado = (string) ($filtros['destaque'] ?? '');

?>
<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Produtos | Painel Administrativo</title>
    <meta
        name="description"
        content="Gerenciamento de produtos da loja online."
    >

    <base href="<?= BASE_URL ?>/">

    <link rel="icon" href="assets/img/favicon.ico">

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
            <nav class="sidebar-nav p-0">
                <a class="sidebar-link" href="admin">
                    <i class="bi bi-grid-1x2-fill"></i>
                    Dashboard
                </a>

                <a class="sidebar-link active" href="admin/produtos">
                    <i class="bi bi-box-seam-fill"></i>
                    Produtos
                </a>

                <a class="sidebar-link" href="admin/categorias">
                    <i class="bi bi-tags-fill"></i>
                    Categorias
                </a>

                <a class="sidebar-link" href="admin/clientes">
                    <i class="bi bi-people-fill"></i>
                    Clientes
                </a>
            </nav>
        </div>
    </div>

    <div class="main-wrapper">

        <?php View::componenteAdmin('header'); ?>

        <main class="content-area">
            <div class="container-fluid p-0">

                <!-- TÍTULO -->
                <section class="mb-4">
                    <div
                        class="d-flex flex-column flex-md-row
                               justify-content-between
                               align-items-md-center gap-3"
                    >
                        <div>
                            <h1 class="h3 fw-bold mb-1">
                                Produtos
                            </h1>

                            <p class="text-secondary mb-0">
                                Consulte, filtre e edite os produtos cadastrados.
                            </p>
                        </div>

                        <a
                            href="admin/produto/novo"
                            class="btn btn-primary"
                        >
                            <i class="bi bi-plus-lg me-1"></i>
                            Novo produto
                        </a>
                    </div>
                </section>

                <!-- FILTROS -->
                <section class="mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">

                            <form
                                action="<?= BASE_URL ?>/admin/produtos"
                                method="get"
                            >
                                <div class="row g-3 align-items-end">

                                    <div class="col-12 col-lg-5">
                                        <label
                                            for="q"
                                            class="form-label fw-semibold"
                                        >
                                            Pesquisar produto
                                        </label>

                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-search"></i>
                                            </span>

                                            <input
                                                type="search"
                                                class="form-control"
                                                id="q"
                                                name="q"
                                                value="<?= htmlspecialchars(
                                                    $busca,
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ); ?>"
                                                placeholder="Nome do produto"
                                            >
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6 col-lg-3">
                                        <label
                                            for="categoria"
                                            class="form-label fw-semibold"
                                        >
                                            Categoria
                                        </label>

                                        <select
                                            class="form-select"
                                            id="categoria"
                                            name="categoria"
                                        >
                                            <option value="">
                                                Todas as categorias
                                            </option>

                                            <?php foreach ($categorias as $categoria): ?>
                                                <?php
                                                $categoriaId =
                                                    (int) ($categoria['id'] ?? 0);

                                                $categoriaNome =
                                                    (string) ($categoria['nome'] ?? '');
                                                ?>

                                                <option
                                                    value="<?= $categoriaId; ?>"
                                                    <?= $categoriaSelecionada === $categoriaId
                                                        ? 'selected'
                                                        : ''; ?>
                                                >
                                                    <?= htmlspecialchars(
                                                        $categoriaNome,
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    ); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-12 col-md-6 col-lg-2">
                                        <label
                                            for="destaque"
                                            class="form-label fw-semibold"
                                        >
                                            Destaque
                                        </label>

                                        <select
                                            class="form-select"
                                            id="destaque"
                                            name="destaque"
                                        >
                                            <option
                                                value=""
                                                <?= $destaqueSelecionado === ''
                                                    ? 'selected'
                                                    : ''; ?>
                                            >
                                                Todos
                                            </option>

                                            <option
                                                value="1"
                                                <?= $destaqueSelecionado === '1'
                                                    ? 'selected'
                                                    : ''; ?>
                                            >
                                                Sim
                                            </option>

                                            <option
                                                value="0"
                                                <?= $destaqueSelecionado === '0'
                                                    ? 'selected'
                                                    : ''; ?>
                                            >
                                                Não
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-12 col-lg-2">
                                        <div class="d-grid">
                                            <button
                                                type="submit"
                                                class="btn btn-primary"
                                            >
                                                <i class="bi bi-funnel me-1"></i>
                                                Filtrar
                                            </button>
                                        </div>
                                    </div>

                                </div>

                                <?php if (
                                    $busca !== ''
                                    || $categoriaSelecionada > 0
                                    || $destaqueSelecionado !== ''
                                ): ?>
                                    <div class="mt-3">
                                        <a
                                            href="admin/produtos"
                                            class="btn btn-sm btn-outline-secondary"
                                        >
                                            <i class="bi bi-x-lg me-1"></i>
                                            Limpar filtros
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </form>

                        </div>
                    </div>
                </section>

                <!-- QUANTIDADE -->
                <section class="mb-3">
                    <span class="text-secondary">
                        <strong class="text-dark">
                            <?= number_format(
                                count($produtos),
                                0,
                                ',',
                                '.'
                            ); ?>
                        </strong>

                        <?= count($produtos) === 1
                            ? 'produto encontrado'
                            : 'produtos encontrados'; ?>
                    </span>
                </section>

                <!-- LISTA -->
                <section>
                    <div class="card border-0 shadow-sm">

                        <?php if ($produtos === []): ?>

                            <div class="card-body text-center py-5">
                                <div class="display-6 text-secondary mb-3">
                                    <i class="bi bi-box-seam"></i>
                                </div>

                                <h2 class="h5">
                                    Nenhum produto encontrado
                                </h2>

                                <p class="text-secondary mb-0">
                                    Altere os filtros ou cadastre um novo produto.
                                </p>
                            </div>

                        <?php else: ?>

                            <div class="table-responsive">
                                <table
                                    class="table table-hover align-middle mb-0"
                                >
                                    <thead class="table-light">
                                        <tr>
                                            <th>Produto</th>
                                            <th>Categoria</th>
                                            <th class="text-end">Preço</th>
                                            <th class="text-center">Estoque</th>
                                            <th class="text-center">Destaque</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-end">Ações</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach ($produtos as $produto): ?>
                                            <?php
                                            $produtoToken =
                                                (string) ($produto['id_seguro'] ?? '');

                                            $produtoNome =
                                                (string) ($produto['nome'] ?? '');

                                            $categoriaNome =
                                                (string) ($produto['categoria_nome'] ?? '');

                                            $preco =
                                                (float) ($produto['preco'] ?? 0);

                                            $estoque =
                                                (int) ($produto['estoque'] ?? 0);

                                            $destaque =
                                                (int) ($produto['destaque'] ?? 0);

                                            $status =
                                                (string) ($produto['status'] ?? 'inativo');

                                            $ofertaAtiva =
                                                (int) ($produto['oferta_ativa'] ?? 0);
                                            ?>

                                            <tr>
                                                <td>
                                                    <div class="fw-semibold">
                                                        <?= htmlspecialchars(
                                                            $produtoNome,
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        ); ?>
                                                    </div>

                                                    <?php if ($ofertaAtiva === 1): ?>
                                                        <span
                                                            class="badge text-bg-danger mt-1"
                                                        >
                                                            Oferta
                                                        </span>
                                                    <?php endif; ?>
                                                </td>

                                                <td>
                                                    <?= htmlspecialchars(
                                                        $categoriaNome,
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    ); ?>
                                                </td>

                                                <td class="text-end fw-semibold">
                                                    R$
                                                    <?= number_format(
                                                        $preco,
                                                        2,
                                                        ',',
                                                        '.'
                                                    ); ?>
                                                </td>

                                                <td class="text-center">
                                                    <?php if ($estoque <= 5): ?>
                                                        <span class="badge text-bg-danger">
                                                            <?= $estoque; ?>
                                                        </span>
                                                    <?php elseif ($estoque <= 10): ?>
                                                        <span class="badge text-bg-warning">
                                                            <?= $estoque; ?>
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="badge text-bg-light">
                                                            <?= $estoque; ?>
                                                        </span>
                                                    <?php endif; ?>
                                                </td>

                                                <td class="text-center">
                                                    <?php if ($destaque === 1): ?>
                                                        <span class="badge text-bg-warning">
                                                            <i class="bi bi-star-fill me-1"></i>
                                                            Sim
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="badge text-bg-secondary">
                                                            Não
                                                        </span>
                                                    <?php endif; ?>
                                                </td>

                                                <td class="text-center">
                                                    <?php if ($status === 'ativo'): ?>
                                                        <span class="badge text-bg-success">
                                                            Ativo
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="badge text-bg-secondary">
                                                            Inativo
                                                        </span>
                                                    <?php endif; ?>
                                                </td>

                                                <td class="text-end">
                                                    <a
                                                        href="admin/produto/editar?id=<?= urlencode(
                                                            $produtoToken
                                                        ); ?>"
                                                        class="btn btn-sm btn-outline-primary"
                                                        title="Editar produto"
                                                    >
                                                        <i class="bi bi-pencil-square me-1"></i>
                                                        Editar
                                                    </a>
                                                </td>
                                            </tr>

                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                        <?php endif; ?>

                    </div>
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
            const anoAtual = document.getElementById('anoAtual');

            if (anoAtual) {
                anoAtual.textContent =
                    new Date().getFullYear();
            }

            const caminhoAtual =
                window.location.pathname
                    .replace('<?= BASE_URL ?>/', '')
                    .replace(/^\/+|\/+$/g, '');

            document
                .querySelectorAll('.sidebar-link[data-route]')
                .forEach(function (link) {
                    const rota =
                        link.dataset.route || '';

                    link.classList.remove('active');

                    if (
                        caminhoAtual === rota
                        || caminhoAtual.startsWith(
                            rota + '/'
                        )
                    ) {
                        link.classList.add('active');
                    }
                });
        });
    </script>

</body>
</html>