<?php
require_once __DIR__ . '/../utils/header_cliente.php';
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
        <h1>Bem-vindo, <?= htmlspecialchars($nomeUsuario); ?>!</h1>
        <h2>Área do Cliente</h2>
        <p>Bem-vindo à sua área exclusiva. Aqui você pode consultar seus pedidos e acompanhar o status.</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
