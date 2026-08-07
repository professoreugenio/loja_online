<?php
declare(strict_types=1);
$tituloCategorias = $tituloCategorias ?? '***Categorias em destaque';
?>
<section class="secao-suave py-5" id="categorias">
            <div class="container py-3">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-4">
                    <div>
                        <span class="text-primary fw-semibold">Explore a loja</span>
                        <h2 class="display-6 fw-bold mb-0"><?= htmlspecialchars($tituloCategorias, ENT_QUOTES, 'UTF-8') ?></h2>
                    </div>

                    <a class="btn btn-outline-primary" href="categorias">Ver todas</a>
                </div>

                <div class="row g-4">
                    <div class="col-6 col-lg-3">
                        <a class="text-decoration-none text-dark" href="categoria/informatica">
                            <article class="categoria-card bg-white h-100 text-center p-4 rounded-4 shadow-sm">
                                <div class="categoria-icone" aria-hidden="true">💻</div>
                                <h3 class="h5 mt-3 mb-1">Informática</h3>
                                <p class="text-secondary small mb-0">Computadores e periféricos</p>
                            </article>
                        </a>
                    </div>

                    <div class="col-6 col-lg-3">
                        <a class="text-decoration-none text-dark" href="categoria/celulares">
                            <article class="categoria-card bg-white h-100 text-center p-4 rounded-4 shadow-sm">
                                <div class="categoria-icone" aria-hidden="true">📱</div>
                                <h3 class="h5 mt-3 mb-1">Celulares</h3>
                                <p class="text-secondary small mb-0">Aparelhos e conectividade</p>
                            </article>
                        </a>
                    </div>

                    <div class="col-6 col-lg-3">
                        <a class="text-decoration-none text-dark" href="categoria/acessorios">
                            <article class="categoria-card bg-white h-100 text-center p-4 rounded-4 shadow-sm">
                                <div class="categoria-icone" aria-hidden="true">🎧</div>
                                <h3 class="h5 mt-3 mb-1">Acessórios</h3>
                                <p class="text-secondary small mb-0">Fones, cabos e utilidades</p>
                            </article>
                        </a>
                    </div>

                    <div class="col-6 col-lg-3">
                        <a class="text-decoration-none text-dark" href="categoria/casa">
                            <article class="categoria-card bg-white h-100 text-center p-4 rounded-4 shadow-sm">
                                <div class="categoria-icone" aria-hidden="true">🏠</div>
                                <h3 class="h5 mt-3 mb-1">Casa</h3>
                                <p class="text-secondary small mb-0">Organização e decoração</p>
                            </article>
                        </a>
                    </div>
                </div>
            </div>
        </section>