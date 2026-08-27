<?php

declare(strict_types=1);

use App\Helpers\View;


/*
|--------------------------------------------------------------------------
| Dados recebidos do PerfilController
|--------------------------------------------------------------------------
*/

$seguranca =
    is_array($seguranca ?? null)
        ? $seguranca
        : [];


$dispositivos =
    is_array($dispositivos ?? null)
        ? $dispositivos
        : [];


$csrfToken =
    (string) (
        $csrfToken
        ?? ''
    );


/*
|--------------------------------------------------------------------------
| Escape HTML
|--------------------------------------------------------------------------
*/

$e =
    static function (
        mixed $valor
    ): string {

        return htmlspecialchars(
            (string) $valor,
            ENT_QUOTES,
            'UTF-8'
        );
    };


/*
|--------------------------------------------------------------------------
| Formatar data
|--------------------------------------------------------------------------
*/

$formatarData =
    static function (
        mixed $data
    ): string {

        if (
            $data === null
            ||
            $data === ''
        ) {
            return 'Não registrado';
        }


        $timestamp =
            strtotime(
                (string) $data
            );


        if ($timestamp === false) {
            return 'Não registrado';
        }


        return date(
            'd/m/Y \à\s H:i',
            $timestamp
        );
    };


/*
|--------------------------------------------------------------------------
| Dados da conta
|--------------------------------------------------------------------------
*/

$nome =
    (string) (
        $seguranca['nome']
        ?? 'Cliente'
    );


$email =
    (string) (
        $seguranca['email']
        ?? ''
    );


$emailVerificado =
    (int) (
        $seguranca[
            'email_verificado'
        ]
        ?? 0
    ) === 1;


$possuiSenha =
    (int) (
        $seguranca[
            'possui_senha'
        ]
        ?? 0
    ) === 1;


$status =
    (string) (
        $seguranca['status']
        ?? 'inativo'
    );


$ultimoAcesso =
    $formatarData(
        $seguranca[
            'ultimo_acesso'
        ]
        ?? null
    );


$statusTexto =
    match ($status) {

        'ativo' =>
            'Ativa',

        'bloqueado' =>
            'Bloqueada',

        'inativo' =>
            'Inativa',

        default =>
            ucfirst($status),
    };


