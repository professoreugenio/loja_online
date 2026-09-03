<?php

declare(strict_types=1);

use App\Helpers\View;

/**
 * Variáveis esperadas pela view:
 *
 * $pedidos = [
 *     [
 *         'id' => 1,
 *         'codigo' => '000125',
 *         'status' => 'preparando',
 *         'criado_em' => '2026-08-15 14:32:00',
 *         'total' => 199.70,
 *         'subtotal' => 199.70,
 *         'frete' => 20.00,
 *         'desconto' => 20.00,
 *         'quantidade_itens' => 3,
 *         'produto_nome' => 'Produto exemplo',
 *         'produto_imagem' => 'assets/img/produtos/produto.jpg',
 *     ]
 * ];
 *
 * $filtroBusca  = $_GET['busca'] ?? '';
 * $filtroStatus = $_GET['status'] ?? '';
 */

$pedidos = $pedidos ?? [];
$filtroBusca = (string) ($_GET['busca'] ?? '');
$filtroStatus = (string) ($_GET['status'] ?? '');

$statusConfig = [
    'aguardando' => [
        'texto' => 'Aguardando pagamento',
        'classe' => 'text-bg-warning',
        'icone' => 'bi-hourglass-split',
    ],
    'pago' => [
        'texto' => 'Pagamento aprovado',
        'classe' => 'text-bg-info',
        'icone' => 'bi-credit-card',
    ],
    'preparando' => [
        'texto' => 'Em preparação',
        'classe' => 'text-bg-warning',
        'icone' => 'bi-box-seam',
    ],
    'enviado' => [
        'texto' => 'Enviado',
        'classe' => 'text-bg-primary',
        'icone' => 'bi-truck',
    ],
    'entregue' => [
        'texto' => 'Entregue',
        'classe' => 'text-bg-success',
        'icone' => 'bi-check-circle',
    ],
    'cancelado' => [
        'texto' => 'Cancelado',
        'classe' => 'text-bg-danger',
        'icone' => 'bi-x-circle',
    ],
];

function e(mixed $valor): string
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}

function dinheiro(mixed $valor): string
{
    return 'R$ ' . number_format((float) $valor, 2, ',', '.');
}

function dataBR(mixed $valor): string
{
    if (empty($valor)) {
        return '-';
    }

    $data = new DateTime((string) $valor);
    return $data->format('d/m/Y');
}

function dataHoraBR(mixed $valor): string
{
    if (empty($valor)) {
        return '-';
    }

    $data = new DateTime((string) $valor);
    return $data->format('d/m/Y \à\s H:i');
}

function statusPedido(array $pedido, array $statusConfig): array
{
    $status = strtolower(trim((string) ($pedido['status'] ?? '')));

    return $statusConfig[$status] ?? [
        'texto' => ucfirst($status ?: 'Não informado'),
        'classe' => 'text-bg-secondary',
        'icone' => 'bi-info-circle',
    ];
}
?>
<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Pedidos do cliente da Loja Online.">
    <title>Meus Pedidos | Loja Online</title>

    <base href="<?= BASE_URL ?>/">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/site.css">
</head>

