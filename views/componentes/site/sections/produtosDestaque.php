<?php
declare(strict_types=1);
$tituloDestaque = $tituloDestaque ?? '*Escolhas populares';
$textoDestaque = $textoDestaque  ?? '**Produtos em destaque para você';
?>
<section class="py-5" id="produtos-destaque">
            <div class="container py-3">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-4">
                    <div>
                        <span class="text-primary fw-semibold"><?= htmlspecialchars($tituloDestaque, ENT_QUOTES, 'UTF-8') ?></span>
                        <h2 class="display-6 fw-bold mb-0"><?= htmlspecialchars($textoDestaque, ENT_QUOTES, 'UTF-8') ?></h2>
                    </div>

                    <a class="btn btn-outline-primary" href="produtos">Ver catálogo</a>
                </div>

                <div class="row g-4">
                    <div class="col-md-6 col-xl-3">
                        <article class="produto-card card h-100 border-0 shadow-sm overflow-hidden">
                            <div class="produto-imagem" aria-hidden="true">💻</div>
                            <div class="card-body d-flex flex-column">
                                <span class="badge text-bg-danger align-self-start mb-2">Oferta</span>
                                <h3 class="h5 card-title">Notebook Essencial 15</h3>
                                <p class="card-text text-secondary small">
                                    Desempenho para estudos, trabalho e navegação.
                                </p>
                                <div class="mt-auto">
                                    <div class="preco-anterior">R$ 3.299,00</div>
                                    <div class="preco-atual">R$ 2.899,00</div>
                                    <a class="btn btn-primary w-100 mt-3" href="produto/notebook-essencial-15">
                                        Ver produto
                                    </a>
                                </div>
                            </div>
                        </article>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <article class="produto-card card h-100 border-0 shadow-sm overflow-hidden">
                            <div class="produto-imagem" aria-hidden="true">📱</div>
                            <div class="card-body d-flex flex-column">
                                <span class="badge text-bg-success align-self-start mb-2">Novidade</span>
                                <h3 class="h5 card-title">Smartphone Connect</h3>
                                <p class="card-text text-secondary small">
                                    Tela ampla, boa autonomia e câmera versátil.
                                </p>
                                <div class="mt-auto">
                                    <div class="preco-anterior">R$ 1.899,00</div>
                                    <div class="preco-atual">R$ 1.699,00</div>
                                    <a class="btn btn-primary w-100 mt-3" href="produto/smartphone-connect">
                                        Ver produto
                                    </a>
                                </div>
                            </div>
                        </article>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <article class="produto-card card h-100 border-0 shadow-sm overflow-hidden">
                            <div class="produto-imagem" aria-hidden="true">🎧</div>
                            <div class="card-body d-flex flex-column">
                                <span class="badge text-bg-primary align-self-start mb-2">Destaque</span>
                                <h3 class="h5 card-title">Fone Bluetooth Air</h3>
                                <p class="card-text text-secondary small">
                                    Som equilibrado e conexão sem fio para o cotidiano.
                                </p>
                                <div class="mt-auto">
                                    <div class="preco-anterior">R$ 249,90</div>
                                    <div class="preco-atual">R$ 199,90</div>
                                    <a class="btn btn-primary w-100 mt-3" href="produto/fone-bluetooth-air">
                                        Ver produto
                                    </a>
                                </div>
                            </div>
                        </article>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <article class="produto-card card h-100 border-0 shadow-sm overflow-hidden">
                            <div class="produto-imagem" aria-hidden="true">⌨️</div>
                            <div class="card-body d-flex flex-column">
                                <span class="badge text-bg-secondary align-self-start mb-2">Mais vendido</span>
                                <h3 class="h5 card-title">Teclado Confort Plus</h3>
                                <p class="card-text text-secondary small">
                                    Digitação confortável para estudo e produtividade.
                                </p>
                                <div class="mt-auto">
                                    <div class="preco-anterior">R$ 189,90</div>
                                    <div class="preco-atual">R$ 149,90</div>
                                    <a class="btn btn-primary w-100 mt-3" href="produto/teclado-confort-plus">
                                        Ver produto
                                    </a>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </section>