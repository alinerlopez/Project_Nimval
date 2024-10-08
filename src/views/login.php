<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/Project_Nimval/public/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/Project_Nimval/public/assets/css/global.css"> 
</head>
<body>

    <header class="bg-dark-blue text-white py-2">
        <div class="container">
            <h3><b>NIMVAL - Rastreamentos</b></h3>
        </div>
    </header>

    <div class="container mt-5">

        <?php if (isset($_GET['email_validado']) && $_GET['email_validado'] == 'true'): ?>
            <div class="alert alert-success text-center">
                Seu e-mail foi validado com sucesso! Agora você pode fazer login.
            </div>
        <?php elseif (isset($_GET['email_validado']) && $_GET['email_validado'] == 'false'): ?>
            <div class="alert alert-danger text-center">
                O token de validação é inválido ou expirou.
            </div>
        <?php endif; ?>

        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card card-login shadow-lg">
                    <div class="card-body">
                        <h2 class="text-center mb-4">Login</h2>
                        <?php
                            if (isset($_GET['senha_criada']) && $_GET['senha_criada'] == 'true') {
                                $success = "Cadastro realizado com sucesso! Verifique seu e-mail para validar o cadastro.";
                            }
                            ?>
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
                        
                        <div class="text-center mt-3">
                            <p>Ainda não tem uma conta? <a href="index.php?page=empresa_cadastro">Cadastre sua empresa</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/Project_Nimval/public/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
