<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sua Loja - Em Breve</title>
    <!-- Importando ícones do FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Reset básico */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            /* Fundo com gradiente moderno */
            background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #333;
            padding: 20px;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 50px 40px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 600px;
            width: 100%;
        }

        .logo {
            font-size: 28px;
            font-weight: 800;
            color: #ff6b6b;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .logo i {
            margin-right: 10px;
        }

        h1 {
            font-size: 36px;
            margin-bottom: 15px;
            color: #2d3436;
        }

        p {
            font-size: 16px;
            color: #636e72;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        /* Contador de Tempo */
        .countdown {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 40px;
        }

        .time-box {
            background-color: #2d3436;
            color: #fff;
            padding: 15px;
            border-radius: 8px;
            min-width: 80px;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .time-box span {
            font-size: 28px;
            font-weight: bold;
            color: #f6d365;
        }

        .time-box small {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 5px;
            color: #dfe6e9;
        }

        /* Formulário de Newsletter */
        .newsletter {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
        }

        .newsletter input {
            flex: 1;
            padding: 12px 20px;
            border: 2px solid #dfe6e9;
            border-radius: 8px;
            font-size: 16px;
            outline: none;
            transition: border-color 0.3s;
        }

        .newsletter input:focus {
            border-color: #fda085;
        }

        .newsletter button {
            padding: 12px 25px;
            background-color: #ff6b6b;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        .newsletter button:hover {
            background-color: #ee5253;
            transform: translateY(-2px);
        }

        /* Redes Sociais */
        .social-links {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        .social-links a {
            color: #b2bec3;
            font-size: 24px;
            transition: color 0.3s;
        }

        .social-links a:hover {
            color: #ff6b6b;
        }

        /* Responsividade */
        @media (max-width: 480px) {
            .countdown {
                flex-wrap: wrap;
            }
            .time-box {
                min-width: 70px;
                padding: 10px;
            }
            .newsletter {
                flex-direction: column;
            }
            h1 {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Substitua pela logo da sua loja ou deixe como texto -->
        <div class="logo">
            <i class="fas fa-shopping-bag"></i> Minha Loja
        </div>
        
        <h1>Nossa nova loja está chegando!</h1>
        <a href="loginadmin">loginadmin</a>
        <p>Estamos preparando uma experiência de compra incrível para você, com produtos exclusivos e ofertas imperdíveis. Aguarde novidades!</p>

        <!-- Contador -->
        <div class="countdown">
            <div class="time-box">
                <span id="days">00</span>
                <small>Dias</small>
            </div>
            <div class="time-box">
                <span id="hours">00</span>
                <small>Horas</small>
            </div>
            <div class="time-box">
                <span id="minutes">00</span>
                <small>Min</small>
            </div>
            <div class="time-box">
                <span id="seconds">00</span>
                <small>Seg</small>
            </div>
        </div>

        <!-- Formulário de Captura -->
        <form class="newsletter" onsubmit="event.preventDefault(); alert('E-mail cadastrado com sucesso! Entraremos em contato em breve.');">
            <input type="email" placeholder="Digite seu melhor e-mail..." required>
            <button type="submit">Avise-me</button>
        </form>

        <!-- Redes Sociais -->
        <div class="social-links">
            <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
            <a href="#" title="Facebook"><i class="fab fa-facebook"></i></a>
            <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
            <a href="#" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
        </div>
    </div>

    <!-- Script do Contador de Tempo -->
    <script>
        // Define a data de lançamento (exemplo: 15 dias a partir de hoje)
        const launchDate = new Date();
        launchDate.setDate(launchDate.getDate() + 15);

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = launchDate - now;

            // Cálculos matemáticos para dias, horas, minutos e segundos
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 100Aqui está o código completo para uma página de "Em Construção" com um design moderno, limpo e responsivo. Ela inclui uma área para o usuário deixar o e-mail e ser avisado sobre as novidades.

Você pode copiar o código abaixo e salvá-lo como `index.html`.

```html
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Em Breve - Nossa Loja Online</title>
    <!-- Importando fonte do Google Fonts -->
    <link href="[https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap](https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap)" rel="stylesheet">
    <!-- Importando FontAwesome para ícones -->
    <link rel="stylesheet" href="[https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css](https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css)">
    
    <style>
        /* Reset básico e tipografia */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            /* Fundo com um gradiente moderno e escuro */
            background: linear-gradient(135deg, #1e1e2f 0%, #12121a 100%);
            color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            text-align: center;
            padding: 20px;
        }

        /* Container principal */
        .container {
            max-width: 600px;
            background: rgba(255, 255, 255, 0.05);
            padding: 50px 40px;
            border-radius: 16px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
            animation: fadeIn 1s ease-in-out;
        }

        /* Ícone de destaque */
        .icon {
            font-size: 60px;
            color: #ff3366;
            margin-bottom: 20px;
            animation: pulse 2s infinite;
        }

        h1 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }

        p {
            font-size: 16px;
            color: #b0b0c0;
            margin-bottom: 30px;
            line-height: 1.5;
            font-weight: 300;
        }

        /* Formulário de captura de email */
        .notify-form {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .notify-form input {
            flex: 1;
            min-width: 250px;
            padding: 14px 20px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            font-size: 14px;
            outline: none;
            transition: border-color 0.3s;
        }

        .notify-form input::placeholder {
            color: #a0a0b0;
        }

        .notify-form input:focus {
            border-color: #ff3366;
        }

        .notify-form button {
            padding: 14px 24px;
            border-radius: 8px;
            border: none;
            background: #ff3366;
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
        }

        .notify-form button:hover {
            background: #e62e5c;
            transform: translateY(-2px);
        }

        /* Redes Sociais */
        .social-links {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .social-links a {
            color: #b0b0c0;
            font-size: 20px;
            text-decoration: none;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            transition: color 0.3s, background 0.3s;
        }

        .social-links a:hover {
            color: #ffffff;
            background: #ff3366;
        }

        /* Animações */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        /* Responsividade */
        @media (max-width: 480px) {
            .notify-form {
                flex-direction: column;
            }
            .notify-form button {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Ícone representativo -->
        <div class="icon">
            <i class="fas fa-tools"></i>
        </div>
        
        <!-- Textos Principais -->
        <h1>Nossa Loja Está em Construção</h1>
        -----
        <p>Estamos preparando uma experiência de compra incrível para você. Deixe seu e-mail abaixo e seja o primeiro a saber quando lançarmos as novidades!</p>
        
        <!-- Formulário para receber novidades -->
        <form class="notify-form" onsubmit="event.preventDefault(); alert('Obrigado! Seu e-mail foi cadastrado com sucesso.');">
            <input type="email" placeholder="Digite seu melhor e-mail" required>
            <button type="submit">Avise-me <i class="fas fa-paper-plane" style="margin-left: 5px;"></i></button>
        </form>

        <!-- Links das redes sociais -->
        <div class="social-links">
            <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
            <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
            <a href="#" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
        </div>
    </div>

</body>
</html>