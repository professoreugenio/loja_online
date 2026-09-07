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
                <section>
                    <!--
    |--------------------------------------------------------------------------
    | Cabeçalho
    |--------------------------------------------------------------------------
    -->
                    <div
                        class="d-flex justify-content-between
               align-items-center flex-wrap gap-3 mb-4">
                        <div>
                            <h1 class="h3 fw-bold mb-1">
                                Administradores
                            </h1>
                            <p class="text-secondary mb-0">
                                Gerencie os usuários autorizados
                                a utilizar o painel administrativo.
                            </p>
                        </div>
                        <?php if ($ehMaster): ?>
                            <a
                                href="<?= BASE_URL ?>/admin/perfil/novo"
                                class="btn btn-primary">
                                <i class="bi bi-person-plus me-1"></i>
                                Novo administrador
                            </a>
                        <?php endif; ?>
                    </div>
                    <!--
    |--------------------------------------------------------------------------
    | Mensagem de sucesso
    |--------------------------------------------------------------------------
    -->
                    <?php if (!empty($sucesso)): ?>
                        <div
                            class="alert alert-success
                   alert-dismissible fade show"
                            role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <?=
                            htmlspecialchars(
                                (string) $sucesso,
                                ENT_QUOTES,
                                'UTF-8'
                            )
                            ?>
                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="alert"
                                aria-label="Fechar"></button>
                        </div>
                    <?php endif; ?>
                    <!--
    |--------------------------------------------------------------------------
    | Mensagem de erro
    |--------------------------------------------------------------------------
    -->
                    <?php if (!empty($erro)): ?>
                        <div
                            class="alert alert-danger
                   alert-dismissible fade show"
                            role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <?=
                            htmlspecialchars(
                                (string) $erro,
                                ENT_QUOTES,
                                'UTF-8'
                            )
                            ?>
                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="alert"
                                aria-label="Fechar"></button>
                        </div>
                    <?php endif; ?>
                    <!--
    |--------------------------------------------------------------------------
    | Card da listagem
    |--------------------------------------------------------------------------
    -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3">
                            <div
                                class="d-flex justify-content-between
                       align-items-center flex-wrap gap-2">
                                <div>
                                    <h2 class="h5 mb-1">
                                        Usuários administrativos
                                    </h2>
                                    <small class="text-secondary">
                                        <?= count($administradores) ?>
                                        administrador(es) cadastrado(s)
                                    </small>
                                </div>
                                <?php if (!$ehMaster): ?>
                                    <span class="badge text-bg-secondary">
                                        <i class="bi bi-shield-lock me-1"></i>
                                        Somente leitura
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table
                                class="table table-hover
                       align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>
                                            Administrador
                                        </th>
                                        <th>
                                            Nível
                                        </th>
                                        <th>
                                            Status
                                        </th>
                                        <th>
                                            Último acesso
                                        </th>
                                        <?php if ($ehMaster): ?>
                                            <th
                                                class="text-end"
                                                style="width: 120px;">
                                                Ações
                                            </th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach (
                                        $administradores as $item
                                    ): ?>
                                        <?php
                                        $idAdmin =
                                            (int) $item['id'];
                                        $ehUsuarioAtual =
                                            $idAdmin ===
                                            (int) $adminAtualId;
                                        $nivelAdmin =
                                            (string) (
                                                $item['nivel_admin']
                                                ?? 'operador'
                                            );
                                        $statusAdmin =
                                            (string) (
                                                $item['status']
                                                ?? 'inativo'
                                            );
                                        $modalId =
                                            'editarAdmin'
                                            . $idAdmin;
                                        ?>
                                        <tr>
                                            <!-- Administrador -->
                                            <td>
                                                <div
                                                    class="d-flex
                                           align-items-center
                                           gap-3">
                                                    <div
                                                        class="rounded-circle
                                               bg-primary-subtle
                                               text-primary
                                               d-flex
                                               align-items-center
                                               justify-content-center"
                                                        style="
                                            width: 42px;
                                            height: 42px;
                                            min-width: 42px;
                                        ">
                                                        <i class="bi bi-person-fill"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold">
                                                            <?=
                                                            htmlspecialchars(
                                                                (string)
                                                                $item['nome'],
                                                                ENT_QUOTES,
                                                                'UTF-8'
                                                            )
                                                            ?>
                                                            <?php if (
                                                                $ehUsuarioAtual
                                                            ): ?>
                                                                <span
                                                                    class="badge
                                                           text-bg-info
                                                           ms-1">
                                                                    Você
                                                                </span>
                                                            <?php endif; ?>
                                                        </div>
                                                        <small
                                                            class="text-secondary">
                                                            <?=
                                                            htmlspecialchars(
                                                                (string)
                                                                $item['email'],
                                                                ENT_QUOTES,
                                                                'UTF-8'
                                                            )
                                                            ?>
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <!-- Nível -->
                                            <td>
                                                <span
                                                    class="badge <?=
                                                                    $nivelAdmin
                                                                        === 'master'
                                                                        ? 'text-bg-primary'
                                                                        : 'text-bg-secondary'
                                                                    ?>">
                                                    <i
                                                        class="bi <?=
                                                                    $nivelAdmin
                                                                        === 'master'
                                                                        ? 'bi-shield-fill-check'
                                                                        : 'bi-person-gear'
                                                                    ?> me-1"></i>
                                                    <?=
                                                    htmlspecialchars(
                                                        ucfirst(
                                                            $nivelAdmin
                                                        ),
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    )
                                                    ?>
                                                </span>
                                            </td>
                                            <!-- Status -->
                                            <td>
                                                <span
                                                    class="badge <?=
                                                                    $statusAdmin
                                                                        === 'ativo'
                                                                        ? 'text-bg-success'
                                                                        : 'text-bg-danger'
                                                                    ?>">
                                                    <i
                                                        class="bi <?=
                                                                    $statusAdmin
                                                                        === 'ativo'
                                                                        ? 'bi-check-circle-fill'
                                                                        : 'bi-x-circle-fill'
                                                                    ?> me-1"></i>
                                                    <?=
                                                    htmlspecialchars(
                                                        ucfirst(
                                                            $statusAdmin
                                                        ),
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    )
                                                    ?>
                                                </span>
                                            </td>
                                            <!-- Último acesso -->
                                            <td>
                                                <?php if (
                                                    !empty($item['ultimo_acesso'])
                                                ): ?>
                                                    <div>
                                                        <i
                                                            class="bi bi-clock-history
                                                   text-secondary me-1"></i>
                                                        <?=
                                                        date(
                                                            'd/m/Y H:i',
                                                            strtotime(
                                                                (string)
                                                                $item['ultimo_acesso']
                                                            )
                                                        )
                                                        ?>
                                                    </div>
                                                <?php else: ?>
                                                    <span
                                                        class="text-secondary">
                                                        <i
                                                            class="bi bi-dash-circle me-1"></i>
                                                        Nunca acessou
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <!-- Ações -->
                                            <?php if ($ehMaster): ?>
                                                <td class="text-end">
                                                    <button
                                                        type="button"
                                                        class="btn
                                               btn-outline-primary
                                               btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#<?= $modalId ?>">
                                                        <i
                                                            class="bi bi-pencil-square me-1"></i>
                                                        Editar
                                                    </button>
                                                </td>
                                            <?php endif; ?>
                                        </tr>
                                        <!--
                        |--------------------------------------------------------------------------
                        | Modal editar administrador
                        |--------------------------------------------------------------------------
                        -->
                                        <?php if ($ehMaster): ?>
                                            <div
                                                class="modal fade"
                                                id="<?= $modalId ?>"
                                                tabindex="-1"
                                                aria-hidden="true">
                                                <div
                                                    class="modal-dialog
                                           modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <div>
                                                                <h2
                                                                    class="modal-title
                                                           fs-5">
                                                                    Editar administrador
                                                                </h2>
                                                                <small
                                                                    class="text-secondary">
                                                                    Atualize os dados
                                                                    e permissões.
                                                                </small>
                                                            </div>
                                                            <button
                                                                type="button"
                                                                class="btn-close"
                                                                data-bs-dismiss="modal"
                                                                aria-label="Fechar"></button>
                                                        </div>
                                                        <form
                                                            action="<?= BASE_URL ?>/admin/perfil/admin/atualizar"
                                                            method="post">
                                                            <div class="modal-body">
                                                                <!-- CSRF -->
                                                                <input
                                                                    type="hidden"
                                                                    name="_token"
                                                                    value="<?=
                                                                            htmlspecialchars(
                                                                                (string)
                                                                                $csrfToken,
                                                                                ENT_QUOTES,
                                                                                'UTF-8'
                                                                            )
                                                                            ?>">
                                                                <!-- ID -->
                                                                <input
                                                                    type="hidden"
                                                                    name="id"
                                                                    value="<?=
                                                                            (int)
                                                                            $item['id']
                                                                            ?>">
                                                                <!-- Nome -->
                                                                <div class="mb-3">
                                                                    <label
                                                                        class="form-label"
                                                                        for="nome_<?= $idAdmin ?>">
                                                                        Nome
                                                                    </label>
                                                                    <input
                                                                        type="text"
                                                                        class="form-control"
                                                                        id="nome_<?= $idAdmin ?>"
                                                                        name="nome"
                                                                        value="<?=
                                                                                htmlspecialchars(
                                                                                    (string)
                                                                                    $item['nome'],
                                                                                    ENT_QUOTES,
                                                                                    'UTF-8'
                                                                                )
                                                                                ?>"
                                                                        maxlength="150"
                                                                        required>
                                                                </div>
                                                                <!-- E-mail -->
                                                                <div class="mb-3">
                                                                    <label
                                                                        class="form-label"
                                                                        for="email_<?= $idAdmin ?>">
                                                                        E-mail
                                                                    </label>
                                                                    <input
                                                                        type="email"
                                                                        class="form-control"
                                                                        id="email_<?= $idAdmin ?>"
                                                                        name="email"
                                                                        value="<?=
                                                                                htmlspecialchars(
                                                                                    (string)
                                                                                    $item['email'],
                                                                                    ENT_QUOTES,
                                                                                    'UTF-8'
                                                                                )
                                                                                ?>"
                                                                        maxlength="180"
                                                                        required>
                                                                </div>
                                                                <div class="row g-3">
                                                                    <!-- Nível -->
                                                                    <div class="col-md-6">
                                                                        <label
                                                                            class="form-label"
                                                                            for="nivel_<?= $idAdmin ?>">
                                                                            Nível
                                                                        </label>
                                                                        <select
                                                                            class="form-select"
                                                                            id="nivel_<?= $idAdmin ?>"
                                                                            name="nivel_admin"
                                                                            required>
                                                                            <option
                                                                                value="operador"
                                                                                <?=
                                                                                $nivelAdmin
                                                                                    === 'operador'
                                                                                    ? 'selected'
                                                                                    : ''
                                                                                ?>>
                                                                                Operador
                                                                            </option>
                                                                            <option
                                                                                value="master"
                                                                                <?=
                                                                                $nivelAdmin
                                                                                    === 'master'
                                                                                    ? 'selected'
                                                                                    : ''
                                                                                ?>>
                                                                                Master
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                    <!-- Status -->
                                                                    <div class="col-md-6">
                                                                        <label
                                                                            class="form-label"
                                                                            for="status_<?= $idAdmin ?>">
                                                                            Status
                                                                        </label>
                                                                        <select
                                                                            class="form-select"
                                                                            id="status_<?= $idAdmin ?>"
                                                                            name="status"
                                                                            required>
                                                                            <option
                                                                                value="ativo"
                                                                                <?=
                                                                                $statusAdmin
                                                                                    === 'ativo'
                                                                                    ? 'selected'
                                                                                    : ''
                                                                                ?>>
                                                                                Ativo
                                                                            </option>
                                                                            <option
                                                                                value="inativo"
                                                                                <?=
                                                                                $statusAdmin
                                                                                    === 'inativo'
                                                                                    ? 'selected'
                                                                                    : ''
                                                                                ?>>
                                                                                Inativo
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="alert
                                                           alert-warning
                                                           mt-4 mb-0">
                                                                    <i
                                                                        class="bi
                                                               bi-exclamation-triangle-fill
                                                               me-1"></i>
                                                                    Alterar o nível modifica
                                                                    as permissões deste
                                                                    administrador no painel.
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button
                                                                    type="button"
                                                                    class="btn
                                                           btn-outline-secondary"
                                                                    data-bs-dismiss="modal">
                                                                    Cancelar
                                                                </button>
                                                                <button
                                                                    type="submit"
                                                                    class="btn btn-primary">
                                                                    <i
                                                                        class="bi
                                                               bi-check-lg
                                                               me-1"></i>
                                                                    Salvar alterações
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
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