<?php
declare(strict_types=1);
?><!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrativo</title>
    <style>
        /* Reseta as margens e define a fonte padrão */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Centraliza o conteúdo na tela toda */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f2f5;
        }

        /* Estilo do container do formulário */
        .login-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 24px;
            color: #333;
        }

        /* Grupo de inputs (Label + Input) */
        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
        }

        .input-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            outline: none;
            transition: border-color 0.3s;
        }

        .input-group input:focus {
            border-color: #007bff;
        }

        /* Container relativo para posicionar o botão de senha em cima do input */
        .password-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        /* Botão de exibir/ocultar senha */
        .toggle-password {
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            color: #007bff;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
        }

        .toggle-password:hover {
            text-decoration: underline;
        }

        /* Botão de envio (Entrar) */
        .btn-submit {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-submit:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>Painel Admin</h2>

        <?php if ($erro !== null): ?>

                        <div
                            class="alert alert-danger"
                            role="alert"
                        >
                            <?=
                                htmlspecialchars(
                                    (string) $erro,
                                    ENT_QUOTES,
                                    'UTF-8'
                                )
                            ?>
                        </div>

                    <?php endif; ?>
        
        <form action="<?=BASE_URL?>/login-admin" method="POST">


<input
                            type="hidden"
                            name="_token"
                            value="<?=
                                htmlspecialchars(
                                    $csrfToken,
                                    ENT_QUOTES,
                                    'UTF-8'
                                )
                            ?>"
                        >

                        
            <div class="input-group">
                <label for="username">Login</label>
                <input type="text" id="username" name="username" placeholder="Digite seu login" required>
            </div>
            
            <div class="input-group">
                <label for="password">Senha</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" placeholder="Digite sua senha" required>
                    <!-- O type="button" impede que este botão envie o formulário -->
                    <button type="button" class="toggle-password" id="togglePassword">Mostrar</button>
                </div>
            </div>
            
            <button type="submit" class="btn-submit">Entrar</button>
        </form>
    </div>

    <script>
        // Seleciona o input de senha e o botão de alternância
        const passwordInput = document.getElementById('password');
        const togglePasswordButton = document.getElementById('togglePassword');

        // Adiciona o evento de clique no botão "Mostrar/Ocultar"
        togglePasswordButton.addEventListener('click', function () {
            // Verifica o tipo atual do input
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Altera o texto do botão de acordo com o estado
            this.textContent = type === 'password' ? 'Mostrar' : 'Ocultar';
        });
    </script>
</body>
</html>