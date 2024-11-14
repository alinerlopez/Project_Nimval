<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Consulta de Clientes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/5.0.6/inputmask.min.js"></script>
    <style>
        /* Estilos para a tabela */
        .grid-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 1em;
            min-width: 600px;
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

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            padding-top: 50px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            padding-left: 30px; 
            padding-right: 30px; 
            border: 1px solid #888;
            border-radius: 8px;
            width: 400px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: #000;
        }

        .modal-content label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        .modal-content input,
        .modal-content select,
        .modal-content button {
            width: 100%;
            padding: 8px;
            margin-top: 4px;
            margin-bottom: 4px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .modal-content button {
            background-color: #007bff;
            color: #fff;
            border: none;
            font-size: 16px;
            cursor: pointer;
        }

        .modal-content button:hover {
            background-color: #0056b3;
        }

        .action-icon {
            cursor: pointer;
            font-size: 1.2em;
            color: #007bff;
            text-align: center;
            display: inline-block;
            width: 100%;
        }

        .search-container {
            margin-bottom: 20px;
        }

        .search-container input[type="text"] {
            width: 98%;
            padding: 10px;
            margin-right: 20px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>

<h2>Consulta de Clientes</h2>

<div class="search-container">
        <input type="text" id="searchInput" placeholder="Buscar cliente por nome, CPF ou email..." onkeyup="filtrarClientes()">
</div>

<table class="grid-table" id="clientesTable">
    <thead>
        <tr>
            <th>Nome</th>
            <th>CPF</th>
            <th>Email</th>
            <th>Endereço</th>
            <th>Telefone</th>
            <th>Ativo</th>
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
                        <td><?php echo htmlspecialchars($cliente['endereco']); ?></td>
                        <td><?php echo htmlspecialchars($cliente['telefone']); ?></td>
                        <td><?php echo htmlspecialchars($cliente['ativo'] ? 'Sim' : 'Não'); ?></td>
                        <td>
                            <span class="action-icon" onclick="openEditModal(<?php echo $cliente['id_cliente']; ?>, '<?php echo htmlspecialchars($cliente['nome']); ?>', '<?php echo htmlspecialchars($cliente['cpf']); ?>', '<?php echo htmlspecialchars($cliente['email']); ?>', '<?php echo htmlspecialchars($cliente['endereco']); ?>', '<?php echo htmlspecialchars($cliente['telefone']); ?>', '<?php echo $cliente['ativo']; ?>')">
                                <i class="fas fa-edit"></i>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">Nenhum cliente encontrado.</td>
                </tr>
            <?php endif; ?>
    </tbody>
</table>

<div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h3>Editar Cliente</h3>
            <form id="editForm" action="index.php?page=atualizar_cliente" method="post">
                <input type="hidden" id="edit_id_cliente" name="id_cliente">

                <label for="edit_nome">Nome:</label>
                <input type="text" id="edit_nome" name="nome" readonly>

                <label for="edit_cpf">CPF:</label>
                <input type="text" id="edit_cpf" name="cpf" readonly>

                <label for="edit_email">Email:</label>
                <input type="email" id="edit_email" name="email" required>

                <label for="edit_endereco">Endereço:</label>
                <input type="text" id="edit_endereco" name="endereco" required>

                <label for="edit_telefone">Telefone:</label>
                <input type="text" id="edit_telefone" name="telefone" required>

                <label for="edit_ativo">Ativo:</label>
                <select id="edit_ativo" name="ativo" required>
                    <option value="1">Sim</option>
                    <option value="0">Não</option>
                </select>

                <button type="submit">Salvar Alterações</button>
            </form>
        </div>
    </div>

    <script>
        function filtrarClientes() {
            const input = document.getElementById("searchInput").value.toLowerCase();
            const rows = document.querySelectorAll("#clientesTable tbody tr");

            rows.forEach(row => {
                const nome = row.cells[0].textContent.toLowerCase();
                const cpf = row.cells[1].textContent.toLowerCase();
                const email = row.cells[2].textContent.toLowerCase();

                if (nome.includes(input) || cpf.includes(input) || email.includes(input)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        }


        function openEditModal(id, nome, cpf, email, endereco, telefone, ativo) {
            document.getElementById('edit_id_cliente').value = id;
            document.getElementById('edit_nome').value = nome;
            document.getElementById('edit_cpf').value = cpf;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_endereco').value = endereco;
            document.getElementById('edit_telefone').value = telefone;
            document.getElementById('edit_ativo').value = ativo;
            document.getElementById('editModal').style.display = "block";
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = "none";
        }

        window.onclick = function(event) {
            const modal = document.getElementById('editModal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

</body>
</html>
