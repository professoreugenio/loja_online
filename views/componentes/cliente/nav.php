<?php

declare(strict_types=1);

use App\Helpers\CsrfCliente;

$csrfToken =
    CsrfCliente::gerar();

?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">

    <div class="container">

        <!-- LOGO / MINHA CONTA -->

        <a
            class="navbar-brand fw-bold"
            href="<?= BASE_URL ?>/cliente">
            <i class="bi bi-person-circle me-2"></i>

            Minha Conta
        </a>


        <!-- BOTÃO MOBILE -->

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#menuCliente"
            aria-controls="menuCliente"
            aria-expanded="false"
            aria-label="Abrir menu">
            <span class="navbar-toggler-icon"></span>
        </button>


        <!-- MENU -->

        <div
            class="collapse navbar-collapse"
            id="menuCliente">

            <ul class="navbar-nav ms-auto align-items-lg-center">


                <!-- PAINEL -->

                <li class="nav-item">

                    <a
                        class="nav-link"
                        href="<?= BASE_URL ?>/cliente">
                        <i class="bi bi-speedometer2 me-1"></i>

                        Painel
                    </a>

                </li>
                <li class="nav-item">

                    <a
                        class="nav-link"
                        href="<?= BASE_URL ?>/">
                        <i class="bi bi-speedometer2 me-1"></i>

                        Site
                    </a>

                </li>
                <li class="nav-item">

                    <a
                        class="nav-link"
                        href="<?= BASE_URL ?>/carrinho">
                        
                        <i class="bi bi-cart3 me-1"></i>

                        
                    </a>

                </li>


                <!-- PERFIL -->

                <li class="nav-item">

                    <a
                        class="nav-link"
                        href="<?= BASE_URL ?>/cliente/perfil">
                        <i class="bi bi-person me-1"></i>

                        Perfil
                    </a>

                </li>


                <!-- PEDIDOS -->

                <li class="nav-item">

                    <a
                        class="nav-link"
                        href="<?= BASE_URL ?>/cliente/pedidos">
                        <i class="bi bi-bag-check me-1"></i>

                        Pedidos
                    </a>

                </li>


                <!-- ENDEREÇOS -->

                <li class="nav-item">

                    <a
                        class="nav-link"
                        href="<?= BASE_URL ?>/cliente/enderecos">
                        <i class="bi bi-geo-alt me-1"></i>

                        Endereços
                    </a>

                </li>


                <!-- SEGURANÇA -->

                <li class="nav-item">

                    <a
                        class="nav-link"
                        href="<?= BASE_URL ?>/cliente/seguranca">
                        <i class="bi bi-shield-lock me-1"></i>

                        Segurança
                    </a>

                </li>


                <!-- SAIR -->

                <li class="nav-item ms-lg-3">

                    <form
                        action="<?= BASE_URL ?>/cliente/sair"
                        method="POST"
                        class="d-inline">

                        <input
                            type="hidden"
                            name="csrf_token"
                            value="<?=
                                    htmlspecialchars(
                                        $csrfToken,
                                        ENT_QUOTES,
                                        'UTF-8'
                                    )
                                    ?>">

                        <button
                            type="submit"
                            class="btn btn-outline-light btn-sm">
                            <i class="bi bi-box-arrow-right me-1"></i>

                            Sair
                        </button>

                    </form>

                </li>


            </ul>

        </div>

    </div>

</nav>