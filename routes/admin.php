<?php

declare(strict_types=1);

use App\Controllers\Admin\DashboardController;
// use App\Controllers\Admin\ProdutosController;
// use App\Controllers\Admin\CategoriasController;
// use App\Controllers\Admin\ClientesController;
// use App\Controllers\Admin\PedidosController;
// use App\Controllers\Admin\PagamentosController;
// use App\Controllers\Admin\CarrinhosController;
// use App\Controllers\Admin\EstoqueController;
// use App\Controllers\Admin\NotificacoesController;
// use App\Controllers\Admin\ContatosController;
// use App\Controllers\Admin\RelatoriosController;

return [

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */
    [
        'method' => 'GET',
        'path' => '/admin',
        'action' => [
            DashboardController::class,
            'index',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Produtos
    |--------------------------------------------------------------------------
    */
    [
        'method' => 'GET',
        'path' => '/admin/produtos',
        'action' => [
            ProdutosController::class,
            'index',
        ],
    ],

    

];