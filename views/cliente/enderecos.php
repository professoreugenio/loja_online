<?php
declare(strict_types=1);
use App\Helpers\View;
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1">
    <meta
        name="description"
        content="Gerenciamento de endereços do cliente da Loja Online.">
    <title>Meus Endereços | Loja Online</title>
    <base href="<?= BASE_URL ?>/">
    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <!-- CSS do projeto -->
    <link
        rel="stylesheet"
        href="assets/css/site.css">
</head>
<body class="bg-light">
    <?php View::componenteCliente('nav'); ?>
    <main class="py-5">
        <div class="container">
            <div
                class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                <div>
                    <h1 class="h3 fw-bold mb-1">
                        <i class="bi bi-geo-alt text-primary me-2"></i>
                        Meus Endereços
                    </h1>
                    <p class="text-muted mb-0">
                        Gerencie os endereços utilizados para entrega
                        dos seus pedidos.
                    </p>
                </div>
                <button
                    type="button"
                    class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#modalNovoEndereco">
                    <i class="bi bi-plus-lg me-1"></i>
                    Novo endereço
                </button>
            </div>
           
            <div class="row g-4">
                <?php if (!empty($enderecos)): ?>
                    <?php foreach ($enderecos as $endereco): ?>
                        <?php
                        $id = (int) ($endereco['id'] ?? 0);
                        $principal = (int) ($endereco['principal'] ?? 0) === 1;
                        $identificacao = htmlspecialchars(
                            $endereco['identificacao'] ?? 'Endereço',
                            ENT_QUOTES,
                            'UTF-8'
                        );
                        $destinatario = htmlspecialchars(
                            $endereco['destinatario'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        );
                        $cep = htmlspecialchars(
                            $endereco['cep'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        );
                        $logradouro = htmlspecialchars(
                            $endereco['logradouro'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        );
                        $numero = htmlspecialchars(
                            $endereco['numero'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        );
                        $complemento = htmlspecialchars(
                            $endereco['complemento'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        );
                        $bairro = htmlspecialchars(
                            $endereco['bairro'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        );
                        $cidade = htmlspecialchars(
                            $endereco['cidade'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        );
                        $estado = htmlspecialchars(
                            $endereco['estado'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        );
                        ?>
                        <!-- =================================================
                             CARD ENDEREÇO
                        ================================================== -->
                        <div class="col-12 col-lg-6">
                            <div
                                class="card shadow-sm h-100 <?= $principal ? 'border-primary' : 'border-0' ?>">
                                <!-- HEADER -->
                                <div class="card-header bg-white">
                                    <div
                                        class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <i
                                                class="bi bi-geo-alt-fill text-primary me-1">
                                            </i>
                                            <strong>
                                                <?= $identificacao ?>
                                            </strong>
                                        </div>
                                        <?php if ($principal): ?>
                                            <span class="badge text-bg-primary">
                                                <i class="bi bi-star-fill me-1"></i>
                                                Principal
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <!-- BODY -->
                                <div class="card-body">
                                    <h2 class="h6 fw-bold">
                                        <?= $destinatario ?>
                                    </h2>
                                    <p class="mb-1">
                                        <?= $logradouro ?>,
                                        <?= $numero ?>
                                    </p>
                                    <?php if ($complemento !== ''): ?>
                                        <p class="mb-1">
                                            <?= $complemento ?>
                                        </p>
                                    <?php endif; ?>
                                    <p class="mb-1">
                                        <?= $bairro ?>
                                    </p>
                                    <p class="mb-1">
                                        <?= $cidade ?> -
                                        <?= $estado ?>
                                    </p>
                                    <p class="mb-0">
                                        CEP:
                                        <?= $cep ?>
                                    </p>
                                </div>
                                <!-- FOOTER -->
                                <div class="card-footer bg-white">
                                    <div
                                        class="d-flex flex-wrap gap-2">
                                        <!-- EDITAR -->
                                        <button
                                            type="button"
                                            class="btn btn-outline-primary btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEditarEndereco<?= $id ?>">
                                            <i
                                                class="bi bi-pencil-square me-1">
                                            </i>
                                            Editar
                                        </button>
                                        <!-- PRINCIPAL -->
                                        <?php if (!$principal): ?>
                                            <form
                                                action="cliente/endereco/principal"
                                                method="post"
                                                class="d-inline">
                                                <input
                                                    type="hidden"
                                                    name="id"
                                                    value="<?= $id ?>">
                                                <button
                                                    type="submit"
                                                    class="btn btn-outline-success btn-sm">
                                                    <i
                                                        class="bi bi-star me-1">
                                                    </i>
                                                    Tornar principal
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                        <!-- EXCLUIR -->
                                        <button
                                            type="button"
                                            class="btn btn-outline-danger btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalExcluirEndereco<?= $id ?>">
                                            <i
                                                class="bi bi-trash me-1">
                                            </i>
                                            Excluir
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- =================================================
                             MODAL EDITAR
                        ================================================== -->
                        <div
                            class="modal fade"
                            id="modalEditarEndereco<?= $id ?>"
                            tabindex="-1"
                            aria-hidden="true">
                            <div
                                class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h2 class="modal-title fs-5">
                                            <i
                                                class="bi bi-pencil-square text-primary me-2">
                                            </i>
                                            Editar endereço
                                        </h2>
                                        <button
                                            type="button"
                                            class="btn-close"
                                            data-bs-dismiss="modal">
                                        </button>
                                    </div>
                                    <form
                                        action="cliente/endereco/editar"
                                        method="post">
                                        <input
                                            type="hidden"
                                            name="id"
                                            value="<?= $id ?>">
                                        <div class="modal-body">
                                            <div class="row g-3">
                                                <!-- IDENTIFICAÇÃO -->
                                                <div class="col-12">
                                                    <label
                                                        class="form-label"
                                                        for="identificacao<?= $id ?>">
                                                        Identificação
                                                    </label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="identificacao<?= $id ?>"
                                                        name="identificacao"
                                                        value="<?= $identificacao ?>"
                                                        maxlength="80"
                                                        required>
                                                </div>
                                                <!-- DESTINATÁRIO -->
                                                <div class="col-12">
                                                    <label
                                                        class="form-label"
                                                        for="destinatario<?= $id ?>">
                                                        Nome do destinatário
                                                    </label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="destinatario<?= $id ?>"
                                                        name="destinatario"
                                                        value="<?= $destinatario ?>"
                                                        maxlength="150"
                                                        required>
                                                </div>
                                                <!-- CEP -->
                                                <div class="col-12 col-md-4">
                                                    <label
                                                        class="form-label"
                                                        for="cep<?= $id ?>">
                                                        CEP
                                                    </label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="cep<?= $id ?>"
                                                        name="cep"
                                                        value="<?= $cep ?>"
                                                        maxlength="9"
                                                        required>
                                                </div>
                                                <!-- LOGRADOURO -->
                                                <div class="col-12 col-md-8">
                                                    <label
                                                        class="form-label"
                                                        for="logradouro<?= $id ?>">
                                                        Rua / Avenida
                                                    </label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="logradouro<?= $id ?>"
                                                        name="logradouro"
                                                        value="<?= $logradouro ?>"
                                                        maxlength="180"
                                                        required>
                                                </div>
                                                <!-- NÚMERO -->
                                                <div class="col-12 col-md-4">
                                                    <label
                                                        class="form-label"
                                                        for="numero<?= $id ?>">
                                                        Número
                                                    </label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="numero<?= $id ?>"
                                                        name="numero"
                                                        value="<?= $numero ?>"
                                                        maxlength="20"
                                                        required>
                                                </div>
                                                <!-- COMPLEMENTO -->
                                                <div class="col-12 col-md-8">
                                                    <label
                                                        class="form-label"
                                                        for="complemento<?= $id ?>">
                                                        Complemento
                                                    </label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="complemento<?= $id ?>"
                                                        name="complemento"
                                                        value="<?= $complemento ?>"
                                                        maxlength="120">
                                                </div>
                                                <!-- BAIRRO -->
                                                <div class="col-12 col-md-6">
                                                    <label
                                                        class="form-label"
                                                        for="bairro<?= $id ?>">
                                                        Bairro
                                                    </label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="bairro<?= $id ?>"
                                                        name="bairro"
                                                        value="<?= $bairro ?>"
                                                        maxlength="120"
                                                        required>
                                                </div>
                                                <!-- CIDADE -->
                                                <div class="col-12 col-md-6">
                                                    <label
                                                        class="form-label"
                                                        for="cidade<?= $id ?>">
                                                        Cidade
                                                    </label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="cidade<?= $id ?>"
                                                        name="cidade"
                                                        value="<?= $cidade ?>"
                                                        maxlength="120"
                                                        required>
                                                </div>
                                                <!-- ESTADO -->
                                                <div class="col-12 col-md-4">
                                                    <label
                                                        class="form-label"
                                                        for="estado<?= $id ?>">
                                                        Estado
                                                    </label>
                                                    <select
                                                        class="form-select"
                                                        id="estado<?= $id ?>"
                                                        name="estado"
                                                        required>
                                                        <option value="">
                                                            Selecione
                                                        </option>
                                                        <?php
                                                        $estados = [
                                                            'AC',
                                                            'AL',
                                                            'AP',
                                                            'AM',
                                                            'BA',
                                                            'CE',
                                                            'DF',
                                                            'ES',
                                                            'GO',
                                                            'MA',
                                                            'MT',
                                                            'MS',
                                                            'MG',
                                                            'PA',
                                                            'PB',
                                                            'PR',
                                                            'PE',
                                                            'PI',
                                                            'RJ',
                                                            'RN',
                                                            'RS',
                                                            'RO',
                                                            'RR',
                                                            'SC',
                                                            'SP',
                                                            'SE',
                                                            'TO'
                                                        ];
                                                        foreach ($estados as $uf):
                                                        ?>
                                                            <option
                                                                value="<?= $uf ?>"
                                                                <?= $estado === $uf ? 'selected' : '' ?>>
                                                                <?= $uf ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button
                                                type="button"
                                                class="btn btn-secondary"
                                                data-bs-dismiss="modal">
                                                Cancelar
                                            </button>
                                            <button
                                                type="submit"
                                                class="btn btn-primary">
                                                <i
                                                    class="bi bi-check-lg me-1">
                                                </i>
                                                Salvar alterações
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- =================================================
     MODAL EXCLUIR
================================================== -->
<div class="modal fade" id="modalExcluirEndereco<?= $id ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fs-5">
                    <i class="bi bi-trash text-danger me-2"></i>
                    Excluir endereço
                </h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="mb-2">Tem certeza que deseja excluir este endereço?</p>
                <div class="alert alert-warning mb-0">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong><?= $identificacao ?></strong>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancelar
                </button>
                <!-- Ajuste no action do form abaixo -->
                <form action="<?= BASE_URL ?>/cliente/endereco/excluir" method="post">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>
                        Sim, excluir
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- =================================================
                         NENHUM ENDEREÇO
                    ================================================== -->
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div
                                class="card-body text-center py-5">
                                <i
                                    class="bi bi-geo-alt text-muted"
                                    style="font-size: 4rem;">
                                </i>
                                <h2 class="h5 fw-bold mt-3">
                                    Nenhum endereço cadastrado
                                </h2>
                                <p class="text-muted">
                                    Cadastre um endereço para facilitar
                                    suas compras e entregas.
                                </p>
                                <button
                                    type="button"
                                    class="btn btn-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalNovoEndereco">
                                    <i
                                        class="bi bi-plus-lg me-1">
                                    </i>
                                    Cadastrar endereço
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
    <!-- ============================================================
         MODAL NOVO ENDEREÇO
    ============================================================= -->
    <!-- ============================================================
     MODAL NOVO ENDEREÇO
============================================================= -->
<div class="modal fade" id="modalNovoEndereco" tabindex="-1" aria-labelledby="modalNovoEnderecoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fs-5" id="modalNovoEnderecoLabel">
                    <i class="bi bi-geo-alt text-primary me-2"></i>
                    Novo endereço
                </h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <form action="<?= BASE_URL ?>/cliente/endereco/cadastrar" method="post">
                <div class="modal-body">
                    <div class="row g-3">
                        <!-- IDENTIFICAÇÃO (SELECT) -->
                        <div class="col-12">
                            <label for="identificacao" class="form-label">
                                Identificação do endereço
                            </label>
                            <select class="form-select" id="identificacao" name="identificacao" required>
                                <option value="">Selecione uma opção</option>
                                <option value="Casa">Casa</option>
                                <option value="Trabalho">Trabalho</option>
                                <option value="Apartamento">Apartamento</option>
                                <option value="Comercial">Comercial</option>
                                <option value="Outro">Outro</option>
                            </select>
                        </div>
                        
                        <!-- DESTINATÁRIO -->
                        <div class="col-12">
                            <label for="destinatario" class="form-label">Nome do destinatário</label>
                            <input type="text" class="form-control" id="destinatario" name="destinatario" placeholder="Nome completo" maxlength="150" required>
                        </div>

                        <!-- CEP -->
                        <div class="col-12 col-md-4">
                            <label for="cep" class="form-label">CEP</label>
                            <input type="text" class="form-control" id="cep" name="cep" placeholder="00000-000" maxlength="9" required>
                        </div>

                        <!-- LOGRADOURO -->
                        <div class="col-12 col-md-8">
                            <label for="logradouro" class="form-label">Rua / Avenida</label>
                            <input type="text" class="form-control" id="logradouro" name="logradouro" placeholder="Nome da rua ou avenida" maxlength="180" required>
                        </div>

                        <!-- NÚMERO -->
                        <div class="col-12 col-md-4">
                            <label for="numero" class="form-label">Número</label>
                            <input type="text" class="form-control" id="numero" name="numero" maxlength="20" required>
                        </div>

                        <!-- COMPLEMENTO -->
                        <div class="col-12 col-md-8">
                            <label for="complemento" class="form-label">Complemento</label>
                            <input type="text" class="form-control" id="complemento" name="complemento" placeholder="Apartamento, bloco, sala..." maxlength="120">
                        </div>

                        <!-- BAIRRO -->
                        <div class="col-12 col-md-6">
                            <label for="bairro" class="form-label">Bairro</label>
                            <input type="text" class="form-control" id="bairro" name="bairro" maxlength="120" required>
                        </div>

                        <!-- CIDADE -->
                        <div class="col-12 col-md-6">
                            <label for="cidade" class="form-label">Cidade</label>
                            <input type="text" class="form-control" id="cidade" name="cidade" maxlength="120" required>
                        </div>

                        <!-- ESTADO -->
                        <div class="col-12 col-md-4">
                            <label for="estado" class="form-label">Estado</label>
                            <select class="form-select" id="estado" name="estado" required>
                                <option value="">Selecione</option>
                                <?php foreach ($estados as $uf): ?>
                                    <option value="<?= $uf ?>"><?= $uf ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- PRINCIPAL -->
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="principal" name="principal" value="1">
                                <label class="form-check-label" for="principal">
                                    Definir como meu endereço principal
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i>
                        Salvar endereço
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
    <!-- ============================================================
         FOOTER
    ============================================================= -->
    <footer class="bg-dark text-white mt-5">
        <div class="container py-4">
            <div class="row align-items-center">
                <div class="col-12 col-md-6 text-center text-md-start">
                    <strong>
                        Loja Online
                    </strong>
                    <p class="small text-white-50 mb-0">
                        Sua loja online com segurança e praticidade.
                    </p>
                </div>
                <div
                    class="col-12 col-md-6 text-center text-md-end mt-3 mt-md-0">
                    <a
                        href=""
                        class="text-white text-decoration-none me-3">
                        Loja
                    </a>
                    <a
                        href="produtos"
                        class="text-white text-decoration-none me-3">
                        Produtos
                    </a>
                    <a
                        href="cliente/pedidos"
                        class="text-white text-decoration-none">
                        Meus Pedidos
                    </a>
                </div>
            </div>
            <hr class="border-secondary">
            <div class="text-center">
                <small class="text-white-50">
                    &copy; 2026 Loja Online.
                    Todos os direitos reservados.
                </small>
            </div>
        </div>
    </footer>
    <!-- Bootstrap JS -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
    </script>
</body>
</html>