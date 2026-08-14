<?php

declare(strict_types=1);

namespace App\Controllers\Cliente;

use App\Helpers\Cpf;
use App\Helpers\CsrfCliente;
use App\Helpers\IdSeguro;
use App\Repositories\CategoriaRepository;
use App\Repositories\ClienteRepository;
use App\Repositories\EnderecoRepository;
use App\Services\ClienteCadastroService;
use RuntimeException;

final class ClienteCadastroController
{
    private CategoriaRepository
        $categoriaRepository;

    private ClienteCadastroService
        $cadastroService;


    public function __construct()
    {
        require_once APP_ROOT
            . '/database/conexao.php';


        $pdo =
            \Config::connect();


        $this->categoriaRepository =
            new CategoriaRepository(
                $pdo
            );


        $clienteRepository =
            new ClienteRepository(
                $pdo
            );


        $enderecoRepository =
            new EnderecoRepository(
                $pdo
            );


        $this->cadastroService =
            new ClienteCadastroService(
                $pdo,
                $clienteRepository,
                $enderecoRepository
            );
    }


    public function formulario(): void
    {
        $categorias =
            $this->categoriaRepository
                ->listarAtivas();


        foreach (
            $categorias
            as &$categoria
        ) {

            $categoria[
                'id_seguro'
            ] =
                IdSeguro::criptografar(
                    (int)
                    $categoria['id']
                );
        }

        unset($categoria);


        $erro =
            $_SESSION[
                'cliente_cadastro_erro'
            ]
            ?? null;


        $sucesso =
            $_SESSION[
                'cliente_cadastro_sucesso'
            ]
            ?? null;


        $dados =
            $_SESSION[
                'cliente_cadastro_dados'
            ]
            ?? [];


        unset(
            $_SESSION[
                'cliente_cadastro_erro'
            ],
            $_SESSION[
                'cliente_cadastro_sucesso'
            ],
            $_SESSION[
                'cliente_cadastro_dados'
            ]
        );


        $csrfToken =
            CsrfCliente::gerar();


        $tituloPagina =
            'Criar minha conta';


        $arquivoView =
            APP_ROOT
            . '/views/site/'
            . 'cliente_cadastro.php';


        if (!is_file($arquivoView)) {

            throw new RuntimeException(
                'A página de cadastro '
                . 'não foi encontrada.'
            );
        }


        require $arquivoView;
    }