$statusClasse =
    match ($status) {

        'ativo' =>
            'success',

        'bloqueado' =>
            'danger',

        default =>
            'secondary',
    };
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
        name="description"
        content="Configurações de segurança da conta do cliente."
    >

    <title>
        Segurança | Loja Online
    </title>

    <base href="/loja_online/public/">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
    >

    <link
        rel="stylesheet"
        href="assets/css/site.css"
    >

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
                 CABEÇALHO
            ===================================================== -->

            <div class="row mb-4">

                <div class="col-12">

                    <h1 class="h3 fw-bold mb-1">

                        <i
                            class="bi bi-shield-lock
                            text-primary me-2"
                        ></i>

                        Segurança da Conta

                    </h1>


                    <p class="text-muted mb-0">

                        Gerencie sua senha e consulte
                        as informações de segurança
                        registradas na sua conta.

                    </p>

                </div>

            </div>


            <!-- ====================================================
                 MENSAGENS
            ===================================================== -->

            <?php if (!empty($mensagemSucesso)): ?>

                <div
                    class="alert alert-success
                    alert-dismissible fade show"
                    role="alert"
                >

                    <i
                        class="bi bi-check-circle-fill me-2"
                    ></i>

                    <?= $e($mensagemSucesso) ?>


                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Fechar"
                    ></button>

                </div>

            <?php endif; ?>


            <?php if (!empty($mensagemErro)): ?>

                <div
                    class="alert alert-danger
                    alert-dismissible fade show"
                    role="alert"
                >

                    <i
                        class="bi bi-exclamation-triangle-fill me-2"
                    ></i>

                    <?= $e($mensagemErro) ?>


                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Fechar"
                    ></button>

                </div>

            <?php endif; ?>


            <div class="row g-4">


                <!-- =================================================
                     COLUNA PRINCIPAL
                ================================================== -->

                <div class="col-12 col-lg-8">


                    <!-- =============================================
                         ALTERAR SENHA
                    ============================================== -->

                    <section
                        class="card border-0
                        shadow-sm mb-4"
                    >

                        <div
                            class="card-header
                            bg-white py-3"
                        >

                            <h2
                                class="h5 fw-bold mb-0"
                            >

                                <i
                                    class="bi bi-key
                                    text-primary me-2"
                                ></i>

                                Alterar Senha

                            </h2>

                        </div>


                        <div class="card-body">

                            <p class="text-muted">

                                Utilize uma senha forte
                                e diferente das utilizadas
                                em outros sites.

                            </p>


                            <form
                                action="cliente/seguranca/senha"
                                method="post"
                                id="formAlterarSenha"
                            >


                                <!-- CSRF -->

                                <input
                                    type="hidden"
                                    name="csrf_token"
                                    value="<?= $e($csrfToken) ?>"
                                >


                                <!-- SENHA ATUAL -->

                                <?php if ($possuiSenha): ?>

                                    <div class="mb-3">

                                        <label
                                            for="senhaAtual"
                                            class="form-label"
                                        >
                                            Senha atual
                                        </label>


                                        <div class="input-group">

                                            <span
                                                class="input-group-text"
                                            >

                                                <i
                                                    class="bi bi-lock"
                                                ></i>

                                            </span>


                                            <input
                                                type="password"
                                                class="form-control"
                                                id="senhaAtual"
                                                name="senha_atual"
                                                placeholder="Digite sua senha atual"
                                                autocomplete="current-password"
                                                required
                                            >


                                            <button
                                                class="btn btn-outline-secondary btn-mostrar-senha"
                                                type="button"
                                                data-target="senhaAtual"
                                                aria-label="Mostrar senha atual"
                                            >

                                                <i
                                                    class="bi bi-eye"
                                                ></i>

                                            </button>

                                        </div>

                                    </div>

                                <?php else: ?>

                                    <div
                                        class="alert alert-info"
                                    >

                                        <i
                                            class="bi bi-info-circle me-1"
                                        ></i>

                                        Sua conta ainda não possui
                                        senha local configurada.
                                        Defina uma nova senha abaixo.

                                    </div>

                                <?php endif; ?>


                                <!-- NOVA SENHA -->

                                <div class="mb-3">

                                    <label
                                        for="novaSenha"
                                        class="form-label"
                                    >
                                        Nova senha
                                    </label>


                                    <div class="input-group">

                                        <span
                                            class="input-group-text"
                                        >

                                            <i
                                                class="bi bi-lock-fill"
                                            ></i>

                                        </span>


                                        <input
                                            type="password"
                                            class="form-control"
                                            id="novaSenha"
                                            name="nova_senha"
                                            placeholder="Digite a nova senha"
                                            minlength="8"
                                            maxlength="255"
                                            autocomplete="new-password"
                                            required
                                        >


                                        <button
                                            class="btn btn-outline-secondary btn-mostrar-senha"
                                            type="button"
                                            data-target="novaSenha"
                                            aria-label="Mostrar nova senha"
                                        >

                                            <i
                                                class="bi bi-eye"
                                            ></i>

                                        </button>

                                    </div>


                                    <div class="form-text">

                                        Utilize pelo menos
                                        8 caracteres.

                                    </div>

                                </div>


                                <!-- CONFIRMAR SENHA -->

                                <div class="mb-4">

                                    <label
                                        for="confirmarSenha"
                                        class="form-label"
                                    >
                                        Confirmar nova senha
                                    </label>


                                    <div class="input-group">

                                        <span
                                            class="input-group-text"
                                        >

                                            <i
                                                class="bi bi-lock-fill"
                                            ></i>

                                        </span>


                                        <input
                                            type="password"
                                            class="form-control"
                                            id="confirmarSenha"
                                            name="confirmar_senha"
                                            placeholder="Digite novamente a nova senha"
                                            minlength="8"
                                            maxlength="255"
                                            autocomplete="new-password"
                                            required
                                        >


                                        <button
                                            class="btn btn-outline-secondary btn-mostrar-senha"
                                            type="button"
                                            data-target="confirmarSenha"
                                            aria-label="Mostrar confirmação da senha"
                                        >

                                            <i
                                                class="bi bi-eye"
                                            ></i>

                                        </button>

                                    </div>


                                    <div
                                        id="mensagemSenhas"
                                        class="form-text"
                                    ></div>

                                </div>


                                <!-- RECOMENDAÇÕES -->

                                <div
                                    class="alert alert-light border"
                                >

                                    <strong>

                                        <i
                                            class="bi bi-info-circle
                                            text-primary me-1"
                                        ></i>

                                        Recomendações

                                    </strong>


                                    <ul class="mb-0 mt-2">

                                        <li>
                                            Utilize pelo menos 8 caracteres.
                                        </li>

                                        <li>
                                            Combine letras maiúsculas
                                            e minúsculas.
                                        </li>

                                        <li>
                                            Utilize números.
                                        </li>

                                        <li>
                                            Utilize caracteres especiais.
                                        </li>

                                        <li>
                                            Não utilize CPF,
                                            telefone ou datas fáceis.
                                        </li>

                                    </ul>

                                </div>


                                <div class="text-end">

                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                    >

                                        <i
                                            class="bi bi-check-lg me-1"
                                        ></i>

                                        Alterar senha

                                    </button>

                                </div>

                            </form>

                        </div>

                    </section>


                    <!-- =============================================
                         DISPOSITIVOS REGISTRADOS
                    ============================================== -->

                    <section
                        class="card border-0
                        shadow-sm mb-4"
                    >

                        <div
                            class="card-header
                            bg-white py-3"
                        >

                            <h2
                                class="h5 fw-bold mb-0"
                            >

                                <i
                                    class="bi bi-device-hdd
                                    text-primary me-2"
                                ></i>

                                Dispositivos Registrados

                            </h2>

                        </div>


                        <div class="card-body">

                            <p class="text-muted small">

                                Esta lista utiliza os registros
                                da tabela de dispositivos de
                                notificação da sua conta.

                            </p>


                            <?php if (empty($dispositivos)): ?>

                                <div
                                    class="alert alert-light
                                    border mb-0"
                                >

                                    <i
                                        class="bi bi-info-circle me-1"
                                    ></i>

                                    Nenhum dispositivo de
                                    notificação foi registrado.

                                </div>

                            <?php else: ?>


                                <?php foreach ($dispositivos as $indice => $dispositivo): ?>

                                    <?php

                                    $plataforma =
                                        strtolower(
                                            trim(
                                                (string) (
                                                    $dispositivo[
                                                        'plataforma'
                                                    ]
                                                    ?? 'web'
                                                )
                                            )
                                        );


                                    $iconePlataforma =
                                        match ($plataforma) {

                                            'android',
                                            'ios' =>
                                                'bi-phone',

                                            'web' =>
                                                'bi-globe2',

                                            default =>
                                                'bi-device-hdd',
                                        };


                                    $plataformaTexto =
                                        match ($plataforma) {

                                            'android' =>
                                                'Android',

                                            'ios' =>
                                                'iOS',

                                            'web' =>
                                                'Web',

                                            default =>
                                                ucfirst(
                                                    $plataforma
                                                ),
                                        };


                                    $dispositivoAtivo =
                                        (int) (
                                            $dispositivo[
                                                'ativo'
                                            ]
                                            ?? 0
                                        ) === 1;


                                    $ultimoAcessoDispositivo =
                                        $formatarData(
                                            $dispositivo[
                                                'ultimo_acesso'
                                            ]
                                            ?? null
                                        );
                                    ?>


                                    <?php if ($indice > 0): ?>

                                        <hr>

                                    <?php endif; ?>


                                    <div
                                        class="d-flex flex-column
                                        flex-md-row
                                        justify-content-between
                                        align-items-md-center
                                        gap-3"
                                    >

                                        <div
                                            class="d-flex
                                            align-items-center"
                                        >

                                            <div class="me-3">

                                                <i
                                                    class="bi <?= $e($iconePlataforma) ?>
                                                    text-primary fs-2"
                                                ></i>

                                            </div>


                                            <div>

                                                <h3
                                                    class="h6
                                                    fw-bold mb-1"
                                                >

                                                    <?= $e($plataformaTexto) ?>

                                                </h3>


                                                <?php if ($dispositivoAtivo): ?>

                                                    <span
                                                        class="badge
                                                        text-bg-success"
                                                    >
                                                        Ativo
                                                    </span>

                                                <?php else: ?>

                                                    <span
                                                        class="badge
                                                        text-bg-secondary"
                                                    >
                                                        Inativo
                                                    </span>

                                                <?php endif; ?>

                                            </div>

                                        </div>


                                        <div class="text-md-end">

                                            <small
                                                class="text-muted d-block"
                                            >
                                                Último acesso
                                            </small>

                                            <strong class="small">

                                                <?= $e($ultimoAcessoDispositivo) ?>

                                            </strong>

                                        </div>

                                    </div>

                                <?php endforeach; ?>


                            <?php endif; ?>

                        </div>

                    </section>


                    <!-- =============================================
                         ATIVIDADE DA CONTA
                    ============================================== -->

                    <section
                        class="card border-0 shadow-sm"
                    >

                        <div
                            class="card-header
                            bg-white py-3"
                        >

                            <h2
                                class="h5 fw-bold mb-0"
                            >

                                <i
                                    class="bi bi-clock-history
                                    text-primary me-2"
                                ></i>

                                Atividade da Conta

                            </h2>

                        </div>


                        <div class="card-body">

                            <div
                                class="d-flex flex-column
                                flex-md-row
                                justify-content-between
                                gap-3"
                            >

                                <div>

                                    <strong class="d-block">
                                        Último login registrado
                                    </strong>

                                    <small class="text-muted">

                                        O banco atual mantém
                                        somente a informação
                                        do último acesso do cliente.

                                    </small>

                                </div>


                                <div class="text-md-end">

                                    <i
                                        class="bi bi-clock me-1"
                                    ></i>

                                    <strong>

                                        <?= $e($ultimoAcesso) ?>

                                    </strong>

                                </div>

                            </div>

                        </div>

                    </section>

                </div>


                <!-- =================================================
                     COLUNA LATERAL
                ================================================== -->

                <aside class="col-12 col-lg-4">


                    <!-- =============================================
                         STATUS
                    ============================================== -->

                    <section
                        class="card border-0
                        shadow-sm mb-4"
                    >

                        <div
                            class="card-header
                            bg-white py-3"
                        >

                            <h2
                                class="h5 fw-bold mb-0"
                            >

                                <i
                                    class="bi bi-shield-check
                                    text-success me-2"
                                ></i>

                                Segurança da Conta

                            </h2>

                        </div>


                        <div class="card-body">


                            <!-- SENHA -->

                            <div
                                class="d-flex
                                align-items-center mb-3"
                            >

                                <?php if ($possuiSenha): ?>

                                    <i
                                        class="bi bi-check-circle-fill
                                        text-success fs-4 me-3"
                                    ></i>

                                <?php else: ?>

                                    <i
                                        class="bi bi-exclamation-circle-fill
                                        text-warning fs-4 me-3"
                                    ></i>

                                <?php endif; ?>


                                <div>

                                    <strong class="d-block">

                                        <?= $possuiSenha
                                            ? 'Senha configurada'
                                            : 'Senha não configurada'
                                        ?>

                                    </strong>

                                    <small class="text-muted">

                                        <?= $possuiSenha
                                            ? 'Sua conta possui senha de acesso.'
                                            : 'Defina uma senha para o acesso local.'
                                        ?>

                                    </small>

                                </div>

                            </div>


                            <hr>


                            <!-- EMAIL -->

                            <div
                                class="d-flex
                                align-items-center mb-3"
                            >

                                <?php if ($emailVerificado): ?>

                                    <i
                                        class="bi bi-check-circle-fill
                                        text-success fs-4 me-3"
                                    ></i>

                                <?php else: ?>

                                    <i
                                        class="bi bi-exclamation-circle-fill
                                        text-warning fs-4 me-3"
                                    ></i>

                                <?php endif; ?>


                                <div>

                                    <strong class="d-block">

                                        <?= $emailVerificado
                                            ? 'E-mail verificado'
                                            : 'E-mail não verificado'
                                        ?>

                                    </strong>


                                    <small class="text-muted">

                                        <?= $e(
                                            $email !== ''
                                                ? $email
                                                : 'Não informado'
                                        ) ?>

                                    </small>

                                </div>

                            </div>


                            <hr>


                            <!-- STATUS DA CONTA -->

                            <div
                                class="d-flex
                                align-items-center"
                            >

                                <i
                                    class="bi bi-person-check
                                    text-primary fs-4 me-3"
                                ></i>


                                <div>

                                    <strong class="d-block">

                                        <?= $e($nome) ?>

                                    </strong>


                                    <span
                                        class="badge
                                        text-bg-<?= $e($statusClasse) ?>"
                                    >

                                        Conta <?= $e($statusTexto) ?>

                                    </span>

                                </div>

                            </div>

                        </div>

                    </section>


                    <!-- =============================================
                         ÚLTIMO ACESSO
                    ============================================== -->

                    <section
                        class="card border-0
                        shadow-sm mb-4"
                    >

                        <div
                            class="card-header
                            bg-white py-3"
                        >

                            <h2
                                class="h5 fw-bold mb-0"
                            >

                                <i
                                    class="bi bi-clock
                                    text-primary me-2"
                                ></i>

                                Último Acesso

                            </h2>

                        </div>


                        <div class="card-body">

                            <strong class="d-block">

                                <?= $e($ultimoAcesso) ?>

                            </strong>


                            <small class="text-muted">

                                Informação registrada
                                no cadastro do cliente
                                após o login.

                            </small>

                        </div>

                    </section>


                    <!-- =============================================
                         VERIFICAÇÃO EM DUAS ETAPAS
                    ============================================== -->

                    <section
                        class="card border-0
                        shadow-sm mb-4"
                    >

                        <div
                            class="card-header
                            bg-white py-3"
                        >

                            <h2
                                class="h5 fw-bold mb-0"
                            >

                                <i
                                    class="bi bi-phone
                                    text-primary me-2"
                                ></i>

                                Verificação em Duas Etapas

                            </h2>

                        </div>


                        <div class="card-body">

                            <span
                                class="badge
                                text-bg-secondary mb-3"
                            >
                                Ainda não disponível
                            </span>


                            <p
                                class="text-muted
                                small mb-0"
                            >

                                O banco atual não possui
                                campos para configuração
                                de autenticação em duas etapas.

                            </p>

                        </div>

                    </section>


                    <!-- =============================================
                         DICAS
                    ============================================== -->

                    <section
                        class="card border-0 shadow-sm"
                    >

                        <div
                            class="card-header
                            bg-white py-3"
                        >

                            <h2
                                class="h5 fw-bold mb-0"
                            >

                                <i
                                    class="bi bi-lightbulb
                                    text-warning me-2"
                                ></i>

                                Dicas de Segurança

                            </h2>

                        </div>


                        <div class="card-body">

                            <ul
                                class="small
                                text-muted ps-3 mb-0"
                            >

                                <li class="mb-2">
                                    Nunca compartilhe sua senha.
                                </li>

                                <li class="mb-2">
                                    Não reutilize a mesma senha
                                    em vários sites.
                                </li>

                                <li class="mb-2">
                                    Evite salvar sua senha
                                    em computadores públicos.
                                </li>

                                <li class="mb-2">
                                    Desconfie de mensagens
                                    solicitando sua senha.
                                </li>

                                <li>
                                    Mantenha seus dados
                                    de contato atualizados.
                                </li>

                            </ul>

                        </div>

                    </section>

                </aside>

            </div>

        </div>

    </main>


    <!-- ============================================================
         FOOTER
    ============================================================= -->

    <footer
        class="bg-dark text-white mt-5"
    >

        <div class="container py-4">

            <div class="row align-items-center">

                <div
                    class="col-12 col-md-6
                    text-center text-md-start"
                >

                    <strong>
                        Loja Online
                    </strong>

                    <p
                        class="small
                        text-white-50 mb-0"
                    >

                        Sua loja online
                        com segurança
                        e praticidade.

                    </p>

                </div>


                <div
                    class="col-12 col-md-6
                    text-center text-md-end
                    mt-3 mt-md-0"
                >

                    <a
                        href=""
                        class="text-white
                        text-decoration-none me-3"
                    >
                        Loja
                    </a>


                    <a
                        href="produtos"
                        class="text-white
                        text-decoration-none me-3"
                    >
                        Produtos
                    </a>


                    <a
                        href="cliente/pedidos"
                        class="text-white
                        text-decoration-none"
                    >
                        Meus Pedidos
                    </a>

                </div>

            </div>


            <hr class="border-secondary">


            <div class="text-center">

                <small class="text-white-50">

                    &copy;
                    <?= date('Y') ?>
                    Loja Online.
                    Todos os direitos reservados.

                </small>

            </div>

        </div>

    </footer>


    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    ></script>


    <script>

        /*
        |--------------------------------------------------------------------------
        | Mostrar / ocultar senha
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll(
                '.btn-mostrar-senha'
            )
            .forEach(function (botao) {

                botao.addEventListener(
                    'click',
                    function () {

                        const campo =
                            document.getElementById(
                                this.dataset.target
                            );

                        const icone =
                            this.querySelector('i');


                        if (!campo) {
                            return;
                        }


                        const mostrar =
                            campo.type ===
                            'password';


                        campo.type =
                            mostrar
                                ? 'text'
                                : 'password';


                        icone.classList.toggle(
                            'bi-eye',
                            !mostrar
                        );


                        icone.classList.toggle(
                            'bi-eye-slash',
                            mostrar
                        );

                    }
                );

            });


        /*
        |--------------------------------------------------------------------------
        | Conferir confirmação da senha
        |--------------------------------------------------------------------------
        */

        const form =
            document.getElementById(
                'formAlterarSenha'
            );


        const novaSenha =
            document.getElementById(
                'novaSenha'
            );


        const confirmarSenha =
            document.getElementById(
                'confirmarSenha'
            );


        const mensagemSenhas =
            document.getElementById(
                'mensagemSenhas'
            );


        function conferirSenhas() {

            if (
                !novaSenha
                ||
                !confirmarSenha
            ) {
                return true;
            }


            if (
                confirmarSenha.value === ''
            ) {

                confirmarSenha
                    .classList
                    .remove(
                        'is-valid',
                        'is-invalid'
                    );


                mensagemSenhas.textContent =
                    '';


                return false;
            }


            const iguais =
                novaSenha.value ===
                confirmarSenha.value;


            confirmarSenha
                .classList
                .toggle(
                    'is-valid',
                    iguais
                );


            confirmarSenha
                .classList
                .toggle(
                    'is-invalid',
                    !iguais
                );


            mensagemSenhas.textContent =
                iguais
                    ? 'As senhas conferem.'
                    : 'As senhas não são iguais.';


            mensagemSenhas.className =
                iguais
                    ? 'form-text text-success'
                    : 'form-text text-danger';


            return iguais;
        }


        novaSenha?.addEventListener(
            'input',
            conferirSenhas
        );


        confirmarSenha?.addEventListener(
            'input',
            conferirSenhas
        );


        form?.addEventListener(
            'submit',
            function (event) {

                if (!conferirSenhas()) {

                    event.preventDefault();

                    confirmarSenha?.focus();

                }

            }
        );

    </script>

</body>

</html>
