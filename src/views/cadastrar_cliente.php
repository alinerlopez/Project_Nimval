<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Cliente</title>
    <link rel="stylesheet" href="/Project_Nimval/public/assets/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Cadastro de Cliente</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger text-center">
                <?= htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($success)): ?>
            <div class="alert alert-success text-center">
                <?= htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="index.php?page=salvar_cliente">
            <div class="form-group mb-3">
                <label for="nome">Nome Completo</label>
                <input type="text" class="form-control" name="nome" required value="<?= isset($nome) ? htmlspecialchars($nome) : ''; ?>">
            </div>
            <div class="form-group mb-3">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" required value="<?= isset($email) ? htmlspecialchars($email) : ''; ?>">
            </div>
            <div class="form-group mb-3">
                <label for="cpf">CPF</label>
                <input type="text" class="form-control" name="cpf" required value="<?= isset($cpf) ? htmlspecialchars($cpf) : ''; ?>">
            </div>
            <div class="form-group mb-3">
                <label for="telefone">Telefone</label>
                <input type="text" class="form-control" name="telefone" required value="<?= isset($telefone) ? htmlspecialchars($telefone) : ''; ?>">
            </div>
            <div class="form-group mb-3">
                <label for="senha">Senha</label>
                <input type="password" class="form-control" name="senha" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Cadastrar Cliente</button>
        </form>
    </div>
    <script src="/Project_Nimval/public/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
