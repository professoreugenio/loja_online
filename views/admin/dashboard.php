<?php

declare(strict_types=1);

use App\Helpers\View;
$baseUrl = defined('BASE_URL') ? BASE_URL : '';

$indicadores = is_array($indicadores ?? null)
    ? $indicadores
    : [];

$pedidosRecentes = is_array($pedidosRecentes ?? null)
    ? $pedidosRecentes
    : [];

$produtosEstoqueBaixo =
    is_array($produtosEstoqueBaixo ?? null)
        ? $produtosEstoqueBaixo
        : [];

$notificacoesNaoLidas =
    (int) ($notificacoesNaoLidas ?? 0);

$contatosRecebidos =
    (int) ($contatosRecebidos ?? 0);

$contatosAguardando =
    (int) ($contatosAguardando ?? 0);

$statusPedidos = [
    'aguardando_pagamento' => [
        'texto' => 'Aguardando pagamento',
        'classe' => 'text-bg-warning',
    ],
    'pago' => [
        'texto' => 'Pago',
        'classe' => 'text-bg-success',
    ],
    'em_separacao' => [
        'texto' => 'Em separação',
        'classe' => 'text-bg-primary',
    ],
    'enviado' => [
        'texto' => 'Enviado',
        'classe' => 'text-bg-info',
    ],
    'entregue' => [
        'texto' => 'Entregue',
        'classe' => 'text-bg-success',
    ],
    'cancelado' => [
        'texto' => 'Cancelado',
        'classe' => 'text-bg-danger',
    ],
];

?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Administrativo | Loja Online</title>
    <meta name="description" content="Painel administrativo para gerenciamento da loja online.">

    <!-- Caminho-base do projeto no XAMPP -->
    <base href="/loja_online/public/">

    <link rel="icon" href="assets/img/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">

  
    <link rel="stylesheet" href="<?= htmlspecialchars($baseUrl . '/assets/css/admin.css', ENT_QUOTES, 'UTF-8') ?>">
</head>

