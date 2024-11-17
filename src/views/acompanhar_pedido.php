<?php
require_once __DIR__ . '/../utils/session_helper.php';
require_once __DIR__ . '/../models/PedidoModel.php';
verificarSessao('id_cliente');

if (!isset($_GET['id_pedido'])) {
    $_SESSION['error'] = "Nenhum pedido selecionado.";
    header('Location: index.php?page=meus_pedidos');
    exit();
}

$id_pedido = $_GET['id_pedido'];
$pedido = PedidoModel::getPedidoById($id_pedido);

if (!$pedido) {
    $_SESSION['error'] = "Pedido não encontrado.";
    header('Location: index.php?page=meus_pedidos');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Acompanhar Pedido</title>
    <link href="/Project_Nimval/public/assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Acompanhamento do Pedido</h2>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Pedido Nº <?= htmlspecialchars($pedido['numero_pedido']); ?></h5>
                <p><strong>Status:</strong> <?= htmlspecialchars($pedido['status_pedido']); ?></p>
                <p><strong>Descrição:</strong> <?= htmlspecialchars($pedido['descricao_pedido']); ?></p>
                <p><strong>Data do Pedido:</strong> <?= htmlspecialchars($pedido['data_pedido']); ?></p>
            </div>
        </div>
    </div>
</body>
</html>
