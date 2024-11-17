<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php?page=login");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Consulta de Clientes</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/5.0.6/inputmask.min.js"></script>

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
            background-color: var(--azul-principal);
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
            padding: 20px;
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
            max-width: 40%; 
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
            margin-top: 8px;
            font-weight: bold;
            font-size: 14px;
        }

        .modal-content input,
        .modal-content select,
        .modal-content button {
            font-size: 12px;
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
            font-size: 14px;
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

        .search-container input[type="text"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
    </style>
</head>
    <body>

    <?php include __DIR__ . '/../utils/sidebar_fornecedor.php'; ?>

    <div class="content">
        <h2 class="text-center mb-4">Consulta de Clientes</h2>

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
                <h4>Editar Cliente</h4>
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
                    <input type="tel" id="edit_telefone" name="telefone" required>

                    <label for="edit_ativo">Ativo:</label>
                    <select id="edit_ativo" name="ativo" required>
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                    </select>

                    <button type="submit">Salvar Alterações</button>
                </form>
            </div>
        </div>
    </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

        <script>
            
            $(document).ready(function() {
                $('#edit_telefone').mask('(00) 00000-0000');
            });
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

            $(document).ready(function() {
                $('#edit_telefone').mask('(00) 00000-0000');
            });  

            function openEditModal(id, nome, cpf, email, endereco, telefone, ativo) {
                document.getElementById('edit_id_cliente').value = id;
                document.getElementById('edit_nome').value = nome;
                document.getElementById('edit_cpf').value = cpf;
                document.getElementById('edit_email').value = email;
                document.getElementById('edit_endereco').value = endereco;
                document.getElementById('edit_telefone').value = telefone;
                document.getElementById('edit_ativo').value = ativo;

                $('#edit_telefone').mask('(00) 00000-0000');
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
