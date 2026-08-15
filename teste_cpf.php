<?php

declare(strict_types=1);

require_once __DIR__
    . '/vendor/autoload.php';

use App\Helpers\Cpf;
$cpfInformado =
    '000.000.000-00';

$cpfSomenteNumeros =
    Cpf::somenteNumeros(
        $cpfInformado
    );

if (
    !Cpf::validar(
        $cpfInformado
    )
) {
    echo 'CPF inválido';
} else {

    echo 'CPF válido';
}

?>