<nav class="sidebar" id="sidebar">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        @import url('/Project_Nimval/public/assets/css/colors.css');

        .sidebar {
            width: 260px; 
            background-color: var(--cinza-escuro);
            color: white;
            position: fixed; 
            height: 100vh; 
            top: 0;
            left: 0;
            transition: width 0.3s ease;
            z-index: 1000; 
        }

        .sidebar a {
            color: var(--cinza-claro2);
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 15px;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        .sidebar a:hover {
            background-color: var(--cinza-claro2);
        }

        .sidebar .nav-link i {
            margin-right: 10px;
        }

        .sidebar .nav-link span {
            white-space: nowrap;
        }

        .sidebar-toggler {
            background-color: #343a40;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .sidebar-toggler:hover {
            background-color: #495057;
        }

        .content {
            margin-left: 260px; 
            padding: 20px;
            background-color: #f8f9fa;
            height: 100vh;
            overflow: auto;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 100%; 
            }

            .content {
                margin-left: 0;
            }
        }
    </style>

    <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
        <h4 class="mb-0">Nimval</h4>
        <button class="sidebar-toggler" id="toggleSidebar">
            <i class="fas fa-bars"></i>
        </button>
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="index.php?page=home" class="nav-link">
                <i class="fas fa-home"></i> <span>Home</span>
            </a>
        </li>
        <?php if ($_SESSION['nivel_acesso'] == 'admin'): ?>
            <li class="nav-item">
                <a href="#funcionariosSubMenu" class="nav-link" data-bs-toggle="collapse">
                    <i class="fas fa-user-tie"></i> <span>Funcionários</span>
                </a>
                <ul class="collapse" id="funcionariosSubMenu">
                    <li class="nav-item">
                        <a href="index.php?page=cadastrar_funcionario" class="nav-link"><i class="fas fa-user-plus"></i> Cadastrar Funcionário</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="fas fa-search"></i> Consultar Funcionários</a>
                    </li>
                </ul>
            </li>
        <?php endif; ?>

        <li class="nav-item">
            <a href="#clientesSubMenu" class="nav-link" data-bs-toggle="collapse">
                <i class="fas fa-users"></i> <span>Clientes</span>
            </a>
            <ul class="collapse" id="clientesSubMenu">
                <li class="nav-item">
                    <a href="index.php?page=cadastrar_cliente" class="nav-link"><i class="fas fa-user-plus"></i> Cadastrar Cliente</a>
                </li>
                <li class="nav-item">
                    <a href="index.php?page=editar_clientes" class="nav-link"><i class="fas fa-search"></i> Consultar Cliente</a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#pedidosSubMenu" class="nav-link" data-bs-toggle="collapse">
                <i class="fas fa-box"></i> <span>Pedidos</span>
            </a>
            <ul class="collapse" id="pedidosSubMenu">
                <li class="nav-item">
                    <a href="index.php?page=cad_pedidos" class="nav-link"><i class="fas fa-cart-plus"></i> Cadastrar Pedido</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="fas fa-list-alt"></i> Consultar Pedido</a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fas fa-cog"></i> <span>Configurações de Conta</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="index.php?page=logout" onclick="return confirm('Você realmente deseja sair?');" class="nav-link btn btn-danger">
                <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
            </a>
        </li>
    </ul>
</nav>
