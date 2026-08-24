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