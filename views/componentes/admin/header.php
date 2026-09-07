<?php

declare(strict_types=1);

use App\Helpers\SessaoAdmin;
use App\Helpers\Csrf;

$baseUrl =
    defined('BASE_URL')
    ? rtrim(
        (string) BASE_URL,
        '/'
    )
    : '';

$csrfLogout =
    Csrf::gerar();

$nomeAdmin =
    SessaoAdmin::nome()
    ?? 'Administrador';

$nivelAdmin =
    SessaoAdmin::nivel()
    ?? 'operador';

?>

<?php

$nomeAdmin =
    SessaoAdmin::nome()
    ?? 'Administrador';

$nivelAdmin =
    SessaoAdmin::nivel()
    ?? 'operador';

$partesNome = preg_split(
    '/\s+/',
    trim($nomeAdmin)
);

$iniciais = '';

if (!empty($partesNome)) {

    $iniciais .= mb_strtoupper(
        mb_substr(
            $partesNome[0],
            0,
            1
        )
    );

    if (count($partesNome) > 1) {

        $iniciais .= mb_strtoupper(
            mb_substr(
                $partesNome[1],
                0,
                1
            )
        );
    }
}

?>
<header class="topbar">
    <div class="container-fluid px-3 px-lg-4">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-outline-secondary d-lg-none" type="button"
                data-bs-toggle="offcanvas" data-bs-target="#menuMobile"
                aria-label="Abrir menu">
                <i class="bi bi-list fs-5"></i>
            </button>

            <form class="d-none d-md-block flex-grow-1" style="max-width:420px"
                action="admin/buscar" method="get" role="search">
                <label class="visually-hidden" for="buscaDashboard">Pesquisar no painel</label>
                <div class="input-group">
                    <span class="input-group-text bg-body border-end-0">
                        <i class="bi bi-search text-secondary"></i>
                    </span>
                    <input class="form-control border-start-0" id="buscaDashboard"
                        type="search" name="q"
                        placeholder="Pesquisar produtos, clientes ou pedidos">
                </div>
            </form>

            <div class="ms-auto d-flex align-items-center gap-2">
                <a class="btn btn-light position-relative" href="admin/notificacoes"
                    aria-label="Abrir notificações">
                    <i class="bi bi-bell"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill text-bg-danger">
                        5
                    </span>
                </a>

                <div class="dropdown">
                    <button
                        class="btn btn-light
           d-flex align-items-center gap-2"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">

                        <!-- Iniciais do administrador -->
                        <span class="avatar">

                            <?=
                            htmlspecialchars(
                                $iniciais,
                                ENT_QUOTES,
                                'UTF-8'
                            )
                            ?>

                        </span>


                        <!-- Nome e nível -->
                        <span
                            class="d-none
               d-sm-block
               text-start">

                            <strong class="d-block small">

                                <?=
                                htmlspecialchars(
                                    $nomeAdmin,
                                    ENT_QUOTES,
                                    'UTF-8'
                                )
                                ?>

                            </strong>

                            <small class="text-secondary">

                                <?= htmlspecialchars(
                                    ucfirst($nivelAdmin),
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </small>

                        </span>


                        <i class="bi bi-chevron-down small"></i>

                    </button>

                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                        <li>
                            <a class="dropdown-item" href="admin/perfil">
                                <i class="bi bi-person me-2"></i> Meu perfil
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="admin/configuracoes">
                                <i class="bi bi-gear me-2"></i> Configurações
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li class="px-2">
                            <form
                                action="<?=
                                        htmlspecialchars(
                                            $baseUrl
                                                . '/admin/sair',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        )
                                        ?>"
                                method="post">

                                <input
                                    type="hidden"
                                    name="_token"
                                    value="<?=
                                            htmlspecialchars(
                                                $csrfLogout,
                                                ENT_QUOTES,
                                                'UTF-8'
                                            )
                                            ?>">


                                <button
                                    class="dropdown-item text-danger"
                                    type="submit">

                                    <i
                                        class="bi bi-box-arrow-left me-2"></i>

                                    Sair

                                </button>

                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>