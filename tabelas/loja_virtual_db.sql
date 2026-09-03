-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Tempo de geração: 03/09/2026 às 19:02
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `loja_virtual_db`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `carrinhos`
--

CREATE TABLE `carrinhos` (
  `id` int(10) UNSIGNED NOT NULL,
  `cliente_id` int(10) UNSIGNED DEFAULT NULL,
  `token_sessao` char(64) DEFAULT NULL,
  `status` enum('aberto','convertido','abandonado') NOT NULL DEFAULT 'aberto',
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `carrinhos`
--

INSERT INTO `carrinhos` (`id`, `cliente_id`, `token_sessao`, `status`, `criado_em`, `atualizado_em`) VALUES
(7, 1, 'c00d16e77d08acd2a27886191184f3d0eac59ba2a9472ec9ed4217a72fe09a3e', 'aberto', '2026-08-25 19:02:26', '2026-08-25 19:02:26'),
(8, 1, '8f3529ad975864adee429d55e0bae7b6c06dd6d04d19b6885ae6be434cc92a76', 'aberto', '2026-08-26 17:29:56', '2026-08-26 19:23:12'),
(9, 1, '1c8b4202445bf1279b13c0865c33837baca4b55763c962587eddecf02cfd4af4', 'aberto', '2026-08-27 16:07:59', '2026-08-27 17:38:54'),
(10, NULL, '4652836c38949bd28daea21b2bb92e9405e6d0d58a7867881ff6b643a830b10b', 'aberto', '2026-08-28 16:07:52', '2026-08-28 16:07:52'),
(11, NULL, 'da8d0fdbf5aa023b6e0fba901fc204c8bd9f02c3c7a16449a5ba8b362e12f038', 'aberto', '2026-08-31 16:08:34', '2026-08-31 16:08:34'),
(12, NULL, '7fcc33b345b59dadddca9dec0a071db4d032b7bf1be2ac25a2fcbb40c27008f7', 'aberto', '2026-09-02 17:32:24', '2026-09-02 17:32:24'),
(13, NULL, 'fe6cd7778501a5f9fda28b756d80af82a4c787cee51783bccdabc5154c9b7f00', 'aberto', '2026-09-02 18:26:57', '2026-09-02 18:26:57'),
(14, NULL, 'a172888ef44ecac684df8ec1f0288fe12dd3230412c0fa79a4cdd9b360cf5521', 'aberto', '2026-09-02 19:14:59', '2026-09-02 19:14:59'),
(15, NULL, '48b78a90296b8afd7a414f550b4ed550628b8bec59f012a8775721a590d0163d', 'aberto', '2026-09-03 16:04:42', '2026-09-03 16:04:42');

-- --------------------------------------------------------

--
-- Estrutura para tabela `carrinho_itens`
--

CREATE TABLE `carrinho_itens` (
  `id` int(10) UNSIGNED NOT NULL,
  `carrinho_id` int(10) UNSIGNED NOT NULL,
  `produto_id` int(10) UNSIGNED NOT NULL,
  `quantidade` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `preco_unitario` decimal(10,2) UNSIGNED NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `carrinho_itens`
--

INSERT INTO `carrinho_itens` (`id`, `carrinho_id`, `produto_id`, `quantidade`, `preco_unitario`, `criado_em`, `atualizado_em`) VALUES
(24, 7, 1, 1, 3299.90, '2026-08-25 19:02:28', '2026-08-25 19:02:28'),
(25, 9, 1, 1, 3299.90, '2026-08-27 17:39:04', '2026-08-27 17:39:04');

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias`
--

CREATE TABLE `categorias` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome` varchar(100) NOT NULL,
  `imgcategoria` varchar(150) DEFAULT NULL,
  `slug` varchar(120) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `categorias`
--

INSERT INTO `categorias` (`id`, `nome`, `imgcategoria`, `slug`, `descricao`, `ativo`, `criado_em`, `atualizado_em`) VALUES
(1, 'Informática', 'informatica.webp', 'informatica', 'Computadores, notebooks, monitores, componentes e equipamentos de informática.', 1, '2026-08-11 17:47:39', '2026-08-11 17:47:39'),
(2, 'Celulares', 'celulares.webp', 'celulares', 'Smartphones e dispositivos móveis para comunicação e entretenimento.', 1, '2026-08-11 17:47:39', '2026-08-11 17:47:39'),
(3, 'Acessórios', 'acessorios.webp', 'acessorios', 'Acessórios para computadores, celulares e dispositivos eletrônicos.', 1, '2026-08-11 17:47:39', '2026-08-11 17:47:39'),
(4, 'Casa e Decoração', 'casa-decoracao.webp', 'casa-decoracao', 'Produtos para organização, conforto, iluminação e decoração da casa.', 1, '2026-08-11 17:47:39', '2026-08-11 17:47:39'),
(5, 'teste1010', 'teste', 'teste1010', 'descricao teste', 0, '2026-08-14 19:16:53', '2026-08-31 18:02:37');

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
--

CREATE TABLE `clientes` (
  `id` int(10) UNSIGNED NOT NULL,
  `google_sub` varchar(255) DEFAULT NULL,
  `nome` varchar(150) NOT NULL,
  `cpf` char(11) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `email` varchar(180) NOT NULL,
  `senha_hash` varchar(255) DEFAULT NULL,
  `foto_url` varchar(500) DEFAULT NULL,
  `email_verificado` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('ativo','inativo','bloqueado') NOT NULL DEFAULT 'ativo',
  `newsletter` tinyint(1) NOT NULL DEFAULT 0,
  `aceitou_termos_em` datetime DEFAULT NULL,
  `ultimo_acesso` datetime DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `clientes`
--

INSERT INTO `clientes` (`id`, `google_sub`, `nome`, `cpf`, `data_nascimento`, `telefone`, `email`, `senha_hash`, `foto_url`, `email_verificado`, `status`, `newsletter`, `aceitou_termos_em`, `ultimo_acesso`, `criado_em`, `atualizado_em`) VALUES
(1, NULL, 'Eugênio Márcio', '08230437033', '1971-03-07', '85997810324', 'professoreugeniomls@gmail.com', '$2y$10$/s2gCh2ndrq9LQMc1IOXKewjatdKgKL4DWoHSwpaB53fLGwWseBcu', NULL, 0, 'ativo', 1, '2026-08-14 17:18:27', '2026-08-28 17:02:08', '2026-08-14 20:18:27', '2026-08-28 20:02:08'),
(2, NULL, 'tetse', '123456789', '1971-03-07', '8599785858', 'edesignercriacoes@gmail.com', '$2y$10$bs686y3A9.2mdQ2dkpNJtuILfdFpRcVOAK7275t/StLGQ3J9bt0BK', NULL, 0, 'inativo', 1, '2026-08-19 15:44:39', '2026-08-19 16:06:10', '2026-08-19 18:44:39', '2026-08-28 20:15:45');

-- --------------------------------------------------------

--
-- Estrutura para tabela `configuracoes`
--

CREATE TABLE `configuracoes` (
  `id` int(10) UNSIGNED NOT NULL,
  `nomedosite` varchar(150) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `keywords` varchar(500) DEFAULT NULL,
  `slogan` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `telefone` varchar(30) DEFAULT NULL,
  `whatsapp` varchar(30) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `tiktok` varchar(255) DEFAULT NULL,
  `sitemanutencao` tinyint(1) NOT NULL DEFAULT 0,
  `sitestandby` tinyint(1) NOT NULL DEFAULT 0,
  `mensagemmanutencao` text DEFAULT NULL,
  `mensagemstandby` text DEFAULT NULL,
  `titulo_seo` varchar(255) DEFAULT NULL,
  `descricao_seo` varchar(320) DEFAULT NULL,
  `google_analytics` varchar(100) DEFAULT NULL,
  `google_tag_manager` varchar(100) DEFAULT NULL,
  `facebook_pixel` varchar(100) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `estado` char(2) DEFAULT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `moeda` char(3) NOT NULL DEFAULT 'BRL',
  `frete_gratis_valor` decimal(10,2) DEFAULT NULL,
  `criado_em` datetime NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dispositivos_notificacao`
--

CREATE TABLE `dispositivos_notificacao` (
  `id` int(10) UNSIGNED NOT NULL,
  `cliente_id` int(10) UNSIGNED NOT NULL,
  `token_fcm` varchar(512) NOT NULL,
  `plataforma` varchar(30) NOT NULL DEFAULT 'web',
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `ultimo_acesso` datetime DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `enderecos`
--

CREATE TABLE `enderecos` (
  `id` int(10) UNSIGNED NOT NULL,
  `cliente_id` int(10) UNSIGNED NOT NULL,
  `identificacao` varchar(80) NOT NULL DEFAULT 'Endereço principal',
  `destinatario` varchar(150) NOT NULL,
  `cep` varchar(9) NOT NULL,
  `logradouro` varchar(180) NOT NULL,
  `numero` varchar(20) NOT NULL,
  `complemento` varchar(120) DEFAULT NULL,
  `bairro` varchar(120) NOT NULL,
  `cidade` varchar(120) NOT NULL,
  `estado` char(2) NOT NULL,
  `principal` tinyint(1) NOT NULL DEFAULT 0,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `enderecos`
--

INSERT INTO `enderecos` (`id`, `cliente_id`, `identificacao`, `destinatario`, `cep`, `logradouro`, `numero`, `complemento`, `bairro`, `cidade`, `estado`, `principal`, `criado_em`, `atualizado_em`) VALUES
(1, 1, 'Endereço principal', 'Eugênio MLS SOUSA', '61925480', 'rua tal xyz VUW', '1234', 'teste', 'teste', 'teste', 'CE', 0, '2026-08-14 20:18:27', '2026-08-27 17:01:34'),
(2, 2, 'Endereço principal', 'tetse', '61925-480', 'R. Dezenove A', '42', 'tal e tal', 'Industrial', 'Maracanaú', 'CE', 1, '2026-08-19 18:44:39', '2026-08-19 18:44:39'),
(4, 1, 'Casa', 'Francisca Lins de sousa', '61925-480', 'R. Dezenove A', '42', 'A SQP BLOCO A', 'Industrial', 'Maracanaú', 'CE', 0, '2026-08-27 16:10:21', '2026-08-27 16:24:36');

-- --------------------------------------------------------

--
-- Estrutura para tabela `movimentacoes_estoque`
--

CREATE TABLE `movimentacoes_estoque` (
  `id` int(10) UNSIGNED NOT NULL,
  `produto_id` int(10) UNSIGNED NOT NULL,
  `pedido_id` int(10) UNSIGNED DEFAULT NULL,
  `tipo` enum('entrada','saida','ajuste','reserva','devolucao') NOT NULL,
  `quantidade` int(10) UNSIGNED NOT NULL,
  `saldo_anterior` int(10) UNSIGNED NOT NULL,
  `saldo_posterior` int(10) UNSIGNED NOT NULL,
  `observacao` varchar(500) DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pagamentos`
--

CREATE TABLE `pagamentos` (
  `id` int(10) UNSIGNED NOT NULL,
  `pedido_id` int(10) UNSIGNED NOT NULL,
  `provedor` varchar(50) NOT NULL DEFAULT 'mercadopago',
  `pagamento_externo_id` varchar(120) DEFAULT NULL,
  `metodo` enum('pix','cartao') NOT NULL,
  `status` enum('pendente','aprovado','recusado','cancelado','reembolsado') NOT NULL DEFAULT 'pendente',
  `valor` decimal(10,2) UNSIGNED NOT NULL,
  `pix_copia_cola` text DEFAULT NULL,
  `expira_em` datetime DEFAULT NULL,
  `aprovado_em` datetime DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(10) UNSIGNED NOT NULL,
  `codigo` varchar(40) NOT NULL,
  `cliente_id` int(10) UNSIGNED NOT NULL,
  `status` enum('aguardando_pagamento','pago','em_separacao','enviado','entregue','cancelado') NOT NULL DEFAULT 'aguardando_pagamento',
  `subtotal` decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `frete` decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `desconto` decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `observacao` varchar(500) DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedido_enderecos`
--

CREATE TABLE `pedido_enderecos` (
  `id` int(10) UNSIGNED NOT NULL,
  `pedido_id` int(10) UNSIGNED NOT NULL,
  `destinatario` varchar(150) NOT NULL,
  `cep` varchar(9) NOT NULL,
  `logradouro` varchar(180) NOT NULL,
  `numero` varchar(20) NOT NULL,
  `complemento` varchar(120) DEFAULT NULL,
  `bairro` varchar(120) NOT NULL,
  `cidade` varchar(120) NOT NULL,
  `estado` char(2) NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedido_itens`
--

CREATE TABLE `pedido_itens` (
  `id` int(10) UNSIGNED NOT NULL,
  `pedido_id` int(10) UNSIGNED NOT NULL,
  `produto_id` int(10) UNSIGNED NOT NULL,
  `nome_produto` varchar(150) NOT NULL,
  `quantidade` int(10) UNSIGNED NOT NULL,
  `preco_unitario` decimal(10,2) UNSIGNED NOT NULL,
  `subtotal` decimal(10,2) UNSIGNED NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(10) UNSIGNED NOT NULL,
  `categoria_id` int(10) UNSIGNED NOT NULL,
  `nome` varchar(150) NOT NULL,
  `slug` varchar(180) NOT NULL,
  `descricao` text DEFAULT NULL,
  `preco` decimal(10,2) UNSIGNED NOT NULL,
  `oferta_ativa` tinyint(1) NOT NULL DEFAULT 0,
  `percentual_oferta` decimal(5,2) DEFAULT NULL,
  `oferta_inicio` datetime DEFAULT NULL,
  `oferta_fim` datetime DEFAULT NULL,
  `estoque` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` enum('ativo','inativo') NOT NULL DEFAULT 'ativo',
  `destaque` tinyint(1) NOT NULL DEFAULT 0,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `categoria_id`, `nome`, `slug`, `descricao`, `preco`, `oferta_ativa`, `percentual_oferta`, `oferta_inicio`, `oferta_fim`, `estoque`, `status`, `destaque`, `criado_em`, `atualizado_em`) VALUES
(1, 1, 'Notebook Core i5 16GB SSD 512GB', 'notebook-core-i5-16gb-ssd-512gb', 'Notebook com processador Intel Core i5, 16GB de memória RAM e SSD de 512GB.', 3299.90, 1, 15.00, '2026-08-17 16:08:02', '2026-08-24 17:08:02', 15, 'ativo', 1, '2026-08-11 17:47:39', '2026-08-17 19:10:03'),
(2, 1, 'Notebook Ryzen 5 8GB SSD 512GB', 'notebook-ryzen-5-8gb-ssd-512gb', 'Notebook com processador AMD Ryzen 5, 8GB de memória RAM e SSD de 512GB.', 2899.90, 1, 15.00, '2026-08-17 16:30:05', '2026-08-24 16:30:05', 12, 'ativo', 1, '2026-08-11 17:47:39', '2026-08-17 19:30:05'),
(3, 1, 'Computador Desktop Core i5 16GB', 'computador-desktop-core-i5-16gb', 'Computador desktop com processador Core i5, 16GB de memória RAM e SSD.', 2499.90, 1, 15.00, '2026-08-17 16:30:00', '2026-08-24 16:30:00', 10, 'ativo', 0, '2026-08-11 17:47:39', '2026-08-24 19:32:26'),
(4, 1, 'Monitor LED 24 Polegadas Full HD', 'monitor-led-24-full-hd', 'Monitor LED de 24 polegadas com resolução Full HD e conexão HDMI.', 699.90, 0, NULL, NULL, NULL, 25, 'ativo', 1, '2026-08-11 17:47:39', '2026-08-11 17:47:39'),
(5, 1, 'Monitor Gamer 27 Polegadas 165Hz', 'monitor-gamer-27-165hz', 'Monitor gamer de 27 polegadas com frequência de atualização de 165Hz.', 1399.90, 0, NULL, NULL, NULL, 8, 'ativo', 1, '2026-08-11 17:47:39', '2026-08-11 17:47:39'),
(6, 1, 'SSD 480GB SATA', 'ssd-480gb-sata', 'Unidade de armazenamento SSD SATA com capacidade de 480GB.', 249.90, 0, NULL, NULL, NULL, 35, 'ativo', 0, '2026-08-11 17:47:39', '2026-08-11 17:47:39'),
(7, 1, 'SSD NVMe 1TB', 'ssd-nvme-1tb', 'SSD NVMe de alto desempenho com capacidade de armazenamento de 1TB.', 449.90, 0, NULL, NULL, NULL, 22, 'ativo', 1, '2026-08-11 17:47:39', '2026-08-11 17:47:39'),
(8, 1, 'Memória RAM DDR4 8GB', 'memoria-ram-ddr4-8gb', 'Memória RAM DDR4 de 8GB para computadores desktop.', 179.90, 0, NULL, NULL, NULL, 40, 'ativo', 0, '2026-08-11 17:47:39', '2026-08-11 17:47:39'),
(9, 1, 'Memória RAM DDR4 16GB', 'memoria-ram-ddr4-16gb', 'Memória RAM DDR4 de 16GB para expansão de computadores.', 299.90, 0, NULL, NULL, NULL, 28, 'ativo', 0, '2026-08-11 17:47:39', '2026-08-11 17:47:39'),
(10, 1, 'Roteador Wi-Fi Dual Band', 'roteador-wifi-dual-band', 'Roteador Wi-Fi Dual Band para redes domésticas e pequenos escritórios.', 289.90, 0, NULL, NULL, NULL, 18, 'ativo', 0, '2026-08-11 17:47:39', '2026-08-11 17:47:39'),
(11, 2, 'Smartphone 128GB 6GB RAM Preto', 'smartphone-128gb-6gb-preto', 'Smartphone com armazenamento de 128GB, 6GB de memória RAM e câmera de alta resolução.', 1299.90, 0, NULL, NULL, NULL, 20, 'ativo', 1, '2026-08-11 17:47:39', '2026-08-11 17:47:39'),
(12, 2, 'Smartphone 256GB 8GB RAM Azul', 'smartphone-256gb-8gb-azul', 'Smartphone com 256GB de armazenamento, 8GB de RAM e tela de alta definição.', 1899.90, 0, NULL, NULL, NULL, 16, 'ativo', 1, '2026-08-11 17:47:39', '2026-08-11 17:47:39'),
(13, 2, 'Smartphone 5G 128GB', 'smartphone-5g-128gb', 'Smartphone compatível com redes 5G e armazenamento interno de 128GB.', 1599.90, 0, NULL, NULL, NULL, 25, 'ativo', 1, '2026-08-11 17:47:39', '2026-08-11 17:47:39'),
(14, 2, 'Smartphone 5G 256GB', 'smartphone-5g-256gb', 'Smartphone 5G com armazenamento de 256GB e câmera traseira de alta resolução.', 2199.90, 0, NULL, NULL, NULL, 14, 'ativo', 1, '2026-08-11 17:47:39', '2026-08-11 17:47:39'),
(15, 2, 'Smartphone Tela 6.5 128GB', 'smartphone-tela-6-5-128gb', 'Smartphone com tela de 6.5 polegadas e armazenamento de 128GB.', 1099.90, 0, NULL, NULL, NULL, 30, 'ativo', 0, '2026-08-11 17:47:39', '2026-08-11 17:47:39'),
(16, 2, 'Smartphone Tela AMOLED 256GB', 'smartphone-tela-amoled-256gb', 'Smartphone com tela AMOLED e armazenamento interno de 256GB.', 2499.90, 0, NULL, NULL, NULL, 11, 'ativo', 1, '2026-08-11 17:47:39', '2026-08-11 17:47:39'),
(17, 2, 'Smartphone Dual SIM 128GB', 'smartphone-dual-sim-128gb', 'Smartphone com suporte para dois chips e armazenamento interno de 128GB.', 999.90, 0, NULL, NULL, NULL, 24, 'ativo', 0, '2026-08-11 17:47:39', '2026-08-11 17:47:39'),
(18, 2, 'Smartphone 64GB Tela 6.4', 'smartphone-64gb-tela-6-4', 'Smartphone de entrada com armazenamento de 64GB e tela de 6.4 polegadas.', 749.90, 0, NULL, NULL, NULL, 35, 'ativo', 0, '2026-08-11 17:47:39', '2026-08-11 17:47:39'),
(19, 2, 'Smartphone Premium 512GB', 'smartphone-premium-512gb', 'Smartphone premium com armazenamento de 512GB, câmera avançada e conexão 5G.', 4299.90, 0, NULL, NULL, NULL, 6, 'ativo', 1, '2026-08-11 17:47:39', '2026-08-11 17:47:39'),
(20, 2, 'Smartphone Compacto 128GB', 'smartphone-compacto-128gb', 'Smartphone compacto com 128GB de armazenamento e câmera dupla.', 1199.90, 0, NULL, NULL, NULL, 19, 'ativo', 0, '2026-08-11 17:47:39', '2026-08-11 17:47:39'),
(21, 3, 'Mouse Sem Fio USB', 'mouse-sem-fio-usb', 'Mouse sem fio com conexão USB e design ergonômico.', 79.90, 0, NULL, NULL, NULL, 50, 'ativo', 0, '2026-08-11 17:47:39', '2026-08-11 17:47:39'),
(22, 3, 'Mouse Gamer RGB 7200 DPI', 'mouse-gamer-rgb-7200-dpi', 'Mouse gamer com iluminação RGB e resolução ajustável de até 7200 DPI.', 149.90, 0, NULL, NULL, NULL, 30, 'ativo', 1, '2026-08-11 17:47:39', '2026-08-11 17:47:39'),
(23, 3, 'Teclado Mecânico RGB', 'teclado-mecanico-rgb', 'Teclado mecânico com iluminação RGB e teclas de alta durabilidade.', 289.90, 0, NULL, NULL, NULL, 22, 'ativo', 1, '2026-08-11 17:47:39', '2026-08-11 17:47:39'),
(24, 3, 'Teclado Sem Fio', 'teclado-sem-fio', 'Teclado compacto sem fio para computadores e notebooks.', 119.90, 0, NULL, NULL, NULL, 32, 'ativo', 0, '2026-08-11 17:47:39', '2026-08-11 17:47:39'),
(25, 3, 'Headset Gamer com Microfone', 'headset-gamer-com-microfone', 'Headset gamer com microfone integrado e controle de volume.', 199.90, 0, NULL, NULL, NULL, 26, 'ativo', 1, '2026-08-11 17:47:39', '2026-08-11 17:47:39'),
(26, 3, 'Webcam Full HD USB', 'webcam-full-hd-usb', 'Webcam Full HD com microfone integrado e conexão USB.', 229.90, 0, NULL, NULL, NULL, 17, 'ativo', 0, '2026-08-11 17:47:39', '2026-08-11 17:47:39'),
(27, 3, 'Carregador USB-C 30W', 'carregador-usb-c-30w', 'Carregador rápido USB-C com potência de 30 watts.', 99.90, 0, NULL, NULL, NULL, 45, 'ativo', 0, '2026-08-11 17:47:39', '2026-08-11 17:47:39'),
(28, 3, 'Power Bank 10000mAh', 'power-bank-10000mah', 'Bateria portátil com capacidade de 10000mAh e duas portas USB.', 139.90, 0, NULL, NULL, NULL, 34, 'ativo', 1, '2026-08-11 17:47:39', '2026-08-11 17:47:39'),
(29, 3, 'Hub USB 4 Portas', 'hub-usb-4-portas', 'Hub USB com quatro portas para expansão de conexões.', 69.90, 0, NULL, NULL, NULL, 38, 'ativo', 0, '2026-08-11 17:47:39', '2026-08-11 17:47:39'),
(30, 3, 'Suporte Ajustável para Notebook', 'suporte-ajustavel-notebook', 'Suporte ajustável e ergonômico para notebooks.', 109.90, 0, NULL, NULL, NULL, 27, 'ativo', 0, '2026-08-11 17:47:39', '2026-08-11 17:47:39'),
(31, 4, 'Luminária LED de Mesa', 'luminaria-led-de-mesa', 'Luminária LED de mesa com ajuste de intensidade e braço articulado.', 129.90, 0, NULL, NULL, NULL, 25, 'ativo', 1, '2026-08-11 17:47:39', '2026-08-11 17:47:39'),
(32, 4, 'Lâmpada Inteligente Wi-Fi', 'lampada-inteligente-wifi', 'Lâmpada inteligente com conexão Wi-Fi e controle por aplicativo.', 89.90, 0, NULL, NULL, NULL, 40, 'ativo', 1, '2026-08-11 17:47:39', '2026-08-11 17:47:39'),
(33, 4, 'Fita LED RGB 5 Metros', 'fita-led-rgb-5-metros', 'Fita LED RGB de cinco metros com controle remoto.', 79.90, 0, NULL, NULL, NULL, 35, 'ativo', 0, '2026-08-11 17:47:39', '2026-08-11 17:47:39'),
(34, 4, 'Relógio Digital LED', 'relogio-digital-led', 'Relógio digital com display LED para mesa ou cabeceira.', 99.90, 0, NULL, NULL, NULL, 22, 'ativo', 0, '2026-08-11 17:47:39', '2026-08-11 17:47:39'),
(35, 4, 'Difusor de Aromas USB', 'difusor-de-aromas-usb', 'Difusor compacto para aromatização de ambientes com alimentação USB.', 89.90, 0, NULL, NULL, NULL, 30, 'ativo', 0, '2026-08-11 17:47:39', '2026-08-11 17:47:39'),
(36, 4, 'Ventilador de Mesa Compacto', 'ventilador-de-mesa-compacto', 'Ventilador compacto para mesa com múltiplas velocidades.', 149.90, 0, NULL, NULL, NULL, 18, 'ativo', 1, '2026-08-11 17:47:39', '2026-08-11 17:47:39'),
(37, 4, 'Organizador de Mesa Multiuso', 'organizador-de-mesa-multiuso', 'Organizador para materiais de escritório, acessórios e objetos pessoais.', 59.90, 0, NULL, NULL, NULL, 42, 'ativo', 0, '2026-08-11 17:47:39', '2026-08-11 17:47:39'),
(38, 4, 'Balança Digital para Cozinha', 'balanca-digital-cozinha', 'Balança digital compacta para pesagem de alimentos.', 79.90, 0, NULL, NULL, NULL, 28, 'ativo', 0, '2026-08-11 17:47:39', '2026-08-11 17:47:39'),
(39, 4, 'Porta Retrato Digital', 'porta-retrato-digital', 'Porta retrato digital para exibição automática de fotografias.', 349.90, 0, NULL, NULL, NULL, 12, 'ativo', 1, '2026-08-11 17:47:39', '2026-08-11 17:47:39'),
(40, 4, 'Abajur LED Touch', 'abajur-led-touch', 'Abajur LED com acionamento por toque e níveis de iluminação.', 119.90, 1, 15.00, '2026-08-31 16:32:00', '2026-09-04 16:32:00', 20, 'ativo', 1, '2026-08-11 17:47:39', '2026-08-28 19:32:12');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto_imagens`
--

CREATE TABLE `produto_imagens` (
  `id` int(10) UNSIGNED NOT NULL,
  `produto_id` int(10) UNSIGNED NOT NULL,
  `url_imagem` varchar(500) NOT NULL,
  `texto_alternativo` varchar(255) DEFAULT NULL,
  `principal` tinyint(1) NOT NULL DEFAULT 0,
  `ordem` smallint(5) UNSIGNED NOT NULL DEFAULT 1,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `produto_imagens`
--

INSERT INTO `produto_imagens` (`id`, `produto_id`, `url_imagem`, `texto_alternativo`, `principal`, `ordem`, `criado_em`) VALUES
(10, 40, 'imagens/produtos/abajur-led-touch_1787935484_40_4.webp', 'Abajur LED Touch', 1, 1, '2026-08-28 16:44:44'),
(11, 40, 'imagens/produtos/abajur-led-touch_1787935485_40_4.webp', 'Abajur LED Touch', 0, 2, '2026-08-28 16:44:44'),
(12, 40, 'imagens/produtos/abajur-led-touch_1787935486_40_4.webp', 'Abajur LED Touch', 0, 3, '2026-08-28 16:44:45');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios_admin`
--

CREATE TABLE `usuarios_admin` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome` varchar(150) NOT NULL,
  `email` varchar(180) NOT NULL,
  `senha_hash` varchar(255) NOT NULL,
  `status` enum('ativo','inativo') NOT NULL DEFAULT 'ativo',
  `ultimo_acesso` datetime DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `usuarios_admin`
--

INSERT INTO `usuarios_admin` (`id`, `nome`, `email`, `senha_hash`, `status`, `ultimo_acesso`, `criado_em`, `atualizado_em`) VALUES
(1, 'Professor Eugênio', 'professoreugeniomls@gmail.com', '$2y$10$Vx407iuQ2RkUqqBd3I07..iOu.zWW2jnwareqYRcntXV7r/QiYtyK', 'ativo', '2026-09-02 16:14:35', '2026-07-30 15:43:30', '2026-09-02 19:14:35'),
(2, 'Admin', 'admin@admin.com', '$2y$10$lJz5JNpabVU.92I/OK2Ry.O9fpr6v0xs0eJvwUbgjW6cm30mv55CW', 'ativo', '2026-08-10 13:13:38', '2026-08-03 16:15:18', '2026-08-10 16:13:38');

-- --------------------------------------------------------

--
-- Estrutura para tabela `webhook_logs`
--

CREATE TABLE `webhook_logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `provedor` varchar(50) NOT NULL,
  `evento` varchar(100) NOT NULL,
  `identificador_externo` varchar(120) DEFAULT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`payload`)),
  `processado` tinyint(1) NOT NULL DEFAULT 0,
  `tentativas` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `erro` text DEFAULT NULL,
  `recebido_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `processado_em` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `carrinhos`
--
ALTER TABLE `carrinhos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_carrinhos_token` (`token_sessao`),
  ADD KEY `idx_carrinhos_cliente` (`cliente_id`),
  ADD KEY `idx_carrinhos_status` (`status`);

--
-- Índices de tabela `carrinho_itens`
--
ALTER TABLE `carrinho_itens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_carrinho_produto` (`carrinho_id`,`produto_id`),
  ADD KEY `idx_carrinho_itens_carrinho` (`carrinho_id`),
  ADD KEY `idx_carrinho_itens_produto` (`produto_id`);

--
-- Índices de tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_categorias_nome` (`nome`),
  ADD UNIQUE KEY `uq_categorias_slug` (`slug`);

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_clientes_email` (`email`),
  ADD UNIQUE KEY `uq_clientes_google_sub` (`google_sub`),
  ADD UNIQUE KEY `uq_clientes_cpf` (`cpf`);

--
-- Índices de tabela `configuracoes`
--
ALTER TABLE `configuracoes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `dispositivos_notificacao`
--
ALTER TABLE `dispositivos_notificacao`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_dispositivos_token` (`token_fcm`),
  ADD KEY `idx_dispositivos_cliente` (`cliente_id`),
  ADD KEY `idx_dispositivos_ativo` (`ativo`);

--
-- Índices de tabela `enderecos`
--
ALTER TABLE `enderecos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_enderecos_cliente` (`cliente_id`),
  ADD KEY `idx_enderecos_cep` (`cep`);

--
-- Índices de tabela `movimentacoes_estoque`
--
ALTER TABLE `movimentacoes_estoque`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_movimentacoes_produto` (`produto_id`),
  ADD KEY `idx_movimentacoes_pedido` (`pedido_id`),
  ADD KEY `idx_movimentacoes_tipo` (`tipo`);

--
-- Índices de tabela `pagamentos`
--
ALTER TABLE `pagamentos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_pagamentos_externo` (`pagamento_externo_id`),
  ADD KEY `idx_pagamentos_pedido` (`pedido_id`),
  ADD KEY `idx_pagamentos_status` (`status`);

--
-- Índices de tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_pedidos_codigo` (`codigo`),
  ADD KEY `idx_pedidos_cliente` (`cliente_id`),
  ADD KEY `idx_pedidos_status` (`status`),
  ADD KEY `idx_pedidos_criado_em` (`criado_em`);

--
-- Índices de tabela `pedido_enderecos`
--
ALTER TABLE `pedido_enderecos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_pedido_endereco` (`pedido_id`);

--
-- Índices de tabela `pedido_itens`
--
ALTER TABLE `pedido_itens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_pedido_itens_pedido` (`pedido_id`),
  ADD KEY `idx_pedido_itens_produto` (`produto_id`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_produtos_slug` (`slug`),
  ADD KEY `idx_produtos_categoria` (`categoria_id`),
  ADD KEY `idx_produtos_nome` (`nome`),
  ADD KEY `idx_produtos_status` (`status`);

--
-- Índices de tabela `produto_imagens`
--
ALTER TABLE `produto_imagens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_imagens_produto` (`produto_id`);

--
-- Índices de tabela `usuarios_admin`
--
ALTER TABLE `usuarios_admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_usuarios_admin_email` (`email`);

--
-- Índices de tabela `webhook_logs`
--
ALTER TABLE `webhook_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_webhook_provedor` (`provedor`),
  ADD KEY `idx_webhook_evento` (`evento`),
  ADD KEY `idx_webhook_externo` (`identificador_externo`),
  ADD KEY `idx_webhook_processado` (`processado`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `carrinhos`
--
ALTER TABLE `carrinhos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `carrinho_itens`
--
ALTER TABLE `carrinho_itens`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `configuracoes`
--
ALTER TABLE `configuracoes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `dispositivos_notificacao`
--
ALTER TABLE `dispositivos_notificacao`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `enderecos`
--
ALTER TABLE `enderecos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `movimentacoes_estoque`
--
ALTER TABLE `movimentacoes_estoque`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pagamentos`
--
ALTER TABLE `pagamentos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pedido_enderecos`
--
ALTER TABLE `pedido_enderecos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pedido_itens`
--
ALTER TABLE `pedido_itens`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de tabela `produto_imagens`
--
ALTER TABLE `produto_imagens`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `usuarios_admin`
--
ALTER TABLE `usuarios_admin`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `webhook_logs`
--
ALTER TABLE `webhook_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `carrinhos`
--
ALTER TABLE `carrinhos`
  ADD CONSTRAINT `fk_carrinhos_clientes` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `carrinho_itens`
--
ALTER TABLE `carrinho_itens`
  ADD CONSTRAINT `fk_carrinho_itens_carrinhos` FOREIGN KEY (`carrinho_id`) REFERENCES `carrinhos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_carrinho_itens_produtos` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `dispositivos_notificacao`
--
ALTER TABLE `dispositivos_notificacao`
  ADD CONSTRAINT `fk_dispositivos_clientes` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `enderecos`
--
ALTER TABLE `enderecos`
  ADD CONSTRAINT `fk_enderecos_clientes` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `movimentacoes_estoque`
--
ALTER TABLE `movimentacoes_estoque`
  ADD CONSTRAINT `fk_movimentacoes_pedidos` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_movimentacoes_produtos` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `pagamentos`
--
ALTER TABLE `pagamentos`
  ADD CONSTRAINT `fk_pagamentos_pedidos` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_pedidos_clientes` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `pedido_enderecos`
--
ALTER TABLE `pedido_enderecos`
  ADD CONSTRAINT `fk_pedido_enderecos_pedidos` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `pedido_itens`
--
ALTER TABLE `pedido_itens`
  ADD CONSTRAINT `fk_pedido_itens_pedidos` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pedido_itens_produtos` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `fk_produtos_categorias` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `produto_imagens`
--
ALTER TABLE `produto_imagens`
  ADD CONSTRAINT `fk_imagens_produtos` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
