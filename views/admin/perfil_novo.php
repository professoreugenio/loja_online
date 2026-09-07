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
                    <div class="d-flex justify-content-between
                align-items-center flex-wrap gap-3 mb-4">
                        <div>
                            <h1 class="h3 fw-bold mb-1">
                                Novo administrador
                            </h1>
                            <p class="text-secondary mb-0">
                                Cadastre um novo usuário
                                do painel administrativo.
                            </p>
                        </div>
                        <a
                            href="<?= BASE_URL ?>/admin/perfil/lista"
                            class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i>
                            Voltar
                        </a>
                    </div>
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
                                method="post"
                                action="<?= BASE_URL ?>/admin/perfil/cadastrar">
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
                                        <label class="form-label">
                                            Nome
                                        </label>
                                        <input
                                            class="form-control"
                                            name="nome"
                                            maxlength="150"
                                            required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">
                                            E-mail
                                        </label>
                                        <input
                                            class="form-control"
                                            type="email"
                                            name="email"
                                            maxlength="180"
                                            required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">
                                            Senha
                                        </label>
                                        <input
                                            class="form-control"
                                            type="password"
                                            name="senha"
                                            minlength="8"
                                            required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">
                                            Confirmar senha
                                        </label>
                                        <input
                                            class="form-control"
                                            type="password"
                                            name="confirmar_senha"
                                            minlength="8"
                                            required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">
                                            Nível administrativo
                                        </label>
                                        <select
                                            class="form-select"
                                            name="nivel_admin"
                                            required>
                                            <option value="operador">
                                                Operador
                                            </option>
                                            <option value="master">
                                                Master
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <button
                                            class="btn btn-primary"
                                            type="submit">
                                            <i class="bi bi-person-plus"></i>
                                            Cadastrar administrador
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