<body>
    <?php View::componenteAdmin('aside', [
    'notificacoesNaoLidas' => $notificacoesNaoLidas,
]); ?>

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
        <header class="topbar">
            <div class="container-fluid px-3 px-lg-4">
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-outline-secondary d-lg-none" type="button"
                            data-bs-toggle="offcanvas" data-bs-target="#menuMobile"
                            aria-label="Abrir menu">
                        <i class="bi bi-list fs-5"></i>
                    </button>

                    <form class="d-none d-md-block flex-grow-1" style="max-width:420px"
                          action="admin/buscar" method="get" role="search">
                        <label class="visually-hidden" for="buscaDashboard">Pesquisar no painel</label>
                        <div class="input-group">
                            <span class="input-group-text bg-body border-end-0">
                                <i class="bi bi-search text-secondary"></i>
                            </span>
                            <input class="form-control border-start-0" id="buscaDashboard"
                                   type="search" name="q"
                                   placeholder="Pesquisar produtos, clientes ou pedidos">
                        </div>
                    </form>

                    <div class="ms-auto d-flex align-items-center gap-2">
                        <a class="btn btn-light position-relative" href="admin/notificacoes"
                           aria-label="Abrir notificações">
                            <i class="bi bi-bell"></i>
                            <?php if ($notificacoesNaoLidas > 0): ?>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill text-bg-danger">
                                    <?= number_format($notificacoesNaoLidas, 0, ',', '.'); ?>
                                </span>
                            <?php endif; ?>
                        </a>

                        <div class="dropdown">
                            <button class="btn btn-light d-flex align-items-center gap-2"
                                    type="button" data-bs-toggle="dropdown">
                                <span class="avatar">AD</span>
                                <span class="d-none d-sm-block text-start">
                                    <strong class="d-block small">Administrador</strong>
                                    <small class="text-secondary">Conta administrativa</small>
                                </span>
                                <i class="bi bi-chevron-down small"></i>
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                <li>
                                    <a class="dropdown-item" href="admin/perfil">
                                        <i class="bi bi-person me-2"></i> Meu perfil
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="admin/configuracoes">
                                        <i class="bi bi-gear me-2"></i> Configurações
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li class="px-2">
                                    <form action="admin/sair" method="post">
                                        <button class="dropdown-item text-danger" type="submit">
                                            <i class="bi bi-box-arrow-left me-2"></i> Sair
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="content-area">
            <div class="container-fluid p-0">
                <section class="mb-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                        <div>
                            <h1 class="h3 fw-bold mb-1">Dashboard administrativo</h1>
                            <p class="text-secondary mb-0">
                                Acompanhe os dados e acesse os módulos da loja.
                            </p>
                        </div>

                        <div class="d-flex gap-2">
                            <a class="btn btn-outline-primary" href="" target="_blank">
                                <i class="bi bi-eye me-1"></i> Ver loja
                            </a>
                            <a class="btn btn-primary" href="admin/produtos/novo">
                                <i class="bi bi-plus-lg me-1"></i> Novo produto
                            </a>
                        </div>
                    </div>
                </section>

                <section class="mb-4" aria-label="Indicadores">
                    <div class="row g-3">
                        <div class="col-12 col-sm-6 col-xl-3">
                            <a href="admin/produtos" class="text-dark">
                                <article class="card metric-card">
                                    <div class="card-body d-flex justify-content-between gap-3">
                                        <div>
                                            <div class="metric-label">Produtos cadastrados</div>
                                            <p class="metric-value"><?= number_format((int) ($indicadores['total_produtos'] ?? 0), 0, ',', '.'); ?></p>
                                            <small class="text-success"><?= number_format((int) ($indicadores['produtos_mes'] ?? 0), 0, ',', '.'); ?> novos neste mês</small>
                                        </div>
                                        <span class="metric-icon bg-primary-subtle text-primary">
                                            <i class="bi bi-box-seam"></i>
                                        </span>
                                    </div>
                                </article>
                            </a>
                        </div>

                        <div class="col-12 col-sm-6 col-xl-3">
                            <a href="admin/clientes" class="text-dark">
                                <article class="card metric-card">
                                    <div class="card-body d-flex justify-content-between gap-3">
                                        <div>
                                            <div class="metric-label">Clientes cadastrados</div>
                                            <p class="metric-value"><?= number_format((int) ($indicadores['total_clientes'] ?? 0), 0, ',', '.'); ?></p>
                                            <small class="text-success"><?= number_format((int) ($indicadores['clientes_mes'] ?? 0), 0, ',', '.'); ?> novos neste mês</small>
                                        </div>
                                        <span class="metric-icon bg-success-subtle text-success">
                                            <i class="bi bi-people"></i>
                                        </span>
                                    </div>
                                </article>
                            </a>
                        </div>

                        <div class="col-12 col-sm-6 col-xl-3">
                            <a href="admin/pedidos" class="text-dark">
                                <article class="card metric-card">
                                    <div class="card-body d-flex justify-content-between gap-3">
                                        <div>
                                            <div class="metric-label">Pedidos pendentes</div>
                                            <p class="metric-value"><?= number_format((int) ($indicadores['pedidos_pendentes'] ?? 0), 0, ',', '.'); ?></p>
                                            <small class="text-warning-emphasis"><?= number_format((int) ($indicadores['pedidos_aguardando_pagamento'] ?? 0), 0, ',', '.'); ?> aguardam pagamento</small>
                                        </div>
                                        <span class="metric-icon bg-warning-subtle text-warning-emphasis">
                                            <i class="bi bi-bag-check"></i>
                                        </span>
                                    </div>
                                </article>
                            </a>
                        </div>

                        <div class="col-12 col-sm-6 col-xl-3">
                            <a href="admin/estoque?filtro=baixo" class="text-dark">
                                <article class="card metric-card">
                                    <div class="card-body d-flex justify-content-between gap-3">
                                        <div>
                                            <div class="metric-label">Estoque baixo</div>
                                            <p class="metric-value"><?= number_format((int) ($indicadores['estoque_baixo'] ?? 0), 0, ',', '.'); ?></p>
                                            <small class="text-danger">Requer atenção</small>
                                        </div>
                                        <span class="metric-icon bg-danger-subtle text-danger">
                                            <i class="bi bi-exclamation-triangle"></i>
                                        </span>
                                    </div>
                                </article>
                            </a>
                        </div>

                        <div class="col-12 col-sm-6 col-xl-3">
                            <a href="admin/carrinhos" class="text-dark">
                                <article class="card metric-card">
                                    <div class="card-body d-flex justify-content-between gap-3">
                                        <div>
                                            <div class="metric-label">Carrinhos ativos</div>
                                            <p class="metric-value"><?= number_format((int) ($indicadores['carrinhos_ativos'] ?? 0), 0, ',', '.'); ?></p>
                                            <small class="text-secondary"><?= number_format((int) ($indicadores['carrinhos_hoje'] ?? 0), 0, ',', '.'); ?> iniciados hoje</small>
                                        </div>
                                        <span class="metric-icon bg-info-subtle text-info-emphasis">
                                            <i class="bi bi-cart"></i>
                                        </span>
                                    </div>
                                </article>
                            </a>
                        </div>

                        <div class="col-12 col-sm-6 col-xl-3">
                            <a href="admin/pagamentos" class="text-dark">
                                <article class="card metric-card">
                                    <div class="card-body d-flex justify-content-between gap-3">
                                        <div>
                                            <div class="metric-label">Pagamentos confirmados</div>
                                            <p class="metric-value">R$ <?= number_format((float) ($indicadores['pagamentos_mes'] ?? 0), 2, ',', '.'); ?></p>
                                            <small class="text-success">Total do mês</small>
                                        </div>
                                        <span class="metric-icon bg-success-subtle text-success">
                                            <i class="bi bi-cash-coin"></i>
                                        </span>
                                    </div>
                                </article>
                            </a>
                        </div>

                        <div class="col-12 col-sm-6 col-xl-3">
                            <a href="admin/notificacoes" class="text-dark">
                                <article class="card metric-card">
                                    <div class="card-body d-flex justify-content-between gap-3">
                                        <div>
                                            <div class="metric-label">Notificações</div>
                                            <p class="metric-value"><?= number_format($notificacoesNaoLidas, 0, ',', '.'); ?></p>
                                            <small class="text-secondary">Tabela ainda não criada</small>
                                        </div>
                                        <span class="metric-icon bg-primary-subtle text-primary">
                                            <i class="bi bi-bell"></i>
                                        </span>
                                    </div>
                                </article>
                            </a>
                        </div>

                        <div class="col-12 col-sm-6 col-xl-3">
                            <a href="admin/contatos" class="text-dark">
                                <article class="card metric-card">
                                    <div class="card-body d-flex justify-content-between gap-3">
                                        <div>
                                            <div class="metric-label">Contatos recebidos</div>
                                            <p class="metric-value"><?= number_format($contatosRecebidos, 0, ',', '.'); ?></p>
                                            <small class="text-secondary"><?= number_format($contatosAguardando, 0, ',', '.'); ?> aguardam resposta</small>
                                        </div>
                                        <span class="metric-icon bg-secondary-subtle text-secondary">
                                            <i class="bi bi-chat-left-text"></i>
                                        </span>
                                    </div>
                                </article>
                            </a>
                        </div>
                    </div>
                </section>

                <section class="mb-4" aria-labelledby="acessosRapidos">
                    <h2 class="h5 fw-bold mb-3" id="acessosRapidos">Acessos rápidos</h2>

                    <div class="row g-3">
                        <div class="col-6 col-md-4 col-xl-2">
                            <a class="quick-card" href="admin/produtos">
                                <span class="quick-icon"><i class="bi bi-box-seam"></i></span>
                                <strong class="d-block">Produtos</strong>
                                <small class="text-secondary">Cadastrar e gerenciar</small>
                            </a>
                        </div>
                        <div class="col-6 col-md-4 col-xl-2">
                            <a class="quick-card" href="admin/clientes">
                                <span class="quick-icon"><i class="bi bi-people"></i></span>
                                <strong class="d-block">Clientes</strong>
                                <small class="text-secondary">Consultar cadastros</small>
                            </a>
                        </div>
                        <div class="col-6 col-md-4 col-xl-2">
                            <a class="quick-card" href="admin/pedidos">
                                <span class="quick-icon"><i class="bi bi-bag-check"></i></span>
                                <strong class="d-block">Pedidos</strong>
                                <small class="text-secondary">Acompanhar vendas</small>
                            </a>
                        </div>
                        <div class="col-6 col-md-4 col-xl-2">
                            <a class="quick-card" href="admin/pagamentos">
                                <span class="quick-icon"><i class="bi bi-credit-card"></i></span>
                                <strong class="d-block">Pagamentos</strong>
                                <small class="text-secondary">Conferir transações</small>
                            </a>
                        </div>
                        <div class="col-6 col-md-4 col-xl-2">
                            <a class="quick-card" href="admin/estoque">
                                <span class="quick-icon"><i class="bi bi-boxes"></i></span>
                                <strong class="d-block">Estoque</strong>
                                <small class="text-secondary">Controlar quantidades</small>
                            </a>
                        </div>
                        <div class="col-6 col-md-4 col-xl-2">
                            <a class="quick-card" href="admin/relatorios">
                                <span class="quick-icon"><i class="bi bi-file-earmark-bar-graph"></i></span>
                                <strong class="d-block">Relatórios</strong>
                                <small class="text-secondary">Analisar resultados</small>
                            </a>
                        </div>
                    </div>
                </section>

                <div class="row g-4">
                    <section class="col-12 col-xl-8" aria-labelledby="pedidosRecentes">
                        <article class="card panel-card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <h2 class="h5 fw-bold mb-1" id="pedidosRecentes">Pedidos recentes</h2>
                                    <small class="text-secondary">Últimas vendas registradas.</small>
                                </div>
                                <a class="btn btn-sm btn-outline-primary" href="admin/pedidos">Ver todos</a>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Pedido</th>
                                            <th>Cliente</th>
                                            <th>Data</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th class="text-end">Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if ($pedidosRecentes === []): ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-secondary py-4">
                                                Nenhum pedido registrado até o momento.
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($pedidosRecentes as $pedido): ?>
                                            <?php
                                            $pedidoId = (int) ($pedido['id'] ?? 0);
                                            $codigoPedido = trim((string) ($pedido['codigo'] ?? ''));

                                            if ($codigoPedido === '') {
                                                $codigoPedido = '#' . $pedidoId;
                                            }

                                            $statusPedido = (string) ($pedido['status'] ?? '');
                                            $statusInfo = $statusPedidos[$statusPedido] ?? [
                                                'texto' => ucfirst(str_replace('_', ' ', $statusPedido)),
                                                'classe' => 'text-bg-secondary',
                                            ];

                                            $dataPedido = !empty($pedido['criado_em'])
                                                ? date('d/m/Y H:i', strtotime((string) $pedido['criado_em']))
                                                : '-';
                                            ?>
                                            <tr>
                                                <td class="fw-semibold">
                                                    <?= htmlspecialchars($codigoPedido, ENT_QUOTES, 'UTF-8'); ?>
                                                </td>
                                                <td>
                                                    <?= htmlspecialchars((string) ($pedido['cliente_nome'] ?? 'Cliente'), ENT_QUOTES, 'UTF-8'); ?>
                                                </td>
                                                <td><?= htmlspecialchars($dataPedido, ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td>
                                                    R$ <?= number_format((float) ($pedido['total'] ?? 0), 2, ',', '.'); ?>
                                                </td>
                                                <td>
                                                    <span class="badge <?= htmlspecialchars($statusInfo['classe'], ENT_QUOTES, 'UTF-8'); ?>">
                                                        <?= htmlspecialchars($statusInfo['texto'], ENT_QUOTES, 'UTF-8'); ?>
                                                    </span>
                                                </td>
                                                <td class="text-end">
                                                    <a
                                                        class="btn btn-sm btn-light"
                                                        href="admin/pedidos/detalhes?id=<?= $pedidoId; ?>"
                                                        aria-label="Ver pedido <?= $pedidoId; ?>"
                                                    >
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
</tbody>
                                </table>
                            </div>
                        </article>
                    </section>

                    <section class="col-12 col-xl-4" aria-labelledby="estoqueBaixo">
                        <article class="card panel-card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <h2 class="h5 fw-bold mb-1" id="estoqueBaixo">Estoque baixo</h2>
                                    <small class="text-secondary">Produtos que precisam de reposição.</small>
                                </div>
                                <a class="btn btn-sm btn-outline-danger" href="admin/estoque?filtro=baixo">Ver</a>
                            </div>

                            <div class="card-body">
                                <?php if ($produtosEstoqueBaixo === []): ?>
                                    <div class="text-center text-secondary py-4">
                                        Nenhum produto com estoque baixo.
                                    </div>
                                <?php else: ?>
                                    <?php foreach ($produtosEstoqueBaixo as $index => $produto): ?>
                                        <?php
                                        $estoque = (int) ($produto['estoque'] ?? 0);
                                        $classeBadge = $estoque <= 2
                                            ? 'text-bg-danger'
                                            : 'text-bg-warning';

                                        $classeBorda =
                                            $index < count($produtosEstoqueBaixo) - 1
                                                ? 'border-bottom'
                                                : '';
                                        ?>
                                        <div class="d-flex justify-content-between align-items-center gap-3 <?= $classeBorda; ?> py-3">
                                            <span>
                                                <?= htmlspecialchars((string) ($produto['nome'] ?? 'Produto'), ENT_QUOTES, 'UTF-8'); ?>
                                            </span>
                                            <span class="badge <?= $classeBadge; ?>">
                                                <?= number_format($estoque, 0, ',', '.'); ?>
                                                <?= $estoque === 1 ? 'unidade' : 'unidades'; ?>
                                            </span>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
</div>
                        </article>
                    </section>
                </div>
            </div>
        </main>

        <footer class="dashboard-footer">
            <div class="d-flex flex-column flex-md-row justify-content-between gap-2">
                <span>&copy; <span id="anoAtual">2026</span> Loja Online. Painel administrativo.</span>
                <span>Ambiente protegido <i class="bi bi-shield-check ms-1"></i></span>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('anoAtual').textContent = new Date().getFullYear();

            const caminhoAtual = window.location.pathname
                .replace('/loja_online/public/', '')
                .replace(/^\/+|\/+$/g, '');

            document.querySelectorAll('.sidebar-link[data-route]').forEach(function (link) {
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