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

    <style>
        :root {
            --sidebar-width: 270px;
            --sidebar-bg: #111827;
            --sidebar-hover: #1f2937;
            --sidebar-active: #2563eb;
            --page-bg: #f4f7fb;
        }

        * { box-sizing: border-box; }

        body {
            min-height: 100vh;
            margin: 0;
            background: var(--page-bg);
            color: #1f2937;
        }

        a { text-decoration: none; }

        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 1030;
            width: var(--sidebar-width);
            min-height: 100vh;
            overflow-y: auto;
            background: var(--sidebar-bg);
            color: #fff;
        }

        .sidebar-brand {
            min-height: 72px;
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: 1rem 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,.08);
            color: #fff;
        }

        .brand-icon {
            width: 42px;
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: .8rem;
            background: var(--sidebar-active);
            font-size: 1.25rem;
        }

        .menu-title {
            padding: 1.15rem 1.25rem .45rem;
            color: #9ca3af;
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .sidebar-nav { padding: 0 .75rem 1rem; }

        .sidebar-link,
        .sidebar-button {
            width: 100%;
            display: flex;
            align-items: center;
            gap: .85rem;
            padding: .78rem .9rem;
            margin-bottom: .3rem;
            border: 0;
            border-radius: .75rem;
            background: transparent;
            color: #d1d5db;
            text-align: left;
            transition: .2s ease;
        }

        .sidebar-link:hover,
        .sidebar-link:focus,
        .sidebar-button:hover,
        .sidebar-button:focus {
            background: var(--sidebar-hover);
            color: #fff;
            transform: translateX(3px);
        }

        .sidebar-link.active {
            background: var(--sidebar-active);
            color: #fff;
        }

        .main-wrapper {
            min-height: 100vh;
            margin-left: var(--sidebar-width);
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 1020;
            min-height: 72px;
            display: flex;
            align-items: center;
            background: rgba(255,255,255,.96);
            border-bottom: 1px solid #e5e7eb;
            backdrop-filter: blur(10px);
        }

        .content-area { padding: 1.5rem; }

        .avatar {
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #dbeafe;
            color: #1d4ed8;
            font-weight: 700;
        }

        .metric-card,
        .panel-card {
            height: 100%;
            border: 0;
            border-radius: 1rem;
            box-shadow: 0 .55rem 1.75rem rgba(15,23,42,.07);
        }

        .metric-card {
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .metric-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 .85rem 2rem rgba(15,23,42,.11);
        }

        .metric-icon {
            width: 52px;
            height: 52px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: .9rem;
            font-size: 1.4rem;
        }

        .metric-label { color: #6b7280; font-size: .9rem; }
        .metric-value { margin: .15rem 0 0; font-size: 1.65rem; font-weight: 700; }

        .quick-card {
            height: 100%;
            display: block;
            padding: 1.1rem;
            border: 1px solid #e5e7eb;
            border-radius: 1rem;
            background: #fff;
            color: #1f2937;
            transition: .2s ease;
        }

        .quick-card:hover {
            border-color: #93c5fd;
            color: #1f2937;
            transform: translateY(-3px);
            box-shadow: 0 .7rem 1.6rem rgba(37,99,235,.1);
        }

        .quick-icon {
            width: 46px;
            height: 46px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: .8rem;
            border-radius: .85rem;
            background: #eff6ff;
            color: #2563eb;
            font-size: 1.25rem;
        }

        .panel-card .card-header {
            padding: 1rem 1.15rem;
            border-bottom: 1px solid #eef0f3;
            background: #fff;
            border-radius: 1rem 1rem 0 0;
        }

        .table thead th {
            white-space: nowrap;
            color: #6b7280;
            font-size: .8rem;
            text-transform: uppercase;
        }

        .table tbody td { vertical-align: middle; }

        .offcanvas-dashboard {
            background: var(--sidebar-bg);
            color: #fff;
        }

        .offcanvas-dashboard .btn-close { filter: invert(1); }

        .dashboard-footer {
            padding: 1.2rem 1.5rem;
            border-top: 1px solid #e5e7eb;
            background: #fff;
            color: #6b7280;
            font-size: .9rem;
        }

        @media (max-width: 991.98px) {
            .sidebar { display: none; }
            .main-wrapper { margin-left: 0; }
            .content-area { padding: 1rem; }
        }
    </style>
</head>

<body>
    <aside class="sidebar d-none d-lg-flex flex-column">
        <a class="sidebar-brand" href="admin">
            <span class="brand-icon"><i class="bi bi-shop"></i></span>
            <span>
                <strong class="d-block">Loja Online</strong>
                <small class="text-white-50">Painel administrativo</small>
            </span>
        </a>

        <div class="flex-grow-1">
            <div class="menu-title">Visão geral</div>
            <nav class="sidebar-nav" aria-label="Visão geral">
                <a class="sidebar-link active" href="admin" data-route="admin">
                    <i class="bi bi-grid-1x2-fill"></i> Dashboard
                </a>
                <a class="sidebar-link" href="admin/relatorios" data-route="admin/relatorios">
                    <i class="bi bi-bar-chart-line-fill"></i> Relatórios
                </a>
            </nav>

            <div class="menu-title">Cadastros</div>
            <nav class="sidebar-nav" aria-label="Cadastros">
                <a class="sidebar-link" href="admin/produtos" data-route="admin/produtos">
                    <i class="bi bi-box-seam-fill"></i> Produtos
                </a>
                <a class="sidebar-link" href="admin/categorias" data-route="admin/categorias">
                    <i class="bi bi-tags-fill"></i> Categorias
                </a>
                <a class="sidebar-link" href="admin/clientes" data-route="admin/clientes">
                    <i class="bi bi-people-fill"></i> Clientes
                </a>
            </nav>

            <div class="menu-title">Vendas</div>
            <nav class="sidebar-nav" aria-label="Vendas">
                <a class="sidebar-link" href="admin/pedidos" data-route="admin/pedidos">
                    <i class="bi bi-bag-check-fill"></i> Pedidos
                </a>
                <a class="sidebar-link" href="admin/pagamentos" data-route="admin/pagamentos">
                    <i class="bi bi-credit-card-2-front-fill"></i> Pagamentos
                </a>
                <a class="sidebar-link" href="admin/carrinhos" data-route="admin/carrinhos">
                    <i class="bi bi-cart-fill"></i> Carrinhos ativos
                </a>
            </nav>

            <div class="menu-title">Controle</div>
            <nav class="sidebar-nav" aria-label="Controle">
                <a class="sidebar-link" href="admin/estoque" data-route="admin/estoque">
                    <i class="bi bi-boxes"></i> Estoque
                </a>
                <a class="sidebar-link" href="admin/notificacoes" data-route="admin/notificacoes">
                    <i class="bi bi-bell-fill"></i> Notificações
                    <span class="badge rounded-pill text-bg-danger ms-auto">5</span>
                </a>
                <a class="sidebar-link" href="admin/contatos" data-route="admin/contatos">
                    <i class="bi bi-chat-left-text-fill"></i> Contatos
                </a>
                <a class="sidebar-link" href="admin/configuracoes" data-route="admin/configuracoes">
                    <i class="bi bi-gear-fill"></i> Configurações
                </a>
            </nav>
        </div>

        <div class="p-3 border-top border-secondary">
            <a class="sidebar-link" href="" target="_blank">
                <i class="bi bi-box-arrow-up-right"></i> Visualizar loja
            </a>

            <!-- Em produção, inclua token CSRF após converter para PHP. -->
            <form action="admin/sair" method="post">
                <button class="sidebar-button text-danger" type="submit">
                    <i class="bi bi-box-arrow-left"></i> Sair do sistema
                </button>
            </form>
        </div>
    </aside>

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
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill text-bg-danger">
                                5
                            </span>
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
                                            <p class="metric-value">248</p>
                                            <small class="text-success">12 novos neste mês</small>
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
                                            <p class="metric-value">1.084</p>
                                            <small class="text-success">8,4% de crescimento</small>
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
                                            <p class="metric-value">32</p>
                                            <small class="text-warning-emphasis">7 aguardam pagamento</small>
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
                                            <p class="metric-value">14</p>
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
                                            <p class="metric-value">46</p>
                                            <small class="text-secondary">11 iniciados hoje</small>
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
                                            <p class="metric-value">R$ 28.640</p>
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
                                            <p class="metric-value">5</p>
                                            <small class="text-secondary">Não lidas</small>
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
                                            <p class="metric-value">18</p>
                                            <small class="text-secondary">4 aguardam resposta</small>
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
                                        <tr>
                                            <td class="fw-semibold">#1058</td>
                                            <td>Mariana Alves</td>
                                            <td>05/08/2026</td>
                                            <td>R$ 1.249,90</td>
                                            <td><span class="badge text-bg-warning">Aguardando</span></td>
                                            <td class="text-end">
                                                <a class="btn btn-sm btn-light" href="admin/pedidos/1058" aria-label="Ver pedido 1058">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">#1057</td>
                                            <td>Carlos Henrique</td>
                                            <td>05/08/2026</td>
                                            <td>R$ 389,90</td>
                                            <td><span class="badge text-bg-success">Pago</span></td>
                                            <td class="text-end">
                                                <a class="btn btn-sm btn-light" href="admin/pedidos/1057" aria-label="Ver pedido 1057">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">#1056</td>
                                            <td>Ana Beatriz</td>
                                            <td>04/08/2026</td>
                                            <td>R$ 2.899,00</td>
                                            <td><span class="badge text-bg-primary">Em separação</span></td>
                                            <td class="text-end">
                                                <a class="btn btn-sm btn-light" href="admin/pedidos/1056" aria-label="Ver pedido 1056">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
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
                                <div class="d-flex justify-content-between border-bottom py-3">
                                    <span>Mouse sem fio</span>
                                    <span class="badge text-bg-danger">2 unidades</span>
                                </div>
                                <div class="d-flex justify-content-between border-bottom py-3">
                                    <span>Teclado mecânico</span>
                                    <span class="badge text-bg-warning">5 unidades</span>
                                </div>
                                <div class="d-flex justify-content-between py-3">
                                    <span>Fone Bluetooth</span>
                                    <span class="badge text-bg-warning">7 unidades</span>
                                </div>
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
