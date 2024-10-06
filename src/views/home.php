<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php?page=login");
    exit();
}

$nivelAcesso = $_SESSION['nivel_acesso'];
$nomeUsuario = $_SESSION['nome_usuario']; 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Nimval Rastreamentos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            display: flex;
            height: 100vh;
            overflow: hidden;
            margin: 0;
        }

        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: white;
            transition: width 0.3s ease;
            position: relative;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .sidebar a:hover {
            background-color: #495057;
            color: white;
        }

        .sidebar .nav-link {
            padding: 15px;
        }

        .content {
            flex-grow: 1;
            padding: 20px;
            background-color: #f8f9fa;
            transition: transform 0.3s ease;
        }

        .sidebar-toggler {
            background-color: #343a40;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
        }

        .sidebar-toggler i {
            margin-right: 10px;
        }

        .sidebar.collapsed .nav-link span {
            display: none;
        }

        .sidebar.collapsed .nav-link {
            justify-content: center;
        }

        .sidebar-toggler {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .content.shifted {
            transform: translateX(80px);
        }
    </style>
</head>
<body>

    <nav class="sidebar" id="sidebar">
        <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
            <h4 class="mb-0">Nimval</h4>
            <button class="sidebar-toggler" id="toggleSidebar">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        <ul class="nav flex-column">
            <?php if ($nivelAcesso == 'fornecedor'): ?>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-users"></i> <span>Clientes</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-box"></i> <span>Pedidos</span>
                    </a>
                </li>
            <?php elseif ($nivelAcesso == 'cliente'): ?>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-box"></i> <span>Consultar Pedidos</span>
                    </a>
                </li>
            <?php endif; ?>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-cog"></i> <span>Configurações de Conta</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="index.php?page=logout" onclick="return confirmarLogout()" class="nav-link btn btn-danger">
                    <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
                </a>
            </li>
        </ul>
    </nav>

    <div class="content" id="content">
        <h1>Bem-vindo, <?php echo htmlspecialchars($nomeUsuario); ?>!</h1>
        <?php if ($nivelAcesso == 'fornecedor'): ?>
            <h2>Área do Fornecedor</h2>
            <p>Aqui estão os pedidos e status gerenciados por você, como fornecedor.</p>
        <?php elseif ($nivelAcesso == 'cliente'): ?>
            <h2>Área do Cliente</h2>
            <p>Veja o status de seus pedidos como cliente.</p>
        <?php else: ?>
            <p>Erro: Tipo de usuário desconhecido.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('toggleSidebar').addEventListener('click', function () {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            sidebar.classList.toggle('collapsed');

            if (sidebar.classList.contains('collapsed')) {
                content.classList.add('shifted');
            } else {
                content.classList.remove('shifted');
            }
        });

        function confirmarLogout() {
            return confirm("Você realmente deseja sair?");
        }
    </script>
</body>
</html>
