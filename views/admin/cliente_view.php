<?php

declare(strict_types=1);

use App\Helpers\View;

$baseUrl = defined('BASE_URL') ? BASE_URL : '';

$cliente = is_array($cliente ?? null) ? $cliente : [];
$enderecos = is_array($enderecos ?? null) ? $enderecos : [];
$pedidos = is_array($pedidos ?? null) ? $pedidos : [];
$carrinhosAbertos = is_array($carrinhosAbertos ?? null) ? $carrinhosAbertos : [];

$e = static fn(mixed $valor): string =>
    htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');

$formatarData = static function (?string $valor, bool $comHora = false): string {
    if ($valor === null || trim($valor) === '') {
        return 'Não informado';
    }

    $timestamp = strtotime($valor);

    if ($timestamp === false) {
        return $valor;
    }

    return date($comHora ? 'd/m/Y H:i' : 'd/m/Y', $timestamp);
};

$formatarCpf = static function (?string $cpf): string {
    $cpf = preg_replace('/\D+/', '', (string) $cpf) ?? '';

    if (strlen($cpf) !== 11) {
        return $cpf !== '' ? $cpf : 'Não informado';
    }

    return substr($cpf, 0, 3) . '.'
        . substr($cpf, 3, 3) . '.'
        . substr($cpf, 6, 3) . '-'
        . substr($cpf, 9, 2);
};

$badgeCliente = match ((string) ($cliente['status'] ?? '')) {
    'ativo' => 'bg-success',
    'inativo' => 'bg-secondary',
    'bloqueado' => 'bg-danger',
    default => 'bg-dark',
};

$statusPedido = static function (string $status): array {
    return match ($status) {
        'aguardando_pagamento' => ['Aguardando pagamento', 'bg-warning text-dark'],
        'pago' => ['Pago', 'bg-success'],
        'em_separacao' => ['Em separação', 'bg-info text-dark'],
        'enviado' => ['Enviado', 'bg-primary'],
        'entregue' => ['Entregue', 'bg-success'],
        'cancelado' => ['Cancelado', 'bg-danger'],
        default => [ucfirst(str_replace('_', ' ', $status)), 'bg-secondary'],
    };
};
?>
<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cliente | Loja Online</title>
    <base href="/loja_online/public/">

    <link rel="icon" href="assets/img/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= $e($baseUrl . '/assets/css/admin.css') ?>">
</head>