<body class="bg-light">

    <?php View::componenteCliente('nav'); ?>

    <main class="py-5">
        <div class="container">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                <div>
                    <h1 class="h3 fw-bold mb-1">
                        <i class="bi bi-bag-check text-primary me-2"></i>
                        Meus Pedidos
                    </h1>
                    <p class="text-muted mb-0">
                        Consulte seus pedidos e acompanhe o andamento das suas compras.
                    </p>
                </div>

                <a href="produtos" class="btn btn-primary">
                    <i class="bi bi-cart-plus me-1"></i>
                    Continuar comprando
                </a>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <form method="get" action="cliente/pedidos">
                        <div class="row g-3 align-items-end">

                            <div class="col-12 col-md-5">
                                <label for="buscarPedido" class="form-label">
                                    Buscar pedido
                                </label>

                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-search"></i>
                                    </span>

                                    <input
                                        type="search"
                                        class="form-control"
                                        id="buscarPedido"
                                        name="busca"
                                        value="<?= e($filtroBusca) ?>"
                                        placeholder="Número do pedido">
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <label for="statusPedido" class="form-label">
                                    Status
                                </label>

                                <select class="form-select" id="statusPedido" name="status">
                                    <option value="">Todos os pedidos</option>

                                    <?php foreach ($statusConfig as $valor => $config): ?>
                                        <option
                                            value="<?= e($valor) ?>"
                                            <?= $filtroStatus === $valor ? 'selected' : '' ?>>
                                            <?= e($config['texto']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-12 col-md-3">
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-funnel me-1"></i>
                                        Filtrar
                                    </button>

                                    <?php if ($filtroBusca !== '' || $filtroStatus !== ''): ?>
                                        <a href="cliente/pedidos" class="btn btn-outline-secondary">
                                            <i class="bi bi-x-lg me-1"></i>
                                            Limpar filtros
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            <?php if (empty($pedidos)): ?>

                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">

                        <div class="mb-3">
                            <span
                                class="d-inline-flex align-items-center justify-content-center bg-light text-secondary rounded-circle"
                                style="width: 80px; height: 80px;">
                                <i class="bi bi-bag-x fs-1"></i>
                            </span>
                        </div>

                        <h2 class="h5 fw-bold">
                            Nenhum pedido encontrado
                        </h2>

                        <p class="text-muted mb-4">
                            <?php if ($filtroBusca !== '' || $filtroStatus !== ''): ?>
                                Não encontramos pedidos para os filtros informados.
                            <?php else: ?>
                                Você ainda não possui pedidos realizados.
                            <?php endif; ?>
                        </p>

                        <a href="produtos" class="btn btn-primary">
                            <i class="bi bi-cart-plus me-1"></i>
                            Comprar agora
                        </a>

                    </div>
                </div>

            <?php else: ?>

                <?php foreach ($pedidos as $pedido): ?>

                    <?php
                    $status = statusPedido($pedido, $statusConfig);
                    $codigo = $pedido['codigo'] ?? $pedido['id'] ?? '';
                    $imagem = $pedido['produto_imagem'] ?? 'assets/img/produtos/produto.jpg';
                    $nomeProduto = $pedido['produto_nome'] ?? 'Produto do pedido';
                    $quantidadeItens = (int) ($pedido['quantidade_itens'] ?? 0);
                    ?>

                    <div class="card border-0 shadow-sm mb-4">

                        <div class="card-header bg-white py-3">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">

                                <div>
                                    <h2 class="h5 fw-bold mb-1">
                                        Pedido #<?= e($codigo) ?>
                                    </h2>

                                    <small class="text-muted">
                                        Realizado em <?= e(dataHoraBR($pedido['criado_em'] ?? null)) ?>
                                    </small>
                                </div>

                                <span class="badge <?= e($status['classe']) ?> px-3 py-2">
                                    <i class="bi <?= e($status['icone']) ?> me-1"></i>
                                    <?= e($status['texto']) ?>
                                </span>

                            </div>
                        </div>

                        <div class="card-body">

                            <div class="row align-items-center g-3">

                                <div class="col-4 col-md-2">
                                    <img
                                        src="<?= e($imagem) ?>"
                                        class="img-fluid rounded border"
                                        alt="<?= e($nomeProduto) ?>"
                                        loading="lazy"
                                        onerror="this.src='assets/img/produtos/produto.jpg';">
                                </div>

                                <div class="col-8 col-md-5">
                                    <h3 class="h6 fw-bold mb-1">
                                        <?= e($nomeProduto) ?>
                                    </h3>

                                    <small class="text-muted">
                                        <?php if ($quantidadeItens > 1): ?>
                                            <?= $quantidadeItens ?> itens no pedido
                                        <?php else: ?>
                                            1 item no pedido
                                        <?php endif; ?>
                                    </small>
                                </div>

                                <div class="col-6 col-md-2">
                                    <small class="text-muted d-block">
                                        Total
                                    </small>

                                    <strong class="fs-6">
                                        <?= e(dinheiro($pedido['total'] ?? 0)) ?>
                                    </strong>
                                </div>

                                <div class="col-6 col-md-3 text-md-end">
                                    <a
                                        href="cliente/pedido?id=<?= urlencode((string) ($pedido['id'] ?? '')) ?>"
                                        class="btn btn-outline-primary">
                                        <i class="bi bi-eye me-1"></i>
                                        Ver pedido
                                    </a>
                                </div>

                            </div>

                            <hr>

                            <div class="row g-3">

                                <div class="col-12 col-md-4">
                                    <small class="text-muted d-block">
                                        Subtotal
                                    </small>

                                    <strong>
                                        <?= e(dinheiro($pedido['subtotal'] ?? 0)) ?>
                                    </strong>
                                </div>

                                <div class="col-12 col-md-4">
                                    <small class="text-muted d-block">
                                        Frete
                                    </small>

                                    <strong>
                                        <?= e(dinheiro($pedido['frete'] ?? 0)) ?>
                                    </strong>
                                </div>

                                <div class="col-12 col-md-4 text-md-end">
                                    <small class="text-muted d-block">
                                        Total do pedido
                                    </small>

                                    <span class="fs-5 fw-bold text-success">
                                        <?= e(dinheiro($pedido['total'] ?? 0)) ?>
                                    </span>
                                </div>

                            </div>

                        </div>
                    </div>

                <?php endforeach; ?>

            <?php endif; ?>

        </div>
    </main>

    <footer class="bg-dark text-white mt-5">
        <div class="container py-4">

            <div class="row align-items-center">

                <div class="col-12 col-md-6 text-center text-md-start">
                    <strong>Loja Online</strong>

                    <p class="small text-white-50 mb-0">
                        Sua loja online com segurança e praticidade.
                    </p>
                </div>

                <div class="col-12 col-md-6 text-center text-md-end mt-3 mt-md-0">
                    <a href="" class="text-white text-decoration-none me-3">
                        Loja
                    </a>

                    <a href="produtos" class="text-white text-decoration-none me-3">
                        Produtos
                    </a>

                    <a href="cliente/pedidos" class="text-white text-decoration-none">
                        Meus Pedidos
                    </a>
                </div>

            </div>

            <hr class="border-secondary">

            <div class="text-center">
                <small class="text-white-50">
                    &copy; <?= date('Y') ?> Loja Online.
                    Todos os direitos reservados.
                </small>
            </div>

        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>