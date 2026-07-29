<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

$raizProjeto = dirname(__DIR__);

/*
|--------------------------------------------------------------------------
| Carregamento dos arquivos de rotas
|--------------------------------------------------------------------------
*/

$rotas = array_merge(
    require $raizProjeto . '/routes/web.php',
    require $raizProjeto . '/routes/cliente.php',
    require $raizProjeto . '/routes/admin.php',
    require $raizProjeto . '/routes/logadm.php'
);

/*
|--------------------------------------------------------------------------
| Identificação da requisição
|--------------------------------------------------------------------------
*/

$metodoHttp = $_SERVER['REQUEST_METHOD'] ?? 'GET';

$caminho = parse_url(
    $_SERVER['REQUEST_URI'] ?? '/',
    PHP_URL_PATH
);

$caminho = $caminho ?: '/';

/*
|--------------------------------------------------------------------------
| Remoção do caminho-base no XAMPP
|--------------------------------------------------------------------------
*/

$caminhoBase = str_replace(
    '\\',
    '/',
    dirname($_SERVER['SCRIPT_NAME'] ?? '')
);

$caminhoBase = rtrim($caminhoBase, '/');

if (str_starts_with($caminho, $caminhoBase)) {
    $caminho = substr($caminho, strlen($caminhoBase));
}

$caminho = '/' . trim($caminho, '/');

if ($caminho === '/') {
    $caminho = '/';
}

/*
|--------------------------------------------------------------------------
| Localização da rota
|--------------------------------------------------------------------------
*/

foreach ($rotas as $rota) {
    $mesmoMetodo = $rota['method'] === $metodoHttp;
    $mesmoCaminho = $rota['path'] === $caminho;

    if (!$mesmoMetodo || !$mesmoCaminho) {
        continue;
    }

    [$controller, $acao] = $rota['action'];

    if (!class_exists($controller)) {
        throw new RuntimeException(
            "Controller não encontrado: {$controller}"
        );
    }

    $objetoController = new $controller();

    if (!method_exists($objetoController, $acao)) {
        throw new RuntimeException(
            "Método não encontrado: {$controller}::{$acao}"
        );
    }

    $objetoController->{$acao}();

    exit;
}

/*
|--------------------------------------------------------------------------
| Página não encontrada
|--------------------------------------------------------------------------
*/

http_response_code(404);

require $raizProjeto . '/views/erros/404.php';