<?php

declare(strict_types=1);

use App\Helpers\View;

$baseUrl = defined('BASE_URL')
    ? rtrim((string) BASE_URL, '/')
    : '';

$categorias = is_array($categorias ?? null)
    ? $categorias
    : [];

$filtros = is_array($filtros ?? null)
    ? $filtros
    : [];

$busca = trim(
    (string) ($filtros['q'] ?? '')
);

$statusSelecionado = trim(
    (string) ($filtros['status'] ?? '')
);

$csrfToken = (string) ($csrfToken ?? '');
$sucesso = (string) ($sucesso ?? '');
$erro = (string) ($erro ?? '');

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
        Categorias | Loja Online
    </title>

    <meta
        name="description"
        content="Gerenciamento de categorias da loja online."
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
                    data-route="admin"
                >
                    <i class="bi bi-grid-1x2-fill"></i>
                    Dashboard
                </a>

                <a
                    class="sidebar-link"
                    href="admin/produtos"
                    data-route="admin/produtos"
                >
                    <i class="bi bi-box-seam-fill"></i>
                    Produtos
                </a>

                <a
                    class="sidebar-link active"
                    href="admin/categorias"
                    data-route="admin/categorias"
                >
                    <i class="bi bi-tags-fill"></i>
                    Categorias
                </a>

                <a
                    class="sidebar-link"
                    href="admin/clientes"
                    data-route="admin/clientes"
                >
                    <i class="bi bi-people-fill"></i>
                    Clientes
                </a>

                <a
                    class="sidebar-link"
                    href="admin/pedidos"
                    data-route="admin/pedidos"
                >
                    <i class="bi bi-bag-check-fill"></i>
                    Pedidos
                </a>

                <a
                    class="sidebar-link"
                    href="admin/pagamentos"
                    data-route="admin/pagamentos"
                >
                    <i class="bi bi-credit-card-fill"></i>
                    Pagamentos
                </a>

                <a
                    class="sidebar-link"
                    href="admin/estoque"
                    data-route="admin/estoque"
                >
                    <i class="bi bi-boxes"></i>
                    Estoque
                </a>

                <a
                    class="sidebar-link"
                    href="admin/notificacoes"
                    data-route="admin/notificacoes"
                >
                    <i class="bi bi-bell-fill"></i>
                    Notificações
                </a>

                <a
                    class="sidebar-link"
                    href="admin/relatorios"
                    data-route="admin/relatorios"
                >
                    <i class="bi bi-bar-chart-line-fill"></i>
                    Relatórios
                </a>

                <a
                    class="sidebar-link"
                    href="admin/configuracoes"
                    data-route="admin/configuracoes"
                >
                    <i class="bi bi-gear-fill"></i>
                    Configurações
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
                            <h1 class="h3 fw-bold mb-1">
                                Categorias
                            </h1>

                            <p class="text-secondary mb-0">
                                Cadastre, edite e controle as categorias disponíveis na loja.
                            </p>
                        </div>

                        <button
                            type="button"
                            class="btn btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#modalNovaCategoria"
                        >
                            <i class="bi bi-plus-lg me-1"></i>
                            Adicionar nova categoria
                        </button>
                    </div>
                </section>

                <!-- MENSAGENS -->
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

                <!-- FILTROS -->
                <section class="card border-0 shadow-sm mb-4">
                    <div class="card-body">

                        <form
                            action="admin/categorias"
                            method="get"
                        >
                            <div class="row g-3 align-items-end">

                                <div class="col-12 col-lg-6">
                                    <label
                                        for="q"
                                        class="form-label fw-semibold"
                                    >
                                        Pesquisar categoria
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
                                            placeholder="Nome, slug ou descrição"
                                        >
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-3">
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
                                    >
                                        <option
                                            value=""
                                            <?= $statusSelecionado === ''
                                                ? 'selected'
                                                : ''; ?>
                                        >
                                            Todas
                                        </option>

                                        <option
                                            value="ativo"
                                            <?= $statusSelecionado === 'ativo'
                                                ? 'selected'
                                                : ''; ?>
                                        >
                                            Ativas
                                        </option>

                                        <option
                                            value="inativo"
                                            <?= $statusSelecionado === 'inativo'
                                                ? 'selected'
                                                : ''; ?>
                                        >
                                            Inativas
                                        </option>
                                    </select>
                                </div>

                                <div class="col-12 col-md-6 col-lg-3">
                                    <div class="d-flex gap-2">
                                        <button
                                            type="submit"
                                            class="btn btn-primary flex-fill"
                                        >
                                            <i class="bi bi-funnel me-1"></i>
                                            Filtrar
                                        </button>

                                        <a
                                            href="admin/categorias"
                                            class="btn btn-outline-secondary"
                                            title="Limpar filtros"
                                        >
                                            <i class="bi bi-arrow-counterclockwise"></i>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </form>

                    </div>
                </section>

                <!-- LISTA -->
                <section class="card border-0 shadow-sm">
                    <div
                        class="card-header bg-white
                               d-flex flex-column
                               flex-md-row
                               justify-content-between
                               align-items-md-center
                               gap-2 py-3"
                    >
                        <div>
                            <h2 class="h5 mb-1">
                                Categorias cadastradas
                            </h2>

                            <p class="text-secondary small mb-0">
                                <?= count($categorias); ?>
                                <?= count($categorias) === 1
                                    ? 'categoria encontrada'
                                    : 'categorias encontradas'; ?>
                            </p>
                        </div>
                    </div>

                    <div class="card-body p-0">

                        <?php if ($categorias === []): ?>
                            <div class="p-5 text-center">
                                <div class="display-6 text-secondary mb-3">
                                    <i class="bi bi-tags"></i>
                                </div>

                                <h3 class="h5">
                                    Nenhuma categoria encontrada
                                </h3>

                                <p class="text-secondary mb-0">
                                    Ajuste os filtros ou cadastre uma nova categoria.
                                </p>
                            </div>
                        <?php else: ?>

                            <div class="table-responsive">
                                <table
                                    class="table table-hover align-middle mb-0"
                                >
                                    <thead class="table-light">
                                        <tr>
                                            <th>Categoria</th>
                                            <th>Descrição</th>
                                            <th>Imagem</th>
                                            <th class="text-center">
                                                Produtos
                                            </th>
                                            <th>Status</th>
                                            <th>Atualizada</th>
                                            <th class="text-end">
                                                Ações
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <?php foreach ($categorias as $categoria): ?>
                                            <?php
                                            $idSeguro = (string) (
                                                $categoria['id_seguro']
                                                ?? ''
                                            );

                                            $nome = (string) (
                                                $categoria['nome']
                                                ?? ''
                                            );

                                            $slug = (string) (
                                                $categoria['slug']
                                                ?? ''
                                            );

                                            $descricao = (string) (
                                                $categoria['descricao']
                                                ?? ''
                                            );

                                            $imgcategoria = (string) (
                                                $categoria['imgcategoria']
                                                ?? ''
                                            );

                                            $ativo = (int) (
                                                $categoria['ativo']
                                                ?? 0
                                            );

                                            $totalProdutos = (int) (
                                                $categoria['total_produtos']
                                                ?? 0
                                            );

                                            $atualizadoEm = trim(
                                                (string) (
                                                    $categoria['atualizado_em']
                                                    ?? ''
                                                )
                                            );
                                            ?>

                                            <tr>
                                                <td>
                                                    <div class="fw-semibold">
                                                        <?= htmlspecialchars(
                                                            $nome,
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        ); ?>
                                                    </div>

                                                    <small class="text-secondary">
                                                        <?= htmlspecialchars(
                                                            $slug,
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        ); ?>
                                                    </small>
                                                </td>

                                                <td style="min-width: 260px;">
                                                    <?php if ($descricao !== ''): ?>
                                                        <?= htmlspecialchars(
                                                            $descricao,
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        ); ?>
                                                    <?php else: ?>
                                                        <span class="text-secondary">
                                                            Sem descrição
                                                        </span>
                                                    <?php endif; ?>
                                                </td>

                                                <td>
                                                    <?php if ($imgcategoria !== ''): ?>
                                                        <code>
                                                            <?= htmlspecialchars(
                                                                $imgcategoria,
                                                                ENT_QUOTES,
                                                                'UTF-8'
                                                            ); ?>
                                                        </code>
                                                    <?php else: ?>
                                                        <span class="text-secondary">
                                                            —
                                                        </span>
                                                    <?php endif; ?>
                                                </td>

                                                <td class="text-center">
                                                    <span
                                                        class="badge text-bg-light border"
                                                    >
                                                        <?= $totalProdutos; ?>
                                                    </span>
                                                </td>

                                                <td>
                                                    <?php if ($ativo === 1): ?>
                                                        <span
                                                            class="badge text-bg-success"
                                                        >
                                                            Ativa
                                                        </span>
                                                    <?php else: ?>
                                                        <span
                                                            class="badge text-bg-secondary"
                                                        >
                                                            Inativa
                                                        </span>
                                                    <?php endif; ?>
                                                </td>

                                                <td class="text-nowrap">
                                                    <?php if ($atualizadoEm !== ''): ?>
                                                        <?= htmlspecialchars(
                                                            date(
                                                                'd/m/Y H:i',
                                                                strtotime($atualizadoEm)
                                                            ),
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        ); ?>
                                                    <?php else: ?>
                                                        —
                                                    <?php endif; ?>
                                                </td>

                                                <td class="text-end">
                                                    <div
                                                        class="d-inline-flex gap-2"
                                                    >
                                                        <button
                                                            type="button"
                                                            class="btn btn-sm btn-outline-primary btn-editar-categoria"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalEditarCategoria"
                                                            data-id="<?= htmlspecialchars(
                                                                $idSeguro,
                                                                ENT_QUOTES,
                                                                'UTF-8'
                                                            ); ?>"
                                                            data-nome="<?= htmlspecialchars(
                                                                $nome,
                                                                ENT_QUOTES,
                                                                'UTF-8'
                                                            ); ?>"
                                                            data-slug="<?= htmlspecialchars(
                                                                $slug,
                                                                ENT_QUOTES,
                                                                'UTF-8'
                                                            ); ?>"
                                                            data-descricao="<?= htmlspecialchars(
                                                                $descricao,
                                                                ENT_QUOTES,
                                                                'UTF-8'
                                                            ); ?>"
                                                            data-imgcategoria="<?= htmlspecialchars(
                                                                $imgcategoria,
                                                                ENT_QUOTES,
                                                                'UTF-8'
                                                            ); ?>"
                                                        >
                                                            <i class="bi bi-pencil-square"></i>
                                                            Editar
                                                        </button>

                                                        <?php if ($ativo === 1): ?>
                                                            <button
                                                                type="button"
                                                                class="btn btn-sm btn-outline-danger btn-status-categoria"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#modalStatusCategoria"
                                                                data-id="<?= htmlspecialchars(
                                                                    $idSeguro,
                                                                    ENT_QUOTES,
                                                                    'UTF-8'
                                                                ); ?>"
                                                                data-nome="<?= htmlspecialchars(
                                                                    $nome,
                                                                    ENT_QUOTES,
                                                                    'UTF-8'
                                                                ); ?>"
                                                                data-acao="desativar"
                                                                data-url="admin/categoria/desativar"
                                                            >
                                                                <i class="bi bi-slash-circle"></i>
                                                                Desativar
                                                            </button>
                                                        <?php else: ?>
                                                            <button
                                                                type="button"
                                                                class="btn btn-sm btn-outline-success btn-status-categoria"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#modalStatusCategoria"
                                                                data-id="<?= htmlspecialchars(
                                                                    $idSeguro,
                                                                    ENT_QUOTES,
                                                                    'UTF-8'
                                                                ); ?>"
                                                                data-nome="<?= htmlspecialchars(
                                                                    $nome,
                                                                    ENT_QUOTES,
                                                                    'UTF-8'
                                                                ); ?>"
                                                                data-acao="ativar"
                                                                data-url="admin/categoria/ativar"
                                                            >
                                                                <i class="bi bi-check-circle"></i>
                                                                Ativar
                                                            </button>
                                                        <?php endif; ?>
                                                    </div>
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


    <!-- =========================================================
         MODAL: NOVA CATEGORIA
    ========================================================== -->
    <div
        class="modal fade"
        id="modalNovaCategoria"
        tabindex="-1"
        aria-labelledby="modalNovaCategoriaLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <form
                    action="admin/categoria/cadastrar"
                    method="post"
                >
                    <div class="modal-header">
                        <h2
                            class="modal-title fs-5"
                            id="modalNovaCategoriaLabel"
                        >
                            <i class="bi bi-plus-circle me-1"></i>
                            Adicionar nova categoria
                        </h2>

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Fechar"
                        ></button>
                    </div>

                    <div class="modal-body">

                        <input
                            type="hidden"
                            name="csrf_token"
                            value="<?= htmlspecialchars(
                                $csrfToken,
                                ENT_QUOTES,
                                'UTF-8'
                            ); ?>"
                        >

                        <div class="row g-3">

                            <div class="col-12 col-md-6">
                                <label
                                    for="nova_nome"
                                    class="form-label fw-semibold"
                                >
                                    Nome
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="nova_nome"
                                    name="nome"
                                    maxlength="100"
                                    required
                                >
                            </div>

                            <div class="col-12 col-md-6">
                                <label
                                    for="nova_slug"
                                    class="form-label fw-semibold"
                                >
                                    Slug
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="nova_slug"
                                    name="slug"
                                    maxlength="120"
                                    placeholder="Gerado automaticamente se vazio"
                                >
                            </div>

                            <div class="col-12">
                                <label
                                    for="nova_imgcategoria"
                                    class="form-label fw-semibold"
                                >
                                    Imagem da categoria
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="nova_imgcategoria"
                                    name="imgcategoria"
                                    maxlength="150"
                                    placeholder="Ex.: informatica.webp"
                                >

                                <div class="form-text">
                                    Informe somente o nome/caminho utilizado atualmente pelo seu projeto.
                                </div>
                            </div>

                            <div class="col-12">
                                <label
                                    for="nova_descricao"
                                    class="form-label fw-semibold"
                                >
                                    Descrição
                                </label>

                                <textarea
                                    class="form-control"
                                    id="nova_descricao"
                                    name="descricao"
                                    rows="4"
                                    maxlength="255"
                                ></textarea>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-outline-secondary"
                            data-bs-dismiss="modal"
                        >
                            Cancelar
                        </button>

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            <i class="bi bi-check-lg me-1"></i>
                            Salvar categoria
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>


    <!-- =========================================================
         MODAL: EDITAR CATEGORIA
    ========================================================== -->
    <div
        class="modal fade"
        id="modalEditarCategoria"
        tabindex="-1"
        aria-labelledby="modalEditarCategoriaLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <form
                    action="admin/categoria/atualizar"
                    method="post"
                >
                    <div class="modal-header">
                        <h2
                            class="modal-title fs-5"
                            id="modalEditarCategoriaLabel"
                        >
                            <i class="bi bi-pencil-square me-1"></i>
                            Editar categoria
                        </h2>

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Fechar"
                        ></button>
                    </div>

                    <div class="modal-body">

                        <input
                            type="hidden"
                            name="csrf_token"
                            value="<?= htmlspecialchars(
                                $csrfToken,
                                ENT_QUOTES,
                                'UTF-8'
                            ); ?>"
                        >

                        <input
                            type="hidden"
                            id="editar_id"
                            name="id"
                            value=""
                        >

                        <div class="row g-3">

                            <div class="col-12 col-md-6">
                                <label
                                    for="editar_nome"
                                    class="form-label fw-semibold"
                                >
                                    Nome
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="editar_nome"
                                    name="nome"
                                    maxlength="100"
                                    required
                                >
                            </div>

                            <div class="col-12 col-md-6">
                                <label
                                    for="editar_slug"
                                    class="form-label fw-semibold"
                                >
                                    Slug
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="editar_slug"
                                    name="slug"
                                    maxlength="120"
                                >
                            </div>

                            <div class="col-12">
                                <label
                                    for="editar_imgcategoria"
                                    class="form-label fw-semibold"
                                >
                                    Imagem da categoria
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="editar_imgcategoria"
                                    name="imgcategoria"
                                    maxlength="150"
                                >
                            </div>

                            <div class="col-12">
                                <label
                                    for="editar_descricao"
                                    class="form-label fw-semibold"
                                >
                                    Descrição
                                </label>

                                <textarea
                                    class="form-control"
                                    id="editar_descricao"
                                    name="descricao"
                                    rows="4"
                                    maxlength="255"
                                ></textarea>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-outline-secondary"
                            data-bs-dismiss="modal"
                        >
                            Cancelar
                        </button>

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            <i class="bi bi-check-lg me-1"></i>
                            Salvar alterações
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>


    <!-- =========================================================
         MODAL: ATIVAR / DESATIVAR
    ========================================================== -->
    <div
        class="modal fade"
        id="modalStatusCategoria"
        tabindex="-1"
        aria-labelledby="modalStatusCategoriaLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content">

                <form
                    id="formStatusCategoria"
                    action=""
                    method="post"
                >
                    <div class="modal-header">
                        <h2
                            class="modal-title fs-5"
                            id="modalStatusCategoriaLabel"
                        >
                            Alterar status
                        </h2>

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Fechar"
                        ></button>
                    </div>

                    <div class="modal-body">

                        <input
                            type="hidden"
                            name="csrf_token"
                            value="<?= htmlspecialchars(
                                $csrfToken,
                                ENT_QUOTES,
                                'UTF-8'
                            ); ?>"
                        >

                        <input
                            type="hidden"
                            id="status_categoria_id"
                            name="id"
                            value=""
                        >

                        <p
                            class="mb-0"
                            id="status_categoria_mensagem"
                        ></p>

                    </div>

                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-outline-secondary"
                            data-bs-dismiss="modal"
                        >
                            Cancelar
                        </button>

                        <button
                            type="submit"
                            class="btn"
                            id="status_categoria_confirmar"
                        >
                            Confirmar
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

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

                /*
                 * Preenche o modal de edição.
                 */
                document
                    .querySelectorAll(
                        '.btn-editar-categoria'
                    )
                    .forEach(function (botao) {
                        botao.addEventListener(
                            'click',
                            function () {
                                document.getElementById(
                                    'editar_id'
                                ).value =
                                    botao.dataset.id || '';

                                document.getElementById(
                                    'editar_nome'
                                ).value =
                                    botao.dataset.nome || '';

                                document.getElementById(
                                    'editar_slug'
                                ).value =
                                    botao.dataset.slug || '';

                                document.getElementById(
                                    'editar_descricao'
                                ).value =
                                    botao.dataset.descricao || '';

                                document.getElementById(
                                    'editar_imgcategoria'
                                ).value =
                                    botao.dataset.imgcategoria || '';
                            }
                        );
                    });

                /*
                 * Modal de ativação/desativação.
                 */
                document
                    .querySelectorAll(
                        '.btn-status-categoria'
                    )
                    .forEach(function (botao) {
                        botao.addEventListener(
                            'click',
                            function () {
                                const acao =
                                    botao.dataset.acao || '';

                                const nome =
                                    botao.dataset.nome || '';

                                const url =
                                    botao.dataset.url || '';

                                const id =
                                    botao.dataset.id || '';

                                const form =
                                    document.getElementById(
                                        'formStatusCategoria'
                                    );

                                const titulo =
                                    document.getElementById(
                                        'modalStatusCategoriaLabel'
                                    );

                                const mensagem =
                                    document.getElementById(
                                        'status_categoria_mensagem'
                                    );

                                const confirmar =
                                    document.getElementById(
                                        'status_categoria_confirmar'
                                    );

                                form.action = url;

                                document.getElementById(
                                    'status_categoria_id'
                                ).value = id;

                                if (acao === 'desativar') {
                                    titulo.textContent =
                                        'Desativar categoria';

                                    mensagem.textContent =
                                        'Deseja realmente desativar a categoria "' +
                                        nome +
                                        '"? Os produtos não serão excluídos.';

                                    confirmar.className =
                                        'btn btn-danger';

                                    confirmar.innerHTML =
                                        '<i class="bi bi-slash-circle me-1"></i> Desativar';
                                } else {
                                    titulo.textContent =
                                        'Ativar categoria';

                                    mensagem.textContent =
                                        'Deseja ativar novamente a categoria "' +
                                        nome +
                                        '"?';

                                    confirmar.className =
                                        'btn btn-success';

                                    confirmar.innerHTML =
                                        '<i class="bi bi-check-circle me-1"></i> Ativar';
                                }
                            }
                        );
                    });

                /*
                 * Ajusta o item ativo do menu.
                 */
                const caminhoAtual =
                    window.location.pathname
                        .replace(
                            '/loja_online/public/',
                            ''
                        )
                        .replace(
                            /^\/+|\/+$/g,
                            ''
                        );

                document
                    .querySelectorAll(
                        '.sidebar-link[data-route]'
                    )
                    .forEach(function (link) {
                        const rota =
                            link.dataset.route || '';

                        link.classList.remove(
                            'active'
                        );

                        if (
                            caminhoAtual === rota
                            || caminhoAtual.startsWith(
                                rota + '/'
                            )
                        ) {
                            link.classList.add(
                                'active'
                            );
                        }
                    });
            }
        );
    </script>

</body>
</html>