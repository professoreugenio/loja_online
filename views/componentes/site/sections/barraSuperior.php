<?php
declare(strict_types=1);
$tituloBarraSuperior = $tituloBarraSuperior ?? 'Frete grátis em compras selecionadas';
$textoBarraSuperior = $textoBarraSuperior  ?? 'Atendimento: segunda a sexta, das 8h às 18h';
?>
<div class="barra-superior py-2">
        <div class="container d-flex flex-column flex-md-row justify-content-between gap-1">
            <span>🚚 <?= htmlspecialchars($tituloBarraSuperior, ENT_QUOTES,'UTF-8'  );  ?> </span>
            <span><?= htmlspecialchars($textoBarraSuperior, ENT_QUOTES,'UTF-8'  );  ?></span>
        </div>
    </div>