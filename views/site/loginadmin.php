<?php

declare(strict_types=1);

$baseUrl = defined('BASE_URL')
    ? rtrim((string) BASE_URL, '/')
    : '';

?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta
        name="robots"
        content="noindex, nofollow"
    >

    <title>
        Login administrativo — Loja Online
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
    >

    <style>
        :root {
            --admin-bg-start: #f8f9fa;
            --admin-bg-end: #e9ecef;
            --admin-card-radius: 1.35rem;
        }

        body {
            min-height: 100vh;
            background:
                radial-gradient(
                    circle at top left,
                    rgba(13, 110, 253, .12),
                    transparent 32rem
                ),
                linear-gradient(
                    135deg,
                    var(--admin-bg-start),
                    var(--admin-bg-end)
                );
        }

        .login-wrapper {
            width: 100%;
            max-width: 460px;
        }

        .login-card {
            border-radius: var(--admin-card-radius);
            overflow: hidden;
        }

        .login-card::before {
            content: "";
            display: block;
            height: 5px;
            background: var(--bs-primary);
        }

        .login-icon {
            width: 76px;
            height: 76px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(13, 110, 253, .1);
            color: var(--bs-primary);
            font-size: 2rem;
        }

        .form-control,
        .input-group-text,
        .btn-password {
            min-height: 48px;
        }

        .form-control:focus {
            box-shadow: 0 0 0 .25rem rgba(13, 110, 253, .15);
        }

        .btn-password {
            border-color: var(--bs-border-color);
            background: var(--bs-body-bg);
            color: var(--bs-secondary-color);
        }

        .btn-password:hover,
        .btn-password:focus {
            background: var(--bs-tertiary-bg);
            color: var(--bs-body-color);
            border-color: var(--bs-border-color);
        }

        .btn-login {
            min-height: 50px;
            font-weight: 600;
        }

        .login-footer {
            font-size: .875rem;
        }
    </style>
</head>

<body>

    <main
        class="container py-4
               d-flex align-items-center
               justify-content-center"
        style="min-height: 100vh;"
    >

        <div class="login-wrapper">

            <div class="card login-card border-0 shadow-lg">

                <div class="card-body p-4 p-sm-5">

                    <div class="text-center mb-4">

                        <div
                            class="login-icon"
                            aria-hidden="true"
                        >
                            <i class="bi bi-shield-lock-fill"></i>
                        </div>

                        <h1 class="h3 fw-bold mt-3 mb-2">
                            Área administrativa
                        </h1>

                        <p class="text-secondary mb-0">
                            Entre com suas credenciais para acessar o painel.
                        </p>

                    </div>

                    <?php if (!empty($erro)): ?>

                        <div
                            class="alert alert-danger
                                   d-flex align-items-start gap-2"
                            role="alert"
                        >
                            <i
                                class="bi bi-exclamation-triangle-fill mt-1"
                                aria-hidden="true"
                            ></i>

                            <div>
                                <?=
                                    htmlspecialchars(
                                        (string) $erro,
                                        ENT_QUOTES,
                                        'UTF-8'
                                    )
                                ?>
                            </div>
                        </div>

                    <?php endif; ?>

                    <form
                        action="<?=
                            htmlspecialchars(
                                $baseUrl . '/loginadmin',
                                ENT_QUOTES,
                                'UTF-8'
                            )
                        ?>"
                        method="post"
                        autocomplete="on"
                    >

                        <input
                            type="hidden"
                            name="_token"
                            value="<?=
                                htmlspecialchars(
                                    (string) $csrfToken,
                                    ENT_QUOTES,
                                    'UTF-8'
                                )
                            ?>"
                        >

                        <div class="mb-3">

                            <label
                                class="form-label fw-semibold"
                                for="email"
                            >
                                E-mail
                            </label>

                            <div class="input-group">

                                <span
                                    class="input-group-text"
                                    aria-hidden="true"
                                >
                                    <i class="bi bi-envelope"></i>
                                </span>

                                <input
                                    class="form-control"
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="<?=
                                        htmlspecialchars(
                                            (string) $email,
                                            ENT_QUOTES,
                                            'UTF-8'
                                        )
                                    ?>"
                                    placeholder="admin@exemplo.com"
                                    autocomplete="username"
                                    maxlength="190"
                                    required
                                    autofocus
                                >

                            </div>

                        </div>

                        <div class="mb-4">

                            <label
                                class="form-label fw-semibold"
                                for="senha"
                            >
                                Senha
                            </label>

                            <div class="input-group">

                                <span
                                    class="input-group-text"
                                    aria-hidden="true"
                                >
                                    <i class="bi bi-key"></i>
                                </span>

                                <input
                                    class="form-control"
                                    type="password"
                                    id="senha"
                                    name="senha"
                                    placeholder="Digite sua senha"
                                    autocomplete="current-password"
                                    required
                                >

                                <button
                                    class="btn btn-password"
                                    type="button"
                                    id="toggleSenha"
                                    aria-label="Mostrar senha"
                                    aria-pressed="false"
                                    title="Mostrar senha"
                                >
                                    <i
                                        class="bi bi-eye"
                                        id="iconeSenha"
                                        aria-hidden="true"
                                    ></i>
                                </button>

                            </div>

                            <div
                                class="form-text"
                                id="ajudaSenha"
                            >
                                Clique no ícone do olho para visualizar a senha.
                            </div>

                        </div>

                        <div class="d-grid">

                            <button
                                class="btn btn-primary btn-lg btn-login"
                                type="submit"
                            >
                                <i
                                    class="bi bi-box-arrow-in-right me-2"
                                    aria-hidden="true"
                                ></i>
                                Entrar no painel
                            </button>

                        </div>

                    </form>

                    <div
                        class="login-footer text-center
                               border-top mt-4 pt-4"
                    >

                        <a
                            class="text-decoration-none"
                            href="<?=
                                htmlspecialchars(
                                    $baseUrl . '/',
                                    ENT_QUOTES,
                                    'UTF-8'
                                )
                            ?>"
                        >
                            <i
                                class="bi bi-arrow-left me-1"
                                aria-hidden="true"
                            ></i>
                            Voltar para a loja
                        </a>

                        <p class="text-secondary mt-3 mb-0">
                            <i
                                class="bi bi-lock-fill me-1"
                                aria-hidden="true"
                            ></i>
                            Acesso restrito a usuários autorizados.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </main>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    ></script>

    <script>
        (() => {
            'use strict';

            const senha = document.getElementById('senha');
            const botao = document.getElementById('toggleSenha');
            const icone = document.getElementById('iconeSenha');

            if (!senha || !botao || !icone) {
                return;
            }

            botao.addEventListener('click', () => {
                const estaOculta =
                    senha.type === 'password';

                senha.type =
                    estaOculta
                        ? 'text'
                        : 'password';

                icone.classList.toggle(
                    'bi-eye',
                    !estaOculta
                );

                icone.classList.toggle(
                    'bi-eye-slash',
                    estaOculta
                );

                botao.setAttribute(
                    'aria-label',
                    estaOculta
                        ? 'Ocultar senha'
                        : 'Mostrar senha'
                );

                botao.setAttribute(
                    'title',
                    estaOculta
                        ? 'Ocultar senha'
                        : 'Mostrar senha'
                );

                botao.setAttribute(
                    'aria-pressed',
                    estaOculta
                        ? 'true'
                        : 'false'
                );

                senha.focus();
            });
        })();
    </script>

</body>
</html>
