<?php

declare(strict_types=1);

namespace App\Repositories;

use PDO;

final class SegurancaRepository
{
    private PDO $pdo;


    public function __construct(
        PDO $pdo
    ) {
        $this->pdo = $pdo;
    }


    /*
    |--------------------------------------------------------------------------
    | Resumo de segurança da conta
    |--------------------------------------------------------------------------
    |
    | Não retorna senha_hash para a View.
    | A consulta apenas informa se existe uma senha configurada.
    |
    */
    public function buscarResumoPorCliente(
        int $clienteId
    ): ?array {

        $sql = '
            SELECT
                id,
                nome,
                email,
                email_verificado,
                status,
                ultimo_acesso,
                criado_em,
                atualizado_em,

                CASE
                    WHEN senha_hash IS NOT NULL
                     AND senha_hash <> \'\'
                    THEN 1
                    ELSE 0
                END AS possui_senha

            FROM clientes

            WHERE id = :cliente_id

            LIMIT 1
        ';


        $consulta =
            $this->pdo
                ->prepare($sql);


        $consulta->bindValue(
            ':cliente_id',
            $clienteId,
            PDO::PARAM_INT
        );


        $consulta->execute();


        $seguranca =
            $consulta->fetch(
                PDO::FETCH_ASSOC
            );


        return is_array($seguranca)
            ? $seguranca
            : null;
    }


    /*
    |--------------------------------------------------------------------------
    | Busca somente o hash da senha
    |--------------------------------------------------------------------------
    |
    | Utilizado exclusivamente no Controller para validar a senha atual.
    |
    */
    public function buscarSenhaHash(
        int $clienteId
    ): ?string {

        $sql = '
            SELECT
                senha_hash

            FROM clientes

            WHERE id = :cliente_id

            LIMIT 1
        ';


        $consulta =
            $this->pdo
                ->prepare($sql);


        $consulta->bindValue(
            ':cliente_id',
            $clienteId,
            PDO::PARAM_INT
        );


        $consulta->execute();


        $senhaHash =
            $consulta->fetchColumn();


        if (
            $senhaHash === false
            ||
            $senhaHash === null
            ||
            $senhaHash === ''
        ) {
            return null;
        }


        return (string) $senhaHash;
    }


    /*
    |--------------------------------------------------------------------------
    | Atualiza a senha do cliente
    |--------------------------------------------------------------------------
    */
    public function atualizarSenha(
        int $clienteId,
        string $senhaHash
    ): bool {

        $sql = '
            UPDATE clientes

            SET
                senha_hash = :senha_hash,
                atualizado_em = NOW()

            WHERE id = :cliente_id
        ';


        $consulta =
            $this->pdo
                ->prepare($sql);


        $consulta->bindValue(
            ':senha_hash',
            $senhaHash,
            PDO::PARAM_STR
        );


        $consulta->bindValue(
            ':cliente_id',
            $clienteId,
            PDO::PARAM_INT
        );


        $consulta->execute();


        return $consulta->rowCount() > 0;
    }


    /*
    |--------------------------------------------------------------------------
    | Dispositivos registrados para notificações
    |--------------------------------------------------------------------------
    |
    | A tabela dispositivos_notificacao não armazena navegador,
    | sistema operacional, IP ou localização.
    |
    | Por segurança, token_fcm NÃO é enviado para a View.
    |
    */
    public function listarDispositivos(
        int $clienteId
    ): array {

        $sql = '
            SELECT
                id,
                plataforma,
                ativo,
                ultimo_acesso,
                criado_em,
                atualizado_em

            FROM dispositivos_notificacao

            WHERE cliente_id = :cliente_id

            ORDER BY
                COALESCE(
                    ultimo_acesso,
                    atualizado_em,
                    criado_em
                ) DESC,
                id DESC
        ';


        $consulta =
            $this->pdo
                ->prepare($sql);


        $consulta->bindValue(
            ':cliente_id',
            $clienteId,
            PDO::PARAM_INT
        );


        $consulta->execute();


        $dispositivos =
            $consulta->fetchAll(
                PDO::FETCH_ASSOC
            );


        return is_array($dispositivos)
            ? $dispositivos
            : [];
    }


    /*
    |--------------------------------------------------------------------------
    | Desativa um dispositivo
    |--------------------------------------------------------------------------
    |
    | Método preparado para uma futura ação:
    | "Desativar notificações deste dispositivo".
    |
    */
    public function desativarDispositivo(
        int $dispositivoId,
        int $clienteId
    ): bool {

        $sql = '
            UPDATE dispositivos_notificacao

            SET
                ativo = 0,
                atualizado_em = NOW()

            WHERE id = :dispositivo_id
              AND cliente_id = :cliente_id
        ';


        $consulta =
            $this->pdo
                ->prepare($sql);


        $consulta->bindValue(
            ':dispositivo_id',
            $dispositivoId,
            PDO::PARAM_INT
        );


        $consulta->bindValue(
            ':cliente_id',
            $clienteId,
            PDO::PARAM_INT
        );


        $consulta->execute();


        return $consulta->rowCount() > 0;
    }
}
