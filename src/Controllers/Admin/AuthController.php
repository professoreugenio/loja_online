<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Helpers\Csrf;
use App\Helpers\SessaoAdmin;
use App\Repositories\UsuarioAdminRepository;
use App\Services\AutenticacaoAdminService;

final class AuthController extends Controller
{
    private AutenticacaoAdminService
        $autenticacao;

    public function __construct()
    {
        $raizProjeto =
            dirname(__DIR__, 3);

        require_once
            $raizProjeto
            . '/database/conexao.php';

        $pdo = \Config::connect();

        $repository =
            new UsuarioAdminRepository(
                $pdo
            );

        $this->autenticacao =
            new AutenticacaoAdminService(
                $repository
            );
    }

    public function formulario(): void
    {
        if (SessaoAdmin::autenticado()) {
            $this->redirecionar(
                '/admin'
            );
        }

        $erro =
            $_SESSION['login_admin_erro']
            ?? null;

        $email =
            $_SESSION['login_admin_email']
            ?? '';

        unset(
            $_SESSION['login_admin_erro'],
            $_SESSION['login_admin_email']
        );

        $this->view(
            'site/loginadmin',
            [
                'tituloPagina' =>
                'Login administrativo',

                'erro' =>
                $erro,

                'email' =>
                $email,

                'csrfToken' =>
                Csrf::gerar(),
            ]
        );
    }

    public function autenticar(): void
    {
        $token = isset(
            $_POST['_token']
        )
            ? (string)
            $_POST['_token']
            : null;

        if (!Csrf::validar($token)) {
            $this->falhar(
                'O formulário expirou. '
                    . 'Atualize a página '
                    . 'e tente novamente.'
            );
        }

        $email =
            mb_strtolower(
                trim(
                    (string) (
                        $_POST['email']
                        ?? ''
                    )
                )
            );

        $senha =
            (string) (
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

        $usuario =
            $this->autenticacao
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

        SessaoAdmin::entrar(
            $usuario
        );

        Csrf::renovar();

        $this->redirecionar(
            '/admin'
        );
    }

    public function sair(): void
    {
        $token = isset(
            $_POST['_token']
        )
            ? (string)
            $_POST['_token']
            : null;

        if (!Csrf::validar($token)) {
            http_response_code(403);

            exit('Solicitação de logout inválida.');
        }

        SessaoAdmin::sair();

        $this->redirecionar(
            '/loginadmin'
        );
    }

    private function falhar(
        string $mensagem,
        string $email = ''
    ): never {
        $_SESSION['login_admin_erro'] = $mensagem;

        $_SESSION['login_admin_email'] = $email;

        $this->redirecionar(
            '/loginadmin'
        );
    }
}
