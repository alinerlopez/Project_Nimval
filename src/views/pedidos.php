<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Pedidos</title>
    <link href="/Project_Nimval/public/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/Project_Nimval/public/assets/css/global.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            margin: 0;
            height: 100vh;
            overflow: hidden;
        }

        .content {
            flex-grow: 1;
            padding: 20px;
            background-color: #f8f9fa;
            overflow-y: auto;
        }

        .grid-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 1em;
            min-width: 400px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .grid-table th, .grid-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .grid-table th {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
        }

        .grid-table tr:hover {
            background-color: #f1f1f1;
        }

        .search-container {
            margin-bottom: 20px;
        }

        .search-container input {
            padding: 10px;
            width: 100%;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        @media (max-width: 768px) {
            .grid-table th, .grid-table td {
                font-size: 0.9em;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <?php include __DIR__ . '/../utils/sidebar_fornecedor.php'; ?>

    <div class="content">
        <h2 class="text-center mb-4">Pedidos</h2>

        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Buscar pedido por número, descrição ou status..." onkeyup="filtrarPedidos()">
        </div>

        <?php if (!empty($pedidos)): ?>
            <form action="index.php?page=atualizar_pedidos" method="post">
                <table class="grid-table" id="pedidosTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nº Pedido</th>
                            <th>Descrição</th>
                            <th>Status</th>
                            <th>Data</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pedidos as $pedido): ?>
                            <tr>
                                <td><?= htmlspecialchars($pedido['id_pedido']); ?></td>
                                <td><?= htmlspecialchars($pedido['numero_pedido']); ?></td>
                                <td><?= htmlspecialchars($pedido['descricao_pedido']); ?></td>
                                <td><?= htmlspecialchars($pedido['status_pedido']); ?></td>
                                <td><?= htmlspecialchars($pedido['data_pedido']); ?></td>
                                <td>
                                    <button type="submit" name="atualizar" value="<?= htmlspecialchars($pedido['id_pedido']); ?>" class="btn">Atualizar</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </form>
        <?php else: ?>
            <p>Nenhum pedido encontrado.</p>
        <?php endif; ?>
    </div>

    <script>
        function filtrarPedidos() {
            const searchInput = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('#pedidosTable tbody tr');

            rows.forEach(row => {
                const numero = row.cells[1].textContent.toLowerCase();
                const descricao = row.cells[2].textContent.toLowerCase();
                const status = row.cells[3].textContent.toLowerCase();

                if (descricao.includes(searchInput) || status.includes(searchInput) || numero.includes(searchInput)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
    <script src="/Project_Nimval/public/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
