<?php
declare(strict_types=1);
use App\Helpers\View;
use App\Helpers\SessaoAdmin;
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
                    <div class="d-flex justify-content-between
            align-items-center flex-wrap gap-3 mb-4">
                        <!--
    |--------------------------------------------------------------------------
    | Título
    |--------------------------------------------------------------------------
    -->
                        <div>
                            <h1 class="h3 fw-bold mb-1">
                                Meu perfil
                            </h1>
                            <p class="text-secondary mb-0">
                                Atualize seus dados administrativos.
                            </p>
                        </div>
                        <!--
    |--------------------------------------------------------------------------
    | Ações do perfil
    |--------------------------------------------------------------------------
    -->
                        <div class="d-flex
                align-items-center
                flex-wrap
                gap-2">
                            <!-- Nível do administrador -->
                            <span class="badge text-bg-primary fs-6">
                                <?=
                                htmlspecialchars(
                                    strtoupper(
                                        (string)
                                        $admin['nivel_admin']
                                    ),
                                    ENT_QUOTES,
                                    'UTF-8'
                                )
                                ?>
                            </span>
                            <?php if (SessaoAdmin::ehMaster()): ?>
                                <!-- Lista de administradores -->
                                <a
                                    href="<?= BASE_URL ?>/admin/perfil/lista"
                                    class="btn btn-outline-secondary">
                                    <i class="bi bi-people me-1"></i>
                                    Administradores
                                </a>
                                <!--
        |--------------------------------------------------------------------------
        | Somente MASTER pode cadastrar administrador
        |--------------------------------------------------------------------------
        -->
                                <a
                                    href="<?= BASE_URL ?>/admin/perfil/novo"
                                    class="btn btn-primary">
                                    <i class="bi bi-person-plus me-1"></i>
                                    Novo administrador
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if (!empty($sucesso)): ?>
                        <div class="alert alert-success">
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
                        <div class="alert alert-danger">
                            <?=
                            htmlspecialchars(
                                $erro,
                                ENT_QUOTES,
                                'UTF-8'
                            )
                            ?>
                        </div>
                    <?php endif; ?>
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <form
                                action="<?= BASE_URL ?>/admin/perfil/atualizar"
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
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label
                                            for="nome"
                                            class="form-label">
                                            Nome
                                        </label>
                                        <input
                                            class="form-control"
                                            id="nome"
                                            name="nome"
                                            value="<?=
                                                    htmlspecialchars(
                                                        $admin['nome'],
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    )
                                                    ?>"
                                            required>
                                    </div>
                                    <div class="col-md-6">
                                        <label
                                            for="email"
                                            class="form-label">
                                            E-mail
                                        </label>
                                        <input
                                            class="form-control"
                                            type="email"
                                            id="email"
                                            name="email"
                                            value="<?=
                                                    htmlspecialchars(
                                                        $admin['email'],
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    )
                                                    ?>"
                                            required>
                                    </div>
                                    <div class="col-md-6">
                                        <label
                                            for="senha"
                                            class="form-label">
                                            Nova senha
                                        </label>
                                        <input
                                            class="form-control"
                                            type="password"
                                            id="senha"
                                            name="senha"
                                            autocomplete="new-password">
                                        <div class="form-text">
                                            Deixe em branco para manter
                                            a senha atual.
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label
                                            for="confirmar_senha"
                                            class="form-label">
                                            Confirmar nova senha
                                        </label>
                                        <input
                                            class="form-control"
                                            type="password"
                                            id="confirmar_senha"
                                            name="confirmar_senha"
                                            autocomplete="new-password">
                                    </div>
                                    <div class="col-12">
                                        <button
                                            class="btn btn-primary"
                                            type="submit">
                                            <i class="bi bi-check-lg"></i>
                                            Salvar alterações
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
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