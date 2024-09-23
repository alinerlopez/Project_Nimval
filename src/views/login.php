<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/Project_Nimval/public/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/Project_Nimval/public/assets/css/global.css"> <!-- CSS personalizado -->
</head>
<body>

    <!-- Header com fundo azul escuro -->
    <header class="bg-dark-blue text-white py-2">
        <div class="container">
            <h3><b>NIMVAL - Rastreamentos</b></h3>
        </div>
    </header>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card card-login shadow-lg">
                    <div class="card-body">
                        <h2 class="text-center mb-4">Login</h2>

                        <!-- Exibição de erros, se houver -->
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger text-center">
                                <?= htmlspecialchars($error); ?>
                            </div>
                        <?php endif; ?>

                        <!-- Formulário de login -->
                        <form method="POST" action="index.php?page=login">
                            <div class="form-group mb-3">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="senha">Senha</label>
                                <input type="password" class="form-control" name="senha" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Entrar</button>
                        </form>
                        
                        <!-- Link para cadastro de empresa -->
                        <div class="text-center mt-3">
                            <p>Ainda não tem uma conta? <a href="index.php?page=cadastro_empresa">Cadastre sua empresa</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/Project_Nimval/public/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
