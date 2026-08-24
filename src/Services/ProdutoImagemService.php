<?php

declare(strict_types=1);

namespace App\Services;

use RuntimeException;

final class ProdutoImagemService
{
    private const LARGURA_SAIDA = 1024;
    private const TAMANHO_MAXIMO_BYTES = 122880; // 120 KB
    private const TAMANHO_UPLOAD_MAXIMO = 20971520; // 20 MB
    private const PIXELS_MAXIMOS = 60000000;

    private string $diretorioFisico;

    public function __construct(
        private string $raizProjeto
    ) {
        $this->diretorioFisico =
            rtrim(
                $this->raizProjeto,
                DIRECTORY_SEPARATOR
            )
            . DIRECTORY_SEPARATOR
            . 'public'
            . DIRECTORY_SEPARATOR
            . 'imagens'
            . DIRECTORY_SEPARATOR
            . 'produtos';
    }

    /**
     * @return array{
     *     url_imagem:string,
     *     caminho_fisico:string,
     *     largura:int,
     *     altura:int,
     *     tamanho:int
     * }
     */
    public function processarUpload(
        array $arquivo,
        string $nomeProduto,
        int $produtoId,
        int $categoriaId,
        int $timestamp
    ): array {
        $this->validarGd();

        $erro =
            (int) ($arquivo['error']
                ?? UPLOAD_ERR_NO_FILE);

        if ($erro !== UPLOAD_ERR_OK) {
            throw new RuntimeException(
                $this->mensagemErroUpload($erro)
            );
        }

        $temporario = (string) (
            $arquivo['tmp_name']
            ?? ''
        );

        if (
            $temporario === ''
            || !is_uploaded_file($temporario)
        ) {
            throw new RuntimeException(
                'O arquivo enviado não é um upload válido.'
            );
        }

        $tamanhoUpload =
            (int) ($arquivo['size'] ?? 0);

        if (
            $tamanhoUpload <= 0
            || $tamanhoUpload
                > self::TAMANHO_UPLOAD_MAXIMO
        ) {
            throw new RuntimeException(
                'Cada imagem deve possuir no máximo 20 MB antes do processamento.'
            );
        }

        $dadosImagem =
            @getimagesize($temporario);

        if (
            !is_array($dadosImagem)
            || empty($dadosImagem[0])
            || empty($dadosImagem[1])
        ) {
            throw new RuntimeException(
                'O arquivo enviado não é uma imagem válida.'
            );
        }

        $larguraOriginal =
            (int) $dadosImagem[0];

        $alturaOriginal =
            (int) $dadosImagem[1];

        if (
            $larguraOriginal
            * $alturaOriginal
            > self::PIXELS_MAXIMOS
        ) {
            throw new RuntimeException(
                'A resolução da imagem é muito alta para processamento seguro.'
            );
        }

        $mime =
            strtolower(
                (string) (
                    $dadosImagem['mime']
                    ?? ''
                )
            );

        $permitidos = [
            'image/jpeg',
            'image/png',
            'image/webp',
        ];

        if (
            !in_array(
                $mime,
                $permitidos,
                true
            )
        ) {
            throw new RuntimeException(
                'Formato não permitido. Envie JPG, PNG ou WebP.'
            );
        }

        $conteudo =
            @file_get_contents($temporario);

        if ($conteudo === false) {
            throw new RuntimeException(
                'Não foi possível ler a imagem enviada.'
            );
        }

        $origem =
            @imagecreatefromstring($conteudo);

        if ($origem === false) {
            throw new RuntimeException(
                'Não foi possível abrir a imagem enviada.'
            );
        }

        /*
         * A largura de 1024 px é o TAMANHO DE SAÍDA.
         * Não é uma largura mínima exigida no upload.
         * Se a imagem original for menor, ela também será
         * ajustada para 1024 px, mantendo a proporção.
         */
        $alturaSaida = max(
            1,
            (int) round(
                $alturaOriginal
                * (
                    self::LARGURA_SAIDA
                    / $larguraOriginal
                )
            )
        );

        $destino =
            imagecreatetruecolor(
                self::LARGURA_SAIDA,
                $alturaSaida
            );

        if ($destino === false) {
            imagedestroy($origem);

            throw new RuntimeException(
                'Não foi possível criar a imagem de destino.'
            );
        }

        imagealphablending(
            $destino,
            false
        );

        imagesavealpha(
            $destino,
            true
        );

        $transparente =
            imagecolorallocatealpha(
                $destino,
                0,
                0,
                0,
                127
            );

        imagefilledrectangle(
            $destino,
            0,
            0,
            self::LARGURA_SAIDA,
            $alturaSaida,
            $transparente
        );

        $ok =
            imagecopyresampled(
                $destino,
                $origem,
                0,
                0,
                0,
                0,
                self::LARGURA_SAIDA,
                $alturaSaida,
                $larguraOriginal,
                $alturaOriginal
            );

        imagedestroy($origem);

        if (!$ok) {
            imagedestroy($destino);

            throw new RuntimeException(
                'Não foi possível redimensionar a imagem.'
            );
        }

        $this->garantirDiretorio();

        $nomeSeguro =
            $this->nomeArquivoSeguro(
                $nomeProduto
            );

        $nomeArquivo =
            $nomeSeguro
            . '_'
            . $timestamp
            . '_'
            . $produtoId
            . '_'
            . $categoriaId
            . '.webp';

        $caminhoFinal =
            $this->diretorioFisico
            . DIRECTORY_SEPARATOR
            . $nomeArquivo;

        $caminhoTemporario =
            $caminhoFinal
            . '.tmp.webp';

        /*
         * Reduz progressivamente a qualidade do WebP até
         * atingir o limite de 120 KB, mantendo a largura
         * final em 1024 px.
         */
        $qualidades = range(82, 1, -1);

        $tamanhoFinal = 0;
        $atingiuLimite = false;

        foreach ($qualidades as $qualidade) {
            @unlink($caminhoTemporario);

            $gravou =
                imagewebp(
                    $destino,
                    $caminhoTemporario,
                    $qualidade
                );

            clearstatcache(
                true,
                $caminhoTemporario
            );

            if (
                !$gravou
                || !is_file(
                    $caminhoTemporario
                )
            ) {
                continue;
            }

            $tamanhoFinal =
                (int) filesize(
                    $caminhoTemporario
                );

            if (
                $tamanhoFinal > 0
                && $tamanhoFinal
                    <= self::TAMANHO_MAXIMO_BYTES
            ) {
                $atingiuLimite = true;
                break;
            }
        }

        imagedestroy($destino);

        if (!$atingiuLimite) {
            @unlink($caminhoTemporario);

            throw new RuntimeException(
                'Não foi possível reduzir a imagem para até 120 KB mantendo 1024 px de largura.'
            );
        }

        if (is_file($caminhoFinal)) {
            @unlink($caminhoFinal);
        }

        if (
            !@rename(
                $caminhoTemporario,
                $caminhoFinal
            )
        ) {
            @unlink($caminhoTemporario);

            throw new RuntimeException(
                'Não foi possível salvar a imagem processada.'
            );
        }

        return [
            'url_imagem' =>
                'imagens/produtos/'
                . $nomeArquivo,
            'caminho_fisico' =>
                $caminhoFinal,
            'largura' =>
                self::LARGURA_SAIDA,
            'altura' =>
                $alturaSaida,
            'tamanho' =>
                $tamanhoFinal,
        ];
    }

