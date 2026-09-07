<?php

declare(strict_types=1);

use App\Repositories\ConfiguracoesRepository;
require_once dirname(__DIR__) . '/vendor/autoload.php';


$raizProjeto = dirname(__DIR__);
define(
    'APP_ROOT',
    $raizProjeto
);
/*
|--------------------------------------------------------------------------
| Identificação automática da URL base
|--------------------------------------------------------------------------
|
| LOCAL:
|
| C:/xampp/htdocs/loja_online
|
| Resultado:
|
| /loja_online
|
|--------------------------------------------------------------------------
|
| PRODUÇÃO:
|
| Se o projeto estiver diretamente na raiz do domínio:
|
| https://professor.sysalunos.com/
|
| Resultado:
|
| BASE_URL = ''
|
*/
$documentRoot = $_SERVER['DOCUMENT_ROOT'] ?? '';
$documentRootReal = realpath(
    $documentRoot
);
$projetoReal = realpath(
    $raizProjeto
);
$documentRootReal = str_replace(
    '\\',
    '/',
    $documentRootReal ?: $documentRoot
);
$projetoReal = str_replace(
    '\\',
    '/',
    $projetoReal ?: $raizProjeto
);
$documentRootReal = rtrim(
    $documentRootReal,
    '/'
);
$caminhoBase = '';
/*
|--------------------------------------------------------------------------
| Projeto diretamente no DocumentRoot
|--------------------------------------------------------------------------
*/
if (
    $projetoReal === $documentRootReal
) {
    $caminhoBase = '';
}
/*
|--------------------------------------------------------------------------
| Projeto dentro de uma pasta
|--------------------------------------------------------------------------
|
| Exemplo:
|
| DOCUMENT_ROOT
| C:/xampp/htdocs
|
| PROJETO
| C:/xampp/htdocs/loja_online
|
| Resultado:
| /loja_online
|
*/ elseif (
    $documentRootReal !== ''
    && str_starts_with(
        $projetoReal,
        $documentRootReal . '/'
    )
) {
    $relativo = substr(
        $projetoReal,
        strlen($documentRootReal)
    );
    $caminhoBase = '/'
        . trim(
            $relativo,
            '/'
        );
}
define(
    'BASE_URL',
    $caminhoBase
);
/*
|--------------------------------------------------------------------------
| Configuração da sessão
|--------------------------------------------------------------------------
*/
ini_set('session.use_strict_mode', '1');
ini_set('session.use_only_cookies', '1');
$usaHttps = !empty($_SERVER['HTTPS'])
    && $_SERVER['HTTPS'] !== 'off';
session_name('LOJAONLINESESSID');
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => $usaHttps,
    'httponly' => true,
    'samesite' => 'Lax',
]);
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
/*
|--------------------------------------------------------------------------
| Carregamento dos arquivos de rotas
|--------------------------------------------------------------------------
*/
$rotas = array_merge(
    require $raizProjeto . '/routes/site.php',
    require $raizProjeto . '/routes/logadm.php',
    require $raizProjeto . '/routes/admin.php',
    require $raizProjeto . '/routes/produtos.php',
    require $raizProjeto . '/routes/categorias.php',
    require $raizProjeto . '/routes/ofertas.php',
    require $raizProjeto . '/routes/ajuda_central.php',
    require $raizProjeto . '/routes/ajuda_perguntas.php',
    require $raizProjeto . '/routes/ajuda_rastreio.php',
    require $raizProjeto . '/routes/ajuda_trocas.php',
    require $raizProjeto . '/routes/ajuda_contato.php',
    require $raizProjeto . '/routes/busca.php',
    require $raizProjeto . '/routes/cliente_login.php',
    require $raizProjeto . '/routes/cliente_cadastro.php',
    require $raizProjeto . '/routes/cliente.php',
    require $raizProjeto . '/routes/carrinho.php',
);
/*
|--------------------------------------------------------------------------
| Identificação da requisição
|--------------------------------------------------------------------------
*/
$metodoHttp = strtoupper(
    $_SERVER['REQUEST_METHOD'] ?? 'GET'
);
$caminho = parse_url(
    $_SERVER['REQUEST_URI'] ?? '/',
    PHP_URL_PATH
);
$caminho = is_string($caminho) && $caminho !== ''
    ? $caminho
    : '/';
