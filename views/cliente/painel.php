<?php

declare(strict_types=1);

use App\Helpers\View;
?>
<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Painel da área do cliente da Loja Online.">
    <title>Painel | Loja Online</title>
    <base href="/loja_online/public/">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <!-- CSS do projeto -->
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
                 BOAS-VINDAS
            ===================================================== -->
            <div class="row mb-4">
                <div class="col-12">
                    <h1 class="h3 fw-bold mb-1">
                        <?=
                        htmlspecialchars(
                            $primeiroNome,
                            ENT_QUOTES,
                            'UTF-8'
                        )
                        ?>!
                    </h1>
                    <p class="text-muted mb-0">
                        Bem-vindo à sua área de cliente.
                        Aqui você pode acompanhar seus pedidos
                        e gerenciar sua conta.
                    </p>
                </div>
            </div>
            <!-- ====================================================
                 CARDS DE RESUMO
            ===================================================== -->
            <div class="row g-4 mb-5">
                <!-- PEDIDOS -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-1">
                                        Total de Pedidos
                                    </p>
                                    <h2 class="fw-bold mb-0">
                                        <?=
                                        (int)
                                        $totalPedidos
                                        ?>
                                    </h2>
                                </div>
                                <div class="fs-1 text-primary">
                                    <i class="bi bi-bag-check"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- EM ANDAMENTO -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-1">
                                        Em Andamento
                                    </p>
                                    <h2 class="fw-bold mb-0">
                                        <?=
                                        (int)
                                        $pedidosEmAndamento
                                        ?>
                                    </h2>
                                </div>
                                <div class="fs-1 text-warning">
                                    <i class="bi bi-clock-history"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ENTREGUES -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-1">
                                        Entregues
                                    </p>
                                    <h2 class="fw-bold mb-0">
                                        <?=
                                        (int)
                                        $pedidosEntregues
                                        ?>
                                    </h2>
                                </div>
                                <div class="fs-1 text-success">
                                    <i class="bi bi-check-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ENDEREÇOS -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-1">
                                        Endereços
                                    </p>
                                    <h2 class="fw-bold mb-0">
                                        <?=
                                        (int)
                                        $quantidadeEnderecos
                                        ?>
                                    </h2>
                                </div>
                                <div class="fs-1 text-info">
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ====================================================
                 CONTEÚDO PRINCIPAL
            ===================================================== -->
            <div class="row g-4">
                <!-- =================================================
                     ÚLTIMOS PEDIDOS
                ================================================== -->
                <div class="col-12 col-lg-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                            <h2 class="h5 fw-bold mb-0">
                                <i class="bi bi-bag-check text-primary me-2"></i>
                                Últimos Pedidos
                            </h2>
                            <a href="cliente/pedidos" class="btn btn-outline-primary btn-sm">
                                Ver todos
                            </a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">

                                <?php if (
                                    $ultimosPedidos === []
                                ): ?>

                                    <div
                                        class="
            text-center
            py-5
        ">

                                        <i
                                            class="
                bi
                bi-bag
                fs-1
                text-muted
            "></i>


                                        <h3 class="h6 mt-3">

                                            Você ainda não possui pedidos.

                                        </h3>


                                        <a
                                            href="produtos"
                                            class="
                btn
                btn-primary
                btn-sm
                mt-2
            ">

                                            Começar a comprar

                                        </a>

                                    </div>

                                <?php else: ?>
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Pedido</th>
                                                <th>Data</th>
                                                <th>Total</th>
                                                <th>Status</th>
                                                <th class="text-end">
                                                    Ação
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- PEDIDO 1 -->
                                            <?php foreach ($ultimosPedidos as $pedido): ?>

                                                <?php

                                                $statusPedidos = [

                                                    'aguardando_pagamento' => [
                                                        'texto' =>
                                                        'Aguardando pagamento',

                                                        'classe' =>
                                                        'text-bg-secondary',
                                                    ],

                                                    'pago' => [
                                                        'texto' =>
                                                        'Pago',

                                                        'classe' =>
                                                        'text-bg-info',
                                                    ],

                                                    'em_separacao' => [
                                                        'texto' =>
                                                        'Em separação',

                                                        'classe' =>
                                                        'text-bg-warning',
                                                    ],

                                                    'enviado' => [
                                                        'texto' =>
                                                        'Enviado',

                                                        'classe' =>
                                                        'text-bg-primary',
                                                    ],

                                                    'entregue' => [
                                                        'texto' =>
                                                        'Entregue',

                                                        'classe' =>
                                                        'text-bg-success',
                                                    ],

                                                    'cancelado' => [
                                                        'texto' =>
                                                        'Cancelado',

                                                        'classe' =>
                                                        'text-bg-danger',
                                                    ],
                                                ];

                                                ?>
                                                <tr>
                                                    <td>
                                                        <strong>
                                                            #000125
                                                        </strong>
                                                    </td>
                                                    <td>
                                                        15/08/2026
                                                    </td>
                                                    <td>
                                                        <strong>
                                                            R$ 119,90
                                                        </strong>
                                                    </td>
                                                    <td>
                                                        <span class="badge text-bg-warning">
                                                            Em preparação
                                                        </span>
                                                    </td>
                                                    <td class="text-end">
                                                        <a href="cliente/pedido?id=125" class="btn btn-outline-primary btn-sm">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>


                                        </tbody>
                                    </table>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- =================================================
                     PERFIL RESUMIDO
                ================================================== -->
                <div class="col-12 col-lg-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white py-3">
                            <h2 class="h5 fw-bold mb-0">
                                <i class="bi bi-person-circle text-primary me-2"></i>
                                Minha Conta
                            </h2>
                        </div>
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <?php

                                $fotoCliente =
                                    trim(
                                        (string) (
                                            $cliente['foto_url']
                                            ?? ''
                                        )
                                    );

                                ?>
                                <?php if (
                                    $fotoCliente !== ''
                                ): ?>

                                    <img
                                        src="<?=
                                                htmlspecialchars(
                                                    $fotoCliente,
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                )
                                                ?>"
                                        class="
            rounded-circle
            object-fit-cover
        "
                                        width="100"
                                        height="100"
                                        alt="Foto do cliente">

                                <?php else: ?>

                                    <i
                                        class="
            bi
            bi-person-circle
            text-primary
        "
                                        style="font-size:5rem;"></i>

                                <?php endif; ?>
                            </div>
                            <h3 class="h5 fw-bold">
                                <?=
                                htmlspecialchars(
                                    (string)
                                    $cliente['nome'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                )
                                ?>
                            </h3>
                            <p class="text-muted">
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
                            <div class="d-grid gap-2">
                                <a href="cliente/perfil" class="btn btn-outline-primary">
                                    <i class="bi bi-person me-1"></i>
                                    Meu Perfil
                                </a>
                                <a href="cliente/seguranca" class="btn btn-outline-secondary">
                                    <i class="bi bi-shield-lock me-1"></i>
                                    Segurança
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ====================================================
                 SEGUNDA LINHA
            ===================================================== -->
            <div class="row g-4 mt-1">
                <!-- =================================================
                     ENDEREÇO PRINCIPAL
                ================================================== -->
                <div class="col-12 col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                            <h2 class="h5 fw-bold mb-0">
                                <i class="bi bi-geo-alt text-primary me-2"></i>
                                Endereço Principal
                            </h2>
                            <a href="cliente/enderecos" class="btn btn-outline-primary btn-sm">
                                Gerenciar
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="me-3">
                                    <i class="bi bi-house-door fs-2 text-primary"></i>
                                </div>
                                <div>
                                    <h3 class="h6 fw-bold">
                                        Minha Casa
                                    </h3>
                                    <p class="mb-1">
                                        Rua das Flores, 125
                                    </p>
                                    <p class="mb-1">
                                        Apartamento 302 - Centro
                                    </p>
                                    <p class="mb-1">
                                        Fortaleza - CE
                                    </p>
                                    <p class="mb-0">
                                        CEP: 60000-000
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- =================================================
                     ACESSO RÁPIDO
                ================================================== -->
                <div class="col-12 col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white py-3">
                            <h2 class="h5 fw-bold mb-0">
                                <i class="bi bi-grid text-primary me-2"></i>
                                Acesso Rápido
                            </h2>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <!-- PEDIDOS -->
                                <div class="col-6">
                                    <a href="cliente/pedidos" class="text-decoration-none">
                                        <div class="border rounded p-3 text-center h-100">
                                            <i class="bi bi-bag-check fs-2 text-primary"></i>
                                            <p class="fw-bold text-dark mt-2 mb-0">
                                                Pedidos
                                            </p>
                                        </div>
                                    </a>
                                </div>
                                <!-- PERFIL -->
                                <div class="col-6">
                                    <a href="cliente/perfil" class="text-decoration-none">
                                        <div class="border rounded p-3 text-center h-100">
                                            <i class="bi bi-person fs-2 text-primary"></i>
                                            <p class="fw-bold text-dark mt-2 mb-0">
                                                Perfil
                                            </p>
                                        </div>
                                    </a>
                                </div>
                                <!-- ENDEREÇOS -->
                                <div class="col-6">
                                    <a href="cliente/enderecos" class="text-decoration-none">
                                        <div class="border rounded p-3 text-center h-100">
                                            <i class="bi bi-geo-alt fs-2 text-primary"></i>
                                            <p class="fw-bold text-dark mt-2 mb-0">
                                                Endereços
                                            </p>
                                        </div>
                                    </a>
                                </div>
                                <!-- SEGURANÇA -->
                                <div class="col-6">
                                    <a href="cliente/seguranca" class="text-decoration-none">
                                        <div class="border rounded p-3 text-center h-100">
                                            <i class="bi bi-shield-lock fs-2 text-primary"></i>
                                            <p class="fw-bold text-dark mt-2 mb-0">
                                                Segurança
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ====================================================
                 CONTINUAR COMPRANDO
            ===================================================== -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                        <div>
                            <h2 class="h5 fw-bold mb-1">
                                <i class="bi bi-cart text-primary me-2"></i>
                                Continue comprando
                            </h2>
                            <p class="text-muted mb-0">
                                Confira nossos produtos e encontre
                                novas ofertas.
                            </p>
                        </div>
                        <a href="produtos" class="btn btn-primary">
                            <i class="bi bi-cart-plus me-1"></i>
                            Ver produtos
                        </a>
                    </div>
                </div>
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