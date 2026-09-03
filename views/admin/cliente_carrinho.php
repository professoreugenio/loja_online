<?php

declare(strict_types=1);

use App\Helpers\View;

$baseUrl = defined('BASE_URL') ? BASE_URL : '';

$carrinho = is_array($carrinho ?? null) ? $carrinho : [];
$itens = is_array($itens ?? null) ? $itens : [];
$totalUnidades = (int) ($totalUnidades ?? 0);
$totalCarrinho = (float) ($totalCarrinho ?? 0);
$clienteToken = (string) ($clienteToken ?? '');

$e = static fn(mixed $valor): string =>
    htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');

$formatarData = static function (?string $valor): string {
    if ($valor === null || trim($valor) === '') {
        return 'Não informado';
    }

    $timestamp = strtotime($valor);

    return $timestamp !== false
        ? date('d/m/Y H:i', $timestamp)
        : $valor;
};
?>
<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Carrinho do Cliente | Loja Online</title>
    <base href="<?= BASE_URL ?>/">

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
                            <h1 class="h3 fw-bold mb-0">Carrinho do cliente</h1>
                            <span class="badge bg-success">Aberto</span>
                        </div>

                        <p class="text-muted mb-0">
                            <?= $e($carrinho['cliente_nome'] ?? 'Cliente') ?>
                        </p>
                    </div>

                    <a
                        href="admin/cliente/view?id=<?= rawurlencode($clienteToken) ?>"
                        class="btn btn-outline-secondary"
                    >
                        <i class="bi bi-arrow-left me-1"></i>
                        Voltar para o cliente
                    </a>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-12 col-lg-8">
                        <section class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white py-3">
                                <h2 class="h5 mb-0">
                                    <i class="bi bi-person me-2"></i>
                                    Cliente
                                </h2>
                            </div>

                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-12 col-md-6">
                                        <small class="text-muted d-block">Nome</small>
                                        <strong><?= $e($carrinho['cliente_nome'] ?? '') ?></strong>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <small class="text-muted d-block">E-mail</small>
                                        <strong><?= $e($carrinho['cliente_email'] ?? '') ?></strong>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <small class="text-muted d-block">Criado em</small>
                                        <strong><?= $e($formatarData($carrinho['criado_em'] ?? null)) ?></strong>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <small class="text-muted d-block">Atualizado em</small>
                                        <strong><?= $e($formatarData($carrinho['atualizado_em'] ?? null)) ?></strong>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>

                    <div class="col-12 col-lg-4">
                        <section class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white py-3">
                                <h2 class="h5 mb-0">
                                    <i class="bi bi-receipt me-2"></i>
                                    Resumo
                                </h2>
                            </div>

                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Produtos diferentes</span>
                                    <strong><?= count($itens) ?></strong>
                                </div>

                                <div class="d-flex justify-content-between mb-3">
                                    <span class="text-muted">Total de unidades</span>
                                    <strong><?= $totalUnidades ?></strong>
                                </div>

                                <hr>

                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-semibold">Total do carrinho</span>
                                    <strong class="fs-5">
                                        R$ <?= number_format($totalCarrinho, 2, ',', '.') ?>
                                    </strong>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

                <section class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h2 class="h5 mb-0">
                            <i class="bi bi-cart3 me-2"></i>
                            Itens do carrinho
                        </h2>

                        <span class="badge bg-secondary">
                            <?= count($itens) ?>
                        </span>
                    </div>

                    <div class="card-body p-0">
                        <?php if ($itens === []): ?>
                            <div class="p-3">
                                <div class="alert alert-light border mb-0">
                                    O carrinho está aberto, mas não possui itens.
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Produto</th>
                                            <th>Categoria</th>
                                            <th class="text-center">Quantidade</th>
                                            <th class="text-end">Preço unitário</th>
                                            <th class="text-end">Subtotal</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach ($itens as $item): ?>
                                            <tr>
                                                <td>
                                                    <div class="fw-semibold">
                                                        <?= $e($item['produto_nome'] ?? '') ?>
                                                    </div>

                                                    <?php if (($item['produto_status'] ?? '') !== 'ativo'): ?>
                                                        <small class="text-danger">
                                                            Produto <?= $e($item['produto_status'] ?? '') ?>
                                                        </small>
                                                    <?php endif; ?>
                                                </td>

                                                <td>
                                                    <?= $e($item['categoria_nome'] ?? 'Sem categoria') ?>
                                                </td>

                                                <td class="text-center">
                                                    <?= (int) ($item['quantidade'] ?? 0) ?>
                                                </td>

                                                <td class="text-end">
                                                    R$ <?= number_format((float) ($item['preco_unitario'] ?? 0), 2, ',', '.') ?>
                                                </td>

                                                <td class="text-end fw-semibold">
                                                    R$ <?= number_format((float) ($item['subtotal'] ?? 0), 2, ',', '.') ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>

                                    <tfoot class="table-light">
                                        <tr>
                                            <th colspan="4" class="text-end">
                                                Total
                                            </th>
                                            <th class="text-end">
                                                R$ <?= number_format($totalCarrinho, 2, ',', '.') ?>
                                            </th>
                                        </tr>
                                    </tfoot>
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