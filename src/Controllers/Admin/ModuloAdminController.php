<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Helpers\IdSeguro;
use App\Repositories\AdminRepository;
use App\Repositories\ProdutoAdminRepository;
use App\Repositories\ProdutoImagemAdminRepository;
use App\Services\ProdutoImagemService;
use App\Repositories\AdminCategoriasRepository;
use DateTime;
use RuntimeException;
use Throwable;

final class ModuloAdminController
{
    public function relatorios(): void
    {
        $this->carregarView('relatorios');
    }

    public function produtos(): void
    {
        [$pdo, $repository] = $this->produtoRepository();

        $busca = trim((string) ($_GET['q'] ?? ''));

        $categoriaId = filter_input(
            INPUT_GET,
            'categoria',
            FILTER_VALIDATE_INT
        );

        if ($categoriaId === false || $categoriaId === null || $categoriaId < 1) {
            $categoriaId = null;
        }

        $destaqueRecebido = (string) ($_GET['destaque'] ?? '');
        $destaque = null;

        if ($destaqueRecebido === '0' || $destaqueRecebido === '1') {
            $destaque = (int) $destaqueRecebido;
        }

        $categorias = $repository->listarCategorias();
        $produtos = $repository->listarComFiltros(
            $busca,
            $categoriaId,
            $destaque
        );

        foreach ($produtos as &$produto) {
            $produto['id_seguro'] = IdSeguro::criptografar((int) $produto['id']);
        }
        unset($produto);

        $this->carregarView('produtos', [
            'produtos' => $produtos,
            'categorias' => $categorias,
            'filtros' => [
                'q' => $busca,
                'categoria' => $categoriaId,
                'destaque' => $destaqueRecebido,
            ],
        ]);
    }

    public function produtoNovo(): void
    {
        $this->carregarView('produto_novo');
    }

    public function produtoImagens(): void
    {
        [$pdo, $produtoRepository] = $this->produtoRepository();

        $token = trim((string) ($_GET['id'] ?? ''));
        $produtoId = $this->validarETraduzirToken($token);

        $produto = $produtoRepository->buscarPorId($produtoId);
        if ($produto === null) {
            http_response_code(404);
            throw new RuntimeException('Produto não encontrado.');
        }

        $imagemRepository = new ProdutoImagemAdminRepository($pdo);
        $imagens = $imagemRepository->listarPorProduto($produtoId);

        foreach ($imagens as &$imagem) {
            $imagem['id_seguro'] = IdSeguro::criptografar((int) $imagem['id']);
        }
        unset($imagem);

        $erro = $_SESSION['admin_produto_imagem_erro'] ?? null;
        $sucesso = $_SESSION['admin_produto_imagem_sucesso'] ?? null;

        unset(
            $_SESSION['admin_produto_imagem_erro'],
            $_SESSION['admin_produto_imagem_sucesso']
        );

        $this->carregarView('produto_imagens', [
            'produto' => $produto,
            'produtoToken' => $token,
            'imagens' => $imagens,
            'csrfToken' => $this->gerarCsrfProduto(),
            'erro' => $erro,
            'sucesso' => $sucesso,
        ]);
    }

    public function produtoImagensUpload(): void
    {
        [$pdo, $produtoRepository] = $this->produtoRepository();

        $token = trim((string) ($_POST['id'] ?? ''));
        $produtoId = $this->validarETraduzirToken($token);

        if (!$this->validarCsrfProduto((string) ($_POST['csrf_token'] ?? ''))) {
            $this->redirecionarProdutoImagens(
                $token,
                'O formulário expirou. Atualize a página e tente novamente.'
            );
        }

        $produto = $produtoRepository->buscarPorId($produtoId);
        if ($produto === null) {
            http_response_code(404);
            throw new RuntimeException('Produto não encontrado.');
        }

        $arquivos = $this->normalizarArquivosUpload($_FILES['imagens'] ?? []);

        if ($arquivos === []) {
            $this->redirecionarProdutoImagens($token, 'Selecione pelo menos uma imagem.');
        }

        if (count($arquivos) > 20) {
            $this->redirecionarProdutoImagens($token, 'Envie no máximo 20 imagens por vez.');
        }

        $imagemRepository = new ProdutoImagemAdminRepository($pdo);
        $servicoImagem = new ProdutoImagemService(dirname(__DIR__, 3));
        $arquivosCriados = [];

        try {
            $pdo->beginTransaction();

            $possuiPrincipal = $imagemRepository->possuiPrincipal($produtoId);
            $ordem = $imagemRepository->proximaOrdem($produtoId);

            foreach ($arquivos as $indice => $arquivo) {
                $processada = $servicoImagem->processarUpload(
                    $arquivo,
                    (string) $produto['nome'],
                    $produtoId,
                    (int) $produto['categoria_id'],
                    time() + $indice
                );

                $arquivosCriados[] = $processada['caminho_fisico'];
                $principal = !$possuiPrincipal && $indice === 0;

                $imagemRepository->inserir(
                    $produtoId,
                    $processada['url_imagem'],
                    (string) $produto['nome'],
                    $principal,
                    $ordem + $indice
                );

                if ($principal) {
                    $possuiPrincipal = true;
                }
            }

            $pdo->commit();

            $_SESSION['admin_produto_imagem_sucesso'] = count($arquivos) . (
                count($arquivos) === 1
                ? ' imagem enviada com sucesso.'
                : ' imagens enviadas com sucesso.'
            );

            $this->redirecionarProdutoImagens($token);
        } catch (Throwable $erro) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }

            foreach ($arquivosCriados as $arquivoCriado) {
                if (is_string($arquivoCriado) && is_file($arquivoCriado)) {
                    @unlink($arquivoCriado);
                }
            }

