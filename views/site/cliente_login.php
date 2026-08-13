<?php
declare(strict_types=1);
use App\Helpers\View;
$tituloPagina = $tituloPagina   ?? 'Cliente Entrar';
$descricaoPagina = $descricaoPagina ?? 'Loja online com produtos, ofertas, atendimento ao cliente e compra segura.';
$baseUrl = defined('BASE_URL')? BASE_URL: '';?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta
        name="description"
        content="">
    <title><?= htmlspecialchars($tituloPagina,ENT_QUOTES,'UTF-8');  ?></title>
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
    <?php View::componente('header', ['categorias' => $categorias,]); ?>
    <main>
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-8 col-lg-5 mx-auto py-5">

                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4 p-md-5">

                            <div class="text-center mb-4">
                                <h1 class="h3 mb-2">Entrar na minha conta</h1>
                                <p class="text-secondary mb-0">
                                    Informe seus dados para acessar sua conta.
                                </p>
                            </div>

                            <?php if (!empty($erroLogin)): ?>
                                <div
                                    class="alert alert-danger"
                                    role="alert"
                                >
                                    <?= htmlspecialchars(
                                        (string) $erroLogin,
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($mensagemSucesso)): ?>
                                <div
                                    class="alert alert-success"
                                    role="alert"
                                >
                                    <?= htmlspecialchars(
                                        (string) $mensagemSucesso,
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>
                                </div>
                            <?php endif; ?>

                            <form
                                action="<?= htmlspecialchars(
                                    $baseUrl . '/cliente/login',
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>"
                                method="post"
                                autocomplete="on"
                            >

                                <?php if (!empty($csrfToken)): ?>
                                    <input
                                        type="hidden"
                                        name="csrf_token"
                                        value="<?= htmlspecialchars(
                                            (string) $csrfToken,
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>"
                                    >
                                <?php endif; ?>

                                <div class="mb-3">
                                    <label
                                        for="email"
                                        class="form-label"
                                    >
                                        E-mail
                                    </label>

                                    <input
                                        type="email"
                                        class="form-control form-control-lg"
                                        id="email"
                                        name="email"
                                        placeholder="seuemail@exemplo.com"
                                        value="<?= htmlspecialchars(
                                            (string) ($_POST['email'] ?? ''),
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>"
                                        autocomplete="email"
                                        maxlength="180"
                                        required
                                        autofocus
                                    >
                                </div>

                                <div class="mb-3">
                                    <label
                                        for="senha"
                                        class="form-label"
                                    >
                                        Senha
                                    </label>

                                    <input
                                        type="password"
                                        class="form-control form-control-lg"
                                        id="senha"
                                        name="senha"
                                        placeholder="Digite sua senha"
                                        autocomplete="current-password"
                                        required
                                    >
                                </div>

                                <div
                                    class="d-flex flex-column flex-sm-row justify-content-between gap-2 mb-4"
                                >
                                    <div class="form-check">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="lembrar"
                                            value="1"
                                            id="lembrar"
                                        >

                                        <label
                                            class="form-check-label"
                                            for="lembrar"
                                        >
                                            Lembrar-me
                                        </label>
                                    </div>

                                    <a
                                        href="<?= htmlspecialchars(
                                            $baseUrl . '/cliente/recuperar-senha',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>"
                                        class="text-decoration-none"
                                    >
                                        Esqueci minha senha
                                    </a>
                                </div>

                                <div class="d-grid mb-3">
                                    <button
                                        type="submit"
                                        class="btn btn-primary btn-lg"
                                    >
                                        Entrar
                                    </button>
                                </div>

                                <p class="text-center mb-0">
                                    Ainda não possui uma conta?
                                    <a
                                        href="<?= htmlspecialchars(
                                            $baseUrl . '/cliente/cadastro',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>"
                                        class="text-decoration-none fw-semibold"
                                    >
                                        Criar conta
                                    </a>
                                </p>

                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>
    <!-- ============================================================
         9. RODAPÉ
    ============================================================= -->
    <?php View::componente('footer');?>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>
</html>