<?php
declare(strict_types=1);
$tituloNewsletter = $tituloNewsletter ?? '*Receba novidades da loja';
$textoNewsletter = $textoNewsletter  ?? '**Cadastre seu e-mail para receber informações sobre produtos e ofertas.';
?>
<section class="newsletter py-5 text-white">
            <div class="container py-3">
                <div class="row align-items-center g-4">
                    <div class="col-lg-6">
                        <h2 class="fw-bold"><?= htmlspecialchars($tituloNewsletter, ENT_QUOTES, 'UTF-8') ?></h2>
                        <p class="mb-0 text-white-50">
                            <?= htmlspecialchars($textoNewsletter, ENT_QUOTES, 'UTF-8') ?>
                        </p>
                    </div>

                    <div class="col-lg-6">
                        <form class="row g-2" action="newsletter/cadastrar" method="post">
                            <div class="col-sm-8">
                                <label class="visually-hidden" for="newsletterEmail">Seu e-mail</label>
                                <input
                                    class="form-control form-control-lg"
                                    id="newsletterEmail"
                                    name="email"
                                    type="email"
                                    placeholder="nome@exemplo.com"
                                    required
                                >
                            </div>

                            <div class="col-sm-4 d-grid">
                                <button class="btn btn-light btn-lg text-primary fw-semibold" type="submit">
                                    Cadastrar
                                </button>
                            </div>
                        </form>

                        <p class="small text-white-50 mt-2 mb-0">
                            Ao cadastrar o e-mail, consulte nossa
                            <a class="text-white" href="politica-de-privacidade">Política de Privacidade</a>.
                        </p>
                    </div>
                </div>
            </div>
        </section>