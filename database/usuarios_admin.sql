CREATE TABLE IF NOT EXISTS usuarios_admin (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    nome VARCHAR(150) NOT NULL,

    email VARCHAR(180) NOT NULL,

    senha_hash VARCHAR(255) NOT NULL,

    status ENUM('ativo', 'inativo')
        NOT NULL DEFAULT 'ativo',

    ultimo_acesso DATETIME NULL,

    criado_em TIMESTAMP
        NOT NULL DEFAULT CURRENT_TIMESTAMP,

    atualizado_em TIMESTAMP
        NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT uq_usuarios_admin_email
        UNIQUE (email)
) ENGINE=InnoDB;