    public function cadastrar(): void
    {
        $token =
            isset(
                $_POST['csrf_token']
            )
                ? (string)
                    $_POST['csrf_token']
                : null;


        if (
            !CsrfCliente::validar(
                $token
            )
        ) {
            $this->falhar(
                'O formulário expirou. '
                . 'Atualize a página '
                . 'e tente novamente.',
                []
            );
        }


        $dados = [
            'nome' =>
                trim(
                    (string) (
                        $_POST['nome']
                            ?? ''
                    )
                ),

            'cpf' =>
                trim(
                    (string) (
                        $_POST['cpf']
                            ?? ''
                    )
                ),

            'data_nascimento' =>
                trim(
                    (string) (
                        $_POST[
                            'data_nascimento'
                        ]
                        ?? ''
                    )
                ),

            'telefone' =>
                trim(
                    (string) (
                        $_POST['telefone']
                            ?? ''
                    )
                ),

            'cep' =>
                trim(
                    (string) (
                        $_POST['cep']
                            ?? ''
                    )
                ),

            'logradouro' =>
                trim(
                    (string) (
                        $_POST['logradouro']
                            ?? ''
                    )
                ),

            'numero' =>
                trim(
                    (string) (
                        $_POST['numero']
                            ?? ''
                    )
                ),

            'complemento' =>
                trim(
                    (string) (
                        $_POST['complemento']
                            ?? ''
                    )
                ),

            'bairro' =>
                trim(
                    (string) (
                        $_POST['bairro']
                            ?? ''
                    )
                ),

            'cidade' =>
                trim(
                    (string) (
                        $_POST['cidade']
                            ?? ''
                    )
                ),

            'estado' =>
                strtoupper(
                    trim(
                        (string) (
                            $_POST['estado']
                                ?? ''
                        )
                    )
                ),

            'email' =>
                strtolower(
                    trim(
                        (string) (
                            $_POST['email']
                                ?? ''
                        )
                    )
                ),

            'newsletter' =>
                isset(
                    $_POST['newsletter']
                )
                    ? 1
                    : 0,
        ];


        $senha =
            (string) (
                $_POST['senha']
                    ?? ''
            );


        $confirmarSenha =
            (string) (
                $_POST[
                    'confirmar_senha'
                ]
                ?? ''
            );


        if (
            mb_strlen(
                $dados['nome']
            )
            < 3
        ) {
            $this->falhar(
                'Informe o nome completo.',
                $dados
            );
        }


        if (
            !Cpf::validar(
                $dados['cpf']
            )
        ) {
            $this->falhar(
                'Informe um CPF válido.',
                $dados
            );
        }


        if (
            filter_var(
                $dados['email'],
                FILTER_VALIDATE_EMAIL
            )
            === false
        ) {
            $this->falhar(
                'Informe um e-mail válido.',
                $dados
            );
        }


        if (strlen($senha) < 8) {

            $this->falhar(
                'A senha deve possuir '
                . 'pelo menos 8 caracteres.',
                $dados
            );
        }


        if (
            $senha
            !== $confirmarSenha
        ) {
            $this->falhar(
                'A confirmação da senha '
                . 'não corresponde.',
                $dados
            );
        }


        $aceitouTermos =
            isset(
                $_POST['aceite_termos']
            )
            &&
            $_POST['aceite_termos']
                === '1';


        if (!$aceitouTermos) {

            $this->falhar(
                'Você precisa aceitar '
                . 'os termos de uso.',
                $dados
            );
        }


        $camposObrigatorios = [
            'telefone',
            'cep',
            'logradouro',
            'numero',
            'bairro',
            'cidade',
            'estado',
        ];


        foreach (
            $camposObrigatorios
            as $campo
        ) {

            if (
                $dados[$campo]
                === ''
            ) {
                $this->falhar(
                    'Preencha todos os '
                    . 'campos obrigatórios.',
                    $dados
                );
            }
        }


        $estadosValidos = [
            'AC', 'AL', 'AP', 'AM',
            'BA', 'CE', 'DF', 'ES',
            'GO', 'MA', 'MT', 'MS',
            'MG', 'PA', 'PB', 'PR',
            'PE', 'PI', 'RJ', 'RN',
            'RS', 'RO', 'RR', 'SC',
            'SP', 'SE', 'TO',
        ];


        if (
            !in_array(
                $dados['estado'],
                $estadosValidos,
                true
            )
        ) {
            $this->falhar(
                'Selecione um estado válido.',
                $dados
            );
        }


        $dados['cpf'] =
            Cpf::somenteNumeros(
                $dados['cpf']
            );


        if (
            $dados[
                'data_nascimento'
            ]
            === ''
        ) {
            $dados[
                'data_nascimento'
            ] = null;
        }


        $dados['senha'] =
            $senha;


        try {

            $this->cadastroService
                ->cadastrar(
                    $dados
                );

        } catch (RuntimeException $erro) {

            unset(
                $dados['senha']
            );


            $this->falhar(
                $erro->getMessage(),
                $dados
            );
        }


        CsrfCliente::renovar();


        $_SESSION[
            'cliente_login_sucesso'
        ] =
            'Cadastro realizado com sucesso. '
            . 'Agora você pode entrar '
            . 'na sua conta.';


        header(
            'Location: '
            . BASE_URL
            . '/cliente/login'
        );


        exit;
    }


    private function falhar(
        string $mensagem,
        array $dados
    ): void {

        unset(
            $dados['senha'],
            $dados['confirmar_senha']
        );


        $_SESSION[
            'cliente_cadastro_erro'
        ] =
            $mensagem;


        $_SESSION[
            'cliente_cadastro_dados'
        ] =
            $dados;


        header(
            'Location: '
            . BASE_URL
            . '/cliente/cadastro'
        );


        exit;
    }
}
