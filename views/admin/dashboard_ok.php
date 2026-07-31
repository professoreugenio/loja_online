<?php

declare(strict_types=1);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Painel Admin</title>
    <!-- Importando ícones do FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Reset de estilos básicos */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
            background-color: #f0f2f5;
        }

        /* Menu Lateral (Sidebar) */
        .sidebar {
            width: 250px;
            background-color: #1e293b;
            color: #fff;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            padding: 24px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            border-bottom: 1px solid #334155;
            letter-spacing: 1px;
        }

        .sidebar-menu {
            list-style: none;
            padding: 20px 0;
            flex-grow: 1;
        }

        .sidebar-menu li {
            padding: 15px 24px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #cbd5e1;
            transition: 0.2s;
        }

        .sidebar-menu li:hover, .sidebar-menu li.active {
            background-color: #334155;
            color: #fff;
            border-left: 4px solid #3b82f6;
        }

        /* Área de Conteúdo Principal */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* Cabeçalho Superior */
        .top-header {
            background-color: #fff;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .top-header h2 {
            color: #333;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #475569;
            font-weight: 500;
        }

        /* Grid de Cartões (Dashboard) */
        .dashboard-cards {
            padding: 30px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        /* Estilo Individual de cada Cartão */
        .card {
            background-color: #fff;
            padding: 24px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.1);
        }

        .card-info h3 {
            font-size: 14px;
            color: #64748b;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .card-info p {
            font-size: 28px;
            font-weight: bold;
            color: #1e293b;
        }

        .card-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 22px;
            color: #fff;
        }

        /* Cores específicas para cada ícone */
        .bg-blue { background-color: #3b82f6; }
        .bg-green { background-color: #10b981; }
        .bg-purple { background-color: #8b5cf6; }
        .bg-orange { background-color: #f59e0b; }
        .bg-red { background-color: #ef4444; }
        .bg-teal { background-color: #14b8a6; }
        .bg-indigo { background-color: #6366f1; }
        .bg-pink { background-color: #ec4899; }

        /* Responsividade para telas menores */
        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }
            .sidebar {
                width: 100%;
                height: auto;
            }
            .sidebar-menu {
                display: flex;
                overflow-x: auto;
                padding: 10px;
            }
            .sidebar-menu li {
                border-left: none;
                border-bottom: 4px solid transparent;
            }
            .sidebar-menu li.active {
                border-left: none;
                border-bottom: 4px solid #3b82f6;
            }
        }
    </style>
</head>
<body>

    <!-- Menu Lateral -->
    <aside class="sidebar">
        <div class="sidebar-header">
            AdminPanel
        </div>
        <ul class="sidebar-menu">
            <li class="active"><i class="fas fa-home"></i> Dashboard</li>
            <li><i class="fas fa-box"></i> Produtos</li>
            <li><i class="fas fa-users"></i> Clientes</li>
            <li><i class="fas fa-shopping-cart"></i> Pedidos</li>
            <li><i class="fas fa-cog"></i> Configurações</li>
            <li class="nav-item">
    <form
        action="<?= htmlspecialchars(
            BASE_URL . '/logout-admin',
            ENT_QUOTES,
            'UTF-8'
        ) ?>"
        method="post"
        class="m-0"
    >
        <input
            type="hidden"
            name="_token"
            value="<?= htmlspecialchars(
                $csrfToken,
                ENT_QUOTES,
                'UTF-8'
            ) ?>"
        >

        <button
            type="submit"
            class="nav-link btn btn-link text-start w-100 border-0"
        >
            <i
                class="fas fa-sign-out-alt me-2"
                aria-hidden="true"
            ></i>

            Sair
        </button>
    </form>
</li>
        </ul>
    </aside>

    <!-- Conteúdo Principal -->
    <main class="main-content">
        <!-- Cabeçalho -->
        <header class="top-header">
            <h2>Visão Geral</h2>
            <div class="user-info">
                <span>Olá, Admin</span>
                <i class="fas fa-user-circle fa-2x"></i>
            </div>
        </header>

        <!-- Grade de Cartões -->
        <div class="dashboard-cards">
            
            <!-- Produtos -->
            <div class="card">
                <div class="card-info">
                    <h3>Produtos</h3>
                    <p id="count-produtos">1.240</p>
                </div>
                <div class="card-icon bg-blue">
                    <i class="fas fa-box"></i>
                </div>
            </div>

            <!-- Clientes -->
            <div class="card">
                <div class="card-info">
                    <h3>Clientes</h3>
                    <p id="count-clientes">8.432</p>
                </div>
                <div class="card-icon bg-green">
                    <i class="fas fa-users"></i>
                </div>
            </div>

            <!-- Endereços -->
            <div class="card">
                <div class="card-info">
                    <h3>Endereços</h3>
                    <p id="count-enderecos">10.125</p>
                </div>
                <div class="card-icon bg-purple">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
            </div>

            <!-- Carrinhos -->
            <div class="card">
                <div class="card-info">
                    <h3>Carrinhos Ativos</h3>
                    <p id="count-carrinhos">342</p>
                </div>
                <div class="card-icon bg-orange">
                    <i class="fas fa-shopping-basket"></i>
                </div>
            </div>

            <!-- Pedidos -->
            <div class="card">
                <div class="card-info">
                    <h3>Pedidos</h3>
                    <p id="count-pedidos">5.890</p>
                </div>
                <div class="card-icon bg-indigo">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>

            <!-- Pagamentos -->
            <div class="card">
                <div class="card-info">
                    <h3>Pagamentos</h3>
                    <p id="count-pagamentos">R$ 142k</p>
                </div>
                <div class="card-icon bg-teal">
                    <i class="fas fa-credit-card"></i>
                </div>
            </div>

            <!-- Estoque -->
            <div class="card">
                <div class="card-info">
                    <h3>Estoque Baixo</h3>
                    <p id="count-estoque">15 itens</p>
                </div>
                <div class="card-icon bg-red">
                    <i class="fas fa-warehouse"></i>
                </div>
            </div>

            <!-- Notificações -->
            <div class="card">
                <div class="card-info">
                    <h3>Notificações</h3>
                    <p id="count-notificacoes">8 novas</p>
                </div>
                <div class="card-icon bg-pink">
                    <i class="fas fa-bell"></i>
                </div>
            </div>

        </div>
    </main>

    <!-- Script opcional apenas para interatividade básica -->
    <script>
        // Lógica simples para marcar o item do menu clicado como ativo
        const menuItems = document.querySelectorAll('.sidebar-menu li');
        
        menuItems.forEach(item => {
            item.addEventListener('click', () => {
                menuItems.forEach(i => i.classList.remove('active'));
                item.classList.add('active');
            });
        });
    </script>
</body>
</html>