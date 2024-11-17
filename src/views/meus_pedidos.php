<?php
require_once __DIR__ . '/../utils/session_helper.php';
require_once __DIR__ . '/../models/PedidoModel.php';
require_once __DIR__ . '/../utils/header_cliente.php';
verificarSessao('id_cliente');

$id_cliente = $_SESSION['usuario'];
$fornecedores = PedidoModel::getFornecedoresComPedidos($id_cliente);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Meus Pedidos</title>
    <link href="/Project_Nimval/public/assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            background-color: var(--gelo);
        }
        .table-container {
            margin: 20px auto;
            width: 90%;
            border: 1px solid var(--borda-clara);
            background-color: var(--branco);
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .table th, .table td {
            text-align: left;
            padding: 10px;
            cursor: pointer;
        }
        .expandable-row {
            display: none;
            background-color: var(--cinza-claro);
        }
        .btn-primary {
            background-color: var(--azul-principal);
            border: none;
        }
        .btn-primary:hover {
            background-color: var(--azul-escuro);
        }
        .fornecedor-row:hover {
            background-color: var(--cinza-claro2);
        }
    </style>
    <script>
        function togglePedidos(fornecedorId) {
            const row = document.getElementById(`pedidos-${fornecedorId}`);
            row.style.display = row.style.display === "table-row" ? "none" : "table-row";
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="container mt-5">
            <h2>Meus Pedidos</h2>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Fornecedor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($fornecedores as $fornecedor): ?>
                            <tr class="fornecedor-row" onclick="togglePedidos(<?= $fornecedor['id_fornecedor']; ?>)">
                                <td><?= htmlspecialchars($fornecedor['nome_fornecedor']); ?></td>
                            </tr>
                            <tr class="expandable-row" id="pedidos-<?= $fornecedor['id_fornecedor']; ?>">
                                <td>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Nº Pedido</th>
                                                <th>Status</th>
                                                <th>Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $pedidos = PedidoModel::getPedidosPorFornecedor($fornecedor['id_fornecedor'], $id_cliente);
                                            foreach ($pedidos as $pedido): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($pedido['numero_pedido']); ?></td>
                                                    <td><?= htmlspecialchars($pedido['status_pedido']); ?></td>
                                                    <td>
                                                    <a href="index.php?page=acompanhar_pedido&id_pedido=<?= htmlspecialchars($pedido['id_pedido']); ?>" class="link-acompanhar-pedido">
                                                        Acompanhar Pedido
                                                    </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>    
    </div>
</body>
</html>
