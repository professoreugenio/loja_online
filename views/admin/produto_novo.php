<?php

declare(strict_types=1);

use App\Helpers\View;

$baseUrl = defined('BASE_URL') ? BASE_URL : '';

?>
<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Administrativo | Loja Online</title>
    <meta name="description" content="Painel administrativo para gerenciamento da loja online.">

    <!-- Caminho-base do projeto no XAMPP -->
    <base href="<?= BASE_URL ?>/">

    <link rel="icon" href="assets/img/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">


    <link rel="stylesheet" href="<?= htmlspecialchars($baseUrl . '/assets/css/admin.css', ENT_QUOTES, 'UTF-8') ?>">
</head>

<body>
    <?php View::componenteAdmin('aside'); ?>

    <div class="offcanvas offcanvas-start offcanvas-dashboard" tabindex="-1" id="menuMobile">
        <div class="offcanvas-header border-bottom border-secondary">
            <div>
                <h2 class="offcanvas-title h5 mb-0">Loja Online</h2>
                <small class="text-white-50">Painel administrativo</small>
            </div>
            <button class="btn-close" type="button" data-bs-dismiss="offcanvas" aria-label="Fechar menu"></button>
        </div>

        <div class="offcanvas-body">
            <nav class="sidebar-nav p-0" aria-label="Menu móvel">
                <a class="sidebar-link active" href="admin"><i class="bi bi-grid-1x2-fill"></i> Dashboard</a>
                <a class="sidebar-link" href="admin/produtos"><i class="bi bi-box-seam-fill"></i> Produtos</a>
                <a class="sidebar-link" href="admin/categorias"><i class="bi bi-tags-fill"></i> Categorias</a>
                <a class="sidebar-link" href="admin/clientes"><i class="bi bi-people-fill"></i> Clientes</a>
                <a class="sidebar-link" href="admin/pedidos"><i class="bi bi-bag-check-fill"></i> Pedidos</a>
                <a class="sidebar-link" href="admin/pagamentos"><i class="bi bi-credit-card-fill"></i> Pagamentos</a>
                <a class="sidebar-link" href="admin/estoque"><i class="bi bi-boxes"></i> Estoque</a>
                <a class="sidebar-link" href="admin/notificacoes"><i class="bi bi-bell-fill"></i> Notificações</a>
                <a class="sidebar-link" href="admin/relatorios"><i class="bi bi-bar-chart-line-fill"></i> Relatórios</a>
                <a class="sidebar-link" href="admin/configuracoes"><i class="bi bi-gear-fill"></i> Configurações</a>
            </nav>
        </div>
    </div>

    <div class="main-wrapper">
        <?php View::componenteAdmin('header'); ?>

        <main class="content-area">
            <div class="container-fluid p-0">
                <section class="mb-4">

                    <div
                        class="d-flex
               justify-content-between
               align-items-center
               flex-wrap
               gap-3
               mb-4">

                        <div>

                            <h1 class="h3 fw-bold mb-1">
                                Novo produto
                            </h1>

                            <p class="text-secondary mb-0">
                                Cadastre um novo produto
                                na Loja Online.
                            </p>

                        </div>


                        <a
                            href="<?=
                                    BASE_URL
                                    ?>/admin/produtos"
                            class="btn
                   btn-outline-secondary">

                            <i
                                class="bi
                       bi-arrow-left
                       me-1"></i>

                            Voltar

                        </a>

                    </div>


                    <?php if (
                        !empty($erro)
                    ): ?>

                        <div
                            class="alert
                   alert-danger">

                            <i
                                class="bi
                       bi-exclamation-triangle-fill
                       me-2"></i>

                            <?=
                            htmlspecialchars(
                                (string) $erro,
                                ENT_QUOTES,
                                'UTF-8'
                            )
                            ?>

                        </div>

                    <?php endif; ?>


                    <form
                        action="<?=
                                BASE_URL
                                ?>/admin/produto/cadastrar"
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


                        <div class="row g-4">


                            <!-- COLUNA PRINCIPAL -->

                            <div class="col-lg-8">


                                <div
                                    class="card
                           border-0
                           shadow-sm
                           mb-4">

                                    <div
                                        class="card-header
                               bg-white
                               fw-semibold">

                                        <i
                                            class="bi
                                   bi-box-seam
                                   me-2"></i>

                                        Informações do produto

                                    </div>


                                    <div class="card-body">

                                        <div class="row g-3">


                                            <div class="col-md-6">

                                                <label
                                                    class="form-label"
                                                    for="categoria_id">
                                                    Categoria
                                                </label>

                                                <select
                                                    class="form-select"
                                                    id="categoria_id"
                                                    name="categoria_id"
                                                    required>

                                                    <option value="">
                                                        Selecione
                                                    </option>


                                                    <?php foreach (
                                                        $categorias
                                                        as $categoria
                                                    ): ?>

                                                        <?php
                                                        $categoriaId =
                                                            (int)
                                                            $categoria['id'];

                                                        $categoriaAtiva =
                                                            (int) (
                                                                $categoria['ativo']
                                                                ?? 0
                                                            ) === 1;
                                                        ?>


                                                        <option
                                                            value="<?=
                                                                    $categoriaId
                                                                    ?>"

                                                            <?=
                                                            (
                                                                (int) (
                                                                    $dadosFormulario['categoria_id']
                                                                    ?? 0
                                                                )
                                                                === $categoriaId
                                                            )
                                                                ? 'selected'
                                                                : ''
                                                            ?>

                                                            <?=
                                                            !$categoriaAtiva
                                                                ? 'disabled'
                                                                : ''
                                                            ?>>

                                                            <?=
                                                            htmlspecialchars(
                                                                (string)
                                                                $categoria['nome'],
                                                                ENT_QUOTES,
                                                                'UTF-8'
                                                            )
                                                            ?>

                                                            <?php if (
                                                                !$categoriaAtiva
                                                            ): ?>
                                                                (inativa)
                                                            <?php endif; ?>

                                                        </option>

                                                    <?php endforeach; ?>

                                                </select>

                                            </div>


                                            <div class="col-md-6">

                                                <label
                                                    class="form-label"
                                                    for="status">
                                                    Status
                                                </label>

                                                <select
                                                    class="form-select"
                                                    id="status"
                                                    name="status"
                                                    required>

                                                    <option
                                                        value="ativo"
                                                        <?=
                                                        (
                                                            $dadosFormulario['status']
                                                            ?? 'ativo'
                                                        ) === 'ativo'
                                                            ? 'selected'
                                                            : ''
                                                        ?>>
                                                        Ativo
                                                    </option>

                                                    <option
                                                        value="inativo"
                                                        <?=
                                                        (
                                                            $dadosFormulario['status']
                                                            ?? ''
                                                        ) === 'inativo'
                                                            ? 'selected'
                                                            : ''
                                                        ?>>
                                                        Inativo
                                                    </option>

                                                </select>

                                            </div>


                                            <div class="col-12">

                                                <label
                                                    class="form-label"
                                                    for="nome">
                                                    Nome do produto
                                                </label>

                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="nome"
                                                    name="nome"
                                                    maxlength="150"
                                                    value="<?=
                                                            htmlspecialchars(
                                                                (string) (
                                                                    $dadosFormulario['nome']
                                                                    ?? ''
                                                                ),
                                                                ENT_QUOTES,
                                                                'UTF-8'
                                                            )
                                                            ?>"
                                                    required>

                                            </div>


                                            <div class="col-12">

                                                <label
                                                    class="form-label"
                                                    for="slug">
                                                    Slug
                                                </label>

                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="slug"
                                                    name="slug"
                                                    maxlength="180"
                                                    value="<?=
                                                            htmlspecialchars(
                                                                (string) (
                                                                    $dadosFormulario['slug']
                                                                    ?? ''
                                                                ),
                                                                ENT_QUOTES,
                                                                'UTF-8'
                                                            )
                                                            ?>">

                                                <div class="form-text">
                                                    Deixe em branco
                                                    para gerar automaticamente.
                                                </div>

                                            </div>


                                            <div class="col-12">

                                                <label
                                                    class="form-label"
                                                    for="descricao">
                                                    Descrição
                                                </label>

                                                <textarea
                                                    class="form-control"
                                                    id="descricao"
                                                    name="descricao"
                                                    rows="6"><?=
                                                                htmlspecialchars(
                                                                    (string) (
                                                                        $dadosFormulario['descricao']
                                                                        ?? ''
                                                                    ),
                                                                    ENT_QUOTES,
                                                                    'UTF-8'
                                                                )
                                                                ?></textarea>

                                            </div>

                                        </div>

                                    </div>

                                </div>


                                <!-- PREÇO E ESTOQUE -->

                                <div
                                    class="card
                           border-0
                           shadow-sm
                           mb-4">

                                    <div
                                        class="card-header
                               bg-white
                               fw-semibold">
                                        Preço e estoque
                                    </div>


                                    <div class="card-body">

                                        <div class="row g-3">


                                            <div class="col-md-4">

                                                <label
                                                    class="form-label"
                                                    for="preco">
                                                    Preço
                                                </label>

                                                <div class="input-group">

                                                    <span
                                                        class="input-group-text">
                                                        R$
                                                    </span>

                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="preco"
                                                        name="preco"
                                                        placeholder="0,00"
                                                        value="<?=
                                                                htmlspecialchars(
                                                                    (string) (
                                                                        $dadosFormulario['preco']
                                                                        ?? ''
                                                                    ),
                                                                    ENT_QUOTES,
                                                                    'UTF-8'
                                                                )
                                                                ?>"
                                                        required>

                                                </div>

                                            </div>


                                            <div class="col-md-4">

                                                <label
                                                    class="form-label"
                                                    for="estoque">
                                                    Estoque inicial
                                                </label>

                                                <input
                                                    type="number"
                                                    class="form-control"
                                                    id="estoque"
                                                    name="estoque"
                                                    min="0"
                                                    value="<?=
                                                            htmlspecialchars(
                                                                (string) (
                                                                    $dadosFormulario['estoque']
                                                                    ?? '0'
                                                                ),
                                                                ENT_QUOTES,
                                                                'UTF-8'
                                                            )
                                                            ?>"
                                                    required>

                                            </div>


                                            <div class="col-md-4">

                                                <label
                                                    class="form-label"
                                                    for="limite_estoque">
                                                    Limite de estoque
                                                </label>

                                                <input
                                                    type="number"
                                                    class="form-control"
                                                    id="limite_estoque"
                                                    name="limite_estoque"
                                                    min="0"
                                                    value="<?=
                                                            htmlspecialchars(
                                                                (string) (
                                                                    $dadosFormulario['limite_estoque']
                                                                    ?? '5'
                                                                ),
                                                                ENT_QUOTES,
                                                                'UTF-8'
                                                            )
                                                            ?>"
                                                    required>

                                                <div class="form-text">
                                                    Quantidade usada para
                                                    alerta de estoque baixo.
                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>


                                <!-- OFERTA -->

                                <div
                                    class="card
                           border-0
                           shadow-sm">

                                    <div
                                        class="card-header
                               bg-white
                               fw-semibold">
                                        Oferta
                                    </div>


                                    <div class="card-body">


                                        <div
                                            class="form-check
                                   form-switch
                                   mb-4">

                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                role="switch"
                                                id="oferta_ativa"
                                                name="oferta_ativa"
                                                value="1"

                                                <?=
                                                isset(
                                                    $dadosFormulario['oferta_ativa']
                                                )
                                                    ? 'checked'
                                                    : ''
                                                ?>>

                                            <label
                                                class="form-check-label
                                       fw-semibold"
                                                for="oferta_ativa">
                                                Ativar oferta
                                            </label>

                                        </div>


                                        <div class="row g-3">


                                            <div class="col-md-4">

                                                <label
                                                    class="form-label"
                                                    for="percentual_oferta">
                                                    Desconto (%)
                                                </label>

                                                <input
                                                    type="number"
                                                    step="0.01"
                                                    min="0"
                                                    max="100"
                                                    class="form-control"
                                                    id="percentual_oferta"
                                                    name="percentual_oferta"
                                                    value="<?=
                                                            htmlspecialchars(
                                                                (string) (
                                                                    $dadosFormulario['percentual_oferta']
                                                                    ?? ''
                                                                ),
                                                                ENT_QUOTES,
                                                                'UTF-8'
                                                            )
                                                            ?>">

                                            </div>


                                            <div class="col-md-4">

                                                <label
                                                    class="form-label"
                                                    for="oferta_inicio">
                                                    Início
                                                </label>

                                                <input
                                                    type="datetime-local"
                                                    class="form-control"
                                                    id="oferta_inicio"
                                                    name="oferta_inicio"
                                                    value="<?=
                                                            htmlspecialchars(
                                                                (string) (
                                                                    $dadosFormulario['oferta_inicio']
                                                                    ?? ''
                                                                ),
                                                                ENT_QUOTES,
                                                                'UTF-8'
                                                            )
                                                            ?>">

                                            </div>


                                            <div class="col-md-4">

                                                <label
                                                    class="form-label"
                                                    for="oferta_fim">
                                                    Final
                                                </label>

                                                <input
                                                    type="datetime-local"
                                                    class="form-control"
                                                    id="oferta_fim"
                                                    name="oferta_fim"
                                                    value="<?=
                                                            htmlspecialchars(
                                                                (string) (
                                                                    $dadosFormulario['oferta_fim']
                                                                    ?? ''
                                                                ),
                                                                ENT_QUOTES,
                                                                'UTF-8'
                                                            )
                                                            ?>">

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>


                            <!-- COLUNA LATERAL -->

                            <div class="col-lg-4">


                                <div
                                    class="card
                           border-0
                           shadow-sm
                           mb-4">

                                    <div
                                        class="card-header
                               bg-white
                               fw-semibold">
                                        Publicação
                                    </div>


                                    <div class="card-body">


                                        <div
                                            class="form-check
                                   form-switch">

                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                role="switch"
                                                id="destaque"
                                                name="destaque"
                                                value="1"

                                                <?=
                                                isset(
                                                    $dadosFormulario['destaque']
                                                )
                                                    ? 'checked'
                                                    : ''
                                                ?>>

                                            <label
                                                class="form-check-label"
                                                for="destaque">
                                                Produto em destaque
                                            </label>

                                        </div>

                                    </div>

                                </div>


                                <div
                                    class="alert
                           alert-info">

                                    <i
                                        class="bi
                               bi-info-circle-fill
                               me-1"></i>

                                    Após cadastrar o produto,
                                    você será direcionado para
                                    adicionar as imagens.

                                </div>


                                <div class="d-grid gap-2">

                                    <button
                                        type="submit"
                                        class="btn
                               btn-primary
                               btn-lg">

                                        <i
                                            class="bi
                                   bi-check-lg
                                   me-1"></i>

                                        Cadastrar produto

                                    </button>


                                    <a
                                        href="<?=
                                                BASE_URL
                                                ?>/admin/produtos"
                                        class="btn
                               btn-outline-secondary">
                                        Cancelar
                                    </a>

                                </div>

                            </div>

                        </div>

                    </form>

                </section>




            </div>
        </main>

        <?php View::componenteAdmin('footer'); ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('anoAtual').textContent = new Date().getFullYear();

            const caminhoAtual = window.location.pathname
                .replace('<?= BASE_URL ?>/', '')
                .replace(/^\/+|\/+$/g, '');

            document.querySelectorAll('.sidebar-link[data-route]').forEach(function(link) {
                const rota = link.dataset.route || '';
                link.classList.remove('active');

                if (caminhoAtual === rota || caminhoAtual.startsWith(rota + '/')) {
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>

</html>