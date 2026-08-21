<?php

declare(strict_types=1);

namespace App\Controllers\Cliente;

use App\Helpers\ClienteAuth;
use App\Helpers\CsrfCliente;
use App\Helpers\IdSeguro;
use App\Repositories\CategoriaRepository;
use App\Repositories\ClienteRepository;

final class ClienteLoginController
{
    private ClienteRepository
        $clienteRepository;

    private CategoriaRepository
        $categoriaRepository;


    public function __construct()
    {
        require_once APP_ROOT
            . '/database/conexao.php';

        $pdo =
            \Config::connect();


        $this->clienteRepository =
            new ClienteRepository(
                $pdo
            );


        $this->categoriaRepository =
            new CategoriaRepository(
                $pdo
            );
    }


    public function formulario(): void
    {
        if (
            ClienteAuth::logado()
        ) {
            header(
                'Location: '
                    . BASE_URL
                    . '/cliente'
            );

            exit;
        }


        $categorias =
            $this->categoriaRepository
            ->listarAtivas();


        foreach (
            $categorias
            as &$categoria
        ) {

            $categoria['id_seguro'] =
                IdSeguro::criptografar(
                    (int)
                    $categoria['id']
                );
        }

        unset($categoria);


        $erroLogin =
            $_SESSION['cliente_login_erro']
            ?? null;


        $mensagemSucesso =
            $_SESSION['cliente_login_sucesso']
            ?? null;


        $emailLogin =
            $_SESSION['cliente_login_email']
            ?? '';


        unset(
            $_SESSION['cliente_login_erro'],
            $_SESSION['cliente_login_sucesso'],
            $_SESSION['cliente_login_email']
        );


        $csrfToken =
            CsrfCliente::gerar();


        $arquivoView =
            APP_ROOT
            . '/views/site/cliente_login.php';


        if (!is_file($arquivoView)) {
            throw new \RuntimeException(
                'A página de login '
                    . 'não foi encontrada.'
            );
        }


        require $arquivoView;
    }


    public function autenticar(): void
    {
        $token =
            isset(
                $_POST['csrf_token']
            )
            ? (string)
            $_POST['csrf_token']
            : null;


        if (
            !CsrfCliente::validar(
                $token
            )
        ) {
            $this->falhar(
                'O formulário expirou. '
                    . 'Atualize a página '
                    . 'e tente novamente.'
            );
        }


        $email = strtolower(
            trim(
                (string) (
                    $_POST['email']
                    ?? ''
                )
            )
        );


        $senha = (string) (
            $_POST['senha']
            ?? ''
        );


        if (
            filter_var(
                $email,
                FILTER_VALIDATE_EMAIL
            ) === false
            || $senha === ''
        ) {
            $this->falhar(
                'Informe um e-mail '
                    . 'e uma senha válidos.',
                $email
            );
        }


        $cliente =
            $this->clienteRepository
            ->buscarAtivoPorEmail(
                $email
            );


        $senhaCorreta =
            $cliente !== null
            && !empty($cliente['senha_hash'])
            && password_verify(
                $senha,
                (string)
                $cliente['senha_hash']
            );


        if (!$senhaCorreta) {
            $this->falhar(
                'E-mail ou senha inválidos.',
                $email
            );
        }


        ClienteAuth::entrar(
            $cliente
        );


        $this->clienteRepository
            ->registrarUltimoAcesso(
                (int)
                $cliente['id']
            );


        CsrfCliente::renovar();


        header(
            'Location: '
                . BASE_URL
                . '/cliente'
        );

        exit;
    }


    public function sair(): void
    {
        $token =
            isset(
                $_POST['csrf_token']
            )
            ? (string)
            $_POST['csrf_token']
            : null;


        if (
            !CsrfCliente::validar(
                $token
            )
        ) {
            http_response_code(403);

            exit('Solicitação inválida.');
        }


        ClienteAuth::sair();

        CsrfCliente::renovar();


        header(
            'Location: '
                . BASE_URL
                . '/'
        );

        exit;
    }

    private function falhar(
        string $mensagem,
        string $email = ''
    ): void {

        $_SESSION['cliente_login_erro'] = $mensagem;


        $_SESSION['cliente_login_email'] = $email;


        header(
            'Location: '
                . BASE_URL
                . '/cliente/login'
        );

        exit;
    }
}
