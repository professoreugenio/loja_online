<?php

declare(strict_types=1);

use App\Helpers\View;

/**
 * Variáveis esperadas pela view:
 *
 * $pedido = [
 *     'id' => 1,
 *     'codigo' => '000125',
 *     'status' => 'preparando',
 *     'criado_em' => '2026-08-15 14:32:00',
 *     'atualizado_em' => '2026-08-15 15:00:00',
 *     'subtotal' => 199.70,
 *     'frete' => 20.00,
 *     'desconto' => 20.00,
 *     'total' => 199.70,
 *     'observacao' => null,
 *     'endereco' => [...],
 *     'pagamento' => [...],
 *     'itens' => [...]
 * ];
 */

$pedido = $pedido ?? null;

if (!function_exists('e')) {
    function e(mixed $valor): string
    {
        return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('dinheiro')) {
    function dinheiro(mixed $valor): string
    {
        return 'R$ ' . number_format((float) $valor, 2, ',', '.');
    }
}

if (!function_exists('dataBR')) {
    function dataBR(mixed $valor): string
    {
        if (empty($valor)) {
            return '-';
        }

        return (new DateTime((string) $valor))->format('d/m/Y');
    }
}

if (!function_exists('dataHoraBR')) {
    function dataHoraBR(mixed $valor): string
    {
        if (empty($valor)) {
            return '-';
        }

        return (new DateTime((string) $valor))->format('d/m/Y \à\s H:i');
    }
}

$statusConfig = [
    'aguardando' => [
        'texto' => 'Aguardando pagamento',
        'classe' => 'warning',
        'icone' => 'bi-hourglass-split',
        'etapa' => 1,
    ],
    'pago' => [
        'texto' => 'Pagamento aprovado',
        'classe' => 'success',
        'icone' => 'bi-credit-card',
        'etapa' => 2,
    ],
    'preparando' => [
        'texto' => 'Em preparação',
        'classe' => 'warning',
        'icone' => 'bi-box-seam',
        'etapa' => 3,
    ],
    'enviado' => [
        'texto' => 'Enviado',
        'classe' => 'primary',
        'icone' => 'bi-truck',
        'etapa' => 4,
    ],
    'entregue' => [
        'texto' => 'Entregue',
        'classe' => 'success',
        'icone' => 'bi-house-check',
        'etapa' => 5,
    ],
    'cancelado' => [
        'texto' => 'Cancelado',
        'classe' => 'danger',
        'icone' => 'bi-x-circle',
        'etapa' => 0,
    ],
];

function configurarStatus(array $pedido, array $statusConfig): array
{
    $status = strtolower(trim((string) ($pedido['status'] ?? '')));

    return $statusConfig[$status] ?? [
        'texto' => ucfirst($status ?: 'Não informado'),
        'classe' => 'secondary',
        'icone' => 'bi-info-circle',
        'etapa' => 0,
    ];
}

if (!$pedido):
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pedido não encontrado | Loja Online</title>
    <base href="/loja_online/public/">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/site.css">
</head>
<body class="bg-light">

<?php View::componenteCliente('nav'); ?>

<main class="py-5">
    <div class="container">

        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">

                <i class="bi bi-search fs-1 text-secondary"></i>

                <h1 class="h4 fw-bold mt-3">
                    Pedido não encontrado
                </h1>

                <p class="text-muted">
                    O pedido solicitado não existe ou não pertence à sua conta.
                </p>

                <a href="cliente/pedidos" class="btn btn-primary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Voltar para meus pedidos
                </a>

            </div>
        </div>

    </div>
</main>

</body>
</html>
<?php
exit;
endif;

$status = configurarStatus($pedido, $statusConfig);
$endereco = $pedido['endereco'] ?? [];
$pagamento = $pedido['pagamento'] ?? [];
$itens = $pedido['itens'] ?? [];

$codigo = $pedido['codigo'] ?? $pedido['id'] ?? '';

$nomeEndereco = $endereco['nome'] ?? $endereco['nome_destinatario'] ?? '';
$logradouro = $endereco['logradouro'] ?? $endereco['endereco'] ?? '';
$numero = $endereco['numero'] ?? '';
$complemento = $endereco['complemento'] ?? '';
$bairro = $endereco['bairro'] ?? '';
$cidade = $endereco['cidade'] ?? '';
$estado = $endereco['estado'] ?? $endereco['uf'] ?? '';
$cep = $endereco['cep'] ?? '';
$telefone = $endereco['telefone'] ?? '';

$formaPagamento = $pagamento['metodo'] ?? $pagamento['forma'] ?? $pagamento['metodo_pagamento'] ?? '';
$statusPagamento = $pagamento['status'] ?? '';
$valorPagamento = $pagamento['valor'] ?? $pedido['total'] ?? 0;

$statusAtual = strtolower(trim((string) ($pedido['status'] ?? '')));
$cancelado = $statusAtual === 'cancelado';

$etapas = [
    [
        'titulo' => 'Pedido realizado',
        'icone' => 'bi-check-lg',
        'etapa' => 1,
        'data' => $pedido['criado_em'] ?? null,
    ],
    [
        'titulo' => 'Pagamento aprovado',
        'icone' => 'bi-credit-card',
        'etapa' => 2,
        'data' => $pagamento['pago_em'] ?? $pagamento['atualizado_em'] ?? null,
    ],
    [
        'titulo' => 'Em preparação',
        'icone' => 'bi-box-seam',
        'etapa' => 3,
        'data' => $pedido['status'] === 'preparando' ? $pedido['atualizado_em'] ?? null : null,
    ],
    [
        'titulo' => 'Enviado',
        'icone' => 'bi-truck',
        'etapa' => 4,
        'data' => $pedido['enviado_em'] ?? null,
    ],
    [
        'titulo' => 'Entregue',
        'icone' => 'bi-house-check',
        'etapa' => 5,
        'data' => $pedido['entregue_em'] ?? null,
    ],
];
?>
<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Detalhes do pedido da Loja Online.">
    <title>Pedido #<?= e($codigo) ?> | Loja Online</title>

    <base href="/loja_online/public/">

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
                <a href="cliente/pedidos" class="text-decoration-none">
                    <i class="bi bi-arrow-left me-1"></i>
                    Voltar para meus pedidos
                </a>

                <h1 class="h3 fw-bold mt-3 mb-1">
                    Pedido #<?= e($codigo) ?>
                </h1>

                <p class="text-muted mb-0">
                    Realizado em <?= e(dataHoraBR($pedido['criado_em'] ?? null)) ?>
                </p>
            </div>

            <span class="badge text-bg-<?= e($status['classe']) ?> px-3 py-2 fs-6">
                <i class="bi <?= e($status['icone']) ?> me-1"></i>
                <?= e($status['texto']) ?>
            </span>

        </div>

        <?php if ($cancelado): ?>

            <div class="alert alert-danger border-0 shadow-sm">
                <i class="bi bi-exclamation-triangle me-2"></i>
                Este pedido foi cancelado.
            </div>

        <?php endif; ?>

        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-white py-3">
                <h2 class="h5 fw-bold mb-0">
                    <i class="bi bi-truck text-primary me-2"></i>
                    Acompanhamento do Pedido
                </h2>
            </div>

            <div class="card-body">

                <div class="row g-4 text-center">

                    <?php foreach ($etapas as $etapa): ?>

                        <?php
                        $concluida = !$cancelado && $status['etapa'] >= $etapa['etapa'];
                        $atual = !$cancelado && $status['etapa'] === $etapa['etapa'];

                        $classeCirculo = $concluida
                            ? ($atual ? 'bg-warning text-dark' : 'bg-success text-white')
                            : 'bg-secondary text-white';
                        ?>

                        <div class="col-6 col-lg">

                            <div class="mb-2">

                                <span
                                    class="d-inline-flex align-items-center justify-content-center <?= e($classeCirculo) ?> rounded-circle"
                                    style="width: 50px; height: 50px;">

                                    <i class="bi <?= e($etapa['icone']) ?> fs-4"></i>

                                </span>

                            </div>

                            <strong class="d-block">
                                <?= e($etapa['titulo']) ?>
                            </strong>

                            <small class="text-muted">
                                <?php if ($concluida && !empty($etapa['data'])): ?>
                                    <?= e(dataBR($etapa['data'])) ?>
                                <?php elseif ($atual): ?>
                                    Em andamento
                                <?php else: ?>
                                    Aguardando
                                <?php endif; ?>
                            </small>

                        </div>

                    <?php endforeach; ?>

                </div>

            </div>
        </div>

        <div class="row g-4">

            <div class="col-12 col-lg-8">

                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-header bg-white py-3">
                        <h2 class="h5 fw-bold mb-0">
                            <i class="bi bi-cart-check text-primary me-2"></i>
                            Produtos do Pedido
                        </h2>
                    </div>

                    <div class="card-body">

                        <?php if (empty($itens)): ?>

                            <div class="text-center text-muted py-4">
                                Nenhum item encontrado neste pedido.
                            </div>

                        <?php else: ?>

                            <?php foreach ($itens as $indice => $item): ?>

                                <?php
                                $imagem = $item['imagem'] ?? $item['produto_imagem'] ?? 'assets/img/produtos/produto.jpg';
                                $nomeProduto = $item['produto_nome'] ?? $item['nome'] ?? 'Produto';
                                $quantidade = (int) ($item['quantidade'] ?? 0);
                                $preco = (float) ($item['preco_unitario'] ?? $item['preco'] ?? 0);
                                $subtotalItem = (float) ($item['subtotal'] ?? ($preco * $quantidade));
                                $categoria = $item['categoria_nome'] ?? '';
                                ?>

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

                                        <?php if ($categoria !== ''): ?>
                                            <p class="text-muted small mb-1">
                                                <?= e($categoria) ?>
                                            </p>
                                        <?php endif; ?>

                                        <small>
                                            Quantidade: <?= e($quantidade) ?>
                                        </small>

                                    </div>

                                    <div class="col-6 col-md-2">

                                        <small class="text-muted d-block">
                                            Preço unitário
                                        </small>

                                        <strong>
                                            <?= e(dinheiro($preco)) ?>
                                        </strong>

                                    </div>

                                    <div class="col-6 col-md-3 text-md-end">

                                        <small class="text-muted d-block">
                                            Subtotal
                                        </small>

                                        <strong>
                                            <?= e(dinheiro($subtotalItem)) ?>
                                        </strong>

                                    </div>

                                </div>

                                <?php if ($indice < count($itens) - 1): ?>
                                    <hr>
                                <?php endif; ?>

                            <?php endforeach; ?>

                        <?php endif; ?>

                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-header bg-white py-3">
                        <h2 class="h5 fw-bold mb-0">
                            <i class="bi bi-geo-alt text-primary me-2"></i>
                            Endereço de Entrega
                        </h2>
                    </div>

                    <div class="card-body">

                        <?php if (empty($endereco)): ?>

                            <p class="text-muted mb-0">
                                Endereço não informado.
                            </p>

                        <?php else: ?>

                            <div class="d-flex">

                                <div class="me-3">
                                    <i
                                        class="bi bi-house-door text-primary"
                                        style="font-size: 2rem;">
                                    </i>
                                </div>

                                <div>

                                    <?php if ($nomeEndereco !== ''): ?>
                                        <h3 class="h6 fw-bold">
                                            <?= e($nomeEndereco) ?>
                                        </h3>
                                    <?php endif; ?>

                                    <p class="mb-1">
                                        <?= e($logradouro) ?><?= $numero !== '' ? ', ' . e($numero) : '' ?>
                                    </p>

                                    <?php if ($complemento !== ''): ?>
                                        <p class="mb-1">
                                            <?= e($complemento) ?>
                                        </p>
                                    <?php endif; ?>

                                    <?php if ($bairro !== ''): ?>
                                        <p class="mb-1">
                                            <?= e($bairro) ?>
                                        </p>
                                    <?php endif; ?>

                                    <p class="mb-1">
                                        <?= e($cidade) ?><?= $estado !== '' ? ' - ' . e($estado) : '' ?>
                                    </p>

                                    <?php if ($cep !== ''): ?>
                                        <p class="mb-1">
                                            CEP: <?= e($cep) ?>
                                        </p>
                                    <?php endif; ?>

                                    <?php if ($telefone !== ''): ?>
                                        <p class="mb-0 text-muted">
                                            <i class="bi bi-telephone me-1"></i>
                                            <?= e($telefone) ?>
                                        </p>
                                    <?php endif; ?>

                                </div>

                            </div>

                        <?php endif; ?>

                    </div>
                </div>

                <div class="card border-0 shadow-sm">

                    <div class="card-header bg-white py-3">
                        <h2 class="h5 fw-bold mb-0">
                            <i class="bi bi-truck text-primary me-2"></i>
                            Informações da Entrega
                        </h2>
                    </div>

                    <div class="card-body">

                        <div class="row g-4">

                            <div class="col-12 col-md-6">
                                <small class="text-muted d-block">
                                    Forma de envio
                                </small>

                                <strong>
                                    <?= e($pedido['forma_envio'] ?? 'Entrega padrão') ?>
                                </strong>
                            </div>

                            <div class="col-12 col-md-6">
                                <small class="text-muted d-block">
                                    Previsão de entrega
                                </small>

                                <strong>
                                    <?= e(dataBR($pedido['previsao_entrega'] ?? null)) ?>
                                </strong>
                            </div>

                            <div class="col-12 col-md-6">
                                <small class="text-muted d-block">
                                    Transportadora
                                </small>

                                <strong>
                                    <?= e($pedido['transportadora'] ?? 'Não informada') ?>
                                </strong>
                            </div>

                            <div class="col-12 col-md-6">
                                <small class="text-muted d-block">
                                    Código de rastreamento
                                </small>

                                <strong>
                                    <?= e($pedido['codigo_rastreio'] ?? 'Ainda não disponível') ?>
                                </strong>
                            </div>

                        </div>

                    </div>
                </div>

            </div>

            <aside class="col-12 col-lg-4">

                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-header bg-white py-3">
                        <h2 class="h5 fw-bold mb-0">
                            <i class="bi bi-receipt text-primary me-2"></i>
                            Resumo do Pedido
                        </h2>
                    </div>

                    <div class="card-body">

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Produtos</span>
                            <span><?= e(dinheiro($pedido['subtotal'] ?? 0)) ?></span>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Frete</span>
                            <span><?= e(dinheiro($pedido['frete'] ?? 0)) ?></span>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Desconto</span>

                            <span class="text-success">
                                - <?= e(dinheiro($pedido['desconto'] ?? 0)) ?>
                            </span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between align-items-center">

                            <strong>Total</strong>

                            <span class="fs-4 fw-bold text-success">
                                <?= e(dinheiro($pedido['total'] ?? 0)) ?>
                            </span>

                        </div>

                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-header bg-white py-3">
                        <h2 class="h5 fw-bold mb-0">
                            <i class="bi bi-credit-card text-primary me-2"></i>
                            Pagamento
                        </h2>
                    </div>

                    <div class="card-body">

                        <small class="text-muted d-block">
                            Forma de pagamento
                        </small>

                        <strong class="d-block mb-3">
                            <?= e($formaPagamento ?: 'Não informado') ?>
                        </strong>

                        <small class="text-muted d-block">
                            Valor
                        </small>

                        <strong class="d-block mb-3">
                            <?= e(dinheiro($valorPagamento)) ?>
                        </strong>

                        <?php if ($statusPagamento !== ''): ?>

                            <small class="text-muted d-block">
                                Status do pagamento
                            </small>

                            <strong class="d-block mb-3">
                                <?= e($statusPagamento) ?>
                            </strong>

                        <?php endif; ?>

                        <?php
                        $pagamentoAprovado = in_array(
                            strtolower(trim((string) $statusPagamento)),
                            ['aprovado', 'pago', 'approved', 'paid'],
                            true
                        );
                        ?>

                        <div class="alert <?= $pagamentoAprovado ? 'alert-success' : 'alert-warning' ?> mb-0">

                            <i class="bi <?= $pagamentoAprovado ? 'bi-check-circle' : 'bi-info-circle' ?> me-1"></i>

                            <?= $pagamentoAprovado ? 'Pagamento aprovado' : 'Pagamento em processamento' ?>

                        </div>

                    </div>
                </div>

                <div class="card border-0 shadow-sm">

                    <div class="card-header bg-white py-3">
                        <h2 class="h5 fw-bold mb-0">
                            <i class="bi bi-info-circle text-primary me-2"></i>
                            Informações
                        </h2>
                    </div>

                    <div class="card-body">

                        <div class="mb-3">
                            <small class="text-muted d-block">
                                Número do pedido
                            </small>

                            <strong>
                                #<?= e($codigo) ?>
                            </strong>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block">
                                Criado em
                            </small>

                            <strong>
                                <?= e(dataHoraBR($pedido['criado_em'] ?? null)) ?>
                            </strong>
                        </div>

                        <div>
                            <small class="text-muted d-block">
                                Última atualização
                            </small>

                            <strong>
                                <?= e(dataHoraBR($pedido['atualizado_em'] ?? null)) ?>
                            </strong>
                        </div>

                    </div>
                </div>

            </aside>

        </div>

        <?php if (!empty($pedido['observacao'])): ?>

            <div class="card border-0 shadow-sm mt-4">

                <div class="card-body">

                    <h2 class="h5 fw-bold mb-2">
                        <i class="bi bi-chat-left-text text-primary me-2"></i>
                        Observação
                    </h2>

                    <p class="text-muted mb-0">
                        <?= nl2br(e($pedido['observacao'])) ?>
                    </p>

                </div>
            </div>

        <?php endif; ?>

        <div class="card border-0 shadow-sm mt-4">

            <div class="card-body">

                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">

                    <div>
                        <h2 class="h5 fw-bold mb-1">
                            <i class="bi bi-headset text-primary me-2"></i>
                            Precisa de ajuda com este pedido?
                        </h2>

                        <p class="text-muted mb-0">
                            Entre em contato com nosso atendimento.
                        </p>
                    </div>

                    <div class="d-flex gap-2">

                        <button
                            type="button"
                            class="btn btn-outline-primary"
                            onclick="window.print();">
                            <i class="bi bi-printer me-1"></i>
                            Imprimir
                        </button>

                        <a href="cliente/pedidos" class="btn btn-primary">
                            <i class="bi bi-arrow-left me-1"></i>
                            Meus pedidos
                        </a>

                    </div>

                </div>

            </div>
        </div>

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