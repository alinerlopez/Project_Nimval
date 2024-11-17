<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Conta</title>
    <link href="/Project_Nimval/public/assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/Project_Nimval/public/assets/css/colors.css">
    <style>
        body {
            margin: 0;
            background-color: var(--gelo);
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-control[readonly] {
            background-color: var(--cinza-claro);
            color: var(--cinza-escuro);
        }

        .btn-danger {
            background-color: var(--alerta-erro);
            border: none;
        }

        .btn-danger:hover {
            background-color: var(--alerta-erro-hover);
        }

        .btn-primary {
            background-color: var(--azul-principal);
            border: none;
        }

        .btn-primary:hover {
            background-color: var(--azul-escuro);
        }
    </style>
    <script>
        function confirmarRemocao() {
            return confirm("Tem certeza de que deseja remover sua conta? Esta ação é irreversível.");
        }
    </script>
</head>
<body>
    <?php include __DIR__ . '/../utils/header_cliente.php'; ?>

    <div class="container">
        <h2 class="mb-4">Editar Conta</h2>

        <form action="index.php?page=salvar_conta_cliente" method="post">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" class="form-control" value="<?= htmlspecialchars($cliente['nome'] ?? ''); ?>" readonly>
            </div>

            <div class="form-group">
                <label for="cpf">CPF</label>
                <input type="text" id="cpf" name="cpf" class="form-control" value="<?= htmlspecialchars($cliente['cpf'] ?? ''); ?>" readonly>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($cliente['email'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label for="endereco">Endereço</label>
                <textarea id="endereco" name="endereco" class="form-control" rows="3"><?= htmlspecialchars($cliente['endereco'] ?? ''); ?></textarea>
            </div>

            <div class="form-group">
                <label for="telefone">Telefone</label>
                <input type="text" id="telefone" name="telefone" class="form-control" value="<?= htmlspecialchars($cliente['telefone'] ?? ''); ?>" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-4">Salvar Alterações</button>
        </form>

        <form action="index.php?page=remover_conta_cliente" method="post" onsubmit="return confirmarRemocao();">
            <input type="hidden" name="id_cliente" value="<?= htmlspecialchars($id_cliente); ?>">
            <button type="submit" class="btn btn-danger w-100">Remover Conta</button>
        </form>
    </div>

    <script src="/Project_Nimval/public/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