/*
|--------------------------------------------------------------------------
| Remoção do caminho-base no XAMPP
|--------------------------------------------------------------------------
*/
$estaNoCaminhoBase =
    $caminhoBase !== ''
    && (
        $caminho === $caminhoBase
        || str_starts_with(
            $caminho,
            $caminhoBase . '/'
        )
    );
if ($estaNoCaminhoBase) {
    $caminho = substr(
        $caminho,
        strlen($caminhoBase)
    );
}
$caminho = '/' . trim($caminho, '/');


/*
|--------------------------------------------------------------------------
| Verificação do modo Standby
|--------------------------------------------------------------------------
|
| Quando configuracoes.sitestandby = 1:
|
| - as páginas públicas exibem standby.html;
| - /admin continua acessível;
| - /loginadmin continua acessível.
|
*/


/*
|--------------------------------------------------------------------------
| 1. Identifica a área administrativa
|--------------------------------------------------------------------------
*/
$ehAreaAdmin =
    $caminho === '/admin'
    || str_starts_with(
        $caminho,
        '/admin/'
    );


/*
|--------------------------------------------------------------------------
| 2. Identifica o login administrativo
|--------------------------------------------------------------------------
*/
$ehLoginAdmin =
    $caminho === '/loginadmin';


/*
|--------------------------------------------------------------------------
| 3. Verifica Standby somente nas páginas públicas
|--------------------------------------------------------------------------
*/
if (
    !$ehAreaAdmin
    && !$ehLoginAdmin
) {

    /*
    |--------------------------------------------------------------------------
    | Carrega a conexão
    |--------------------------------------------------------------------------
    */
    require_once
        $raizProjeto
        . '/database/conexao.php';


    /*
    |--------------------------------------------------------------------------
    | Repository das configurações
    |--------------------------------------------------------------------------
    */
    $configRepository =
        new ConfiguracoesRepository(
            \Config::connect()
        );


    /*
    |--------------------------------------------------------------------------
    | Busca as configurações do site
    |--------------------------------------------------------------------------
    */
    $configSite =
        $configRepository->buscar();


    /*
    |--------------------------------------------------------------------------
    | Verifica se o Standby está ativo
    |--------------------------------------------------------------------------
    */
    $standbyAtivo =
        (int) (
            $configSite['sitestandby']
            ?? 0
        ) === 1;


    /*
    |--------------------------------------------------------------------------
    | Site em Standby
    |--------------------------------------------------------------------------
    */
    if ($standbyAtivo) {

        /*
        |--------------------------------------------------------------------------
        | Indisponibilidade temporária
        |--------------------------------------------------------------------------
        */
        http_response_code(503);

        header(
            'Retry-After: 3600'
        );


        /*
        |--------------------------------------------------------------------------
        | Página Standby
        |--------------------------------------------------------------------------
        */
        $paginaStandby =
            $raizProjeto
            . '/standby.html';


        /*
        |--------------------------------------------------------------------------
        | Confere se o arquivo existe
        |--------------------------------------------------------------------------
        */
        if (!is_file($paginaStandby)) {

            throw new RuntimeException(
                'O arquivo standby.html '
                    . 'não foi encontrado.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Exibe Standby e interrompe a aplicação
        |--------------------------------------------------------------------------
        */
        require $paginaStandby;

        exit;
    }
}



/*
|--------------------------------------------------------------------------
| Localização da rota
|--------------------------------------------------------------------------
*/
foreach ($rotas as $rota) {
    $mesmoMetodo =
        ($rota['method'] ?? '') === $metodoHttp;
    $mesmoCaminho =
        ($rota['path'] ?? '') === $caminho;
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