<body>
    <?php View::componenteAdmin('aside'); ?>

    <div class="main-wrapper">
        <?php View::componenteAdmin('header'); ?>

        <main class="content-area p-4">
            <div class="container-fluid p-0">

                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
                    <div>
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <h1 class="h3 fw-bold mb-0"><?= $e($cliente['nome'] ?? 'Cliente') ?></h1>
                            <span class="badge <?= $badgeCliente ?>">
                                <?= $e(ucfirst((string) ($cliente['status'] ?? ''))) ?>
                            </span>
                        </div>
                        <p class="text-muted mb-0">Detalhes do cadastro e movimentações do cliente.</p>
                    </div>

                    <a href="admin/clientes" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i>
                        Voltar para clientes
                    </a>
                </div>

                <!-- Dados do cliente -->
                <section class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h2 class="h5 mb-0">
                            <i class="bi bi-person-vcard me-2"></i>
                            Dados do cliente
                        </h2>
                    </div>

                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-12 col-md-6 col-xl-4">
                                <small class="text-muted d-block">Nome</small>
                                <strong><?= $e($cliente['nome'] ?? 'Não informado') ?></strong>
                            </div>

                            <div class="col-12 col-md-6 col-xl-4">
                                <small class="text-muted d-block">E-mail</small>
                                <strong><?= $e($cliente['email'] ?? 'Não informado') ?></strong>
                            </div>

                            <div class="col-12 col-md-6 col-xl-4">
                                <small class="text-muted d-block">CPF</small>
                                <strong><?= $e($formatarCpf($cliente['cpf'] ?? null)) ?></strong>
                            </div>

                            <div class="col-12 col-md-6 col-xl-4">
                                <small class="text-muted d-block">Telefone</small>
                                <strong><?= $e($cliente['telefone'] ?? 'Não informado') ?></strong>
                            </div>

                            <div class="col-12 col-md-6 col-xl-4">
                                <small class="text-muted d-block">Data de nascimento</small>
                                <strong><?= $e($formatarData($cliente['data_nascimento'] ?? null)) ?></strong>
                            </div>

                            <div class="col-12 col-md-6 col-xl-4">
                                <small class="text-muted d-block">E-mail verificado</small>
                                <strong>
                                    <?= (int) ($cliente['email_verificado'] ?? 0) === 1 ? 'Sim' : 'Não' ?>
                                </strong>
                            </div>

                            <div class="col-12 col-md-6 col-xl-4">
                                <small class="text-muted d-block">Newsletter</small>
                                <strong>
                                    <?= (int) ($cliente['newsletter'] ?? 0) === 1 ? 'Inscrito' : 'Não inscrito' ?>
                                </strong>
                            </div>

                            <div class="col-12 col-md-6 col-xl-4">
                                <small class="text-muted d-block">Último acesso</small>
                                <strong><?= $e($formatarData($cliente['ultimo_acesso'] ?? null, true)) ?></strong>
                            </div>

                            <div class="col-12 col-md-6 col-xl-4">
                                <small class="text-muted d-block">Cadastro realizado em</small>
                                <strong><?= $e($formatarData($cliente['criado_em'] ?? null, true)) ?></strong>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Endereços -->
                <section class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                        <h2 class="h5 mb-0">
                            <i class="bi bi-geo-alt me-2"></i>
                            Endereços cadastrados
                        </h2>

                        <span class="badge bg-secondary">
                            <?= count($enderecos) ?>
                        </span>
                    </div>

                    <div class="card-body">
                        <?php if ($enderecos === []): ?>
                            <div class="alert alert-light border mb-0">
                                <i class="bi bi-info-circle me-1"></i>
                                O cliente não possui endereços cadastrados.
                            </div>
                        <?php else: ?>
                            <div class="row g-3">
                                <?php foreach ($enderecos as $endereco): ?>
                                    <div class="col-12 col-lg-6">
                                        <article class="border rounded-3 p-3 h-100">
                                            <div class="d-flex justify-content-between gap-3 mb-2">
                                                <h3 class="h6 fw-bold mb-0">
                                                    <?= $e($endereco['identificacao'] ?? 'Endereço') ?>
                                                </h3>

                                                <?php if ((int) ($endereco['principal'] ?? 0) === 1): ?>
                                                    <span class="badge bg-primary">Principal</span>
                                                <?php endif; ?>
                                            </div>

                                            <p class="mb-1">
                                                <strong><?= $e($endereco['destinatario'] ?? '') ?></strong>
                                            </p>

                                            <p class="text-muted mb-0">
                                                <?= $e($endereco['logradouro'] ?? '') ?>,
                                                <?= $e($endereco['numero'] ?? '') ?>
                                                <?php if (!empty($endereco['complemento'])): ?>
                                                    - <?= $e($endereco['complemento']) ?>
                                                <?php endif; ?>
                                                <br>
                                                <?= $e($endereco['bairro'] ?? '') ?> -
                                                <?= $e($endereco['cidade'] ?? '') ?>/<?= $e($endereco['estado'] ?? '') ?>
                                                <br>
                                                CEP: <?= $e($endereco['cep'] ?? '') ?>
                                            </p>
                                        </article>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>

                <!-- Pedidos -->
                <section class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                        <h2 class="h5 mb-0">
                            <i class="bi bi-bag-check me-2"></i>
                            Pedidos
                        </h2>

                        <span class="badge bg-secondary">
                            <?= count($pedidos) ?>
                        </span>
                    </div>

                    <div class="card-body p-0">
                        <?php if ($pedidos === []): ?>
                            <div class="p-3">
                                <div class="alert alert-light border mb-0">
                                    <i class="bi bi-info-circle me-1"></i>
                                    O cliente ainda não possui pedidos.
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Pedido</th>
                                            <th>Data</th>
                                            <th>Status</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($pedidos as $pedido): ?>
                                            <?php [$textoStatus, $classeStatus] = $statusPedido((string) ($pedido['status'] ?? '')); ?>
                                            <tr>
                                                <td class="fw-semibold">
                                                    <?= $e($pedido['codigo'] ?? '') ?>
                                                </td>
                                                <td>
                                                    <?= $e($formatarData($pedido['criado_em'] ?? null, true)) ?>
                                                </td>
                                                <td>
                                                    <span class="badge <?= $classeStatus ?>">
                                                        <?= $e($textoStatus) ?>
                                                    </span>
                                                </td>
                                                <td class="text-end fw-semibold">
                                                    R$ <?= number_format((float) ($pedido['total'] ?? 0), 2, ',', '.') ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>

                <!-- Carrinhos abertos -->
                <section class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                        <h2 class="h5 mb-0">
                            <i class="bi bi-cart3 me-2"></i>
                            Carrinho com status aberto
                        </h2>

                        <span class="badge bg-success">
                            <?= count($carrinhosAbertos) ?>
                        </span>
                    </div>

                    <div class="card-body p-0">
                        <?php if ($carrinhosAbertos === []): ?>
                            <div class="p-3">
                                <div class="alert alert-light border mb-0">
                                    <i class="bi bi-cart-x me-1"></i>
                                    O cliente não possui carrinho aberto.
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Status</th>
                                            <th>Unidades</th>
                                            <th>Última atualização</th>
                                            <th class="text-end">Total</th>
                                            <th class="text-end">Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($carrinhosAbertos as $carrinho): ?>
                                            <tr>
                                                <td>
                                                    <span class="badge bg-success">Aberto</span>
                                                </td>
                                                <td>
                                                    <?= (int) ($carrinho['total_unidades'] ?? 0) ?>
                                                </td>
                                                <td>
                                                    <?= $e($formatarData($carrinho['atualizado_em'] ?? null, true)) ?>
                                                </td>
                                                <td class="text-end fw-semibold">
                                                    R$ <?= number_format((float) ($carrinho['total_carrinho'] ?? 0), 2, ',', '.') ?>
                                                </td>
                                                <td class="text-end">
                                                    <a
                                                        href="admin/cliente/carrinho?id=<?= rawurlencode((string) ($carrinho['id_seguro'] ?? '')) ?>"
                                                        class="btn btn-sm btn-outline-primary"
                                                    >
                                                        <i class="bi bi-eye me-1"></i>
                                                        Abrir carrinho
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>

            </div>
        </main>

        <?php View::componenteAdmin('footer'); ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>