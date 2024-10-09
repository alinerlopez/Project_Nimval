<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php?page=login");
    exit();
}

$nomeUsuario = $_SESSION['nome_usuario'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Cliente - Nimval Rastreamentos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Bem-vindo, <?php echo htmlspecialchars($nomeUsuario); ?>!</h1>
        <h2>Área do Cliente</h2>
        <p>Aqui você pode consultar o status de seus pedidos.</p>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
