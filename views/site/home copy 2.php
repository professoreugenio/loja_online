<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta
        name="description"
        content="Loja online com produtos, ofertas, atendimento ao cliente e compra segura."
    >

    <title>Loja Online | Início</title>

    <!--
        Caminho-base das rotas no XAMPP.
        Quando o projeto funcionar sem /public, altere para:
        <base href="/loja_online/">
    -->
    <base href="/loja_online/public/">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous"
    >

    <style>
        :root {
            --loja-cor-primaria: #0d6efd;
            --loja-cor-escura: #172033;
            --loja-cor-suave: #f4f7fb;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background-color: #ffffff;
            color: #212529;
        }

        .barra-superior {
            background-color: var(--loja-cor-escura);
            color: #ffffff;
            font-size: 0.875rem;
        }

        .navbar-brand {
            letter-spacing: -0.03em;
        }

        .hero-loja {
            background:
                radial-gradient(circle at top right, rgba(13, 110, 253, 0.22), transparent 36%),
                linear-gradient(135deg, #eef5ff 0%, #ffffff 54%, #f2f7ff 100%);
            min-height: 520px;
            display: flex;
            align-items: center;
        }

        .hero-ilustracao {
            min-height: 360px;
            border-radius: 2rem;
            background:
                linear-gradient(145deg, rgba(13, 110, 253, 0.95), rgba(111, 66, 193, 0.88));
            box-shadow: 0 1.5rem 3rem rgba(23, 32, 51, 0.18);
            display: grid;
            place-items: center;
            color: #ffffff;
            position: relative;
            overflow: hidden;
        }

        .hero-ilustracao::before,
        .hero-ilustracao::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.14);
        }

        .hero-ilustracao::before {
            width: 220px;
            height: 220px;
            top: -70px;
            right: -40px;
        }

        .hero-ilustracao::after {
            width: 170px;
            height: 170px;
            bottom: -55px;
            left: -35px;
        }

        .hero-emoji {
            font-size: clamp(7rem, 18vw, 11rem);
            filter: drop-shadow(0 1rem 1rem rgba(0, 0, 0, 0.18));
            position: relative;
            z-index: 1;
        }

        .secao-suave {
            background-color: var(--loja-cor-suave);
        }

        .categoria-card,
        .produto-card,
        .beneficio-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .categoria-card:hover,
        .produto-card:hover,
        .beneficio-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 1rem 2.25rem rgba(23, 32, 51, 0.10) !important;
        }

        .categoria-icone {
            width: 72px;
            height: 72px;
            display: grid;
            place-items: center;
            margin-inline: auto;
            border-radius: 1.25rem;
            background-color: rgba(13, 110, 253, 0.10);
            font-size: 2rem;
        }

        .produto-imagem {
            min-height: 210px;
            display: grid;
            place-items: center;
            background: linear-gradient(145deg, #eef4ff, #f8f9fa);
            font-size: 5rem;
        }

        .preco-anterior {
            color: #6c757d;
            font-size: 0.9rem;
            text-decoration: line-through;
        }

        .preco-atual {
            color: #198754;
            font-size: 1.45rem;
            font-weight: 700;
        }

        .newsletter {
            background: linear-gradient(135deg, #0d6efd, #6f42c1);
        }

        footer a {
            color: rgba(255, 255, 255, 0.76);
        }

        footer a:hover,
        footer a:focus {
            color: #ffffff;
        }
    </style>
</head>

<body>

    <!-- ============================================================
         1. BARRA SUPERIOR
    ============================================================= -->
    <div class="barra-superior py-2">
        <div class="container d-flex flex-column flex-md-row justify-content-between gap-1">
            <span>🚚 Frete grátis em compras selecionadas</span>
            <span>Atendimento: segunda a sexta, das 8h às 18h</span>
        </div>
    </div>

    <!-- ============================================================
         2. MENU PRINCIPAL
    ============================================================= -->
    <header class="sticky-top">
        <nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm" aria-label="Menu principal">
            <div class="container py-2">

                <a class="navbar-brand fw-bold fs-4 text-primary" href="./">
                    🛍️ Loja Online
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
                                <li><a class="dropdown-item" href="categoria/informatica">Informática</a></li>
                                <li><a class="dropdown-item" href="categoria/celulares">Celulares</a></li>
                                <li><a class="dropdown-item" href="categoria/acessorios">Acessórios</a></li>
                                <li><a class="dropdown-item" href="categoria/casa">Casa e decoração</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="categorias">Ver todas</a></li>
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
                                <li><a class="dropdown-item" href="ajuda">Central de ajuda</a></li>
                                <li><a class="dropdown-item" href="faq">Perguntas frequentes</a></li>
                                <li><a class="dropdown-item" href="rastrear-pedido">Rastrear pedido</a></li>
                                <li><a class="dropdown-item" href="trocas-devolucoes">Trocas e devoluções</a></li>
                                <li><a class="dropdown-item" href="contato">Fale conosco</a></li>
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

    <main>
        <!-- ========================================================
             3. DESTAQUE PRINCIPAL
        ========================================================= -->
        <section class="hero-loja py-5">
            <div class="container">
                <div class="row align-items-center g-5">
                    <div class="col-lg-6">
                        <span class="badge rounded-pill text-bg-primary mb-3">
                            Ofertas especiais da semana
                        </span>

                        <h1 class="display-4 fw-bold lh-sm mb-3">
                            Produtos para facilitar o seu dia a dia
                        </h1>

                        <p class="lead text-secondary mb-4">
                            Encontre tecnologia, acessórios, itens para casa e muito mais,
                            com praticidade, segurança e atendimento de qualidade.
                        </p>

                        <div class="d-flex flex-column flex-sm-row gap-3">
                            <a class="btn btn-primary btn-lg px-4" href="produtos">
                                Ver produtos
                            </a>

                            <a class="btn btn-outline-dark btn-lg px-4" href="ofertas">
                                Ver ofertas
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="hero-ilustracao" aria-label="Ilustração de sacola de compras">
                            <span class="hero-emoji" aria-hidden="true">🛍️</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================================================
             4. BENEFÍCIOS
        ========================================================= -->
        <section class="py-5 border-bottom">
            <div class="container">
                <div class="row g-4">
                    <div class="col-md-6 col-xl-3">
                        <article class="beneficio-card h-100 p-4 border rounded-4 shadow-sm">
                            <div class="fs-2 mb-3" aria-hidden="true">🔒</div>
                            <h2 class="h5">Compra segura</h2>
                            <p class="text-secondary mb-0">
                                Proteção dos dados durante o cadastro e o pagamento.
                            </p>
                        </article>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <article class="beneficio-card h-100 p-4 border rounded-4 shadow-sm">
                            <div class="fs-2 mb-3" aria-hidden="true">💳</div>
                            <h2 class="h5">Pagamento facilitado</h2>
                            <p class="text-secondary mb-0">
                                Opções de pagamento organizadas para concluir seu pedido.
                            </p>
                        </article>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <article class="beneficio-card h-100 p-4 border rounded-4 shadow-sm">
                            <div class="fs-2 mb-3" aria-hidden="true">🚚</div>
                            <h2 class="h5">Entrega acompanhada</h2>
                            <p class="text-secondary mb-0">
                                Consulte o andamento do pedido pela área do cliente.
                            </p>
                        </article>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <article class="beneficio-card h-100 p-4 border rounded-4 shadow-sm">
                            <div class="fs-2 mb-3" aria-hidden="true">💬</div>
                            <h2 class="h5">Suporte ao cliente</h2>
                            <p class="text-secondary mb-0">
                                Canais de ajuda para dúvidas, trocas e devoluções.
                            </p>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================================================
             5. CATEGORIAS
        ========================================================= -->
        <section class="secao-suave py-5" id="categorias">
            <div class="container py-3">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-4">
                    <div>
                        <span class="text-primary fw-semibold">Explore a loja</span>
                        <h2 class="display-6 fw-bold mb-0">Categorias em destaque</h2>
                    </div>

                    <a class="btn btn-outline-primary" href="categorias">Ver todas</a>
                </div>

                <div class="row g-4">
                    <div class="col-6 col-lg-3">
                        <a class="text-decoration-none text-dark" href="categoria/informatica">
                            <article class="categoria-card bg-white h-100 text-center p-4 rounded-4 shadow-sm">
                                <div class="categoria-icone" aria-hidden="true">💻</div>
                                <h3 class="h5 mt-3 mb-1">Informática</h3>
                                <p class="text-secondary small mb-0">Computadores e periféricos</p>
                            </article>
                        </a>
                    </div>

                    <div class="col-6 col-lg-3">
                        <a class="text-decoration-none text-dark" href="categoria/celulares">
                            <article class="categoria-card bg-white h-100 text-center p-4 rounded-4 shadow-sm">
                                <div class="categoria-icone" aria-hidden="true">📱</div>
                                <h3 class="h5 mt-3 mb-1">Celulares</h3>
                                <p class="text-secondary small mb-0">Aparelhos e conectividade</p>
                            </article>
                        </a>
                    </div>

                    <div class="col-6 col-lg-3">
                        <a class="text-decoration-none text-dark" href="categoria/acessorios">
                            <article class="categoria-card bg-white h-100 text-center p-4 rounded-4 shadow-sm">
                                <div class="categoria-icone" aria-hidden="true">🎧</div>
                                <h3 class="h5 mt-3 mb-1">Acessórios</h3>
                                <p class="text-secondary small mb-0">Fones, cabos e utilidades</p>
                            </article>
                        </a>
                    </div>

                    <div class="col-6 col-lg-3">
                        <a class="text-decoration-none text-dark" href="categoria/casa">
                            <article class="categoria-card bg-white h-100 text-center p-4 rounded-4 shadow-sm">
                                <div class="categoria-icone" aria-hidden="true">🏠</div>
                                <h3 class="h5 mt-3 mb-1">Casa</h3>
                                <p class="text-secondary small mb-0">Organização e decoração</p>
                            </article>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================================================
             6. PRODUTOS EM DESTAQUE
        ========================================================= -->
        <section class="py-5" id="produtos-destaque">
            <div class="container py-3">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-4">
                    <div>
                        <span class="text-primary fw-semibold">Escolhas populares</span>
                        <h2 class="display-6 fw-bold mb-0">Produtos em destaque</h2>
                    </div>

                    <a class="btn btn-outline-primary" href="produtos">Ver catálogo</a>
                </div>

                <div class="row g-4">
                    <div class="col-md-6 col-xl-3">
                        <article class="produto-card card h-100 border-0 shadow-sm overflow-hidden">
                            <div class="produto-imagem" aria-hidden="true">💻</div>
                            <div class="card-body d-flex flex-column">
                                <span class="badge text-bg-danger align-self-start mb-2">Oferta</span>
                                <h3 class="h5 card-title">Notebook Essencial 15</h3>
                                <p class="card-text text-secondary small">
                                    Desempenho para estudos, trabalho e navegação.
                                </p>
                                <div class="mt-auto">
                                    <div class="preco-anterior">R$ 3.299,00</div>
                                    <div class="preco-atual">R$ 2.899,00</div>
                                    <a class="btn btn-primary w-100 mt-3" href="produto/notebook-essencial-15">
                                        Ver produto
                                    </a>
                                </div>
                            </div>
                        </article>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <article class="produto-card card h-100 border-0 shadow-sm overflow-hidden">
                            <div class="produto-imagem" aria-hidden="true">📱</div>
                            <div class="card-body d-flex flex-column">
                                <span class="badge text-bg-success align-self-start mb-2">Novidade</span>
                                <h3 class="h5 card-title">Smartphone Connect</h3>
                                <p class="card-text text-secondary small">
                                    Tela ampla, boa autonomia e câmera versátil.
                                </p>
                                <div class="mt-auto">
                                    <div class="preco-anterior">R$ 1.899,00</div>
                                    <div class="preco-atual">R$ 1.699,00</div>
                                    <a class="btn btn-primary w-100 mt-3" href="produto/smartphone-connect">
                                        Ver produto
                                    </a>
                                </div>
                            </div>
                        </article>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <article class="produto-card card h-100 border-0 shadow-sm overflow-hidden">
                            <div class="produto-imagem" aria-hidden="true">🎧</div>
                            <div class="card-body d-flex flex-column">
                                <span class="badge text-bg-primary align-self-start mb-2">Destaque</span>
                                <h3 class="h5 card-title">Fone Bluetooth Air</h3>
                                <p class="card-text text-secondary small">
                                    Som equilibrado e conexão sem fio para o cotidiano.
                                </p>
                                <div class="mt-auto">
                                    <div class="preco-anterior">R$ 249,90</div>
                                    <div class="preco-atual">R$ 199,90</div>
                                    <a class="btn btn-primary w-100 mt-3" href="produto/fone-bluetooth-air">
                                        Ver produto
                                    </a>
                                </div>
                            </div>
                        </article>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <article class="produto-card card h-100 border-0 shadow-sm overflow-hidden">
                            <div class="produto-imagem" aria-hidden="true">⌨️</div>
                            <div class="card-body d-flex flex-column">
                                <span class="badge text-bg-secondary align-self-start mb-2">Mais vendido</span>
                                <h3 class="h5 card-title">Teclado Confort Plus</h3>
                                <p class="card-text text-secondary small">
                                    Digitação confortável para estudo e produtividade.
                                </p>
                                <div class="mt-auto">
                                    <div class="preco-anterior">R$ 189,90</div>
                                    <div class="preco-atual">R$ 149,90</div>
                                    <a class="btn btn-primary w-100 mt-3" href="produto/teclado-confort-plus">
                                        Ver produto
                                    </a>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================================================
             7. CHAMADA PROMOCIONAL
        ========================================================= -->
        <section class="secao-suave py-5">
            <div class="container">
                <div class="row align-items-center g-4 bg-white rounded-4 shadow-sm p-4 p-lg-5">
                    <div class="col-lg-8">
                        <span class="text-primary fw-semibold">Oferta por tempo limitado</span>
                        <h2 class="display-6 fw-bold mt-2">Economize em produtos selecionados</h2>
                        <p class="lead text-secondary mb-0">
                            Confira as condições disponíveis e encontre o produto adequado para sua necessidade.
                        </p>
                    </div>

                    <div class="col-lg-4 text-lg-end">
                        <a class="btn btn-primary btn-lg" href="ofertas">Acessar ofertas</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================================================
             8. NEWSLETTER
        ========================================================= -->
        <section class="newsletter py-5 text-white">
            <div class="container py-3">
                <div class="row align-items-center g-4">
                    <div class="col-lg-6">
                        <h2 class="fw-bold">Receba novidades da loja</h2>
                        <p class="mb-0 text-white-50">
                            Cadastre seu e-mail para receber informações sobre produtos e ofertas.
                        </p>
                    </div>

                    <div class="col-lg-6">
                        <form class="row g-2" action="newsletter/cadastrar" method="post">
                            <div class="col-sm-8">
                                <label class="visually-hidden" for="newsletterEmail">Seu e-mail</label>
                                <input
                                    class="form-control form-control-lg"
                                    id="newsletterEmail"
                                    name="email"
                                    type="email"
                                    placeholder="nome@exemplo.com"
                                    required
                                >
                            </div>

                            <div class="col-sm-4 d-grid">
                                <button class="btn btn-light btn-lg text-primary fw-semibold" type="submit">
                                    Cadastrar
                                </button>
                            </div>
                        </form>

                        <p class="small text-white-50 mt-2 mb-0">
                            Ao cadastrar o e-mail, consulte nossa
                            <a class="text-white" href="politica-de-privacidade">Política de Privacidade</a>.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- ============================================================
         9. RODAPÉ
    ============================================================= -->
    <footer class="bg-dark text-white pt-5">
        <div class="container">
            <div class="row g-4 pb-4">
                <div class="col-lg-4">
                    <h2 class="h4">🛍️ Loja Online</h2>
                    <p class="text-white-50">
                        Uma loja virtual demonstrativa desenvolvida para apresentar
                        navegação por rotas, produtos, atendimento e área do cliente.
                    </p>
                </div>

                <div class="col-6 col-lg-2">
                    <h2 class="h6 text-uppercase">Institucional</h2>
                    <ul class="list-unstyled d-grid gap-2">
                        <li><a class="text-decoration-none" href="sobre">Sobre a loja</a></li>
                        <li><a class="text-decoration-none" href="contato">Contato</a></li>
                        <li><a class="text-decoration-none" href="trabalhe-conosco">Trabalhe conosco</a></li>
                    </ul>
                </div>

                <div class="col-6 col-lg-2">
                    <h2 class="h6 text-uppercase">Atendimento</h2>
                    <ul class="list-unstyled d-grid gap-2">
                        <li><a class="text-decoration-none" href="ajuda">Central de ajuda</a></li>
                        <li><a class="text-decoration-none" href="faq">Perguntas frequentes</a></li>
                        <li><a class="text-decoration-none" href="rastrear-pedido">Rastrear pedido</a></li>
                        <li><a class="text-decoration-none" href="trocas-devolucoes">Trocas e devoluções</a></li>
                    </ul>
                </div>

                <div class="col-6 col-lg-2">
                    <h2 class="h6 text-uppercase">Minha conta</h2>
                    <ul class="list-unstyled d-grid gap-2">
                        <li><a class="text-decoration-none" href="cliente/login">Entrar</a></li>
                        <li><a class="text-decoration-none" href="cliente/cadastro">Criar conta</a></li>
                        <li><a class="text-decoration-none" href="cliente/pedidos">Meus pedidos</a></li>
                        <li><a class="text-decoration-none" href="carrinho">Carrinho</a></li>
                    </ul>
                </div>

                <div class="col-6 col-lg-2">
                    <h2 class="h6 text-uppercase">Políticas</h2>
                    <ul class="list-unstyled d-grid gap-2">
                        <li><a class="text-decoration-none" href="termos-de-uso">Termos de Uso</a></li>
                        <li><a class="text-decoration-none" href="politica-de-privacidade">Política de Privacidade</a></li>
                        <li><a class="text-decoration-none" href="politica-de-cookies">Política de Cookies</a></li>
                        <li><a class="text-decoration-none" href="trocas-devolucoes">Trocas e devoluções</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-top border-secondary py-3 d-flex flex-column flex-md-row justify-content-between gap-2">
                <small class="text-white-50">
                    &copy; 2026 Loja Online. Todos os direitos reservados.
                </small>

                <small class="text-white-50">
                    Projeto educacional — Programação Web
                </small>
            </div>
        </div>
    </footer>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"
    ></script>
</body>
</html>
