<?php

declare(strict_types=1);

use App\Helpers\View;
?>

<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Área de perfil do cliente da Loja Online.">
    <title>Meu Perfil | Loja Online</title>
    <base href="/loja_online/public/">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
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
            <!-- TÍTULO -->
            <div class="row mb-4">
                <div class="col-12">
                    <h1 class="h3 fw-bold mb-1">
                        <i class="bi bi-person-circle text-primary me-2"></i>
                        Meu Perfil
                    </h1>
                    <p class="text-muted mb-0">
                        Consulte e gerencie as informações da sua conta.
                    </p>
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
                                <i class="bi bi-person-circle text-primary" style="font-size: 5rem;">
                                </i>
                            </div>
                            <h2 class="h5 fw-bold mb-1">
                                <?=
                                htmlspecialchars(
                                    (string)
                                    $cliente['nome'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                )
                                ?>
                            </h2>
                            <p class="text-muted small mb-4">
                                <?=
                                htmlspecialchars(
                                    (string)
                                    $cliente['email'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                )
                                ?>

                            </p>
                            <hr>
                            <div class="list-group list-group-flush text-start">
                                <a href="cliente/painel" class="list-group-item list-group-item-action">
                                    <i class="bi bi-speedometer2 me-2"></i>
                                    Painel
                                </a>
                                <a href="cliente/perfil" class="list-group-item list-group-item-action active">
                                    <i class="bi bi-person me-2"></i>
                                    Meu Perfil
                                </a>
                                <a href="cliente/pedidos" class="list-group-item list-group-item-action">
                                    <i class="bi bi-bag-check me-2"></i>
                                    Meus Pedidos
                                </a>
                                <a href="cliente/enderecos" class="list-group-item list-group-item-action">
                                    <i class="bi bi-geo-alt me-2"></i>
                                    Meus Endereços
                                </a>
                                <a href="cliente/seguranca" class="list-group-item list-group-item-action">
                                    <i class="bi bi-shield-lock me-2"></i>
                                    Segurança
                                </a>
                            </div>
                        </div>
                    </div>
                </aside>
                <!-- =================================================
                     CONTEÚDO DO PERFIL
                ================================================== -->
                <section class="col-12 col-lg-9">
                    <!-- DADOS PESSOAIS -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                            <h2 class="h5 fw-bold mb-0">
                                <i class="bi bi-person-vcard text-primary me-2"></i>
                                Dados Pessoais
                            </h2>
                            <a href="cliente/perfil/editar" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-pencil-square me-1"></i>
                                Editar perfil
                            </a>
                        </div>

                        <?php

                        $cpf =
                            preg_replace(
                                '/\D/',
                                '',
                                (string)
                                $cliente['cpf']
                            );


                        $cpfFormatado =
                            strlen($cpf) === 11

                            ? substr($cpf, 0, 3)
                            . '.'
                            . substr($cpf, 3, 3)
                            . '.'
                            . substr($cpf, 6, 3)
                            . '-'
                            . substr($cpf, 9, 2)

                            : $cpf;

                        ?>

                        <?php

                        $dataNascimento =
                            '-';


                        if (
                            !empty($cliente['data_nascimento'])
                        ) {

                            $timestampNascimento =
                                strtotime(
                                    (string)
                                    $cliente['data_nascimento']
                                );


                            if (
                                $timestampNascimento
                                !== false
                            ) {

                                $dataNascimento =
                                    date(
                                        'd/m/Y',
                                        $timestampNascimento
                                    );
                            }
                        }

                        ?>

                        <?php

                        $clienteDesde = '-';


                        $timestampCadastro =
                            strtotime(
                                (string)
                                $cliente['criado_em']
                            );


                        if (
                            $timestampCadastro !== false
                        ) {

                            $clienteDesde =
                                date(
                                    'd/m/Y',
                                    $timestampCadastro
                                );
                        }

                        ?>


                        <?php

                        $telefone =
                            preg_replace(
                                '/\D/',
                                '',
                                (string) (
                                    $cliente['telefone']
                                    ?? ''
                                )
                            );


                        $telefoneFormatado =
                            $telefone;


                        if (
                            strlen($telefone) === 11
                        ) {

                            $telefoneFormatado =
                                '('
                                . substr($telefone, 0, 2)
                                . ') '
                                . substr($telefone, 2, 5)
                                . '-'
                                . substr($telefone, 7, 4);
                        } elseif (
                            strlen($telefone) === 10
                        ) {

                            $telefoneFormatado =
                                '('
                                . substr($telefone, 0, 2)
                                . ') '
                                . substr($telefone, 2, 4)
                                . '-'
                                . substr($telefone, 6, 4);
                        }


                        if ($telefoneFormatado === '') {

                            $telefoneFormatado =
                                'Não informado';
                        }

                        ?>


                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-12 col-md-6">
                                    <small class="text-muted d-block">
                                        Nome completo
                                    </small>
                                    <strong>
                                        <?=
                                        htmlspecialchars(
                                            (string)
                                            $cliente['nome'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        )
                                        ?>
                                    </strong>
                                </div>
                                <div class="col-12 col-md-6">
                                    <small class="text-muted d-block">
                                        CPF
                                    </small>
                                    <strong>
                                        <?=
                                        htmlspecialchars(
                                            (string)
                                            $cpfFormatado,
                                            ENT_QUOTES,
                                            'UTF-8'
                                        )
                                        ?>
                                    </strong>
                                </div>
                                <div class="col-12 col-md-6">
                                    <small class="text-muted d-block">
                                        Data de nascimento
                                    </small>
                                    <strong>
                                        <?=
                                        htmlspecialchars(
                                            (string)
                                            $dataNascimento,
                                            ENT_QUOTES,
                                            'UTF-8'
                                        )
                                        ?>
                                    </strong>
                                </div>
                                <div class="col-12 col-md-6">
                                    <small class="text-muted d-block">
                                        Cliente desde
                                    </small>
                                    <strong>
                                        <?=
                                        htmlspecialchars(
                                            (string)
                                            $clienteDesde,
                                            ENT_QUOTES,
                                            'UTF-8'
                                        )
                                        ?>
                                    </strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- INFORMAÇÕES DE CONTATO -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h2 class="h5 fw-bold mb-0">
                                <i class="bi bi-envelope text-primary me-2"></i>
                                Informações de Contato
                            </h2>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-12 col-md-6">
                                    <small class="text-muted d-block">
                                        E-mail
                                    </small>
                                    <strong>
                                        <?=
            htmlspecialchars(
                (string)
                $cliente['email'],
                ENT_QUOTES,
                'UTF-8'
            )
        ?>

        <?php if (
    (int)
    $cliente['email_verificado']
    === 1
): ?>

    <span
        class="
            badge
            text-bg-success
            ms-2
        "
    >

        Verificado

    </span>

<?php else: ?>

    <span
        class="
            badge
            text-bg-warning
            ms-2
        "
    >

        Não verificado

    </span>

<?php endif; ?>

                                    </strong>
                                </div>
                                <div class="col-12 col-md-6">
                                    <small class="text-muted d-block">
                                        Telefone
                                    </small>
                                    <strong>
                                        
                                        <?=
                                        htmlspecialchars(
                                            (string)
                                            $telefoneFormatado,
                                            ENT_QUOTES,
                                            'UTF-8'
                                        )
                                        ?>
                                    </strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- =================================================
                         ATALHOS
                    ================================================== -->
                    <div class="row g-3">
                        <!-- PEDIDOS -->
                        <div class="col-12 col-md-4">
                            <a href="cliente/pedidos" class="text-decoration-none">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <i class="bi bi-bag-check text-primary fs-2"></i>
                                        <h3 class="h6 fw-bold mt-3 text-dark">
                                            Meus Pedidos
                                        </h3>
                                        <p class="text-muted small mb-0">
                                            Consulte seus pedidos e acompanhe
                                            as entregas.
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <!-- ENDEREÇOS -->
                        <div class="col-12 col-md-4">
                            <a href="cliente/enderecos" class="text-decoration-none">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <i class="bi bi-geo-alt text-primary fs-2"></i>
                                        <h3 class="h6 fw-bold mt-3 text-dark">
                                            Endereços
                                        </h3>
                                        <p class="text-muted small mb-0">
                                            Gerencie os endereços utilizados
                                            nas entregas.
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <!-- SEGURANÇA -->
                        <div class="col-12 col-md-4">
                            <a href="cliente/seguranca" class="text-decoration-none">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <i class="bi bi-shield-lock text-primary fs-2"></i>
                                        <h3 class="h6 fw-bold mt-3 text-dark">
                                            Segurança
                                        </h3>
                                        <p class="text-muted small mb-0">
                                            Altere sua senha e proteja
                                            sua conta.
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
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
                <div class="col-12 col-md-6 text-center text-md-start">
                    <strong>
                        Loja Online
                    </strong>
                    <p class="small text-white-50 mb-0">
                        Sua loja online com segurança e praticidade.
                    </p>
                </div>
                <div class="col-12 col-md-6 text-center text-md-end mt-3 mt-md-0">
                    <a href="" class="text-white text-decoration-none me-3">
                        Loja
                    </a>
                    <a href="produtos" class="text-white text-decoration-none me-3">
                        Produtos
                    </a>
                    <a href="cliente/pedidos" class="text-white text-decoration-none">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
    </script>
</body>

</html>