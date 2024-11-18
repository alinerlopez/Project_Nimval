<?php
require_once __DIR__ . '/../utils/session_helper.php';
verificarSessao('id_fornecedor');
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Status do Pedido</title>
    <link href="/Project_Nimval/public/assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            height: 100vh;
            margin: 0;
        }

        .content {
            flex-grow: 1;
            padding: 20px;
            background-color: #f8f9fa;
            overflow-y: auto;
        }

        .card {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .card h2 {
            margin-bottom: 20px;
            color: #007bff;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group textarea {
            resize: none;
        }

        .btn-success {
            width: 100%;
            padding: 8px 16px;
            border: 2px solid #007bff;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease, border-color 0.3s ease;
            background-color: #007bff;
            border: none;
        }

        .btn-success:hover {
            background-color: #0056b3;
           
        }

        .btn-finalizar {
            width: 100%;
            padding: 8px 16px;
            background-color: #28a745;
            border: 2px solid #28a745;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease, border-color 0.3s ease;
            border: none;
        }

        .btn-finalizar:hover {
            background-color: #218838;
        }

        .btn-group {
            width: 100%;
            display: flex;
            gap: 10px;
        }
    </style>
</head>
<body>
<?php include __DIR__ . '/../utils/sidebar_fornecedor.php'; ?>

<div class="content">
    <div class="card">
        <h2>Atualizar Status do Pedido</h2>
        <form id="statusForm" action="index.php?page=salvar_status_pedido" method="post">
            <input type="hidden" name="id_pedido" value="<?= htmlspecialchars($pedido['id_pedido']); ?>">

            <div class="form-group">
                <label for="descricao_pedido">Descrição do Pedido:</label>
                <textarea id="descricao_pedido" class="form-control" readonly><?= htmlspecialchars($pedido['descricao_pedido']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="status_atual">Status Atual:</label>
                <input type="text" id="status_atual" class="form-control" value="<?= htmlspecialchars($pedido['status_pedido']); ?>" readonly>
            </div>

            <div class="form-group">
                <label for="descricao_status">Novo Status:</label>
                <textarea id="descricao_status" name="descricao_status" class="form-control" rows="4" required></textarea>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn-primary btn-success">Atualizar Status</button>
                <button type="button" class="btn-primary btn-finalizar" id="finalizarPedido">Finalizar</button>
            </div>
        </form>
    </div>
</div>

<script src="/Project_Nimval/public/assets/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('finalizarPedido').addEventListener('click', function () {
        if (confirm('Tem certeza que deseja finalizar este pedido?')) {
        
            document.getElementById('descricao_status').value = 'Finalizado';
            document.getElementById('statusForm').submit();
            document.querySelectorAll('button').forEach(button => button.disabled = true);
        }
    });
</script>
</body>
</html>
