<?php
require_once __DIR__ . '/../utils/session_helper.php';
verificarSessao('id_fornecedor');
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Funcionário</title>
    <link rel="stylesheet" href="/Project_Nimval/public/assets/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<style>
        body {
            display: flex;
            margin: 0;
            height: 100vh;
            font-family: Arial, sans-serif;
            overflow: hidden;
        }

        .content {
            flex-grow: 1;
            padding: 20px;
            background-color: #f8f9fa;
            overflow-y: auto;
        }
        </style>
</head>
<body>
<?php include __DIR__ . '/../utils/sidebar_fornecedor.php'; ?>

<div class="content">
<h2>Cadastrar Funcionário</h2>
    <form action="index.php?page=cadastrar_funcionario" method="post">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" id="nome" name="nome" class="form-control" maxlength="100" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" id="email" name="email" class="form-control" maxlength="255" required>
        </div>
        <div class="mb-3">
            <label for="cpf" class="form-label">CPF</label>
            <input type="text" id="cpf" name="cpf" class="form-control" maxlength="14" required>
        </div>
        <div class="mb-3">
            <label for="telefone" class="form-label">Telefone</label>
            <input type="text" id="telefone" name="telefone" class="form-control" maxlength="15" required>
        </div>
        <div class="mb-3">
            <label for="senha" class="form-label">Senha</label>
            <input type="password" id="senha" name="senha" class="form-control" maxlength="255" required>
        </div>
        <div class="mb-3">
            <label for="nivel_acesso" class="form-label">Nível de Acesso</label>
            <select id="nivel_acesso" name="nivel_acesso" class="form-select" required>
                <option value="admin">Admin</option>
                <option value="operador">Operador</option>
            </select>
        </div>
        <input type="hidden" name="email_validado" value="1">
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="index.php?page=funcionarios" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('#cpf').mask('000.000.000-00', {reverse: true});
        $('#telefone').mask('(00) 00000-0000');
    });
</script>
<script src="/Project_Nimval/public/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>