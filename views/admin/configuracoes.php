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
                                Configurações
                            </h1>

                            <p class="text-secondary mb-0">
                                Gerencie as informações
                                gerais da Loja Online.
                            </p>

                        </div>


                        <?php if (
                            (int)
                            $configuracoes['sitestandby']
                            === 1
                        ): ?>

                            <span
                                class="badge
                       text-bg-warning
                       fs-6">
                                Site em Standby
                            </span>

                        <?php else: ?>

                            <span
                                class="badge
                       text-bg-success
                       fs-6">
                                Site Online
                            </span>

                        <?php endif; ?>

                    </div>


                    <?php if (!empty($sucesso)): ?>

                        <div
                            class="alert alert-success">
                            <?=
                            htmlspecialchars(
                                $sucesso,
                                ENT_QUOTES,
                                'UTF-8'
                            )
                            ?>
                        </div>

                    <?php endif; ?>


                    <?php if (!empty($erro)): ?>

                        <div
                            class="alert alert-danger">
                            <?=
                            htmlspecialchars(
                                $erro,
                                ENT_QUOTES,
                                'UTF-8'
                            )
                            ?>
                        </div>

                    <?php endif; ?>


                    <form
                        action="<?= BASE_URL ?>/admin/configuracoes/atualizar"
                        method="post">

                        <input
                            type="hidden"
                            name="_token"
                            value="<?=
                                    htmlspecialchars(
                                        $csrfToken,
                                        ENT_QUOTES,
                                        'UTF-8'
                                    )
                                    ?>">

                        <input
                            type="hidden"
                            name="id"
                            value="<?=
                                    (int)
                                    $configuracoes['id']
                                    ?>">


                        <div class="row g-4">


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
                                        Informações gerais
                                    </div>


                                    <div class="card-body">

                                        <div class="row g-3">


                                            <div class="col-md-6">

                                                <label
                                                    class="form-label">
                                                    Nome do site
                                                </label>

                                                <input
                                                    class="form-control"
                                                    name="nomedosite"
                                                    maxlength="150"
                                                    value="<?=
                                                            htmlspecialchars(
                                                                $configuracoes['nomedosite'],
                                                                ENT_QUOTES,
                                                                'UTF-8'
                                                            )
                                                            ?>"
                                                    required>

                                            </div>


                                            <div class="col-md-6">

                                                <label
                                                    class="form-label">
                                                    Slogan
                                                </label>

                                                <input
                                                    class="form-control"
                                                    name="slogan"
                                                    value="<?=
                                                            htmlspecialchars(
                                                                $configuracoes['slogan']
                                                                    ?? '',
                                                                ENT_QUOTES,
                                                                'UTF-8'
                                                            )
                                                            ?>">

                                            </div>


                                            <div class="col-12">

                                                <label
                                                    class="form-label">
                                                    Descrição
                                                </label>

                                                <textarea
                                                    class="form-control"
                                                    name="descricao"
                                                    rows="3"><?=
                                                                htmlspecialchars(
                                                                    $configuracoes['descricao']
                                                                        ?? '',
                                                                    ENT_QUOTES,
                                                                    'UTF-8'
                                                                )
                                                                ?></textarea>

                                            </div>


                                            <div class="col-md-6">

                                                <label
                                                    class="form-label">
                                                    E-mail
                                                </label>

                                                <input
                                                    class="form-control"
                                                    type="email"
                                                    name="email"
                                                    value="<?=
                                                            htmlspecialchars(
                                                                $configuracoes['email']
                                                                    ?? '',
                                                                ENT_QUOTES,
                                                                'UTF-8'
                                                            )
                                                            ?>">

                                            </div>


                                            <div class="col-md-6">

                                                <label
                                                    class="form-label">
                                                    WhatsApp
                                                </label>

                                                <input
                                                    class="form-control"
                                                    name="whatsapp"
                                                    value="<?=
                                                            htmlspecialchars(
                                                                $configuracoes['whatsapp']
                                                                    ?? '',
                                                                ENT_QUOTES,
                                                                'UTF-8'
                                                            )
                                                            ?>">

                                            </div>


                                            <div class="col-md-6">

                                                <label
                                                    class="form-label">
                                                    Logo
                                                </label>

                                                <input
                                                    class="form-control"
                                                    name="logo"
                                                    value="<?=
                                                            htmlspecialchars(
                                                                $configuracoes['logo']
                                                                    ?? '',
                                                                ENT_QUOTES,
                                                                'UTF-8'
                                                            )
                                                            ?>">

                                            </div>


                                            <div class="col-md-6">

                                                <label
                                                    class="form-label">
                                                    Favicon
                                                </label>

                                                <input
                                                    class="form-control"
                                                    name="favicon"
                                                    value="<?=
                                                            htmlspecialchars(
                                                                $configuracoes['favicon']
                                                                    ?? '',
                                                                ENT_QUOTES,
                                                                'UTF-8'
                                                            )
                                                            ?>">

                                            </div>

                                        </div>

                                    </div>

                                </div>


                                <div
                                    class="card
                           border-0
                           shadow-sm
                           mb-4">

                                    <div
                                        class="card-header
                               bg-white
                               fw-semibold">
                                        SEO
                                    </div>

                                    <div class="card-body">

                                        <div class="mb-3">

                                            <label
                                                class="form-label">
                                                Título SEO
                                            </label>

                                            <input
                                                class="form-control"
                                                name="titulo_seo"
                                                value="<?=
                                                        htmlspecialchars(
                                                            $configuracoes['titulo_seo']
                                                                ?? '',
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        )
                                                        ?>">

                                        </div>


                                        <div class="mb-3">

                                            <label
                                                class="form-label">
                                                Descrição SEO
                                            </label>

                                            <textarea
                                                class="form-control"
                                                name="descricao_seo"
                                                maxlength="320"
                                                rows="3"><?=
                                                            htmlspecialchars(
                                                                $configuracoes['descricao_seo']
                                                                    ?? '',
                                                                ENT_QUOTES,
                                                                'UTF-8'
                                                            )
                                                            ?></textarea>

                                        </div>


                                        <div>

                                            <label
                                                class="form-label">
                                                Palavras-chave
                                            </label>

                                            <textarea
                                                class="form-control"
                                                name="keywords"
                                                rows="2"><?=
                                                            htmlspecialchars(
                                                                $configuracoes['keywords']
                                                                    ?? '',
                                                                ENT_QUOTES,
                                                                'UTF-8'
                                                            )
                                                            ?></textarea>

                                        </div>

                                    </div>

                                </div>

                            </div>


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
                                        Disponibilidade
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
                                                id="sitestandby"
                                                name="sitestandby"
                                                value="1"
                                                <?=
                                                (int)
                                                $configuracoes['sitestandby'] === 1
                                                    ? 'checked'
                                                    : ''
                                                ?>>

                                            <label
                                                class="form-check-label
                                       fw-semibold"
                                                for="sitestandby">
                                                Site em Standby
                                            </label>

                                        </div>


                                        <div
                                            class="alert
                                   alert-warning
                                   small">

                                            Ao ativar esta opção,
                                            todas as páginas públicas
                                            serão substituídas por
                                            standby.html.

                                            O painel administrativo
                                            continuará disponível.

                                        </div>


                                        <div class="mb-4">

                                            <label
                                                class="form-label">
                                                Mensagem Standby
                                            </label>

                                            <textarea
                                                class="form-control"
                                                name="mensagemstandby"
                                                rows="3"><?=
                                                            htmlspecialchars(
                                                                $configuracoes['mensagemstandby']
                                                                    ?? '',
                                                                ENT_QUOTES,
                                                                'UTF-8'
                                                            )
                                                            ?></textarea>

                                        </div>


                                        <div
                                            class="form-check
                                   form-switch">

                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                role="switch"
                                                id="sitemanutencao"
                                                name="sitemanutencao"
                                                value="1"
                                                <?=
                                                (int)
                                                $configuracoes['sitemanutencao'] === 1
                                                    ? 'checked'
                                                    : ''
                                                ?>>

                                            <label
                                                class="form-check-label"
                                                for="sitemanutencao">
                                                Modo manutenção
                                            </label>

                                        </div>


                                        <div class="mt-3">

                                            <label
                                                class="form-label">
                                                Mensagem manutenção
                                            </label>

                                            <textarea
                                                class="form-control"
                                                name="mensagemmanutencao"
                                                rows="3"><?=
                                                            htmlspecialchars(
                                                                $configuracoes['mensagemmanutencao']
                                                                    ?? '',
                                                                ENT_QUOTES,
                                                                'UTF-8'
                                                            )
                                                            ?></textarea>

                                        </div>

                                    </div>

                                </div>


                                <div
                                    class="card
                           border-0
                           shadow-sm
                           mb-4">

                                    <div
                                        class="card-header
                               bg-white
                               fw-semibold">
                                        Loja
                                    </div>

                                    <div class="card-body">

                                        <label
                                            class="form-label">
                                            Frete grátis a partir de
                                        </label>

                                        <div class="input-group">

                                            <span
                                                class="input-group-text">
                                                R$
                                            </span>

                                            <input
                                                class="form-control"
                                                name="frete_gratis_valor"
                                                value="<?=
                                                        htmlspecialchars(
                                                            $configuracoes['frete_gratis_valor']
                                                                ?? '',
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        )
                                                        ?>">

                                        </div>

                                    </div>

                                </div>


                                <div class="d-grid">

                                    <button
                                        class="btn
                               btn-primary
                               btn-lg"
                                        type="submit">

                                        <i
                                            class="bi bi-check-lg me-1"></i>

                                        Salvar configurações

                                    </button>

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