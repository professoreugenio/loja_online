<?php

declare(strict_types=1);

use App\Helpers\View;

$baseUrl = defined('BASE_URL') ? BASE_URL : '';
$busca = (string) ($filtros['busca'] ?? '');
$statusFiltro = (string) ($filtros['status'] ?? '');
$csrfToken = (string) ($csrfToken ?? '');
?>
<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gerenciamento de Clientes | Loja Online</title>
    <base href="/loja_online/public/">
    <link rel="icon" href="assets/img/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= htmlspecialchars($baseUrl . '/assets/css/admin.css', ENT_QUOTES, 'UTF-8') ?>">
</head>

<body>
    <?php View::componenteAdmin('aside'); ?>

    <div class="main-wrapper">
        <?php View::componenteAdmin('header'); ?>

        <main class="content-area p-4">
            <div class="container-fluid p-0">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 fw-bold mb-0">Clientes Cadastrados</h1>
                </div>

                <?php if (!empty($sucesso)): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <?= htmlspecialchars((string) $sucesso, ENT_QUOTES, 'UTF-8') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                    </div>
                <?php endif; ?>

                <?php if (!empty($erro)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <?= htmlspecialchars((string) $erro, ENT_QUOTES, 'UTF-8') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                    </div>
                <?php endif; ?>

                <!-- Filtro de Pesquisa -->
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-body">
                        <form method="GET" action="admin/clientes" class="row g-3">
                            <div class="col-12 col-md-6">
                                <label for="busca" class="form-label">Nome, E-mail ou CPF</label>
                                <input type="text" class="form-control" id="busca" name="busca" value="<?= htmlspecialchars($busca, ENT_QUOTES, 'UTF-8') ?>" placeholder="Digite nome, e-mail ou CPF...">
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="">Todos</option>
                                    <option value="ativo" <?= $statusFiltro === 'ativo' ? 'selected' : '' ?>>Ativo</option>
                                    <option value="inativo" <?= $statusFiltro === 'inativo' ? 'selected' : '' ?>>Inativo (0)</option>
                                    <option value="bloqueado" <?= $statusFiltro === 'bloqueado' ? 'selected' : '' ?>>Bloqueado</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-2 d-flex align-items-end gap-2">
                                <button type="submit" class="btn btn-primary flex-grow-1">
                                    <i class="bi bi-search"></i> Filtrar
                                </button>
                                <?php if ($busca !== '' || $statusFiltro !== ''): ?>
                                    <a href="admin/clientes" class="btn btn-outline-secondary" title="Limpar filtros">
                                        <i class="bi bi-x-lg"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tabela de Clientes -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>E-mail</th>
                                        <th>CPF</th>
                                        <th>Status</th>
                                        <th class="text-end">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($clientes)): ?>
                                        <tr>
                                            <td colspan="6" class="text-center py-4 text-muted">Nenhum cliente encontrado.</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($clientes as $c): ?>
                                            <tr>
                                                <td><?= $c['id'] ?></td>
                                                <td>
                                                    <a href="admin/cliente/view?id=<?= $c['id'] ?>" class="fw-bold text-decoration-none">
                                                        <?= htmlspecialchars($c['nome']) ?>
                                                    </a>
                                                </td>
                                                <td><?= htmlspecialchars($c['email']) ?></td>
                                                <td><?= htmlspecialchars($c['cpf'] ?? 'N/A') ?></td>
                                                <td>
                                                    <?php if ($c['status'] === 'ativo'): ?>
                                                        <span class="badge bg-success">Ativo</span>
                                                    <?php elseif ($c['status'] === 'inativo'): ?>
                                                        <span class="badge bg-secondary">Inativo (0)</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Bloqueado</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-end">

                                                    <?php if ($c['status'] === 'inativo'): ?>

                                                        <!-- Ativar cliente -->
                                                        <form
                                                            method="POST"
                                                            action="admin/cliente/ativar"
                                                            class="d-inline"
                                                            onsubmit="
                return confirm(
                    'Deseja realmente ativar este cliente?'
                );
            ">

                                                            <input
                                                                type="hidden"
                                                                name="csrf_token"
                                                                value="<?= htmlspecialchars(
                                                                            $csrfToken,
                                                                            ENT_QUOTES,
                                                                            'UTF-8'
                                                                        ) ?>">

                                                            <input
                                                                type="hidden"
                                                                name="id"
                                                                value="<?= htmlspecialchars(
                                                                            (string) ($c['id_seguro'] ?? ''),
                                                                            ENT_QUOTES,
                                                                            'UTF-8'
                                                                        ) ?>">

                                                            <button
                                                                type="submit"
                                                                class="btn btn-sm btn-outline-success"
                                                                title="Ativar cliente">
                                                                <i class="bi bi-person-check"></i>
                                                                Ativar
                                                            </button>

                                                        </form>


                                                    <?php else: ?>

                                                        <!-- Inativar cliente -->
                                                        <form
                                                            method="POST"
                                                            action="admin/cliente/inativar"
                                                            class="d-inline"
                                                            onsubmit="
                return confirm(
                    'Deseja realmente inativar este cliente?'
                );
            ">

                                                            <input
                                                                type="hidden"
                                                                name="csrf_token"
                                                                value="<?= htmlspecialchars(
                                                                            $csrfToken,
                                                                            ENT_QUOTES,
                                                                            'UTF-8'
                                                                        ) ?>">

                                                            <input
                                                                type="hidden"
                                                                name="id"
                                                                value="<?= htmlspecialchars(
                                                                            (string) ($c['id_seguro'] ?? ''),
                                                                            ENT_QUOTES,
                                                                            'UTF-8'
                                                                        ) ?>">

                                                            <button
                                                                type="submit"
                                                                class="btn btn-sm btn-outline-danger"
                                                                title="Inativar cliente">
                                                                <i class="bi bi-trash"></i>
                                                                Excluir
                                                            </button>

                                                        </form>

                                                    <?php endif; ?>

                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <?php View::componenteAdmin('footer'); ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>