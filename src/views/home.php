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
    <style>
        body {
            display: flex; 
            margin: 0;
            height: 100vh;
            overflow: hidden;
        }

        .content {
            flex-grow: 1;
            padding: 30px;
            background-color: #f8f9fa;
            overflow-y: auto; 
        }

        h1, h2 {
            color: #212529;
        }
    </style>
</head>
<body>
    <?php include __DIR__ . '/../utils/sidebar_fornecedor.php'; ?>

    <div class="content">
        <h1>Bem-vindo, <?php echo htmlspecialchars($nomeUsuario); ?>!</h1>
        <h2>Área de Trabalho</h2>
        <p>Aqui você pode gerenciar clientes, pedidos e funcionários.</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('toggleSidebar').addEventListener('click', function () {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('collapsed');
        });
    </script>
</body>
</html>
