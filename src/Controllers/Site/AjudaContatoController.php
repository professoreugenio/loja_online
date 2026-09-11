<?php

declare(strict_types=1);

namespace App\Controllers\Site;

use App\Helpers\Csrf;
use App\Helpers\IdSeguro;
use App\Repositories\CategoriaRepository;
use App\Services\CarrinhoService;
use App\Services\EmailService;
use RuntimeException;
use Throwable;

final class AjudaContatoController
{
    public function index(): void
    {
        require_once APP_ROOT
            . '/database/conexao.php';

        $pdo =
            \Config::connect();

        $categoriaRepository =
            new CategoriaRepository(
                $pdo
            );

        $categorias =
            $categoriaRepository
            ->listarAtivas();

        foreach ($categorias as &$categoria) {
            $categoria['id_seguro'] =
                IdSeguro::criptografar(
                    (int) $categoria['id']
                );
        }

        unset($categoria);

        $carrinhoService =
            new CarrinhoService(
                $pdo
            );

        $quantidadeCarrinho =
            $carrinhoService
            ->quantidade();

        $csrfToken =
            Csrf::gerar();

        $mensagemSucesso =
            $_SESSION['contato_sucesso']
            ?? null;

        $mensagemErro =
            $_SESSION['contato_erro']
            ?? null;

        $dadosAntigos =
            $_SESSION['contato_dados']
            ?? [];

        unset(
            $_SESSION['contato_sucesso'],
            $_SESSION['contato_erro'],
            $_SESSION['contato_dados']
        );

        $tituloPagina =
            'Fale conosco';

        $descricaoPagina =
            'Entre em contato com a equipe '
            . 'de atendimento da loja.';

        $arquivoView =
            APP_ROOT
            . '/views/site/ajuda_contato.php';

        if (!is_file($arquivoView)) {
            throw new RuntimeException(
                'A página de contato '
                . 'não foi encontrada.'
            );
        }

        require $arquivoView;
    }

    public function enviar(): void
    {
        $csrfToken =
            isset($_POST['csrf_token'])
                ? (string)
                    $_POST['csrf_token']
                : null;

        if (!Csrf::validar($csrfToken)) {
            http_response_code(403);
            exit('Solicitação inválida.');
        }

        /*
        | Campo invisível contra robôs.
        */
        $website =
            trim(
                (string) (
                    $_POST['website']
                    ?? ''
                )
            );

        if ($website !== '') {
            $this->redirecionar();
        }

        /*
        | Evita muitos envios seguidos.
        */
        $ultimoEnvio =
            (int) (
                $_SESSION[
                    'contato_ultimo_envio'
                ]
                ?? 0
            );

        if (
            $ultimoEnvio > 0
            &&
            time() - $ultimoEnvio < 60
        ) {
            $this->falhar(
                'Aguarde um minuto antes '
                . 'de enviar outra mensagem.'
            );
        }

        $dados = [
            'nome' =>
                trim(
                    (string) (
                        $_POST['nome']
                        ?? ''
                    )
                ),

            'email' =>
                mb_strtolower(
                    trim(
                        (string) (
                            $_POST['email']
                            ?? ''
                        )
                    )
                ),

            'telefone' =>
                trim(
                    (string) (
                        $_POST['telefone']
                        ?? ''
                    )
                ),

            'assunto' =>
                trim(
                    (string) (
                        $_POST['assunto']
                        ?? ''
                    )
                ),

            'pedido' =>
                trim(
                    (string) (
                        $_POST['pedido']
                        ?? ''
                    )
                ),

            'mensagem' =>
                trim(
                    (string) (
                        $_POST['mensagem']
                        ?? ''
                    )
                ),
        ];

        $_SESSION['contato_dados'] =
            $dados;

        if (
            mb_strlen($dados['nome']) < 3
            ||
            mb_strlen($dados['nome']) > 150
        ) {
            $this->falhar(
                'Informe um nome válido.'
            );
        }

        if (
            filter_var(
                $dados['email'],
                FILTER_VALIDATE_EMAIL
            ) === false
        ) {
            $this->falhar(
                'Informe um e-mail válido.'
            );
        }

        $assuntosPermitidos = [
            'Pedido',
            'Pagamento',
            'Entrega',
            'Troca ou devolução',
            'Produto',
            'Outros',
        ];

        if (
            !in_array(
                $dados['assunto'],
                $assuntosPermitidos,
                true
            )
        ) {
            $this->falhar(
                'Selecione um assunto válido.'
            );
        }

        if (
            mb_strlen($dados['mensagem']) < 10
            ||
            mb_strlen($dados['mensagem']) > 3000
        ) {
            $this->falhar(
                'A mensagem deve possuir '
                . 'entre 10 e 3.000 caracteres.'
            );
        }

        $aceitou =
            isset($_POST['aceite'])
            &&
            $_POST['aceite'] === '1';

        if (!$aceitou) {
            $this->falhar(
                'Confirme o aceite para '
                . 'enviar a mensagem.'
            );
        }

        try {
            $emailService =
                new EmailService();

            $emailService
                ->enviarContato(
                    $dados
                );

            $_SESSION[
                'contato_ultimo_envio'
            ] = time();

            $_SESSION['contato_sucesso'] =
                'Mensagem enviada com sucesso. '
                . 'Responderemos assim que possível.';

            unset(
                $_SESSION['contato_dados']
            );

            Csrf::renovar();

            $this->redirecionar();
        } catch (Throwable $erro) {
            /*
            | Registre $erro em log no servidor.
            | Não mostre senha ou erro SMTP ao visitante.
            */

            $this->falhar(
                'Não foi possível enviar '
                . 'a mensagem neste momento.'
            );
        }
    }

    private function falhar(
        string $mensagem
    ): void {
        $_SESSION['contato_erro'] =
            $mensagem;

        $this->redirecionar();
    }

    private function redirecionar(): void
    {
        header(
            'Location: '
            . BASE_URL
            . '/ajuda/contato'
        );

        exit;
    }
}
