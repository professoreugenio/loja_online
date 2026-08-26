<?php

declare(strict_types=1);

namespace App\Controllers\Cliente;

use App\Helpers\ClienteAuth;
use App\Repositories\EnderecoRepository;
use RuntimeException;

final class EnderecoController
{
    /**
     * Exibe os endereços do cliente autenticado.
     */
    public function index(): void
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

        $clienteId = ClienteAuth::id();

        if ($clienteId === null) {
            ClienteAuth::exigirLogin();

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Banco de dados
        |--------------------------------------------------------------------------
        */

        require_once APP_ROOT
            . '/database/conexao.php';

        $pdo = \Config::connect();


        /*
        |--------------------------------------------------------------------------
        | Repository
        |--------------------------------------------------------------------------
        */

        $enderecoRepository =
            new EnderecoRepository(
                $pdo
            );


        /*
        |--------------------------------------------------------------------------
        | Buscar endereços do cliente
        |--------------------------------------------------------------------------
        */

        $enderecos =
            $enderecoRepository
                ->listarPorCliente(
                    $clienteId
                );


        /*
        |--------------------------------------------------------------------------
        | View
        |--------------------------------------------------------------------------
        */

        $arquivoView =
            APP_ROOT
            . '/views/cliente/enderecos.php';

        if (!is_file($arquivoView)) {
            throw new RuntimeException(
                'A página de endereços '
                . 'não foi encontrada.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Exibir página
        |--------------------------------------------------------------------------
        */

        require $arquivoView;
    }

    public function editar(): void
    {
        // 1. Verificar Autenticação
        ClienteAuth::exigirLogin();
        $clienteId = ClienteAuth::id();

        if ($clienteId === null) {
            ClienteAuth::exigirLogin();
            return;
        }

        // 2. Receber e sanitizar os dados do formulário
        $id = (int) ($_POST['id'] ?? 0);
        $identificacao = trim((string) ($_POST['identificacao'] ?? ''));
        $destinatario  = trim((string) ($_POST['destinatario'] ?? ''));
        $cep           = trim((string) ($_POST['cep'] ?? ''));
        $logradouro    = trim((string) ($_POST['logradouro'] ?? ''));
        $numero        = trim((string) ($_POST['numero'] ?? ''));
        $complemento   = trim((string) ($_POST['complemento'] ?? ''));
        $bairro        = trim((string) ($_POST['bairro'] ?? ''));
        $cidade        = trim((string) ($_POST['cidade'] ?? ''));
        $estado        = strtoupper(trim((string) ($_POST['estado'] ?? '')));

        // 3. Validação Básica
        if ($id <= 0 || $destinatario === '' || $cep === '' || $logradouro === '' || $numero === '' || $bairro === '' || $cidade === '' || $estado === '') {
            $_SESSION['endereco_erro'] = 'Por favor, preencha todos os campos obrigatórios.';
            header('Location: ' . BASE_URL . '/cliente/enderecos');
            exit;
        }

        // 4. Conectar ao Banco e Instanciar o Repositório
        require_once APP_ROOT . '/database/conexao.php';
        $pdo = \Config::connect();
        $enderecoRepository = new EnderecoRepository($pdo);

        // 5. Verificar se o endereço pertence ao cliente autenticado (Segurança)
        $enderecoExistente = $enderecoRepository->buscarPorIdECliente($id, (int)$clienteId);
        if ($enderecoExistente === null) {
            $_SESSION['endereco_erro'] = 'Endereço não encontrado ou acesso negado.';
            header('Location: ' . BASE_URL . '/cliente/enderecos');
            exit;
        }

        // 6. Atualizar os dados
        $dados = [
            'identificacao' => $identificacao !== '' ? $identificacao : 'Endereço',
            'destinatario'  => $destinatario,
            'cep'           => $cep,
            'logradouro'    => $logradouro,
            'numero'        => $numero,
            'complemento'   => $complemento,
            'bairro'        => $bairro,
            'cidade'        => $cidade,
            'estado'        => $estado,
        ];

        $enderecoRepository->atualizar($id, (int)$clienteId, $dados);

        $_SESSION['endereco_sucesso'] = 'Endereço atualizado com sucesso!';
        header('Location: ' . BASE_URL . '/cliente/enderecos');
        exit;
    }

    public function excluir(): void
{
    // 1. Verificar Autenticação
    ClienteAuth::exigirLogin();
    $clienteId = ClienteAuth::id();

    if ($clienteId === null) {
        ClienteAuth::exigirLogin();
        return;
    }

    // 2. Receber o ID do endereço a ser excluído
    $id = (int) ($_POST['id'] ?? 0);

    if ($id <= 0) {
        $_SESSION['endereco_erro'] = 'ID de endereço inválido.';
        header('Location: ' . BASE_URL . '/cliente/enderecos');
        exit;
    }

    // 3. Conectar ao Banco e Instanciar Repositório
    require_once APP_ROOT . '/database/conexao.php';
    $pdo = \Config::connect();
    $enderecoRepository = new EnderecoRepository($pdo);

    // 4. Segurança: Verificar se o endereço existe e pertence a este cliente
    $enderecoExistente = $enderecoRepository->buscarPorIdECliente($id, (int)$clienteId);
    if ($enderecoExistente === null) {
        $_SESSION['endereco_erro'] = 'Endereço não encontrado ou você não tem permissão para excluí-lo.';
        header('Location: ' . BASE_URL . '/cliente/enderecos');
        exit;
    }

    // 5. Excluir o endereço
    $excluido = $enderecoRepository->excluir($id, (int)$clienteId);

    if ($excluido) {
        $_SESSION['endereco_sucesso'] = 'Endereço excluído com sucesso!';
    } else {
        $_SESSION['endereco_erro'] = 'Erro ao tentar excluir o endereço.';
    }

    // 6. Redirecionar de volta para a lista
    header('Location: ' . BASE_URL . '/cliente/enderecos');
    exit;
}

    public function cadastrar(): void
{
    // 1. Proteção / Autenticação
    ClienteAuth::exigirLogin();
    $clienteId = ClienteAuth::id();

    if ($clienteId === null) {
        ClienteAuth::exigirLogin();
        return;
    }

    // 2. Receber e sanitizar dados
    $identificacao = trim((string) ($_POST['identificacao'] ?? 'Casa'));
    $destinatario  = trim((string) ($_POST['destinatario'] ?? ''));
    $cep           = trim((string) ($_POST['cep'] ?? ''));
    $logradouro    = trim((string) ($_POST['logradouro'] ?? ''));
    $numero        = trim((string) ($_POST['numero'] ?? ''));
    $complemento   = trim((string) ($_POST['complemento'] ?? ''));
    $bairro        = trim((string) ($_POST['bairro'] ?? ''));
    $cidade        = trim((string) ($_POST['cidade'] ?? ''));
    $estado        = strtoupper(trim((string) ($_POST['estado'] ?? '')));
    $principal     = isset($_POST['principal']) && (int) $_POST['principal'] === 1 ? 1 : 0;

    // 3. Validação Básica
    if ($destinatario === '' || $cep === '' || $logradouro === '' || $numero === '' || $bairro === '' || $cidade === '' || $estado === '') {
        $_SESSION['endereco_erro'] = 'Preencha todos os campos obrigatórios.';
        header('Location: ' . BASE_URL . '/cliente/enderecos');
        exit;
    }

    // 4. Conectar ao Banco e Instanciar Repositório
    require_once APP_ROOT . '/database/conexao.php';
    $pdo = \Config::connect();
    $enderecoRepository = new EnderecoRepository($pdo);

    // Se for o primeiro endereço cadastrado pelo cliente, marca automaticamente como principal
    $totalEnderecos = $enderecoRepository->contarPorCliente((int) $clienteId);
    if ($totalEnderecos === 0) {
        $principal = 1;
    }

    // Se o novo endereço for definido como principal, desmarca o anterior
    if ($principal === 1 && $totalEnderecos > 0) {
        $enderecoRepository->desmarcarPrincipaisDoCliente((int) $clienteId);
    }

    // 5. Salvar no Banco
    $dados = [
        'cliente_id'    => (int) $clienteId,
        'identificacao' => $identificacao,
        'destinatario'  => $destinatario,
        'cep'           => $cep,
        'logradouro'    => $logradouro,
        'numero'        => $numero,
        'complemento'   => $complemento,
        'bairro'        => $bairro,
        'cidade'        => $cidade,
        'estado'        => $estado,
        'principal'     => $principal,
    ];

    $enderecoRepository->cadastrar($dados);

    $_SESSION['endereco_sucesso'] = 'Endereço cadastrado com sucesso!';
    header('Location: ' . BASE_URL . '/cliente/enderecos');
    exit;
}
}
