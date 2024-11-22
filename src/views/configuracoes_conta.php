<?php 
require_once __DIR__ . '/../utils/session_helper.php';
require_once __DIR__ . '/../models/EmpresaModel.php';
require_once __DIR__ . '/../utils/sidebar_fornecedor.php';
verificarSessao('id_fornecedor');

$id_fornecedor = $_SESSION['id_fornecedor'];
$fornecedor = EmpresaModel::getFornecedorById($id_fornecedor);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurações de Conta</title>
    <link href="/Project_Nimval/public/assets/css/bootstrap.min.css" rel="stylesheet">
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

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            font-size: 14px;
            cursor: pointer;
            border-radius: 5px;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        h2 {
            color: #343a40;
            font-weight: bold;
        }

        p {
            color: #495057;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ced4da;
            border-radius: 5px;
        }
        .btn {
            width: 100%;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            font-size: 14px;
            cursor: pointer;
            border-radius: 5px;
        }

        .btn-link {
            font-weight: bold;
            color: #007bff;
            text-decoration: none;
        }

        .btn-link:hover {
            text-decoration: underline;
            color: #0056b3;
        }
    </style>
    <script>
        function confirmarRemocao() {
            return confirm('Tem certeza de que deseja remover sua conta? Esta ação é irreversível.');
        }
    </script>
</head>
<body>
    <div class="content">
        <div class="container">
            <h2>Configurações de Conta</h2>
            <p>Atualize suas informações ou remova sua conta.</p>

            <form action="index.php?page=atualizar_conta_fornecedor" method="post">
                <div class="form-group">
                    <label for="nome_fornecedor">Nome</label>
                    <input type="text" id="nome_fornecedor" name="nome_fornecedor" value="<?= htmlspecialchars($fornecedor['nome_fornecedor']); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="email_fornecedor">Email</label>
                    <input type="email" id="email_fornecedor" name="email_fornecedor" value="<?= htmlspecialchars($fornecedor['email_fornecedor']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="tel_fornecedor">Telefone</label>
                    <input type="text" id="tel_fornecedor" name="tel_fornecedor" value="<?= htmlspecialchars($fornecedor['tel_fornecedor']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="cnpj_fornecedor">CNPJ</label>
                    <input type="text" id="cnpj_fornecedor" name="cnpj_fornecedor" value="<?= htmlspecialchars($fornecedor['cnpj_fornecedor']); ?>" readonly>
                </div>
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            </form>

            <form id="removerContaForm" action="index.php?page=remover_conta_fornecedor" method="post">
              <button type="button" class="btn btn-danger" onclick="confirmarRemocao()">Remover Conta</button>
            </form>
        </div>
    </div>
    <script>
      function confirmarRemocao() {
          if (confirm("Tem certeza de que deseja remover sua conta? Esta ação não pode ser desfeita.")) {
              document.getElementById("removerContaForm").submit();
          }
      }
    </script>
    <script src="/Project_Nimval/public/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
