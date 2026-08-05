<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loja Online | Início</title>
    <style>
        /* CSS Reset e Variáveis Básicas */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f8f9fa;
            color: #333;
        }

        /* --- Barra de Navegação (Navbar) --- */
        header {
            background-color: #2c3e50;
            color: white;
            padding: 1rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            text-decoration: none;
            color: white;
        }

        .logo span {
            color: #f39c12; /* Destaque no logo */
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        nav a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        nav a:hover {
            color: #f39c12;
        }

        .cart-link {
            background-color: #f39c12;
            padding: 0.5rem 1.2rem;
            border-radius: 5px;
            font-weight: bold;
        }

        .cart-link:hover {
            background-color: #e67e22;
            color: white;
        }

        /* --- Seção Destaque (Hero) --- */
        .hero {
            background-color: #34495e;
            color: white;
            text-align: center;
            padding: 4rem 1rem;
        }

        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
        }

        .hero-btn {
            background-color: #f39c12;
            color: white;
            text-decoration: none;
            padding: 0.8rem 2rem;
            border-radius: 5px;
            font-size: 1.1rem;
            font-weight: bold;
        }

        /* --- Grade de Produtos --- */
        .produtos {
            padding: 4rem 5%;
        }

        .section-title {
            text-align: center;
            margin-bottom: 3rem;
            font-size: 2.2rem;
            color: #2c3e50;
        }

        .grid-produtos {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .card-produto {
            background-color: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            text-align: center;
            transition: transform 0.3s ease;
        }

        .card-produto:hover {
            transform: translateY(-5px);
        }

        .card-produto img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
            margin-bottom: 1rem;
            background-color: #eee; /* Placeholder para imagens não carregadas */
        }

        .card-produto h3 {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }

        .preco {
            font-size: 1.4rem;
            color: #e74c3c;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .btn-comprar {
            background-color: #27ae60;
            color: white;
            border: none;
            padding: 0.8rem;
            width: 100%;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn-comprar:hover {
            background-color: #2ecc71;
        }

        /* --- Seção de Contato --- */
        .contato {
            background-color: #ecf0f1;
            padding: 4rem 5%;
        }

        .form-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        .form-group input, 
        .form-group textarea {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        .btn-enviar {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 1rem;
            width: 100%;
            border-radius: 5px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn-enviar:hover {
            background-color: #2980b9;
        }

        /* --- Rodapé (Footer) --- */
        footer {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 2rem;
        }

        /* Responsividade para telas menores */
        @media (max-width: 768px) {
            header {
                flex-direction: column;
                gap: 1rem;
            }
            nav ul {
                flex-wrap: wrap;
                justify-content: center;
            }
        }
    </style>
</head>
<body>

    <!-- Barra de Navegação -->
    <header>
        <a href="#" class="logo">Loja<span>Tech</span></a>
        <nav>
            <ul>
                <li><a href="#inicio">Início</a></li>
                <li><a href="#produtos">Produtos</a></li>
                <li><a href="#categorias">Categorias</a></li>
                <li><a href="#contato">Contato</a></li>
                <li><a href="#carrinho" class="cart-link">🛒 Carrinho (0)</a></li>
            </ul>
        </nav>
    </header>

    <!-- Banner Destaque -->
    <section id="inicio" class="hero">
        <h1>As Melhores Ofertas Estão Aqui</h1>
        <p>Encontre produtos incríveis com preços imbatíveis e frete grátis.</p>
        <a href="#produtos" class="hero-btn">Ver Produtos</a>
    </section>

    <!-- Seção de Produtos -->
    <section id="produtos" class="produtos">
        <h2 class="section-title">Nossos Produtos</h2>
        
        <div class="grid-produtos">
            <!-- Produto 1 -->
            <div class="card-produto">
                <img src="https://via.placeholder.com/300x200?text=Produto+1" alt="Produto 1">
                <h3>Smartphone Avançado</h3>
                <p>Tela de 6.5", 128GB, Câmera 48MP</p>
                <div class="preco">R$ 1.999,00</div>
                <button class="btn-comprar">Adicionar ao Carrinho</button>
            </div>

            <!-- Produto 2 -->
            <div class="card-produto">
                <img src="https://via.placeholder.com/300x200?text=Produto+2" alt="Produto 2">
                <h3>Fone de Ouvido Bluetooth</h3>
                <p>Cancelamento de ruído e bateria de 20h</p>
                <div class="preco">R$ 299,00</div>
                <button class="btn-comprar">Adicionar ao Carrinho</button>
            </div>

            <!-- Produto 3 -->
            <div class="card-produto">
                <img src="https://via.placeholder.com/300x200?text=Produto+3" alt="Produto 3">
                <h3>Relógio Smartwatch</h3>
                <p>Monitoramento cardíaco e à prova d'água</p>
                <div class="preco">R$ 450,00</div>
                <button class="btn-comprar">Adicionar ao Carrinho</button>
            </div>

            <!-- Produto 4 -->
            <div class="card-produto">
                <img src="https://via.placeholder.com/300x200?text=Produto+4" alt="Produto 4">
                <h3>Notebook Ultrafino</h3>
                <p>Processador i7, 16GB RAM, SSD 512GB</p>
                <div class="preco">R$ 4.599,00</div>
                <button class="btn-comprar">Adicionar ao Carrinho</button>
            </div>
        </div>
    </section>

    <!-- Seção de Contato -->
    <section id="contato" class="contato">
        <h2 class="section-title">Fale Conosco</h2>
        
        <div class="form-container">
            <form action="#" method="POST">
                <div class="form-group">
                    <label for="nome">Nome Completo</label>
                    <input type="text" id="nome" name="nome" placeholder="Digite seu nome" required>
                </div>
                
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required>
                </div>
                
                <div class="form-group">
                    <label for="mensagem">Mensagem</label>
                    <textarea id="mensagem" name="mensagem" rows="5" placeholder="Como podemos ajudar?" required></textarea>
                </div>
                
                <button type="submit" class="btn-enviar">Enviar Mensagem</button>
            </form>
        </div>
    </section>

    <!-- Rodapé -->
    <footer>
        <p>&copy; 2026 LojaTech. Todos os direitos reservados.</p>
        <p style="margin-top: 10px; font-size: 0.9em; color: #bdc3c7;">
            Pagamento Seguro | Entrega Rápida | Suporte 24/7
        </p>
    </footer>

</body>
</html>