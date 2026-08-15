<?php

declare(strict_types=1);
require_once __DIR__
    . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

$mail = new PHPMailer(true);
echo 'PHPMailer carregado com sucesso.';
