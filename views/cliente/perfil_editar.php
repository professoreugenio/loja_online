<?php

declare(strict_types=1);

use App\Helpers\View;
?>
<!doctype html>
<html lang="pt-BR">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta
        name="description"
        content="Edição dos dados do perfil do cliente da Loja Online.">

    <title>Editar Perfil | Loja Online</title>

    <base href="/loja_online/public/">

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/site.css">

</head>

<body class="bg-light">


    <!-- ============================================================
         NAV
    ============================================================= -->

    <?php View::componenteCliente('nav'); ?>


    <!-- ============================================================
         MAIN
    ============================================================= -->

    <main class="py-5">

        <div class="container">


            <!-- ====================================================
                 TÍTULO
            ===================================================== -->

            <div class="row mb-4">

                <div class="col-12">

                    <div
                        class="d-flex flex-column flex-md-row
                               justify-content-between
                               align-items-md-center gap-3">

                        <div>

                            <h1 class="h3 fw-bold mb-1">

                                <i
                                    class="bi bi-pencil-square
                                           text-primary me-2"></i>

                                Editar Perfil

                            </h1>

                            <p class="text-muted mb-0">

                                Atualize suas informações pessoais
                                e dados de contato.

                            </p>

                        </div>


                        <div>

                            <a
                                href="cliente/perfil"
                                class="btn btn-outline-secondary">

                                <i class="bi bi-arrow-left me-1"></i>

                                Voltar ao perfil

                            </a>

                        </div>

                    </div>

                </div>

            </div>


            <div class="row g-4">


                <!-- =================================================
                     MENU LATERAL
                ================================================== -->

                <aside class="col-12 col-lg-3">

                    <div class="card border-0 shadow-sm">

                        <div class="card-body text-center">


                            <div class="mb-3">

                                <i
                                    class="bi bi-person-circle text-primary"
                                    style="font-size: 5rem;"></i>

                            </div>


                            <h2 class="h5 fw-bold mb-1">

                                João da Silva

                            </h2>


                            <p class="text-muted small mb-4">

                                joao@email.com

                            </p>


                            <hr>


                            <div
                                class="list-group
                                       list-group-flush
                                       text-start">


                                <a
                                    href="cliente/painel"
                                    class="list-group-item
                                           list-group-item-action">

                                    <i class="bi bi-speedometer2 me-2"></i>

                                    Painel

                                </a>


                                <a
                                    href="cliente/perfil"
                                    class="list-group-item
                                           list-group-item-action
                                           active">

                                    <i class="bi bi-person me-2"></i>

                                    Meu Perfil

                                </a>


                                <a
                                    href="cliente/pedidos"
                                    class="list-group-item
                                           list-group-item-action">

                                    <i class="bi bi-bag-check me-2"></i>

                                    Meus Pedidos

                                </a>


                                <a
                                    href="cliente/enderecos"
                                    class="list-group-item
                                           list-group-item-action">

                                    <i class="bi bi-geo-alt me-2"></i>

                                    Meus Endereços

                                </a>


                                <a
                                    href="cliente/seguranca"
                                    class="list-group-item
                                           list-group-item-action">

                                    <i class="bi bi-shield-lock me-2"></i>

                                    Segurança

                                </a>


                            </div>

                        </div>

                    </div>

                </aside>


                <!-- =================================================
                     FORMULÁRIO DE EDIÇÃO
                ================================================== -->

                <section class="col-12 col-lg-9">


                    <form
                        action="<?=
                                htmlspecialchars(
                                    BASE_URL
                                        . '/cliente/perfil/atualizar',
                                    ENT_QUOTES,
                                    'UTF-8'
                                )
                                ?>"
                        method="post"
                        autocomplete="on">


                        <!-- ============================================================
         TOKEN CSRF
    ============================================================= -->

                        <input
                            type="hidden"
                            name="csrf_token"
                            value="<?=
                                    htmlspecialchars(
                                        (string) $csrfToken,
                                        ENT_QUOTES,
                                        'UTF-8'
                                    )
                                    ?>">


                        <!-- ============================================================
         MENSAGENS DE ERRO
    ============================================================= -->

                        <?php if (!empty($erros)): ?>

                            <div
                                class="alert alert-danger"
                                role="alert">

                                <div class="d-flex align-items-start">

                                    <i
                                        class="bi bi-exclamation-triangle-fill
                           fs-5 me-3"></i>

                                    <div>

                                        <strong>
                                            Não foi possível salvar as alterações.
                                        </strong>

                                        <div class="small mb-2">
                                            Verifique os dados informados:
                                        </div>

                                        <ul class="mb-0">

                                            <?php foreach ($erros as $erro): ?>

                                                <li>
                                                    <?=
                                                    htmlspecialchars(
                                                        (string) $erro,
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    )
                                                    ?>
                                                </li>

                                            <?php endforeach; ?>

                                        </ul>

                                    </div>

                                </div>

                            </div>

                        <?php endif; ?>


                        <!-- ============================================================
         DADOS PESSOAIS
    ============================================================= -->

                        <div class="card border-0 shadow-sm mb-4">

                            <div class="card-header bg-white py-3">

                                <h2 class="h5 fw-bold mb-0">

                                    <i
                                        class="bi bi-person-vcard
                           text-primary me-2"></i>

                                    Dados Pessoais

                                </h2>

                            </div>


                            <div class="card-body">

                                <div class="row g-4">


                                    <!-- =================================================
                     NOME COMPLETO
                ================================================== -->

                                    <div class="col-12">

                                        <label
                                            for="nome"
                                            class="form-label fw-semibold">
                                            Nome completo
                                        </label>


                                        <div class="input-group">

                                            <span class="input-group-text">

                                                <i class="bi bi-person"></i>

                                            </span>


                                            <input
                                                type="text"
                                                class="form-control"
                                                id="nome"
                                                name="nome"
                                                value="<?=
                                                        htmlspecialchars(
                                                            (string) (
                                                                $dadosFormulario['nome']
                                                                ?? ''
                                                            ),
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        )
                                                        ?>"
                                                placeholder="Digite seu nome completo"
                                                autocomplete="name"
                                                minlength="3"
                                                maxlength="150"
                                                required>

                                        </div>

                                    </div>


                                    <!-- =================================================
                     CPF
                ================================================== -->

                                    <div class="col-12 col-md-6">

                                        <label
                                            for="cpf"
                                            class="form-label fw-semibold">
                                            CPF
                                        </label>


                                        <div class="input-group">

                                            <span class="input-group-text">

                                                <i class="bi bi-person-badge"></i>

                                            </span>


                                            <input
                                                type="text"
                                                class="form-control"
                                                id="cpf"
                                                name="cpf"
                                                value="<?=
                                                        htmlspecialchars(
                                                            (string) (
                                                                $dadosFormulario['cpf']
                                                                ?? $cliente['cpf']
                                                                ?? ''
                                                            ),
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        )
                                                        ?>"
                                                placeholder="000.000.000-00"
                                                inputmode="numeric"
                                                maxlength="14"
                                                autocomplete="off"
                                                required>

                                        </div>


                                        <div class="form-text">

                                            Informe um CPF válido.

                                        </div>

                                    </div>


                                    <!-- =================================================
                     DATA DE NASCIMENTO
                ================================================== -->

                                    <div class="col-12 col-md-6">

                                        <label
                                            for="data_nascimento"
                                            class="form-label fw-semibold">
                                            Data de nascimento
                                        </label>


                                        <div class="input-group">

                                            <span class="input-group-text">

                                                <i class="bi bi-calendar3"></i>

                                            </span>


                                            <input
                                                type="date"
                                                class="form-control"
                                                id="data_nascimento"
                                                name="data_nascimento"
                                                value="<?=
                                                        htmlspecialchars(
                                                            (string) (
                                                                $dadosFormulario['data_nascimento']
                                                                ?? ''
                                                            ),
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        )
                                                        ?>"
                                                autocomplete="bday">

                                        </div>

                                    </div>


                                </div>

                            </div>

                        </div>


                        <!-- ============================================================
         INFORMAÇÕES DE CONTATO
    ============================================================= -->

                        <div class="card border-0 shadow-sm mb-4">

                            <div class="card-header bg-white py-3">

                                <h2 class="h5 fw-bold mb-0">

                                    <i
                                        class="bi bi-envelope
                           text-primary me-2"></i>

                                    Informações de Contato

                                </h2>

                            </div>


                            <div class="card-body">

                                <div class="row g-4">


                                    <!-- =================================================
                     E-MAIL
                ================================================== -->

                                    <div class="col-12 col-md-6">

                                        <label
                                            for="email"
                                            class="form-label fw-semibold">
                                            E-mail
                                        </label>


                                        <div class="input-group">

                                            <span class="input-group-text">

                                                <i class="bi bi-envelope"></i>

                                            </span>


                                            <input
                                                type="email"
                                                class="form-control"
                                                id="email"
                                                name="email"
                                                value="<?=
                                                        htmlspecialchars(
                                                            (string) (
                                                                $dadosFormulario['email']
                                                                ?? ''
                                                            ),
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        )
                                                        ?>"
                                                placeholder="nome@email.com"
                                                autocomplete="email"
                                                maxlength="190"
                                                required>

                                        </div>


                                        <div class="form-text">

                                            Este e-mail será utilizado para acessar
                                            sua conta.

                                        </div>

                                    </div>


                                    <!-- =================================================
                     TELEFONE
                ================================================== -->

                                    <div class="col-12 col-md-6">

                                        <label
                                            for="telefone"
                                            class="form-label fw-semibold">
                                            Telefone
                                        </label>


                                        <div class="input-group">

                                            <span class="input-group-text">

                                                <i class="bi bi-telephone"></i>

                                            </span>


                                            <input
                                                type="tel"
                                                class="form-control"
                                                id="telefone"
                                                name="telefone"
                                                value="<?=
                                                        htmlspecialchars(
                                                            (string) (
                                                                $dadosFormulario['telefone']
                                                                ?? ''
                                                            ),
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        )
                                                        ?>"
                                                placeholder="(00) 00000-0000"
                                                autocomplete="tel"
                                                inputmode="tel"
                                                maxlength="15">

                                        </div>

                                    </div>


                                </div>

                            </div>

                        </div>


                        <!-- ============================================================
         INFORMAÇÕES DA CONTA
    ============================================================= -->

                        <div class="card border-0 shadow-sm mb-4">

                            <div class="card-header bg-white py-3">

                                <h2 class="h5 fw-bold mb-0">

                                    <i
                                        class="bi bi-info-circle
                           text-primary me-2"></i>

                                    Informações da Conta

                                </h2>

                            </div>


                            <div class="card-body">

                                <div class="row g-4">


                                    <!-- =================================================
                     CLIENTE DESDE
                ================================================== -->

                                    <div class="col-12 col-md-6">

                                        <label
                                            for="cliente_desde"
                                            class="form-label fw-semibold">
                                            Cliente desde
                                        </label>


                                        <?php

                                        $clienteDesde = '';

                                        if (
                                            !empty($cliente['criado_em'])
                                        ) {

                                            $timestamp =
                                                strtotime(
                                                    (string)
                                                    $cliente['criado_em']
                                                );

                                            if ($timestamp !== false) {

                                                $clienteDesde =
                                                    date(
                                                        'd/m/Y',
                                                        $timestamp
                                                    );
                                            }
                                        }

                                        ?>


                                        <div class="input-group">

                                            <span class="input-group-text">

                                                <i class="bi bi-calendar-check"></i>

                                            </span>


                                            <input
                                                type="text"
                                                class="form-control bg-light"
                                                id="cliente_desde"
                                                value="<?=
                                                        htmlspecialchars(
                                                            $clienteDesde,
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        )
                                                        ?>"
                                                readonly>

                                        </div>

                                    </div>


                                    <!-- =================================================
                     STATUS
                ================================================== -->

                                    <div class="col-12 col-md-6">

                                        <label
                                            class="form-label fw-semibold">
                                            Status da conta
                                        </label>


                                        <div
                                            class="form-control
                               bg-light
                               d-flex
                               align-items-center">

                                            <?php

                                            $status =
                                                (string) (
                                                    $cliente['status']
                                                    ?? ''
                                                );

                                            ?>


                                            <?php if ($status === 'ativo'): ?>

                                                <span class="badge text-bg-success">

                                                    <i
                                                        class="bi bi-check-circle me-1"></i>

                                                    Ativa

                                                </span>

                                            <?php else: ?>

                                                <span class="badge text-bg-secondary">

                                                    <i
                                                        class="bi bi-dash-circle me-1"></i>

                                                    <?=
                                                    htmlspecialchars(
                                                        ucfirst($status),
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    )
                                                    ?>

                                                </span>

                                            <?php endif; ?>

                                        </div>

                                    </div>


                                </div>

                            </div>

                        </div>


                        <!-- ============================================================
         AVISO DE SEGURANÇA
    ============================================================= -->

                        <div
                            class="alert alert-info
               d-flex align-items-start"
                            role="alert">

                            <i
                                class="bi bi-info-circle-fill
                   fs-5 me-3"></i>


                            <div>

                                <strong>
                                    Segurança da conta
                                </strong>


                                <div class="small">

                                    Para alterar sua senha,
                                    acesse a página de Segurança da conta.

                                </div>


                                <div class="mt-2">

                                    <a
                                        href="<?=
                                                htmlspecialchars(
                                                    BASE_URL
                                                        . '/cliente/seguranca',
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                )
                                                ?>"
                                        class="alert-link">

                                        <i class="bi bi-shield-lock me-1"></i>

                                        Ir para Segurança

                                    </a>

                                </div>

                            </div>

                        </div>


                        <!-- ============================================================
         BOTÕES
    ============================================================= -->

                        <div
                            class="d-flex
               flex-column
               flex-sm-row
               justify-content-end
               gap-2">


                            <!-- CANCELAR -->

                            <a
                                href="<?=
                                        htmlspecialchars(
                                            BASE_URL
                                                . '/cliente/perfil',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        )
                                        ?>"
                                class="btn btn-outline-secondary">

                                <i class="bi bi-x-circle me-1"></i>

                                Cancelar

                            </a>


                            <!-- SALVAR -->

                            <button
                                type="submit"
                                class="btn btn-primary">

                                <i class="bi bi-check-circle me-1"></i>

                                Salvar alterações

                            </button>


                        </div>


                    </form>


                </section>


            </div>

        </div>

    </main>


    <!-- ============================================================
         FOOTER
    ============================================================= -->

    <footer class="bg-dark text-white mt-5">

        <div class="container py-4">

            <div class="row align-items-center">


                <div
                    class="col-12 col-md-6
                           text-center text-md-start">

                    <strong>
                        Loja Online
                    </strong>

                    <p class="small text-white-50 mb-0">

                        Sua loja online com segurança e praticidade.

                    </p>

                </div>


                <div
                    class="col-12 col-md-6
                           text-center text-md-end
                           mt-3 mt-md-0">

                    <a
                        href=""
                        class="text-white
                               text-decoration-none
                               me-3">

                        Loja

                    </a>


                    <a
                        href="produtos"
                        class="text-white
                               text-decoration-none
                               me-3">

                        Produtos

                    </a>


                    <a
                        href="cliente/pedidos"
                        class="text-white text-decoration-none">

                        Meus Pedidos

                    </a>

                </div>

            </div>


            <hr class="border-secondary">


            <div class="text-center">

                <small class="text-white-50">

                    &copy; 2026 Loja Online.
                    Todos os direitos reservados.

                </small>

            </div>

        </div>

    </footer>


    <!-- Bootstrap JS -->

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>