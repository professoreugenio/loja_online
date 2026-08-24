<?php

declare(strict_types=1);

use App\Helpers\View;

$tituloPagina = $tituloPagina
    ?? 'Loja Online';
$descricaoPagina = $descricaoPagina
    ?? 'Loja online com produtos, ofertas, atendimento ao cliente e compra segura.';
$quantidadeCarrinho = $quantidadeCarrinho ?? 0;
$baseUrl = defined('BASE_URL') ? BASE_URL : ''; ?>
<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta
        name="description"
        content="">
    <title><?=
            htmlspecialchars(
                $tituloPagina,
                ENT_QUOTES,
                'UTF-8'
            )
            ?></title>
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
        crossorigin="anonymous">
    <link rel="stylesheet" href="<?= htmlspecialchars($baseUrl . '/assets/css/site.css', ENT_QUOTES, 'UTF-8') ?>">

<style>
    a.linkadmin {
        text-decoration: none;

        width: 60px;
        height: 60px;

        position: fixed;
        right: 20px;
        bottom: 20px;

        display: flex;
        align-items: center;
        justify-content: center;

        background-color: #c70ca5;
        color: #ffffff;

        border-radius: 50%;

        font-size: 24px;

        z-index: 1000;

        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);

        transition:
            transform 0.2s ease,
            background-color 0.2s ease;
    }

    a.linkadmin:hover {
        background-color: #a9098c;
        color: #ffffff;
        transform: scale(1.08);
    }
</style>

</head>

<body>

<a
    href="admin"
    class="linkadmin"
    title="Painel administrativo"
    aria-label="Acessar painel administrativo"
>
    <i class="bi bi-person-gear"></i>
</a>
    <!-- ============================================================
         1. BARRA SUPERIOR
    =====================   ======================================== -->
    <?php //require_once APP_ROOT  . '/views/componentes/site/sections/barraSuperior.php'; 
    ?>
    <?php View::componente('sections/barraSuperior'); ?>
    <!-- ============================================================
         2. MENU PRINCIPAL
    ============================================================= -->

    <?php //require_once APP_ROOT  . '/views/componentes/site/header.php'; 
    ?>
    <?php //View::componente('header'); 
    ?>
    <?php
    View::componente('header', ['categorias' => $categorias, 'quantidadeCarrinho' => $quantidadeCarrinho,]);
    ?>
    <main>
        <!-- ========================================================
             3. DESTAQUE PRINCIPAL
        ========================================================= -->
        <?php //require_once APP_ROOT  . '/views/componentes/site/sections/destaquePrincipal.php'; 
        ?>
        <?php View::componente('sections/destaquePrincipal'); ?>
        <!-- ========================================================
             4. BENEFÍCIOS
        ========================================================= -->
        <?php //require_once APP_ROOT  . '/views/componentes/site/sections/beneficios.php'; 
        ?>
        <?php View::componente('sections/beneficios'); ?>
        <!-- ========================================================
             5. CATEGORIAS
        ========================================================= -->
        <hr>

        <hr>

        <?php //require_once APP_ROOT  . '/views/componentes/site/sections/categorias.php'; 
        ?>
        <?php View::componente('sections/categorias'); ?>
        <!-- ========================================================
             6. PRODUTOS EM DESTAQUE
        ========================================================= -->
        <?php //require_once APP_ROOT  . '/views/componentes/site/sections/produtosDestaque.php'; 
        ?>
        <?php View::componente('sections/produtosDestaque'); ?>
        <!-- ========================================================
             7. CHAMADA PROMOCIONAL
        ========================================================= -->
        <?php //require_once APP_ROOT  . '/views/componentes/site/sections/chamadapromocional.php'; 
        ?>
        <?php View::componente('sections/chamadapromocional'); ?>
        <!-- ========================================================
             8. NEWSLETTER
        ========================================================= -->
        <?php //require_once APP_ROOT  . '/views/componentes/site/sections/newsletter.php'; 
        ?>
        <?php View::componente('sections/newsletter'); ?>
    </main>
    <!-- ============================================================
         9. RODAPÉ
    ============================================================= -->
    <?php View::componente('footer'); ?>
    <?php //require_once __DIR__ . '/../layouts/site/footer.php'; 
    ?>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>