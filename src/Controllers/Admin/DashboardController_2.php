<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

class DashboardController
{
    public function index(): void
    {
        $arquivoView = dirname(__DIR__, 3)
            . '/views/admin/dashboard.php';

        if (!is_file($arquivoView)) {
            throw new \RuntimeException(
                'O dashboard administrativo não foi encontrado.'
            );
        }

        require $arquivoView;
    }
}