<?php
require_once __DIR__ . '/../utils/session_helper.php';
require_once __DIR__ . '/../models/FuncionarioModel.php';

verificarSessao('id_fornecedor');

$id_fornecedor = $_SESSION['id_fornecedor'];
$funcionarios = FuncionarioModel::getFuncionariosPorFornecedor($id_fornecedor);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Funcionários</title>
    <link rel="stylesheet" href="/Project_Nimval/public/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/Project_Nimval/public/assets/css/colors.css">
    <style>
        body {
            display: flex;
            margin: 0;
            height: 100vh;
            overflow: hidden;
            font-family: Arial, sans-serif;
        }

        .content {
            flex-grow: 1;
            padding: 20px;
            background-color: var(--cinza-claro);
            overflow-y: auto;
        }

        .grid-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 1em;
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
        }

        .grid-table tr:hover {
            background-color: #f1f1f1;
        }

        .action-icon {
            cursor: pointer;
            font-size: 1.2em;
            color: var(--azul-principal);
            margin: 0 5px;
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
            background-color: #fff;
            margin: auto;
            padding: 10px 20px;
            border-radius: 8px;
            width: 400px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: var(--preto);
        }

        .form-control, .form-select {
            margin-bottom: 15px;
        }

        .btn-primary, .btn-secondary {
            width: 40%;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<?php include __DIR__ . '/../utils/sidebar_fornecedor.php'; ?>

<div class="content">
    <h2>Gerenciar Funcionários</h2>
    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Buscar por nome, e-mail ou CPF..." onkeyup="filtrarFuncionarios()">
    </div>
    <div class="mb-3">
        <a href="index.php?page=cadastrar_funcionario" class="btn btn-primary">Cadastrar Novo Funcionário</a>
    </div>
    <table class="grid-table" id="funcionariosTable">
        <thead>
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>CPF</th>
                <th>Telefone</th>
                <th>Nível de Acesso</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($funcionarios)): ?>
                <?php foreach ($funcionarios as $funcionario): ?>
                    <tr>
                        <td><?= htmlspecialchars($funcionario['nome']); ?></td>
                        <td><?= htmlspecialchars($funcionario['email']); ?></td>
                        <td><?= htmlspecialchars($funcionario['cpf']); ?></td>
                        <td><?= htmlspecialchars($funcionario['telefone']); ?></td>
                        <td><?= htmlspecialchars($funcionario['nivel_acesso']); ?></td>
                        <td>
                            <i class="fas fa-edit action-icon" onclick="openEditModal(<?= $funcionario['id_usuario']; ?>, '<?= htmlspecialchars($funcionario['nome']); ?>', '<?= htmlspecialchars($funcionario['email']); ?>', '<?= htmlspecialchars($funcionario['cpf']); ?>', '<?= htmlspecialchars($funcionario['telefone']); ?>', '<?= $funcionario['nivel_acesso']; ?>')"></i>
                            <i class="fas fa-trash text-danger action-icon" onclick="confirmRemove(<?= $funcionario['id_usuario']; ?>)"></i>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">Nenhum funcionário encontrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div id="editFuncionarioModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h5>Editar Funcionário</h5>
            <span class="close" onclick="closeEditModal()">&times;</span>
        </div>
        <form id="editFuncionarioForm" action="index.php?page=editar_funcionario" method="post">
            <input type="hidden" id="edit_id_usuario" name="id_usuario">

            <div class="mb-3">
                <label for="edit_nome" class="form-label">Nome</label>
                <input type="text" id="edit_nome" name="nome" class="form-control" readonly>
            </div>

            <div class="mb-3">
                <label for="edit_email" class="form-label">E-mail</label>
                <input type="email" id="edit_email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="edit_cpf" class="form-label">CPF</label>
                <input type="text" id="edit_cpf" name="cpf" class="form-control" readonly>
            </div>

            <div class="mb-3">
                <label for="edit_telefone" class="form-label">Telefone</label>
                <input type="text" id="edit_telefone" name="telefone" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="edit_nivel_acesso" class="form-label">Nível de Acesso</label>
                <select id="edit_nivel_acesso" name="nivel_acesso" class="form-select">
                    <option value="admin">Admin</option>
                    <option value="operador">Operador</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Cancelar</button>
        </form>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<script>
    $(document).ready(function () {
        $('#edit_cpf').mask('000.000.000-00');
        $('#edit_telefone').mask('(00) 00000-0000');
    });

    function filtrarFuncionarios() {
        const input = document.getElementById("searchInput").value.toLowerCase();
        const rows = document.querySelectorAll("#funcionariosTable tbody tr");

        rows.forEach(row => {
            const nome = row.cells[0].textContent.toLowerCase();
            const email = row.cells[1].textContent.toLowerCase();
            const cpf = row.cells[2].textContent.toLowerCase();

            row.style.display = (nome.includes(input) || email.includes(input) || cpf.includes(input)) ? "" : "none";
        });
    }

    function openEditModal(id, nome, email, cpf, telefone, nivel_acesso) {
        document.getElementById('edit_id_usuario').value = id;
        document.getElementById('edit_nome').value = nome;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_cpf').value = cpf;
        document.getElementById('edit_telefone').value = telefone;
        document.getElementById('edit_nivel_acesso').value = nivel_acesso;
        document.getElementById('editFuncionarioModal').style.display = "block";
    }

    function closeEditModal() {
        document.getElementById('editFuncionarioModal').style.display = "none";
    }

    function confirmRemove(id) {
        if (confirm("Tem certeza que deseja remover este funcionário?")) {
            window.location.href = `index.php?page=remover_funcionario&id=${id}`;
        }
    }
</script>
</body>
</html>
