<?php
declare(strict_types=1);
use App\Helpers\View;
$tituloPagina = $tituloPagina   ?? 'Cliente Cadastro';
$descricaoPagina = $descricaoPagina ?? 'Loja online com produtos, ofertas, atendimento ao cliente e compra segura.';
$baseUrl = defined('BASE_URL')? BASE_URL: '';?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta
        name="description"
        content="">
    <title><?= htmlspecialchars($tituloPagina,ENT_QUOTES,'UTF-8');  ?></title>
    <!--
        Caminho-base das rotas no XAMPP.
        Quando o projeto funcionar sem /public, altere para:
        <base href="/loja_online/">
    -->
    <base href="/loja_online/public/">
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous">
    <link rel="stylesheet" href="<?= htmlspecialchars($baseUrl . '/assets/css/site.css',ENT_QUOTES,'UTF-8')?>">
</head>
<body>
    <!-- ============================================================
         1. BARRA SUPERIOR
    ============================================================= -->
    <?php require_once APP_ROOT  . '/views/componentes/site/sections/barraSuperior.php'; ?>
    <!-- ============================================================
         2. MENU PRINCIPAL
    ============================================================= -->
    <?php View::componente('header', ['categorias' => $categorias,]); ?>
    <main class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10 col-xl-8">

                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4 p-md-5">

                            <div class="text-center mb-4">
                                <h1 class="h3 mb-2">
                                    <?= htmlspecialchars($tituloPagina, ENT_QUOTES, 'UTF-8'); ?>
                                </h1>
                                <p class="text-muted mb-0">
                                    Crie sua conta para realizar compras e acompanhar seus pedidos.
                                </p>
                            </div>

                            <?php if (!empty($erro)): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?= htmlspecialchars((string) $erro, ENT_QUOTES, 'UTF-8'); ?>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($sucesso)): ?>
                                <div class="alert alert-success" role="alert">
                                    <?= htmlspecialchars((string) $sucesso, ENT_QUOTES, 'UTF-8'); ?>
                                </div>
                            <?php endif; ?>

                            <form
                                action="<?= htmlspecialchars($baseUrl . '/cliente/cadastrar', ENT_QUOTES, 'UTF-8'); ?>"
                                method="post"
                                autocomplete="on"
                            >

                                <?php if (!empty($csrfToken)): ?>
                                    <input
                                        type="hidden"
                                        name="csrf_token"
                                        value="<?= htmlspecialchars((string) $csrfToken, ENT_QUOTES, 'UTF-8'); ?>"
                                    >
                                <?php endif; ?>

                                <h2 class="h5 mb-3">Dados pessoais</h2>

                                <div class="row g-3">
                                    <div class="col-12 col-md-8">
                                        <label for="nome" class="form-label">
                                            Nome completo <span class="text-danger">*</span>
                                        </label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="nome"
                                            name="nome"
                                            maxlength="150"
                                            required
                                            autocomplete="name"
                                            value="<?= htmlspecialchars((string) ($dados['nome'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>"
                                        >
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <label for="cpf" class="form-label">
                                            CPF <span class="text-danger">*</span>
                                        </label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="cpf"
                                            name="cpf"
                                            maxlength="14"
                                            inputmode="numeric"
                                            required
                                            placeholder="000.000.000-00"
                                            value="<?= htmlspecialchars((string) ($dados['cpf'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>"
                                        >
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label for="data_nascimento" class="form-label">
                                            Data de nascimento
                                        </label>
                                        <input
                                            type="date"
                                            class="form-control"
                                            id="data_nascimento"
                                            name="data_nascimento"
                                            autocomplete="bday"
                                            value="<?= htmlspecialchars((string) ($dados['data_nascimento'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>"
                                        >
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label for="telefone" class="form-label">
                                            Telefone / WhatsApp <span class="text-danger">*</span>
                                        </label>
                                        <input
                                            type="tel"
                                            class="form-control"
                                            id="telefone"
                                            name="telefone"
                                            maxlength="15"
                                            required
                                            autocomplete="tel"
                                            placeholder="(85) 99999-9999"
                                            value="<?= htmlspecialchars((string) ($dados['telefone'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>"
                                        >
                                    </div>
                                </div>

                                <hr class="my-4">

                                <h2 class="h5 mb-3">Endereço</h2>

                                <div class="row g-3">
                                    <div class="col-12 col-md-4">
                                        <label for="cep" class="form-label">
                                            CEP <span class="text-danger">*</span>
                                        </label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="cep"
                                            name="cep"
                                            maxlength="9"
                                            required
                                            autocomplete="postal-code"
                                            placeholder="00000-000"
                                            value="<?= htmlspecialchars((string) ($dados['cep'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>"
                                        >
                                    </div>

                                    <div class="col-12 col-md-8">
                                        <label for="logradouro" class="form-label">
                                            Endereço <span class="text-danger">*</span>
                                        </label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="logradouro"
                                            name="logradouro"
                                            maxlength="180"
                                            required
                                            autocomplete="street-address"
                                            value="<?= htmlspecialchars((string) ($dados['logradouro'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>"
                                        >
                                    </div>

                                    <div class="col-12 col-md-3">
                                        <label for="numero" class="form-label">
                                            Número <span class="text-danger">*</span>
                                        </label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="numero"
                                            name="numero"
                                            maxlength="20"
                                            required
                                            value="<?= htmlspecialchars((string) ($dados['numero'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>"
                                        >
                                    </div>

                                    <div class="col-12 col-md-5">
                                        <label for="complemento" class="form-label">
                                            Complemento
                                        </label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="complemento"
                                            name="complemento"
                                            maxlength="100"
                                            placeholder="Apartamento, bloco..."
                                            value="<?= htmlspecialchars((string) ($dados['complemento'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>"
                                        >
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <label for="bairro" class="form-label">
                                            Bairro <span class="text-danger">*</span>
                                        </label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="bairro"
                                            name="bairro"
                                            maxlength="100"
                                            required
                                            value="<?= htmlspecialchars((string) ($dados['bairro'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>"
                                        >
                                    </div>

                                    <div class="col-12 col-md-8">
                                        <label for="cidade" class="form-label">
                                            Cidade <span class="text-danger">*</span>
                                        </label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="cidade"
                                            name="cidade"
                                            maxlength="100"
                                            required
                                            autocomplete="address-level2"
                                            value="<?= htmlspecialchars((string) ($dados['cidade'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>"
                                        >
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <label for="estado" class="form-label">
                                            Estado <span class="text-danger">*</span>
                                        </label>
                                        <select
                                            class="form-select"
                                            id="estado"
                                            name="estado"
                                            required
                                            autocomplete="address-level1"
                                        >
                                            <option value="">Selecione</option>
                                            <?php
                                            $estados = [
                                                'AC' => 'Acre',
                                                'AL' => 'Alagoas',
                                                'AP' => 'Amapá',
                                                'AM' => 'Amazonas',
                                                'BA' => 'Bahia',
                                                'CE' => 'Ceará',
                                                'DF' => 'Distrito Federal',
                                                'ES' => 'Espírito Santo',
                                                'GO' => 'Goiás',
                                                'MA' => 'Maranhão',
                                                'MT' => 'Mato Grosso',
                                                'MS' => 'Mato Grosso do Sul',
                                                'MG' => 'Minas Gerais',
                                                'PA' => 'Pará',
                                                'PB' => 'Paraíba',
                                                'PR' => 'Paraná',
                                                'PE' => 'Pernambuco',
                                                'PI' => 'Piauí',
                                                'RJ' => 'Rio de Janeiro',
                                                'RN' => 'Rio Grande do Norte',
                                                'RS' => 'Rio Grande do Sul',
                                                'RO' => 'Rondônia',
                                                'RR' => 'Roraima',
                                                'SC' => 'Santa Catarina',
                                                'SP' => 'São Paulo',
                                                'SE' => 'Sergipe',
                                                'TO' => 'Tocantins',
                                            ];

                                            $estadoSelecionado = (string) ($dados['estado'] ?? '');

                                            foreach ($estados as $sigla => $estadoNome):
                                            ?>
                                                <option
                                                    value="<?= htmlspecialchars($sigla, ENT_QUOTES, 'UTF-8'); ?>"
                                                    <?= $estadoSelecionado === $sigla ? 'selected' : ''; ?>
                                                >
                                                    <?= htmlspecialchars($estadoNome, ENT_QUOTES, 'UTF-8'); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <h2 class="h5 mb-3">Dados de acesso</h2>

                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="email" class="form-label">
                                            E-mail <span class="text-danger">*</span>
                                        </label>
                                        <input
                                            type="email"
                                            class="form-control"
                                            id="email"
                                            name="email"
                                            maxlength="180"
                                            required
                                            autocomplete="email"
                                            value="<?= htmlspecialchars((string) ($dados['email'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>"
                                        >
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label for="senha" class="form-label">
                                            Senha <span class="text-danger">*</span>
                                        </label>
                                        <input
                                            type="password"
                                            class="form-control"
                                            id="senha"
                                            name="senha"
                                            minlength="8"
                                            maxlength="255"
                                            required
                                            autocomplete="new-password"
                                        >
                                        <div class="form-text">
                                            Utilize pelo menos 8 caracteres.
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label for="confirmar_senha" class="form-label">
                                            Confirmar senha <span class="text-danger">*</span>
                                        </label>
                                        <input
                                            type="password"
                                            class="form-control"
                                            id="confirmar_senha"
                                            name="confirmar_senha"
                                            minlength="8"
                                            maxlength="255"
                                            required
                                            autocomplete="new-password"
                                        >
                                    </div>
                                </div>

                                <div class="form-check mt-4">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        value="1"
                                        id="aceite_termos"
                                        name="aceite_termos"
                                        required
                                    >
                                    <label class="form-check-label" for="aceite_termos">
                                        Li e aceito os termos de uso e a política de privacidade.
                                    </label>
                                </div>

                                <div class="form-check mt-2">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        value="1"
                                        id="newsletter"
                                        name="newsletter"
                                    >
                                    <label class="form-check-label" for="newsletter">
                                        Desejo receber ofertas e novidades por e-mail.
                                    </label>
                                </div>

                                <div class="d-grid mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        Criar minha conta
                                    </button>
                                </div>

                                <div class="text-center mt-4">
                                    <span class="text-muted">Já possui cadastro?</span>
                                    <a
                                        href="<?= htmlspecialchars($baseUrl . '/cliente/login', ENT_QUOTES, 'UTF-8'); ?>"
                                        class="text-decoration-none fw-semibold"
                                    >
                                        Entrar
                                    </a>
                                </div>

                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>
    <!-- ============================================================
         9. RODAPÉ
    ============================================================= -->
    <?php View::componente('footer');?>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>
</html>