<?php

declare(strict_types=1);

namespace App\Repositories;

use PDO;

final class ConfiguracoesRepository
{
    public function __construct(
        private readonly PDO $pdo
    ) {}

    public function buscar(): ?array
    {
        $sql = "
            SELECT
                id,
                nomedosite,
                descricao,
                keywords,
                slogan,
                logo,
                favicon,
                email,
                whatsapp,
                sitemanutencao,
                sitestandby,
                mensagemmanutencao,
                mensagemstandby,
                titulo_seo,
                descricao_seo,
                frete_gratis_valor,
                criado_em,
                atualizado_em
            FROM configuracoes
            ORDER BY id ASC
            LIMIT 1
        ";

        $dados =
            $this->pdo
            ->query($sql)
            ->fetch(PDO::FETCH_ASSOC);

        return is_array($dados)
            ? $dados
            : null;
    }


    public function atualizar(
        int $id,
        array $dados
    ): bool {

        $sql = "
            UPDATE configuracoes
            SET
                nomedosite = :nomedosite,
                descricao = :descricao,
                keywords = :keywords,
                slogan = :slogan,
                logo = :logo,
                favicon = :favicon,
                email = :email,
                whatsapp = :whatsapp,
                sitemanutencao = :sitemanutencao,
                sitestandby = :sitestandby,
                mensagemmanutencao = :mensagemmanutencao,
                mensagemstandby = :mensagemstandby,
                titulo_seo = :titulo_seo,
                descricao_seo = :descricao_seo,
                frete_gratis_valor = :frete_gratis_valor
            WHERE id = :id
        ";

        $stmt =
            $this->pdo->prepare($sql);

        return $stmt->execute([
            ':id' => $id,

            ':nomedosite' =>
            $dados['nomedosite'],

            ':descricao' =>
            $dados['descricao'],

            ':keywords' =>
            $dados['keywords'],

            ':slogan' =>
            $dados['slogan'],

            ':logo' =>
            $dados['logo'],

            ':favicon' =>
            $dados['favicon'],

            ':email' =>
            $dados['email'],

            ':whatsapp' =>
            $dados['whatsapp'],

            ':sitemanutencao' =>
            $dados['sitemanutencao'],

            ':sitestandby' =>
            $dados['sitestandby'],

            ':mensagemmanutencao' =>
            $dados['mensagemmanutencao'],

            ':mensagemstandby' =>
            $dados['mensagemstandby'],

            ':titulo_seo' =>
            $dados['titulo_seo'],

            ':descricao_seo' =>
            $dados['descricao_seo'],

            ':frete_gratis_valor' =>
            $dados['frete_gratis_valor'],
        ]);
    }
}
