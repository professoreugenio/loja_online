<?php
declare(strict_types=1);
$tituloHeader = $tituloHeader ?? 'Loja Online';
$textoHeader = $textoHeader  ?? 'Produtos selecionados para você.';
?>
 <header class="sticky-top">
        <nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm" aria-label="Menu principal">
            <div class="container py-2">

                <a class="navbar-brand fw-bold fs-4 text-primary" href="./">
                    🛍️ <?= htmlspecialchars($tituloHeader, ENT_QUOTES,'UTF-8'  );  ?>
                </a>

                <button
                    class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#menuPrincipal"
                    aria-controls="menuPrincipal"
                    aria-expanded="false"
                    aria-label="Abrir ou fechar o menu"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="menuPrincipal">
                    <ul class="navbar-nav mx-auto mb-3 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="./">Início</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="produtos">Produtos</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a
                                class="nav-link dropdown-toggle"
                                href="#"
                                role="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                Categorias
                            </a>

                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="categoria/?v=1">Informática</a></li>
                                <li><a class="dropdown-item" href="categoria/?v=2">Celulares</a></li>
                                <li><a class="dropdown-item" href="categoria/?v=3">Acessórios</a></li>
                                <li><a class="dropdown-item" href="categoria/?v=4">Casa e decoração</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="categoria/?v=0">Ver todas</a></li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="ofertas">Ofertas</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a
                                class="nav-link dropdown-toggle"
                                href="#"
                                role="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                Ajuda
                            </a>

                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="ajuda/central">Central de ajuda</a></li>
                                <li><a class="dropdown-item" href="ajuda/perguntas">Perguntas frequentes</a></li>
                                <li><a class="dropdown-item" href="ajuda/rastreio">Rastrear pedido</a></li>
                                <li><a class="dropdown-item" href="ajuda/trocas">Trocas e devoluções</a></li>
                                <li><a class="dropdown-item" href="ajuda/contato">Fale conosco</a></li>
                            </ul>
                        </li>
                    </ul>

                    <div class="d-flex flex-column flex-lg-row align-items-lg-center gap-2">
                        <form class="d-flex" action="buscar" method="get" role="search">
                            <label class="visually-hidden" for="campoPesquisa">Pesquisar produtos</label>
                            <input
                                class="form-control"
                                id="campoPesquisa"
                                name="q"
                                type="search"
                                placeholder="Pesquisar"
                                required
                            >
                            <button class="btn btn-outline-primary ms-2" type="submit">
                                Buscar
                            </button>
                        </form>

                        <div class="dropdown">
                            <button
                                class="btn btn-outline-dark dropdown-toggle w-100"
                                type="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                Conta
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="cliente/login">Entrar</a></li>
                                <li><a class="dropdown-item" href="cliente/cadastro">Criar conta</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="cliente/pedidos">Meus pedidos</a></li>
                            </ul>
                        </div>

                        <a class="btn btn-primary text-nowrap" href="carrinho">
                            Carrinho
                            <span class="badge text-bg-light ms-1">0</span>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>