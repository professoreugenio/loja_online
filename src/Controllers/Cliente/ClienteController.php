<?php
declare(strict_types=1);
namespace App\Controllers\Cliente;
use App\Helpers\ClienteAuth;
use App\Helpers\IdSeguro;
use App\Repositories\ClienteRepository;
use App\Repositories\EnderecoRepository;
use App\Repositories\PedidoRepository;
use App\Helpers\Cpf;
use App\Helpers\CsrfCliente;
final class ClienteController
{
    public function painel(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Proteção
        |--------------------------------------------------------------------------
        */
        ClienteAuth::exigirLogin();
        /*
        |--------------------------------------------------------------------------
        | Banco
        |--------------------------------------------------------------------------
        */
        require_once APP_ROOT
            . '/database/conexao.php';
        $pdo =
            \Config::connect();
        /*
        |--------------------------------------------------------------------------
        | Repository
        |--------------------------------------------------------------------------
        */
        $clienteRepository =
            new ClienteRepository(
                $pdo
            );
        /*
        |--------------------------------------------------------------------------
        | Cliente autenticado
        |--------------------------------------------------------------------------
        */
        $clienteId =
            ClienteAuth::id();
        $cliente =
            $clienteRepository
            ->buscarPorId(
                (int)
                $clienteId
            );
        if ($cliente === null) {
            ClienteAuth::sair();
            header(
                'Location: '
                    . BASE_URL
                    . '/cliente/login'
            );
            exit;
        }
        /*
        |--------------------------------------------------------------------------
        | View
        |--------------------------------------------------------------------------
        */
        $clienteRepository =
            new ClienteRepository(
                $pdo
            );
        $pedidoRepository =
            new PedidoRepository(
                $pdo
            );
        $enderecoRepository =
            new EnderecoRepository(
                $pdo
            );
        $clienteId =
            ClienteAuth::id();
        if ($clienteId === null) {
            ClienteAuth::exigirLogin();
            return;
        }
        $cliente =
            $clienteRepository
            ->buscarPorId(
                $clienteId
            );
        if ($cliente === null) {
            ClienteAuth::sair();
            header(
                'Location: '
                    . BASE_URL
                    . '/cliente/login'
            );
            exit;
        }
        $resumoPedidos =
            $pedidoRepository
            ->resumoPainel(
                $clienteId
            );
        $totalPedidos =
            $resumoPedidos['total_pedidos'];
        $pedidosEmAndamento =
            $resumoPedidos['em_andamento'];
        $pedidosEntregues =
            $resumoPedidos['entregues'];
        $ultimosPedidos =
            $pedidoRepository
            ->listarUltimosDoCliente(
                $clienteId,
                3
            );
        foreach (
            $ultimosPedidos
            as &$pedido
        ) {
            $pedido['id_seguro'] =
                IdSeguro::criptografar(
                    (int)
                    $pedido['id']
                );
        }
        unset($pedido);
        $quantidadeEnderecos =
            $enderecoRepository
            ->contarPorCliente(
                $clienteId
            );
        $enderecoPrincipal =
            $enderecoRepository
            ->buscarPrincipalPorCliente(
                $clienteId
            );
        $nomeCompleto =
            trim(
                (string)
                $cliente['nome']
            );
        $primeiroNome =
            $nomeCompleto;
        $partesNome =
            preg_split(
                '/\s+/',
                $nomeCompleto
            );
        if (
            is_array($partesNome)
            &&
            isset($partesNome[0])
        ) {
            $primeiroNome =
                $partesNome[0];
        }
        $arquivoView =
            APP_ROOT
            . '/views/cliente/painel.php';
        if (!is_file($arquivoView)) {
            throw new \RuntimeException(
                'A página do painel do cliente não foi encontrada: '
                    . $arquivoView
            );
        }
        require $arquivoView;
    }
    public function perfil(): void
{
    /*
    |--------------------------------------------------------------------------
    | Proteção
    |--------------------------------------------------------------------------
    */
    ClienteAuth::exigirLogin();
    /*
    |--------------------------------------------------------------------------
    | Banco
    |--------------------------------------------------------------------------
    */
    require_once APP_ROOT
        . '/database/conexao.php';
    $pdo =
        \Config::connect();
    /*
    |--------------------------------------------------------------------------
    | Repository
    |--------------------------------------------------------------------------
    */
    $clienteRepository =
        new ClienteRepository(
            $pdo
        );
    /*
    |--------------------------------------------------------------------------
    | Cliente autenticado
    |--------------------------------------------------------------------------
    */
    $clienteId =
        ClienteAuth::id();
    if ($clienteId === null) {
        ClienteAuth::exigirLogin();
        return;
    }
    /*
    |--------------------------------------------------------------------------
    | Dados do cliente
    |--------------------------------------------------------------------------
    */
    $cliente =
        $clienteRepository
            ->buscarPorId(
                $clienteId
            );
    if ($cliente === null) {
        ClienteAuth::sair();
        header(
            'Location: '
            . BASE_URL
            . '/cliente/login'
        );
        exit;
    }
    /*
    |--------------------------------------------------------------------------
    | Mensagem
    |--------------------------------------------------------------------------
    */
    $mensagemSucesso =
        $_SESSION[
            'perfil_sucesso'
        ]
        ?? null;
    unset(
        $_SESSION[
            'perfil_sucesso'
        ]
    );
    /*
    |--------------------------------------------------------------------------
    | View
    |--------------------------------------------------------------------------
    */
    $arquivoView =
        APP_ROOT
        . '/views/cliente/perfil.php';
    if (!is_file($arquivoView)) {
        throw new \RuntimeException(
            'A página de perfil '
            . 'não foi encontrada.'
        );
    }
    require $arquivoView;
}
public function editarPerfil(): void
{
    /*
    |--------------------------------------------------------------------------
    | Proteção
    |--------------------------------------------------------------------------
    */
    ClienteAuth::exigirLogin();
    /*
    |--------------------------------------------------------------------------
    | Banco
    |--------------------------------------------------------------------------
    */
    require_once APP_ROOT
        . '/database/conexao.php';
    $pdo =
        \Config::connect();
    $clienteRepository =
        new ClienteRepository(
            $pdo
        );
    /*
    |--------------------------------------------------------------------------
    | Cliente
    |--------------------------------------------------------------------------
    */
    $clienteId =
        ClienteAuth::id();
    if ($clienteId === null) {
        ClienteAuth::exigirLogin();
        return;
    }
    $cliente =
        $clienteRepository
            ->buscarPorId(
                $clienteId
            );
    if ($cliente === null) {
        ClienteAuth::sair();
        header(
            'Location: '
            . BASE_URL
            . '/cliente/login'
        );
        exit;
    }
    /*
    |--------------------------------------------------------------------------
    | Dados antigos depois de erro
    |--------------------------------------------------------------------------
    */
    $dadosFormulario =
        $_SESSION[
            'perfil_dados'
        ]
        ?? [
            'nome' =>
                $cliente['nome'],
            'data_nascimento' =>
                $cliente[
                    'data_nascimento'
                ],
            'telefone' =>
                $cliente['telefone'],
            'email' =>
                $cliente['email'],
            'newsletter' =>
                $cliente['newsletter'],
        ];
    $erros =
        $_SESSION[
            'perfil_erros'
        ]
        ?? [];
    unset(
        $_SESSION[
            'perfil_dados'
        ],
        $_SESSION[
            'perfil_erros'
        ]
    );
    /*
    |--------------------------------------------------------------------------
    | CSRF
    |--------------------------------------------------------------------------
    */
    $csrfToken =
        CsrfCliente::gerar();
    /*
    |--------------------------------------------------------------------------
    | View
    |--------------------------------------------------------------------------
    */
    $arquivoView =
        APP_ROOT
        . '/views/cliente/'
        . 'perfil_editar.php';
    if (!is_file($arquivoView)) {
        throw new \RuntimeException(
            'A página de edição '
            . 'do perfil não foi encontrada.'
        );
    }
    require $arquivoView;
}
public function atualizarPerfil(): void
{
    /*
    |--------------------------------------------------------------------------
    | Proteção
    |--------------------------------------------------------------------------
    */
    ClienteAuth::exigirLogin();
    /*
    |--------------------------------------------------------------------------
    | Cliente autenticado
    |--------------------------------------------------------------------------
    */
    $clienteId =
        ClienteAuth::id();
    if ($clienteId === null) {
        ClienteAuth::exigirLogin();
        return;
    }
    /*
    |--------------------------------------------------------------------------
    | Token CSRF
    |--------------------------------------------------------------------------
    */
    $token =
        isset($_POST['csrf_token'])
            ? (string) $_POST['csrf_token']
            : null;
    if (
        !CsrfCliente::validar(
            $token
        )
    ) {
        $_SESSION['perfil_erros'] = [
            'O formulário expirou. '
            . 'Atualize a página e tente novamente.',
        ];
        header(
            'Location: '
            . BASE_URL
            . '/cliente/perfil/editar'
        );
        exit;
    }
    /*
    |--------------------------------------------------------------------------
    | Receber dados do formulário
    |--------------------------------------------------------------------------
    */
    $nome =
        trim(
            (string) (
                $_POST['nome']
                ?? ''
            )
        );
    $cpf =
        trim(
            (string) (
                $_POST['cpf']
                ?? ''
            )
        );
    $dataNascimento =
        trim(
            (string) (
                $_POST['data_nascimento']
                ?? ''
            )
        );
    $telefone =
        trim(
            (string) (
                $_POST['telefone']
                ?? ''
            )
        );
    $email =
        strtolower(
            trim(
                (string) (
                    $_POST['email']
                    ?? ''
                )
            )
        );
    /*
    |--------------------------------------------------------------------------
    | Preparar dados
    |--------------------------------------------------------------------------
    */
    $dados = [
        'nome' =>
            $nome,
        'cpf' =>
            $cpf,
        'data_nascimento' =>
            $dataNascimento,
        'telefone' =>
            $telefone,
        'email' =>
            $email,
    ];
    /*
    |--------------------------------------------------------------------------
    | Manter dados caso ocorra erro
    |--------------------------------------------------------------------------
    */
    $_SESSION['perfil_dados'] =
        $dados;
    /*
    |--------------------------------------------------------------------------
    | Validação
    |--------------------------------------------------------------------------
    */
    $erros = [];
    /*
    |--------------------------------------------------------------------------
    | Nome
    |--------------------------------------------------------------------------
    */
    if (
        mb_strlen(
            $nome
        ) < 3
    ) {
        $erros[] =
            'Informe o nome completo.';
    }
    /*
    |--------------------------------------------------------------------------
    | CPF
    |--------------------------------------------------------------------------
    */
    if (
        !Cpf::validar(
            $cpf
        )
    ) {
        $erros[] =
            'Informe um CPF válido.';
    }
    /*
    |--------------------------------------------------------------------------
    | E-mail
    |--------------------------------------------------------------------------
    */
    if (
        filter_var(
            $email,
            FILTER_VALIDATE_EMAIL
        ) === false
    ) {
        $erros[] =
            'Informe um e-mail válido.';
    }
    /*
    |--------------------------------------------------------------------------
    | Normalizar CPF
    |--------------------------------------------------------------------------
    */
    $cpf =
        Cpf::somenteNumeros(
            $cpf
        );
    $dados['cpf'] =
        $cpf;
    /*
    |--------------------------------------------------------------------------
    | Data de nascimento
    |--------------------------------------------------------------------------
    */
    if (
        $dataNascimento === ''
    ) {
        $dados['data_nascimento'] =
            null;
    }
    /*
    |--------------------------------------------------------------------------
    | Retornar se houver erros
    |--------------------------------------------------------------------------
    */
    if ($erros !== []) {
        $_SESSION['perfil_erros'] =
            $erros;
        $_SESSION['perfil_dados'] =
            $dados;
        header(
            'Location: '
            . BASE_URL
            . '/cliente/perfil/editar'
        );
        exit;
    }
    /*
    |--------------------------------------------------------------------------
    | Banco de dados
    |--------------------------------------------------------------------------
    */
    require_once APP_ROOT
        . '/database/conexao.php';
    $pdo =
        \Config::connect();
    /*
    |--------------------------------------------------------------------------
    | Repository
    |--------------------------------------------------------------------------
    */
    $clienteRepository =
        new ClienteRepository(
            $pdo
        );
    /*
    |--------------------------------------------------------------------------
    | Verificar cliente
    |--------------------------------------------------------------------------
    */
    $cliente =
        $clienteRepository
            ->buscarPorId(
                (int) $clienteId
            );
    if ($cliente === null) {
        ClienteAuth::sair();
        header(
            'Location: '
            . BASE_URL
            . '/cliente/login'
        );
        exit;
    }
    /*
    |--------------------------------------------------------------------------
    | E-mail já utilizado por outro cliente
    |--------------------------------------------------------------------------
    */
    if (
        $clienteRepository
            ->emailExisteParaOutroCliente(
                $email,
                (int) $clienteId
            )
    ) {
        $erros[] =
            'Este e-mail já está sendo '
            . 'utilizado por outro cliente.';
    }
    /*
    |--------------------------------------------------------------------------
    | CPF já utilizado por outro cliente
    |--------------------------------------------------------------------------
    */
    if (
        $clienteRepository
            ->cpfExisteParaOutroCliente(
                $cpf,
                (int) $clienteId
            )
    ) {
        $erros[] =
            'Este CPF já está cadastrado '
            . 'para outro cliente.';
    }
    /*
    |--------------------------------------------------------------------------
    | Retornar se houver duplicidade
    |--------------------------------------------------------------------------
    */
    if ($erros !== []) {
        $_SESSION['perfil_erros'] =
            $erros;
        $_SESSION['perfil_dados'] =
            $dados;
        header(
            'Location: '
            . BASE_URL
            . '/cliente/perfil/editar'
        );
        exit;
    }
    /*
    |--------------------------------------------------------------------------
    | Atualizar perfil
    |--------------------------------------------------------------------------
    */
    $clienteRepository
        ->atualizarPerfil(
            (int) $clienteId,
            $dados
        );
    /*
    |--------------------------------------------------------------------------
    | Renovar token CSRF
    |--------------------------------------------------------------------------
    */
    CsrfCliente::renovar();
    /*
    |--------------------------------------------------------------------------
    | Limpar dados temporários
    |--------------------------------------------------------------------------
    */
    unset(
        $_SESSION['perfil_dados'],
        $_SESSION['perfil_erros']
    );
    /*
    |--------------------------------------------------------------------------
    | Mensagem de sucesso
    |--------------------------------------------------------------------------
    */
    $_SESSION['perfil_sucesso'] =
        'Perfil atualizado com sucesso.';
    /*
    |--------------------------------------------------------------------------
    | Redirecionar
    |--------------------------------------------------------------------------
    */
    header(
        'Location: '
        . BASE_URL
        . '/cliente/perfil'
    );
    exit;
}
}
