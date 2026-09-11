<?php

declare(strict_types=1);

namespace App\Services;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use RuntimeException;

final class EmailService
{
    public function enviarContato(
        array $dados
    ): void {
        $mailer =
            new PHPMailer(true);

        try {
            $mailer->isSMTP();

            $mailer->Host =
                $this->obterEnv(
                    'MAIL_HOST'
                );

            $mailer->SMTPAuth =
                true;

            $mailer->Username =
                $this->obterEnv(
                    'MAIL_USERNAME'
                );

            $mailer->Password =
                $this->obterEnv(
                    'MAIL_PASSWORD'
                );

            $mailer->Port =
                (int) $this->obterEnv(
                    'MAIL_PORT'
                );

            $criptografia =
                strtolower(
                    $this->obterEnv(
                        'MAIL_ENCRYPTION'
                    )
                );

            if ($criptografia === 'ssl') {
                $mailer->SMTPSecure =
                    PHPMailer::ENCRYPTION_SMTPS;
            } else {
                $mailer->SMTPSecure =
                    PHPMailer::ENCRYPTION_STARTTLS;
            }

            $mailer->CharSet =
                PHPMailer::CHARSET_UTF8;

            $mailer->setFrom(
                $this->obterEnv(
                    'MAIL_FROM_ADDRESS'
                ),
                $this->obterEnv(
                    'MAIL_FROM_NAME'
                )
            );

            $mailer->addAddress(
                $this->obterEnv(
                    'MAIL_TO_ADDRESS'
                ),
                $this->obterEnv(
                    'MAIL_TO_NAME'
                )
            );

            $mailer->addReplyTo(
                $dados['email'],
                $dados['nome']
            );

            $mailer->isHTML(true);

            $mailer->Subject =
                'Contato do site: '
                . $dados['assunto'];

            $nome =
                htmlspecialchars(
                    $dados['nome'],
                    ENT_QUOTES,
                    'UTF-8'
                );

            $email =
                htmlspecialchars(
                    $dados['email'],
                    ENT_QUOTES,
                    'UTF-8'
                );

            $telefone =
                htmlspecialchars(
                    $dados['telefone'],
                    ENT_QUOTES,
                    'UTF-8'
                );

            $assunto =
                htmlspecialchars(
                    $dados['assunto'],
                    ENT_QUOTES,
                    'UTF-8'
                );

            $pedido =
                htmlspecialchars(
                    $dados['pedido'],
                    ENT_QUOTES,
                    'UTF-8'
                );

            $mensagem =
                nl2br(
                    htmlspecialchars(
                        $dados['mensagem'],
                        ENT_QUOTES,
                        'UTF-8'
                    )
                );

            $mailer->Body =
                '<h2>Nova mensagem do site</h2>'
                . '<p><strong>Nome:</strong> '
                . $nome
                . '</p>'
                . '<p><strong>E-mail:</strong> '
                . $email
                . '</p>'
                . '<p><strong>Telefone:</strong> '
                . ($telefone !== '' ? $telefone : 'Não informado')
                . '</p>'
                . '<p><strong>Assunto:</strong> '
                . $assunto
                . '</p>'
                . '<p><strong>Pedido:</strong> '
                . ($pedido !== '' ? $pedido : 'Não informado')
                . '</p>'
                . '<hr>'
                . '<p><strong>Mensagem:</strong></p>'
                . '<p>'
                . $mensagem
                . '</p>';

            $mailer->AltBody =
                "Nova mensagem do site\n\n"
                . "Nome: {$dados['nome']}\n"
                . "E-mail: {$dados['email']}\n"
                . "Telefone: {$dados['telefone']}\n"
                . "Assunto: {$dados['assunto']}\n"
                . "Pedido: {$dados['pedido']}\n\n"
                . "Mensagem:\n{$dados['mensagem']}";

            $mailer->send();
        } catch (Exception $erro) {
            throw new RuntimeException(
                'Não foi possível enviar '
                . 'a mensagem neste momento.',
                0,
                $erro
            );
        }
    }

    private function obterEnv(
        string $nome
    ): string {
        $valor =
            trim(
                (string) (
                    $_ENV[$nome]
                    ?? ''
                )
            );

        if ($valor === '') {
            throw new RuntimeException(
                'A configuração '
                . $nome
                . ' não foi definida.'
            );
        }

        return $valor;
    }
}
