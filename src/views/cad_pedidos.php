<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Pedido</title>
    <style>
        .search-bar {
            margin-bottom: 20px;
        }
        .search-bar input {
            padding: 10px;
            width: 300px;
            margin-right: 10px;
        }
        .grid-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .grid-table th, .grid-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .grid-table th {
            background-color: #f4f4f4;
        }
        .action-button {
    padding: 10px 20px;
    color: #fff;
    background-color: #0033aa;
    border: none;
    border-radius: 8px; 
    cursor: pointer;
    text-align: center;
    
        }

.action-button:hover {
    background-color: #002288; 
}

.action-button:active {
    background-color: #001166; 
    transform: scale(0.98); 
}
    </style>
</head>
<body>

<h2>Cadastro de Pedido</h2>

<div class="search-bar">
    <input type="text" id="searchInput" placeholder="Buscar cliente por nome..." onkeyup="filterClientes()">
</div>

<table class="grid-table" id="clientesTable">
    <thead>
        <tr>
            <th>Nome</th>
            <th>CPF</th>
            <th>Email</th>
            <th>Ação</th>
        </tr>
    </thead>
    <tbody>
    <?php if (!empty($clientes)): ?>
            <?php foreach ($clientes as $cliente): ?>
                <tr>
                    <td><?php echo htmlspecialchars($cliente['nome']); ?></td>
                    <td><?php echo htmlspecialchars($cliente['cpf']); ?></td>
                    <td><?php echo htmlspecialchars($cliente['email']); ?></td>
                    <td>
                        <button class="action-button" 
                                onclick="openPedidoForm(<?php echo $cliente['id_cliente']; ?>, '<?php echo htmlspecialchars($cliente['nome']); ?>')">
                            Cadastrar Pedido
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">Nenhum cliente encontrado.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<div id="pedidoForm" style="display: none;">
    <h3>Novo Pedido para <span id="clienteNome"></span></h3>
    <form action="cadastrar_pedido.php" method="post">
        <input type="hidden" id="id_cliente" name="id_cliente">
        
        <label for="descricao">Descrição do Pedido:</label>
        <textarea id="descricao" name="descricao_pedido" rows="4" required></textarea>

        <label for="status">Status do Pedido:</label>
        <select id="status" name="status_pedido" required>
            <option value="1">Pendente</option>
            <option value="2">Processando</option>
            <option value="3">Enviado</option>
        </select>

        <label for="data_pedido">Data do Pedido:</label>
        <input type="datetime-local" id="data_pedido" name="data_pedido" required>

        <button type="submit">Cadastrar Pedido</button>
    </form>
</div>

<script>
    function filterClientes() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toUpperCase();
        const table = document.getElementById('clientesTable');
        const tr = table.getElementsByTagName('tr');

        for (let i = 1; i < tr.length; i++) {
            const td = tr[i].getElementsByTagName('td')[0];
            if (td) {
                const txtValue = td.textContent || td.innerText;
                tr[i].style.display = txtValue.toUpperCase().indexOf(filter) > -1 ? '' : 'none';
            }
        }
    }

   
    function openPedidoForm(clienteId) {
        document.getElementById('id_cliente').value = clienteId;
        const clienteNome = document.querySelector(`#clientesTable tr td:first-child`).innerText;
        document.getElementById('clienteNome').innerText = clienteNome;

        document.getElementById('pedidoForm').style.display = 'block';
    }
</script>

</body>
</html>
