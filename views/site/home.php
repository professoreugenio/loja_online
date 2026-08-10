<?php
declare(strict_types=1);
use App\Helpers\View;
$tituloPagina = $tituloPagina
    ?? 'Loja Online';
$descricaoPagina = $descricaoPagina
    ?? 'Loja online com produtos, ofertas, atendimento ao cliente e compra segura.';
$baseUrl = defined('BASE_URL')? BASE_URL: '';?>
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
    <link rel="stylesheet" href="<?= htmlspecialchars($baseUrl . '/assets/css/site.css',ENT_QUOTES,'UTF-8')?>">
</head>
<body>
    <!-- ============================================================
         1. BARRA SUPERIOR
    ============================================================= -->
    <?php require_once APP_ROOT  . '/views/componentes/site/sections/barraSuperior.php'; ?>
    <!-- ============================================================
         2. MENU PRINCIPAL
    ============================================================= -->
    <?php //require_once APP_ROOT  . '/views/layouts/site/header.php'; ?>
    <?php require_once APP_ROOT  . '/views/componentes/site/header.php'; ?>
    <main>
        <!-- ========================================================
             3. DESTAQUE PRINCIPAL
        ========================================================= -->
        <?php require_once APP_ROOT  . '/views/componentes/site/sections/destaquePrincipal.php'; ?>
        <!-- ========================================================
             4. BENEFÍCIOS
        ========================================================= -->
        <?php require_once APP_ROOT  . '/views/componentes/site/sections/beneficios.php'; ?>
        <!-- ========================================================
             5. CATEGORIAS
        ========================================================= -->
        <hr>
  
        <hr>

        <?php require_once APP_ROOT  . '/views/componentes/site/sections/categorias.php'; ?>
        <!-- ========================================================
             6. PRODUTOS EM DESTAQUE
        ========================================================= -->
        <?php require_once APP_ROOT  . '/views/componentes/site/sections/produtosDestaque.php'; ?>
        <!-- ========================================================
             7. CHAMADA PROMOCIONAL
        ========================================================= -->
        <?php require_once APP_ROOT  . '/views/componentes/site/sections/chamadapromocional.php'; ?>
        <!-- ========================================================
             8. NEWSLETTER
        ========================================================= -->
        <?php require_once APP_ROOT  . '/views/componentes/site/sections/newsletter.php'; ?>
    </main>
    <!-- ============================================================
         9. RODAPÉ
    ============================================================= -->
    <?php require_once __DIR__ . '/../layouts/site/footer.php'; ?>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>
</html>