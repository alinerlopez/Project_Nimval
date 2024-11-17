<?php
require_once __DIR__ . '/../utils/session_helper.php';
verificarSessao('id_fornecedor');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Cliente</title>
    <link href="/Project_Nimval/public/assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }

        .content {
            flex-grow: 1; 
            padding: 20px;
            overflow-y: auto;
            background-color: #f8f9fa;
        }

        .alert {
            position: fixed; 
            top: 20px; 
            left: 50%; 
            transform: translateX(-50%); 
            z-index: 1050; 
            padding: 15px 25px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.5s ease-out;
            width: 90%; 
            max-width: 400px;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php include __DIR__ . '/../utils/sidebar_fornecedor.php'; ?>

    <div class="content">
        <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger text-center" id="error-message">
                    <?= htmlspecialchars($_SESSION['error']); ?>
                    <?php unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success text-center" id="success-message">
                    <?= htmlspecialchars($_SESSION['success']); ?>
                    <?php unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>
            <h2 class="text-center mb-4">Cadastro de Cliente</h2>
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger text-center" id="error-message">
                    <?= htmlspecialchars($_SESSION['error']); ?>
                    <?php unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success text-center" id="success-message">
                    <?= htmlspecialchars($_SESSION['success']); ?>
                    <?php unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="index.php?page=cadastrar_cliente">
                <div class="form-group mb-3">
                    <label for="nome">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" autocomplete="off" required>
                </div>
                <div class="form-group mb-3">
                    <label for="cpf">CPF</label>
                    <input type="text" class="form-control" id="cpf" name="cpf" autocomplete="off" required>
                </div>
                <div class="form-group mb-3">
                    <label for="telefone">Telefone</label>
                    <input type="text" class="form-control" id="telefone" name="telefone" autocomplete="off" required>
                </div>
                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" autocomplete="off" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Cadastrar Cliente</button>
            </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#cpf').mask('000.000.000-00');
            $('#telefone').mask('(00) 00000-0000');
            setTimeout(function() {
                $('#error-message').fadeOut('slow');
                $('#success-message').fadeOut('slow');
            }, 800);
        });
    </script>
    <script src="/Project_Nimval/public/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
