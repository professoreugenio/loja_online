<?php
declare(strict_types=1);
$tituloChamada = $tituloChamada ?? '*Oferta por tempo limitado';
$tituloChamada2 = $tituloChamada2 ?? '**Economize em produtos selecionados';
$textoChamada = $textoChamada  ?? '***Confira as condições disponíveis e encontre o produto adequado para sua necessidade..';
?>
<section class="secao-suave py-5">
            <div class="container">
                <div class="row align-items-center g-4 bg-white rounded-4 shadow-sm p-4 p-lg-5">
                    <div class="col-lg-8">
                        <span class="text-primary fw-semibold"><?= htmlspecialchars($tituloChamada, ENT_QUOTES, 'UTF-8') ?></span>
                        <h2 class="display-6 fw-bold mt-2"><?= htmlspecialchars($tituloChamada2, ENT_QUOTES, 'UTF-8') ?></h2>
                        <p class="lead text-secondary mb-0">
                            <?= htmlspecialchars($textoChamada, ENT_QUOTES, 'UTF-8') ?>
                        </p>
                    </div>

                    <div class="col-lg-4 text-lg-end">
                        <a class="btn btn-primary btn-lg" href="ofertas">Acessar ofertas</a>
                    </div>
                </div>
            </div>
        </section>