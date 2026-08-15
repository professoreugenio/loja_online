<?php

declare(strict_types=1);

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;

final class EmailService
{
    public function criarMailer(): PHPMailer
    {
        return new PHPMailer(true);
    }
}