            error_log('[ADMIN PRODUTO IMAGENS UPLOAD] ' . $erro->getMessage());
            $this->redirecionarProdutoImagens($token, $erro->getMessage());
        }
    }

    public function produtoImagemPrincipal(): void
    {
        [$pdo, $produtoRepository] = $this->produtoRepository();

        $produtoToken = trim((string) ($_POST['id'] ?? ''));
        $imagemToken = trim((string) ($_POST['imagem_id'] ?? ''));

        if ($produtoToken === '' || $imagemToken === '') {
            http_response_code(400);
            throw new RuntimeException('Produto ou imagem não informado.');
        }

        if (!$this->validarCsrfProduto((string) ($_POST['csrf_token'] ?? ''))) {
            $this->redirecionarProdutoImagens(
                $produtoToken,
                'O formulário expirou. Atualize a página e tente novamente.'
            );
        }

        $produtoId = IdSeguro::descriptografar($produtoToken);
        $imagemId = IdSeguro::descriptografar($imagemToken);

        if ($produtoId === null || $produtoId < 1 || $imagemId === null || $imagemId < 1) {
            http_response_code(400);
            throw new RuntimeException('Identificador inválido.');
        }

        $produto = $produtoRepository->buscarPorId($produtoId);
        if ($produto === null) {
            http_response_code(404);
            throw new RuntimeException('Produto não encontrado.');
        }

        $imagemRepository = new ProdutoImagemAdminRepository($pdo);
        $imagem = $imagemRepository->buscarPorIdEProduto($imagemId, $produtoId);

        if ($imagem === null) {
            $this->redirecionarProdutoImagens(
                $produtoToken,
                'A imagem selecionada não pertence a este produto.'
            );
        }

        try {
            $pdo->beginTransaction();
            $imagemRepository->definirComoPrincipal($produtoId, $imagemId);
            $pdo->commit();

            $_SESSION['admin_produto_imagem_sucesso'] = 'Imagem principal alterada com sucesso.';
            $this->redirecionarProdutoImagens($produtoToken);
        } catch (Throwable $erro) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }

            error_log('[ADMIN PRODUTO IMAGEM PRINCIPAL] ' . $erro->getMessage());
            $this->redirecionarProdutoImagens(
                $produtoToken,
                'Não foi possível definir a imagem principal.'
            );
        }
    }

    public function produtoImagemExcluir(): void
    {
        [$pdo, $produtoRepository] = $this->produtoRepository();

        $produtoToken = trim((string) ($_POST['id'] ?? ''));
        $imagemToken = trim((string) ($_POST['imagem_id'] ?? ''));

        if ($produtoToken === '' || $imagemToken === '') {
            http_response_code(400);
            throw new RuntimeException('Produto ou imagem não informado.');
        }

        if (!$this->validarCsrfProduto((string) ($_POST['csrf_token'] ?? ''))) {
            $this->redirecionarProdutoImagens(
                $produtoToken,
                'O formulário expirou. Atualize a página e tente novamente.'
            );
        }

        $produtoId = IdSeguro::descriptografar($produtoToken);
        $imagemId = IdSeguro::descriptografar($imagemToken);

        if ($produtoId === null || $produtoId < 1 || $imagemId === null || $imagemId < 1) {
            http_response_code(400);
            throw new RuntimeException('Identificador inválido.');
        }

        if ($produtoRepository->buscarPorId($produtoId) === null) {
            http_response_code(404);
            throw new RuntimeException('Produto não encontrado.');
        }

        $imagemRepository = new ProdutoImagemAdminRepository($pdo);
        $imagem = $imagemRepository->buscarPorIdEProduto($imagemId, $produtoId);

        if ($imagem === null) {
            $this->redirecionarProdutoImagens($produtoToken, 'Imagem não encontrada.');
        }

        $eraPrincipal = (int) $imagem['principal'] === 1;

        try {
            $pdo->beginTransaction();
            $imagemRepository->excluir($imagemId, $produtoId);

            if ($eraPrincipal) {
                $imagemRepository->definirPrimeiraDisponivelComoPrincipal($produtoId);
            }

            $pdo->commit();

            $servicoImagem = new ProdutoImagemService(dirname(__DIR__, 3));
            $apagouArquivo = $servicoImagem->excluirPorUrl((string) $imagem['url_imagem']);

            $_SESSION['admin_produto_imagem_sucesso'] = $apagouArquivo
                ? 'Imagem excluída com sucesso.'
                : 'Registro excluído, mas o arquivo físico não pôde ser removido.';

            $this->redirecionarProdutoImagens($produtoToken);
        } catch (Throwable $erro) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }

            error_log('[ADMIN PRODUTO IMAGEM EXCLUIR] ' . $erro->getMessage());
            $this->redirecionarProdutoImagens($produtoToken, 'Não foi possível excluir a imagem.');
        }
    }

    public function produtoEditar(): void
    {
        [$pdo, $repository] = $this->produtoRepository();

        $token = trim((string) ($_GET['id'] ?? ''));
        $produtoId = $this->validarETraduzirToken($token);

        $produto = $repository->buscarPorId($produtoId);
        if ($produto === null) {
            http_response_code(404);
            throw new RuntimeException('Produto não encontrado.');
        }

        $categorias = $repository->listarCategorias();
        $imagemRepository = new ProdutoImagemAdminRepository($pdo);
        $imagemPrincipal = $imagemRepository->buscarPrincipal($produtoId);

        $erro = $_SESSION['admin_produto_erro'] ?? null;
        $sucesso = $_SESSION['admin_produto_sucesso'] ?? null;
        $dadosFormulario = $_SESSION['admin_produto_dados'] ?? $produto;

        unset(
            $_SESSION['admin_produto_erro'],
            $_SESSION['admin_produto_sucesso'],
            $_SESSION['admin_produto_dados']
        );

        $this->carregarView('produto_editar', [
            'produto' => $produto,
            'dadosFormulario' => $dadosFormulario,
            'categorias' => $categorias,
            'imagemPrincipal' => $imagemPrincipal,
            'produtoToken' => $token,
            'csrfToken' => $this->gerarCsrfProduto(),
            'erro' => $erro,
            'sucesso' => $sucesso,
        ]);
    }

    public function produtoAtualizar(): void
    {
        [$pdo, $repository] = $this->produtoRepository();

        $token = trim((string) ($_POST['id'] ?? ''));
        $produtoId = $this->validarETraduzirToken($token);

        if (!$this->validarCsrfProduto((string) ($_POST['csrf_token'] ?? ''))) {
            $this->redirecionarProdutoEditar(
                $token,
                'O formulário expirou. Atualize a página e tente novamente.',
                $_POST
            );
        }

        $categoriaId = filter_input(INPUT_POST, 'categoria_id', FILTER_VALIDATE_INT);
        $nome = trim((string) ($_POST['nome'] ?? ''));
        $slug = trim((string) ($_POST['slug'] ?? ''));
        $descricao = trim((string) ($_POST['descricao'] ?? ''));
        $precoTexto = str_replace(',', '.', trim((string) ($_POST['preco'] ?? '')));
        $estoque = filter_input(INPUT_POST, 'estoque', FILTER_VALIDATE_INT);
        $status = trim((string) ($_POST['status'] ?? ''));

        $destaque = isset($_POST['destaque']) ? 1 : 0;
        $ofertaAtiva = isset($_POST['oferta_ativa']) ? 1 : 0;

        $percentualTexto = str_replace(',', '.', trim((string) ($_POST['percentual_oferta'] ?? '')));
        $ofertaInicioTexto = trim((string) ($_POST['oferta_inicio'] ?? ''));
        $ofertaFimTexto = trim((string) ($_POST['oferta_fim'] ?? ''));

        $erros = [];

        if (!$categoriaId || $categoriaId < 1) {
            $erros[] = 'Selecione uma categoria válida.';
        }
        if ($nome === '') {
            $erros[] = 'Informe o nome do produto.';
        }
        if ($slug === '') {
            $slug = $this->gerarSlug($nome);
        }
        if ($precoTexto === '' || !is_numeric($precoTexto) || (float) $precoTexto < 0) {
            $erros[] = 'Informe um preço válido.';
        }
        if ($estoque === false || $estoque === null || $estoque < 0) {
            $erros[] = 'Informe um estoque válido.';
        }
        if (!in_array($status, ['ativo', 'inativo'], true)) {
            $erros[] = 'Status inválido.';
        }

        $percentualOferta = null;
        if ($percentualTexto !== '') {
            if (!is_numeric($percentualTexto) || (float) $percentualTexto < 0 || (float) $percentualTexto > 100) {
                $erros[] = 'O percentual da oferta deve estar entre 0 e 100.';
            } else {
                $percentualOferta = number_format((float) $percentualTexto, 2, '.', '');
            }
        }

        if ($ofertaAtiva === 1 && ($percentualOferta === null || (float) $percentualOferta <= 0)) {
            $erros[] = 'Informe um percentual maior que zero para ativar a oferta.';
        }

        $ofertaInicio = $this->converterDataHora($ofertaInicioTexto);
        $ofertaFim = $this->converterDataHora($ofertaFimTexto);

        if ($ofertaInicioTexto !== '' && $ofertaInicio === null) {
            $erros[] = 'Data inicial da oferta inválida.';
        }
        if ($ofertaFimTexto !== '' && $ofertaFim === null) {
            $erros[] = 'Data final da oferta inválida.';
        }
        if ($ofertaInicio !== null && $ofertaFim !== null && strtotime($ofertaFim) <= strtotime($ofertaInicio)) {
            $erros[] = 'A data final da oferta deve ser posterior à data inicial.';
        }

        if ($erros !== []) {
            $this->redirecionarProdutoEditar($token, implode(' ', $erros), $_POST);
        }

        $dados = [
            'categoria_id' => (int) $categoriaId,
            'nome' => $nome,
            'slug' => $slug,
            'descricao' => $descricao !== '' ? $descricao : null,
            'preco' => number_format((float) $precoTexto, 2, '.', ''),
            'oferta_ativa' => $ofertaAtiva,
            'percentual_oferta' => $ofertaAtiva === 1 ? $percentualOferta : null,
            'oferta_inicio' => $ofertaAtiva === 1 ? $ofertaInicio : null,
            'oferta_fim' => $ofertaAtiva === 1 ? $ofertaFim : null,
            'estoque' => (int) $estoque,
            'status' => $status,
            'destaque' => $destaque,
        ];

        try {
            $repository->atualizar($produtoId, $dados);

            $_SESSION['admin_produto_sucesso'] = 'Produto atualizado com sucesso.';
            header('Location: ' . $this->baseUrl() . '/admin/produto/editar?id=' . rawurlencode($token));
            exit;
        } catch (Throwable $erro) {
            error_log('[ADMIN PRODUTO ATUALIZAR] ' . $erro->getMessage());
            $this->redirecionarProdutoEditar(
                $token,
                'Não foi possível atualizar o produto. Verifique os dados e tente novamente.',
                $_POST
            );
        }
    }

    public function categorias(): void
    {
        $this->carregarView('categorias');
    }

    public function clientes(): void
    {
        $repository = $this->adminRepository();

        $busca = trim((string) ($_GET['busca'] ?? ''));
        $status = trim((string) ($_GET['status'] ?? ''));

        if (!in_array($status, ['', 'ativo', 'inativo', 'bloqueado'], true)) {
            $status = '';
        }

        $clientes = $repository->listarClientes($busca, $status);

        foreach ($clientes as &$cliente) {
            $cliente['id_seguro'] = IdSeguro::criptografar(
                (int) $cliente['id']
            );
        }
        unset($cliente);

        $sucesso = $_SESSION['admin_cliente_sucesso'] ?? null;
        $erro = $_SESSION['admin_cliente_erro'] ?? null;

        unset(
            $_SESSION['admin_cliente_sucesso'],
            $_SESSION['admin_cliente_erro']
        );

        $this->carregarView('clientes', [
            'clientes' => $clientes,
            'filtros' => [
                'busca' => $busca,
                'status' => $status,
            ],
            'csrfToken' => $this->gerarCsrfCliente(),
            'sucesso' => $sucesso,
            'erro' => $erro,
        ]);
    }

    public function clienteInativar(): void
    {
        /*
    |--------------------------------------------------------------------------
    | 1. Carrega conexão / .env / APP_KEY
    |--------------------------------------------------------------------------
    |
    | IMPORTANTE:
    | Isso precisa acontecer ANTES de usar IdSeguro.
    |
    */
        $repository = $this->adminRepository();


        /*
    |--------------------------------------------------------------------------
    | 2. Recebe dados do formulário
    |--------------------------------------------------------------------------
    */
        $token = trim(
            (string) ($_POST['id'] ?? '')
        );

        $csrfToken = (string) (
            $_POST['csrf_token']
            ?? ''
        );


        /*
    |--------------------------------------------------------------------------
    | 3. Valida CSRF
    |--------------------------------------------------------------------------
    */
        if (
            !$this->validarCsrfCliente(
                $csrfToken
            )
        ) {
            $_SESSION['admin_cliente_erro'] =
                'O formulário expirou. Atualize a página e tente novamente.';

            $this->redirecionarClientes();
        }


        /*
    |--------------------------------------------------------------------------
    | 4. Verifica se recebeu o ID
    |--------------------------------------------------------------------------
    */
        if ($token === '') {

            $_SESSION['admin_cliente_erro'] =
                'Cliente não informado.';

            $this->redirecionarClientes();
        }


        /*
    |--------------------------------------------------------------------------
    | 5. Descriptografa o ID
    |--------------------------------------------------------------------------
    |
    | Agora APP_KEY já foi carregada.
    |
    */
        $clienteId =
            IdSeguro::descriptografar(
                $token
            );


        /*
    |--------------------------------------------------------------------------
    | 6. Valida ID descriptografado
    |--------------------------------------------------------------------------
    */
        if (
            $clienteId === null
            || $clienteId < 1
        ) {

            $_SESSION['admin_cliente_erro'] =
                'Identificador do cliente inválido.';

            $this->redirecionarClientes();
        }


        /*
    |--------------------------------------------------------------------------
    | 7. Busca cliente
    |--------------------------------------------------------------------------
    */
        $cliente =
            $repository->buscarClientePorId(
                $clienteId
            );


        if ($cliente === null) {

            $_SESSION['admin_cliente_erro'] =
                'Cliente não encontrado.';

            $this->redirecionarClientes();
        }


        /*
    |--------------------------------------------------------------------------
    | 8. Verifica se já está inativo
    |--------------------------------------------------------------------------
    */
        if (
            ($cliente['status'] ?? '')
            === 'inativo'
        ) {

            $_SESSION['admin_cliente_sucesso'] =
                'O cliente já está inativo.';

            $this->redirecionarClientes();
        }


        /*
    |--------------------------------------------------------------------------
    | 9. Inativa cliente
    |--------------------------------------------------------------------------
    */
        try {

            $resultado =
                $repository->inativarCliente(
                    $clienteId
                );


            if (!$resultado) {

                throw new RuntimeException(
                    'Não foi possível alterar o status do cliente.'
                );
            }


            $_SESSION['admin_cliente_sucesso'] =
                'Cliente inativado com sucesso.';
        } catch (Throwable $erro) {

            error_log(
                '[ADMIN CLIENTE INATIVAR] '
                    . $erro->getMessage()
            );


            $_SESSION['admin_cliente_erro'] =
                'Não foi possível inativar o cliente.';
        }


        /*
    |--------------------------------------------------------------------------
    | 10. Retorna para clientes
    |--------------------------------------------------------------------------
    */
        $this->redirecionarClientes();
    }


    public function clienteAtivar(): void
    {
        /*
    |--------------------------------------------------------------------------
    | 1. Carrega conexão / .env / APP_KEY
    |--------------------------------------------------------------------------
    |
    | Precisa acontecer antes de IdSeguro::descriptografar().
    |
    */
        $repository = $this->adminRepository();


        /*
    |--------------------------------------------------------------------------
    | 2. Recebe formulário
    |--------------------------------------------------------------------------
    */
        $token = trim(
            (string) ($_POST['id'] ?? '')
        );

        $csrfToken = (string) (
            $_POST['csrf_token']
            ?? ''
        );


        /*
    |--------------------------------------------------------------------------
    | 3. Valida CSRF
    |--------------------------------------------------------------------------
    */
        if (
            !$this->validarCsrfCliente(
                $csrfToken
            )
        ) {
            $_SESSION['admin_cliente_erro'] =
                'O formulário expirou. Atualize a página e tente novamente.';

            $this->redirecionarClientes();
        }


        /*
    |--------------------------------------------------------------------------
    | 4. Verifica ID
    |--------------------------------------------------------------------------
    */
        if ($token === '') {

            $_SESSION['admin_cliente_erro'] =
                'Cliente não informado.';

            $this->redirecionarClientes();
        }


        /*
    |--------------------------------------------------------------------------
    | 5. Descriptografa ID
    |--------------------------------------------------------------------------
    */
        $clienteId =
            IdSeguro::descriptografar(
                $token
            );


        if (
            $clienteId === null
            || $clienteId < 1
        ) {

            $_SESSION['admin_cliente_erro'] =
                'Identificador do cliente inválido.';

            $this->redirecionarClientes();
        }


        /*
    |--------------------------------------------------------------------------
    | 6. Busca cliente
    |--------------------------------------------------------------------------
    */
        $cliente =
            $repository->buscarClientePorId(
                $clienteId
            );


        if ($cliente === null) {

            $_SESSION['admin_cliente_erro'] =
                'Cliente não encontrado.';

            $this->redirecionarClientes();
        }


        /*
    |--------------------------------------------------------------------------
    | 7. Verifica status
    |--------------------------------------------------------------------------
    */
        if (
            ($cliente['status'] ?? '')
            === 'ativo'
        ) {

            $_SESSION['admin_cliente_sucesso'] =
                'O cliente já está ativo.';

            $this->redirecionarClientes();
        }


        /*
    |--------------------------------------------------------------------------
    | 8. Somente cliente INATIVO pode ser ativado
    |--------------------------------------------------------------------------
    */
        if (
            ($cliente['status'] ?? '')
            !== 'inativo'
        ) {

            $_SESSION['admin_cliente_erro'] =
                'Somente clientes inativos podem ser ativados.';

            $this->redirecionarClientes();
        }


        /*
    |--------------------------------------------------------------------------
    | 9. Ativa cliente
    |--------------------------------------------------------------------------
    */
        try {

            $resultado =
                $repository->ativarCliente(
                    $clienteId
                );


            if (!$resultado) {

                throw new RuntimeException(
                    'Não foi possível ativar o cliente.'
                );
            }


            $_SESSION['admin_cliente_sucesso'] =
                'Cliente ativado com sucesso.';
        } catch (Throwable $erro) {

            error_log(
                '[ADMIN CLIENTE ATIVAR] '
                    . $erro->getMessage()
            );


            $_SESSION['admin_cliente_erro'] =
                'Não foi possível ativar o cliente.';
        }

        /*
    |--------------------------------------------------------------------------
    | 10. Volta para listagem
    |--------------------------------------------------------------------------
    */
        $this->redirecionarClientes();
    }

    public function clienteView(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Carrega conexão / .env / APP_KEY antes de usar IdSeguro
        |--------------------------------------------------------------------------
        */
        $repository = $this->adminRepository();

        $token = trim((string) ($_GET['id'] ?? ''));

        if ($token === '') {
            http_response_code(400);
            throw new RuntimeException('Cliente não informado.');
        }

        $clienteId = IdSeguro::descriptografar($token);

        if ($clienteId === null || $clienteId < 1) {
            http_response_code(400);
            throw new RuntimeException('Identificador do cliente inválido.');
        }

        $cliente = $repository->buscarClientePorId($clienteId);

        if ($cliente === null) {
            http_response_code(404);
            throw new RuntimeException('Cliente não encontrado.');
        }

        $enderecos = $repository->listarEnderecosCliente($clienteId);
        $pedidos = $repository->listarPedidosCliente($clienteId);
        $carrinhosAbertos = $repository->listarCarrinhosAbertosCliente($clienteId);

        foreach ($carrinhosAbertos as &$carrinho) {
            $carrinho['id_seguro'] = IdSeguro::criptografar(
                (int) $carrinho['id']
            );
        }
        unset($carrinho);

        $cliente['id_seguro'] = $token;

        $this->carregarView('cliente_view', [
            'cliente' => $cliente,
            'enderecos' => $enderecos,
            'pedidos' => $pedidos,
            'carrinhosAbertos' => $carrinhosAbertos,
        ]);
    }

    public function clienteCarrinho(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Carrega conexão / .env / APP_KEY antes de usar IdSeguro
        |--------------------------------------------------------------------------
        */
        $repository = $this->adminRepository();

        $token = trim((string) ($_GET['id'] ?? ''));

        if ($token === '') {
            http_response_code(400);
            throw new RuntimeException('Carrinho não informado.');
        }

        $carrinhoId = IdSeguro::descriptografar($token);

        if ($carrinhoId === null || $carrinhoId < 1) {
            http_response_code(400);
            throw new RuntimeException('Identificador do carrinho inválido.');
        }

        $carrinho = $repository->buscarCarrinhoAbertoPorId($carrinhoId);

        if ($carrinho === null) {
            http_response_code(404);
            throw new RuntimeException(
                'Carrinho aberto não encontrado.'
            );
        }

        $itens = $repository->listarItensCarrinho($carrinhoId);

        $totalUnidades = 0;
        $totalCarrinho = 0.0;

        foreach ($itens as $item) {
            $totalUnidades += (int) ($item['quantidade'] ?? 0);
            $totalCarrinho += (float) ($item['subtotal'] ?? 0);
        }

        $clienteToken = IdSeguro::criptografar(
            (int) $carrinho['cliente_id']
        );

        $this->carregarView('cliente_carrinho', [
            'carrinho' => $carrinho,
            'itens' => $itens,
            'totalUnidades' => $totalUnidades,
            'totalCarrinho' => $totalCarrinho,
            'clienteToken' => $clienteToken,
        ]);
    }

    public function pedidos(): void
    {
        $this->carregarView('pedidos');
    }

    public function pedidoDetalhes(): void
    {
        $pedidoId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$pedidoId || $pedidoId < 1) {
            http_response_code(400);
            throw new RuntimeException('Pedido inválido ou não informado.');
        }

        $this->carregarView('pedidos/detalhes', ['pedidoId' => (int) $pedidoId]);
    }

    public function pagamentos(): void
    {
        $this->carregarView('pagamentos');
    }
    public function carrinhos(): void
    {
        $this->carregarView('carrinhos');
    }

    public function estoque(): void
    {
        $filtro = trim((string) ($_GET['filtro'] ?? ''));
        $this->carregarView('estoque', ['filtro' => $filtro]);
    }

    public function notificacoes(): void
    {
        $this->carregarView('notificacoes');
    }
    public function contatos(): void
    {
        $this->carregarView('contatos');
    }
    public function configuracoes(): void
    {
        $this->carregarView('configuracoes');
    }
    public function perfil(): void
    {
        $this->carregarView('perfil');
    }
    public function perfilNovo(): void
    {
        $this->carregarView('perfil_novo');
    }
    public function perfilLista(): void
    {
        $this->carregarView('perfil_lista');
    }

    public function buscar(): void
    {
        $termo = trim((string) ($_GET['q'] ?? ''));
        $this->carregarView('buscar', ['termo' => $termo]);
    }

    public function sair(): void
    {
        unset(
            $_SESSION['admin_id'],
            $_SESSION['admin_nome'],
            $_SESSION['admin_email'],
            $_SESSION['usuario_admin']
        );

        session_regenerate_id(true);
        header('Location: ' . $this->baseUrl() . '/loginadmin');
        exit;
    }

    private function adminRepository(): AdminRepository
    {
        $raizProjeto = dirname(__DIR__, 3);
        require_once $raizProjeto . '/database/conexao.php';

        return new AdminRepository(\Config::connect());
    }

    private function gerarCsrfCliente(): string
    {
        if (empty($_SESSION['admin_cliente_csrf'])) {
            $_SESSION['admin_cliente_csrf'] = bin2hex(random_bytes(32));
        }

        return (string) $_SESSION['admin_cliente_csrf'];
    }

    private function validarCsrfCliente(string $token): bool
    {
        $salvo = (string) ($_SESSION['admin_cliente_csrf'] ?? '');

        return $token !== ''
            && $salvo !== ''
            && hash_equals($salvo, $token);
    }

    private function redirecionarClientes(): never
    {
        $base = defined('BASE_URL')
            ? rtrim((string) BASE_URL, '/')
            : $this->baseUrl();

        header('Location: ' . $base . '/admin/clientes');
        exit;
    }

    private function produtoRepository(): array
    {
        $raizProjeto = dirname(__DIR__, 3);
        require_once $raizProjeto . '/database/conexao.php';

        $pdo = \Config::connect();
        return [$pdo, new ProdutoAdminRepository($pdo)];
    }

    private function validarETraduzirToken(string $token): int
    {
        if ($token === '') {
            http_response_code(400);
            throw new RuntimeException('Produto não informado.');
        }

        $produtoId = IdSeguro::descriptografar($token);

        if ($produtoId === null || $produtoId < 1) {
            http_response_code(400);
            throw new RuntimeException('Identificador do produto inválido.');
        }

        return $produtoId;
    }

    private function gerarCsrfProduto(): string
    {
        if (empty($_SESSION['admin_produto_csrf'])) {
            $_SESSION['admin_produto_csrf'] = bin2hex(random_bytes(32));
        }

        return (string) $_SESSION['admin_produto_csrf'];
    }

    private function validarCsrfProduto(string $token): bool
    {
        $salvo = (string) ($_SESSION['admin_produto_csrf'] ?? '');
        return $token !== '' && $salvo !== '' && hash_equals($salvo, $token);
    }

    private function gerarSlug(string $texto): string
    {
        $texto = trim($texto);
        if ($texto === '') {
            return '';
        }

        $convertido = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $texto);
        if ($convertido !== false) {
            $texto = $convertido;
        }

        $texto = strtolower($texto);
        $texto = preg_replace('/[^a-z0-9]+/', '-', $texto) ?? '';

        return trim($texto, '-');
    }

    private function converterDataHora(string $valor): ?string
    {
        $valor = trim($valor);
        if ($valor === '') {
            return null;
        }

        $data = DateTime::createFromFormat('Y-m-d\TH:i', $valor);
        if (!$data || $data->format('Y-m-d\TH:i') !== $valor) {
            return null;
        }

        return $data->format('Y-m-d H:i:s');
    }

    private function redirecionarProdutoEditar(string $token, string $erro, array $dados): never
    {
        $_SESSION['admin_produto_erro'] = $erro;
        $_SESSION['admin_produto_dados'] = $dados;

        header('Location: ' . $this->baseUrl() . '/admin/produto/editar?id=' . rawurlencode($token));
        exit;
    }

    private function redirecionarProdutoImagens(string $token, ?string $erro = null): never
    {
        if ($erro !== null) {
            $_SESSION['admin_produto_imagem_erro'] = $erro;
        }

        header('Location: ' . $this->baseUrl() . '/admin/produto/imagens?id=' . rawurlencode($token));
        exit;
    }

    private function normalizarArquivosUpload(array $arquivos): array
    {
        if (!isset($arquivos['name'], $arquivos['tmp_name'], $arquivos['error'], $arquivos['size'])) {
            return [];
        }

        $normalizados = [];

        if (is_array($arquivos['name'])) {
            foreach ($arquivos['name'] as $i => $nome) {
                if (($arquivos['error'][$i] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK) {
                    $normalizados[] = [
                        'name'     => $nome,
                        'type'     => $arquivos['type'][$i] ?? '',
                        'tmp_name' => $arquivos['tmp_name'][$i],
                        'error'    => $arquivos['error'][$i],
                        'size'     => $arquivos['size'][$i],
                    ];
                }
            }
        } elseif (($arquivos['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK) {
            $normalizados[] = $arquivos;
        }

        return $normalizados;
    }

    private function carregarView(string $view, array $dados = []): void
    {
        extract($dados);
        $caminhoView = dirname(__DIR__, 3) . "/views/admin/{$view}.php";

        if (!file_exists($caminhoView)) {
            throw new RuntimeException("View [{$view}] não encontrada.");
        }

        require $caminhoView;
    }

    private function baseUrl(): string
    {
        $protocolo = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        return "{$protocolo}://{$host}";
    }
    public function categoriasadmin(): void
    {
        $repository = $this->categoriaRepository();

        $busca = trim(
            (string) ($_GET['q'] ?? '')
        );

        $status = trim(
            (string) ($_GET['status'] ?? '')
        );

        if (
            !in_array(
                $status,
                ['', 'ativo', 'inativo'],
                true
            )
        ) {
            $status = '';
        }

        $categorias = $repository->listar(
            $busca,
            $status
        );

        foreach ($categorias as &$categoria) {
            $categoria['id_seguro'] =
                IdSeguro::criptografar(
                    (int) $categoria['id']
                );
        }

        unset($categoria);

        $sucesso =
            $_SESSION['admin_categoria_sucesso']
            ?? null;

        $erro =
            $_SESSION['admin_categoria_erro']
            ?? null;

        unset(
            $_SESSION['admin_categoria_sucesso'],
            $_SESSION['admin_categoria_erro']
        );

        $this->carregarView(
            'categorias',
            [
                'categorias' => $categorias,

                'filtros' => [
                    'q' => $busca,
                    'status' => $status,
                ],

                'csrfToken' =>
                $this->gerarCsrfCategoria(),

                'sucesso' => $sucesso,
                'erro' => $erro,
            ]
        );
    }

    public function categoriaCadastrar(): void
    {
        $repository =
            $this->categoriaRepository();

        $csrfToken = (string) (
            $_POST['csrf_token']
            ?? ''
        );

        if (
            !$this->validarCsrfCategoria(
                $csrfToken
            )
        ) {
            $_SESSION['admin_categoria_erro'] =
                'O formulário expirou. Atualize a página e tente novamente.';

            $this->redirecionarCategorias();
        }

        $nome = trim(
            (string) ($_POST['nome'] ?? '')
        );

        $slugRecebido = trim(
            (string) ($_POST['slug'] ?? '')
        );

        $descricao = trim(
            (string) ($_POST['descricao'] ?? '')
        );

        $imgcategoria = trim(
            (string) ($_POST['imgcategoria'] ?? '')
        );

        $slug = $this->gerarSlug(
            $slugRecebido !== ''
                ? $slugRecebido
                : $nome
        );

        $erros = [];

        if ($nome === '') {
            $erros[] =
                'Informe o nome da categoria.';
        } elseif (mb_strlen($nome) > 100) {
            $erros[] =
                'O nome deve possuir no máximo 100 caracteres.';
        }

        if ($slug === '') {
            $erros[] =
                'Não foi possível gerar um slug válido.';
        } elseif (mb_strlen($slug) > 120) {
            $erros[] =
                'O slug deve possuir no máximo 120 caracteres.';
        }

        if (mb_strlen($descricao) > 255) {
            $erros[] =
                'A descrição deve possuir no máximo 255 caracteres.';
        }

        if (mb_strlen($imgcategoria) > 150) {
            $erros[] =
                'O nome/caminho da imagem deve possuir no máximo 150 caracteres.';
        }

        if (
            $nome !== ''
            && $repository->nomeExiste($nome)
        ) {
            $erros[] =
                'Já existe uma categoria com este nome.';
        }

        if (
            $slug !== ''
            && $repository->slugExiste($slug)
        ) {
            $erros[] =
                'Já existe uma categoria com este slug.';
        }

        if ($erros !== []) {
            $_SESSION['admin_categoria_erro'] =
                implode(' ', $erros);

            $this->redirecionarCategorias();
        }

        try {
            $repository->cadastrar([
                'nome' => $nome,
                'slug' => $slug,
                'descricao' =>
                $descricao !== ''
                    ? $descricao
                    : null,
                'imgcategoria' =>
                $imgcategoria !== ''
                    ? $imgcategoria
                    : null,
            ]);

            $_SESSION['admin_categoria_sucesso'] =
                'Categoria cadastrada com sucesso.';
        } catch (Throwable $erro) {
            error_log(
                '[ADMIN CATEGORIA CADASTRAR] '
                    . $erro->getMessage()
            );

            $_SESSION['admin_categoria_erro'] =
                'Não foi possível cadastrar a categoria.';
        }

        $this->redirecionarCategorias();
    }

    public function categoriaAtualizar(): void
    {
        /*
     * Carrega conexão/.env/APP_KEY antes do IdSeguro.
     */
        $repository =
            $this->categoriaRepository();

        if (
            !$this->validarCsrfCategoria(
                (string) (
                    $_POST['csrf_token']
                    ?? ''
                )
            )
        ) {
            $_SESSION['admin_categoria_erro'] =
                'O formulário expirou. Atualize a página e tente novamente.';

            $this->redirecionarCategorias();
        }

        $token = trim(
            (string) ($_POST['id'] ?? '')
        );

        if ($token === '') {
            $_SESSION['admin_categoria_erro'] =
                'Categoria não informada.';

            $this->redirecionarCategorias();
        }

        $categoriaId =
            IdSeguro::descriptografar($token);

        if (
            $categoriaId === null
            || $categoriaId < 1
        ) {
            $_SESSION['admin_categoria_erro'] =
                'Identificador da categoria inválido.';

            $this->redirecionarCategorias();
        }

        $categoria =
            $repository->buscarPorId(
                $categoriaId
            );

        if ($categoria === null) {
            $_SESSION['admin_categoria_erro'] =
                'Categoria não encontrada.';

            $this->redirecionarCategorias();
        }

        $nome = trim(
            (string) ($_POST['nome'] ?? '')
        );

        $slugRecebido = trim(
            (string) ($_POST['slug'] ?? '')
        );

        $descricao = trim(
            (string) ($_POST['descricao'] ?? '')
        );

        $imgcategoria = trim(
            (string) ($_POST['imgcategoria'] ?? '')
        );

        $slug = $this->gerarSlug(
            $slugRecebido !== ''
                ? $slugRecebido
                : $nome
        );

        $erros = [];

        if ($nome === '') {
            $erros[] =
                'Informe o nome da categoria.';
        } elseif (mb_strlen($nome) > 100) {
            $erros[] =
                'O nome deve possuir no máximo 100 caracteres.';
        }

        if ($slug === '') {
            $erros[] =
                'Não foi possível gerar um slug válido.';
        } elseif (mb_strlen($slug) > 120) {
            $erros[] =
                'O slug deve possuir no máximo 120 caracteres.';
        }

        if (mb_strlen($descricao) > 255) {
            $erros[] =
                'A descrição deve possuir no máximo 255 caracteres.';
        }

        if (mb_strlen($imgcategoria) > 150) {
            $erros[] =
                'O nome/caminho da imagem deve possuir no máximo 150 caracteres.';
        }

        if (
            $nome !== ''
            && $repository->nomeExiste(
                $nome,
                $categoriaId
            )
        ) {
            $erros[] =
                'Já existe outra categoria com este nome.';
        }

        if (
            $slug !== ''
            && $repository->slugExiste(
                $slug,
                $categoriaId
            )
        ) {
            $erros[] =
                'Já existe outra categoria com este slug.';
        }

        if ($erros !== []) {
            $_SESSION['admin_categoria_erro'] =
                implode(' ', $erros);

            $this->redirecionarCategorias();
        }

        try {
            $repository->atualizar(
                $categoriaId,
                [
                    'nome' => $nome,
                    'slug' => $slug,
                    'descricao' =>
                    $descricao !== ''
                        ? $descricao
                        : null,
                    'imgcategoria' =>
                    $imgcategoria !== ''
                        ? $imgcategoria
                        : null,
                ]
            );

            $_SESSION['admin_categoria_sucesso'] =
                'Categoria atualizada com sucesso.';
        } catch (Throwable $erro) {
            error_log(
                '[ADMIN CATEGORIA ATUALIZAR] '
                    . $erro->getMessage()
            );

            $_SESSION['admin_categoria_erro'] =
                'Não foi possível atualizar a categoria.';
        }

        $this->redirecionarCategorias();
    }

    public function categoriaDesativar(): void
    {
        $repository =
            $this->categoriaRepository();

        if (
            !$this->validarCsrfCategoria(
                (string) (
                    $_POST['csrf_token']
                    ?? ''
                )
            )
        ) {
            $_SESSION['admin_categoria_erro'] =
                'O formulário expirou. Atualize a página e tente novamente.';

            $this->redirecionarCategorias();
        }

        $token = trim(
            (string) ($_POST['id'] ?? '')
        );

        $categoriaId =
            IdSeguro::descriptografar($token);

        if (
            $categoriaId === null
            || $categoriaId < 1
        ) {
            $_SESSION['admin_categoria_erro'] =
                'Identificador da categoria inválido.';

            $this->redirecionarCategorias();
        }

        $categoria =
            $repository->buscarPorId(
                $categoriaId
            );

        if ($categoria === null) {
            $_SESSION['admin_categoria_erro'] =
                'Categoria não encontrada.';

            $this->redirecionarCategorias();
        }

        if ((int) $categoria['ativo'] === 0) {
            $_SESSION['admin_categoria_sucesso'] =
                'A categoria já está desativada.';

            $this->redirecionarCategorias();
        }

        try {
            $repository->desativar(
                $categoriaId
            );

            $_SESSION['admin_categoria_sucesso'] =
                'Categoria desativada com sucesso.';
        } catch (Throwable $erro) {
            error_log(
                '[ADMIN CATEGORIA DESATIVAR] '
                    . $erro->getMessage()
            );

            $_SESSION['admin_categoria_erro'] =
                'Não foi possível desativar a categoria.';
        }

        $this->redirecionarCategorias();
    }

    public function categoriaAtivar(): void
    {
        $repository =
            $this->categoriaRepository();

        if (
            !$this->validarCsrfCategoria(
                (string) (
                    $_POST['csrf_token']
                    ?? ''
                )
            )
        ) {
            $_SESSION['admin_categoria_erro'] =
                'O formulário expirou. Atualize a página e tente novamente.';

            $this->redirecionarCategorias();
        }

        $token = trim(
            (string) ($_POST['id'] ?? '')
        );

        $categoriaId =
            IdSeguro::descriptografar($token);

        if (
            $categoriaId === null
            || $categoriaId < 1
        ) {
            $_SESSION['admin_categoria_erro'] =
                'Identificador da categoria inválido.';

            $this->redirecionarCategorias();
        }

        $categoria =
            $repository->buscarPorId(
                $categoriaId
            );

        if ($categoria === null) {
            $_SESSION['admin_categoria_erro'] =
                'Categoria não encontrada.';

            $this->redirecionarCategorias();
        }

        if ((int) $categoria['ativo'] === 1) {
            $_SESSION['admin_categoria_sucesso'] =
                'A categoria já está ativa.';

            $this->redirecionarCategorias();
        }

        try {
            $repository->ativar(
                $categoriaId
            );

            $_SESSION['admin_categoria_sucesso'] =
                'Categoria ativada com sucesso.';
        } catch (Throwable $erro) {
            error_log(
                '[ADMIN CATEGORIA ATIVAR] '
                    . $erro->getMessage()
            );

            $_SESSION['admin_categoria_erro'] =
                'Não foi possível ativar a categoria.';
        }

        $this->redirecionarCategorias();
    }


    /*
|--------------------------------------------------------------------------
| MÉTODOS PRIVADOS
|--------------------------------------------------------------------------
|
| Adicione estes métodos na área dos métodos private do controller.
|
*/

    private function categoriaRepository(): AdminCategoriasRepository
    {
        $raizProjeto =
            dirname(__DIR__, 3);

        require_once
            $raizProjeto
            . '/database/conexao.php';

        $pdo = \Config::connect();

        return new AdminCategoriasRepository(
            $pdo
        );
    }

    private function gerarCsrfCategoria(): string
    {
        if (
            empty($_SESSION['admin_categoria_csrf'])
        ) {
            $_SESSION['admin_categoria_csrf'] =
                bin2hex(
                    random_bytes(32)
                );
        }

        return (string) $_SESSION['admin_categoria_csrf'];
    }

    private function validarCsrfCategoria(
        string $token
    ): bool {
        $salvo = (string) (
            $_SESSION['admin_categoria_csrf']
            ?? ''
        );

        return $token !== ''
            && $salvo !== ''
            && hash_equals(
                $salvo,
                $token
            );
    }

    private function redirecionarCategorias(): never
    {
        $base = defined('BASE_URL')
            ? rtrim(
                (string) BASE_URL,
                '/'
            )
            : $this->baseUrl();

        header(
            'Location: '
                . $base
                . '/admin/categorias'
        );

        exit;
    }
}
