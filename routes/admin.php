<?php

declare(strict_types=1);

use App\Controllers\Admin\AdminController;
use App\Controllers\Admin\ModuloAdminController;

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
            AdminController::class,
            'index',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Relatórios
    |--------------------------------------------------------------------------
    */
    [
        'method' => 'GET',
        'path' => '/admin/relatorios',
        'action' => [
            ModuloAdminController::class,
            'relatorios',
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
            ModuloAdminController::class,
            'produtos',
        ],
    ],
    [
        'method' => 'GET',
        'path' => '/admin/produto/novo',
        'action' => [
            ModuloAdminController::class,
            'produtoNovo',
        ],
    ],
    [
        'method' => 'GET',
        'path' => '/admin/produto/editar',
        'action' => [
            ModuloAdminController::class,
            'produtoEditar',
        ],
    ],

    [
        'method' => 'POST',
        'path' => '/admin/produto/atualizar',
        'action' => [
            ModuloAdminController::class,
            'produtoAtualizar',
        ],
    ],
    
    [
        'method' => 'GET',
        'path' => '/admin/produto/imagens',
        'action' => [
            ModuloAdminController::class,
            'produtoImagens',
        ],
    ],
    [
        'method' => 'POST',
        'path' => '/admin/produto/imagens/upload',
        'action' => [
            ModuloAdminController::class,
            'produtoImagensUpload',
        ],
    ],
    [
        'method' => 'POST',
        'path' => '/admin/produto/imagens/principal',
        'action' => [
            ModuloAdminController::class,
            'produtoImagemPrincipal',
        ],
    ],
    [
        'method' => 'POST',
        'path' => '/admin/produto/imagens/excluir',
        'action' => [
            ModuloAdminController::class,
            'produtoImagemExcluir',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Categorias
    |--------------------------------------------------------------------------
    */
    [
        'method' => 'GET',
        'path' => '/admin/categorias',
        'action' => [
            ModuloAdminController::class,
            'categorias',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Clientes
    |--------------------------------------------------------------------------
    */
    [
        'method' => 'GET',
        'path' => '/admin/clientes',
        'action' => [
            ModuloAdminController::class,
            'clientes',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Pedidos
    |--------------------------------------------------------------------------
    */
    [
        'method' => 'GET',
        'path' => '/admin/pedidos',
        'action' => [
            ModuloAdminController::class,
            'pedidos',
        ],
    ],
    [
        'method' => 'GET',
        'path' => '/admin/pedidos/detalhes',
        'action' => [
            ModuloAdminController::class,
            'pedidoDetalhes',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Pagamentos
    |--------------------------------------------------------------------------
    */
    [
        'method' => 'GET',
        'path' => '/admin/pagamentos',
        'action' => [
            ModuloAdminController::class,
            'pagamentos',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Carrinhos
    |--------------------------------------------------------------------------
    */
    [
        'method' => 'GET',
        'path' => '/admin/carrinhos',
        'action' => [
            ModuloAdminController::class,
            'carrinhos',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Estoque
    |--------------------------------------------------------------------------
    */
    [
        'method' => 'GET',
        'path' => '/admin/estoque',
        'action' => [
            ModuloAdminController::class,
            'estoque',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Notificações
    |--------------------------------------------------------------------------
    */
    [
        'method' => 'GET',
        'path' => '/admin/notificacoes',
        'action' => [
            ModuloAdminController::class,
            'notificacoes',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Contatos
    |--------------------------------------------------------------------------
    */
    [
        'method' => 'GET',
        'path' => '/admin/contatos',
        'action' => [
            ModuloAdminController::class,
            'contatos',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Configurações
    |--------------------------------------------------------------------------
    */
    [
        'method' => 'GET',
        'path' => '/admin/configuracoes',
        'action' => [
            ModuloAdminController::class,
            'configuracoes',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Perfil administrativo
    |--------------------------------------------------------------------------
    */
    [
        'method' => 'GET',
        'path' => '/admin/perfil',
        'action' => [
            ModuloAdminController::class,
            'perfil',
        ],
    ],
       [
        'method' => 'GET',
        'path' => '/admin/perfil/novo',
        'action' => [
            ModuloAdminController::class,
            'perfilNovo',
        ],
    ],
    [
        'method' => 'GET',
        'path' => '/admin/perfil/lista',
        'action' => [
            ModuloAdminController::class,
            'perfilLista',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Busca do painel
    |--------------------------------------------------------------------------
    */
    [
        'method' => 'GET',
        'path' => '/admin/buscar',
        'action' => [
            ModuloAdminController::class,
            'buscar',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */
    [
        'method' => 'POST',
        'path' => '/admin/sair',
        'action' => [
            ModuloAdminController::class,
            'sair',
        ],
    ],

    [
        'method' => 'POST',
        'path' => '/admin/cliente/inativar',
        'action' => [
            ModuloAdminController::class,
            'clienteInativar',
        ],
    ],
    [
        'method' => 'GET',
        'path' => '/admin/cliente/view',
        'action' => [
            ModuloAdminController::class,
            'clienteView',
        ],
    ],
    [
        'method' => 'GET',
        'path' => '/admin/cliente/carrinho',
        'action' => [
            ModuloAdminController::class,
            'clienteCarrinho',
        ],
    ],
    [
    'method' => 'POST',
    'path' => '/admin/cliente/ativar',
    'action' => [
        ModuloAdminController::class,
        'clienteAtivar',
    ],
],
];