    public function excluirPorUrl(
        string $urlImagem
    ): bool {
        $nomeArquivo =
            basename(
                str_replace(
                    '\\',
                    '/',
                    $urlImagem
                )
            );

        if (
            $nomeArquivo === ''
            || $nomeArquivo === '.'
            || $nomeArquivo === '..'
        ) {
            return false;
        }

        $caminho =
            $this->diretorioFisico
            . DIRECTORY_SEPARATOR
            . $nomeArquivo;

        if (!is_file($caminho)) {
            return true;
        }

        return @unlink($caminho);
    }

    private function validarGd(): void
    {
        if (
            !extension_loaded('gd')
            || !function_exists(
                'imagewebp'
            )
        ) {
            throw new RuntimeException(
                'A extensão GD com suporte a WebP precisa estar habilitada no PHP.'
            );
        }
    }

    private function garantirDiretorio(): void
    {
        if (is_dir($this->diretorioFisico)) {
            return;
        }

        if (
            !mkdir(
                $this->diretorioFisico,
                0755,
                true
            )
            && !is_dir(
                $this->diretorioFisico
            )
        ) {
            throw new RuntimeException(
                'Não foi possível criar public/imagens/produtos.'
            );
        }
    }

    private function nomeArquivoSeguro(
        string $nome
    ): string {
        $nome = trim($nome);

        $convertido =
            @iconv(
                'UTF-8',
                'ASCII//TRANSLIT//IGNORE',
                $nome
            );

        if ($convertido !== false) {
            $nome = $convertido;
        }

        $nome = strtolower($nome);

        $nome = preg_replace(
            '/[^a-z0-9]+/',
            '-',
            $nome
        ) ?? '';

        $nome = trim(
            $nome,
            '-'
        );

        return $nome !== ''
            ? $nome
            : 'produto';
    }

    private function mensagemErroUpload(
        int $erro
    ): string {
        return match ($erro) {
            UPLOAD_ERR_INI_SIZE,
            UPLOAD_ERR_FORM_SIZE =>
                'A imagem excede o limite de upload configurado.',
            UPLOAD_ERR_PARTIAL =>
                'A imagem foi enviada apenas parcialmente.',
            UPLOAD_ERR_NO_FILE =>
                'Nenhuma imagem foi selecionada.',
            UPLOAD_ERR_NO_TMP_DIR =>
                'A pasta temporária do PHP não está disponível.',
            UPLOAD_ERR_CANT_WRITE =>
                'O servidor não conseguiu gravar o arquivo temporário.',
            UPLOAD_ERR_EXTENSION =>
                'Uma extensão do PHP interrompeu o upload.',
            default =>
                'Falha desconhecida durante o upload da imagem.',
        };
    }
}