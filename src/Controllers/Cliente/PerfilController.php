<?php

declare(strict_types=1);

namespace App\Controllers\Cliente;

use App\Helpers\ClienteAuth;
use App\Helpers\CsrfCliente;
use App\Repositories\SegurancaRepository;
use RuntimeException;

final class PerfilController
{
    public function index(): void
    {
        ClienteAuth::exigirLogin();


        $arquivoView =
            APP_ROOT
            . '/views/cliente/perfil.php';


        if (!is_file($arquivoView)) {

            throw new RuntimeException(
                'A página de perfil '
                . 'não foi encontrada.'
            );
        }


        require $arquivoView;
    }


    /*
    |--------------------------------------------------------------------------
    | Página de segurança
    |--------------------------------------------------------------------------
    */
    public function seguranca(): void
    {
        ClienteAuth::exigirLogin();


        /*
        |--------------------------------------------------------------------------
        | Conexão
        |--------------------------------------------------------------------------
        */

        require_once APP_ROOT
            . '/database/conexao.php';


        $pdo =
            \Config::connect();


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
        | Repository
        |--------------------------------------------------------------------------
        */

        $segurancaRepository =
            new SegurancaRepository(
                $pdo
            );


        /*
        |--------------------------------------------------------------------------
        | Dados da conta
        |--------------------------------------------------------------------------
        */

        $seguranca =
            $segurancaRepository
                ->buscarResumoPorCliente(
                    $clienteId
                );


        if ($seguranca === null) {

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
        | Dispositivos
        |--------------------------------------------------------------------------
        */

        $dispositivos =
            $segurancaRepository
                ->listarDispositivos(
                    $clienteId
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
        | Mensagens flash
        |--------------------------------------------------------------------------
        */

        $mensagemSucesso =
            $_SESSION[
                'seguranca_sucesso'
            ]
            ?? null;


        $mensagemErro =
            $_SESSION[
                'seguranca_erro'
            ]
            ?? null;


        unset(
            $_SESSION[
                'seguranca_sucesso'
            ],
            $_SESSION[
                'seguranca_erro'
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | View
        |--------------------------------------------------------------------------
        */

        $arquivoView =
            APP_ROOT
            . '/views/cliente/seguranca.php';


        if (!is_file($arquivoView)) {

            throw new RuntimeException(
                'A página de segurança '
                . 'não foi encontrada.'
            );
        }


        require $arquivoView;
    }


    /*
    |--------------------------------------------------------------------------
    | Alterar senha
    |--------------------------------------------------------------------------
    */
    public function alterarSenha(): void
    {
        ClienteAuth::exigirLogin();


        /*
        |--------------------------------------------------------------------------
        | Validar CSRF
        |--------------------------------------------------------------------------
        */

        $csrfToken =
            isset($_POST['csrf_token'])
                ? (string) $_POST['csrf_token']
                : null;


        if (
            !CsrfCliente::validar(
                $csrfToken
            )
        ) {

            $this->redirecionarComErro(
                'O formulário expirou. '
                . 'Atualize a página e tente novamente.'
            );
        }


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


        /*
        |--------------------------------------------------------------------------
        | Dados do formulário
        |--------------------------------------------------------------------------
        */

        $senhaAtual =
            (string) (
                $_POST['senha_atual']
                ?? ''
            );


        $novaSenha =
            (string) (
                $_POST['nova_senha']
                ?? ''
            );


        $confirmarSenha =
            (string) (
                $_POST['confirmar_senha']
                ?? ''
            );


        /*
        |--------------------------------------------------------------------------
        | Validações
        |--------------------------------------------------------------------------
        */

        if (
            mb_strlen($novaSenha) < 8
        ) {

            $this->redirecionarComErro(
                'A nova senha deve possuir '
                . 'pelo menos 8 caracteres.'
            );
        }


        if (
            $novaSenha
            !==
            $confirmarSenha
        ) {

            $this->redirecionarComErro(
                'A confirmação da nova senha '
                . 'não corresponde.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Conexão + Repository
        |--------------------------------------------------------------------------
        */

        require_once APP_ROOT
            . '/database/conexao.php';


        $pdo =
            \Config::connect();


        $segurancaRepository =
            new SegurancaRepository(
                $pdo
            );


        /*
        |--------------------------------------------------------------------------
        | Senha atual
        |--------------------------------------------------------------------------
        */

        $senhaHashAtual =
            $segurancaRepository
                ->buscarSenhaHash(
                    $clienteId
                );


        /*
        |--------------------------------------------------------------------------
        | Se já existe senha, exigir senha atual
        |--------------------------------------------------------------------------
        */

        if ($senhaHashAtual !== null) {

            if (
                $senhaAtual === ''
                ||
                !password_verify(
                    $senhaAtual,
                    $senhaHashAtual
                )
            ) {

                $this->redirecionarComErro(
                    'A senha atual está incorreta.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Impedir reutilização da mesma senha
            |--------------------------------------------------------------------------
            */

            if (
                password_verify(
                    $novaSenha,
                    $senhaHashAtual
                )
            ) {

                $this->redirecionarComErro(
                    'A nova senha deve ser '
                    . 'diferente da senha atual.'
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Gerar novo hash
        |--------------------------------------------------------------------------
        */

        $novoHash =
            password_hash(
                $novaSenha,
                PASSWORD_DEFAULT
            );


        /*
        |--------------------------------------------------------------------------
        | Atualizar
        |--------------------------------------------------------------------------
        */

        $atualizou =
            $segurancaRepository
                ->atualizarSenha(
                    $clienteId,
                    $novoHash
                );


        if (!$atualizou) {

            /*
            | Se a senha nova gerar exatamente o mesmo estado de atualização
            | ou o banco não alterar linha, fazemos uma confirmação simples.
            */
            $hashDepois =
                $segurancaRepository
                    ->buscarSenhaHash(
                        $clienteId
                    );


            if (
                $hashDepois === null
                ||
                !password_verify(
                    $novaSenha,
                    $hashDepois
                )
            ) {

                $this->redirecionarComErro(
                    'Não foi possível alterar a senha.'
                );
            }
        }


        CsrfCliente::renovar();


        $_SESSION[
            'seguranca_sucesso'
        ] =
            'Senha alterada com sucesso.';


        header(
            'Location: '
            . BASE_URL
            . '/cliente/seguranca'
        );


        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | Redirecionamento de erro
    |--------------------------------------------------------------------------
    */
    private function redirecionarComErro(
        string $mensagem
    ): never {

        $_SESSION[
            'seguranca_erro'
        ] =
            $mensagem;


        header(
            'Location: '
            . BASE_URL
            . '/cliente/seguranca'
        );


        exit;
    }
}
