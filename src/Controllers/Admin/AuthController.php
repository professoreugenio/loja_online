<?php

declare(strict_types=1);

namespace Aluno\LojaOnline\Controllers\Admin;

use Aluno\LojaOnline\Controllers\Controller;
use Aluno\LojaOnline\Helpers\Csrf;
use Aluno\LojaOnline\Helpers\SessaoAdmin;
use Aluno\LojaOnline\Repositories\UsuarioAdminRepository;
use Aluno\LojaOnline\Services\AutenticacaoAdminService;

final class AuthController extends Controller
{
    private AutenticacaoAdminService $autenticacao;

    public function __construct()
    {
        $pdo = require APP_ROOT
            . '/database/conexao.php';

        $repository =
            new UsuarioAdminRepository($pdo);

        $this->autenticacao =
            new AutenticacaoAdminService(
                $repository
            );
    }

    public function formulario(): void
    {
        if (SessaoAdmin::autenticado()) {
            $this->redirecionar('/admin');
        }

        $erro =
            $_SESSION['login_erro'] ?? null;

        $email =
            $_SESSION['login_email'] ?? '';

        unset(
            $_SESSION['login_erro'],
            $_SESSION['login_email']
        );

        $this->view(
            'site/loginadmin',
            [
                'tituloPagina' =>
                    'Login administrativo',

                'erro' => $erro,

                'email' => $email,

                'csrfToken' =>
                    Csrf::gerar(),
            ]
        );
    }

    public function autenticar(): void
    {
        $token = isset($_POST['_token'])
            ? (string) $_POST['_token']
            : null;

        if (!Csrf::validar($token)) {
            $this->falhar(
                'O formulário expirou. '
                . 'Atualize a página e tente novamente.'
            );
        }

        $email = mb_strtolower(
            trim(
                (string) ($_POST['email'] ?? '')
            )
        );

        $senha = (string) (
            $_POST['senha'] ?? ''
        );

        if (
            filter_var(
                $email,
                FILTER_VALIDATE_EMAIL
            ) === false
            || $senha === ''
        ) {
            $this->falhar(
                'Informe um e-mail e uma senha válidos.',
                $email
            );
        }

        $usuario = $this->autenticacao
            ->autenticar(
                $email,
                $senha
            );

        if ($usuario === null) {
            $this->falhar(
                'E-mail ou senha inválidos.',
                $email
            );
        }

        SessaoAdmin::entrar($usuario);

        Csrf::renovar();

        $this->redirecionar('/admin');
    }

    public function sair(): void
    {
        $token = isset($_POST['_token'])
            ? (string) $_POST['_token']
            : null;

        if (!Csrf::validar($token)) {
            http_response_code(403);

            exit(
                'Solicitação de logout inválida.'
            );
        }

        SessaoAdmin::sair();

        $this->redirecionar(
            '/login-admin'
        );
    }

    private function falhar(
        string $mensagem,
        string $email = ''
    ): never {
        $_SESSION['login_erro'] =
            $mensagem;

        $_SESSION['login_email'] =
            $email;

        $this->redirecionar(
            '/login-admin'
        );
    }
}
