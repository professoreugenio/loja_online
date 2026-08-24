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