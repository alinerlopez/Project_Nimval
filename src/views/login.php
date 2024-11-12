<?php
 if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$perfil = isset($_GET['perfil']) ? $_GET['perfil'] : (isset($_SESSION['perfil']) ? $_SESSION['perfil'] : null);

if (!$perfil) {
    header('Location: selecionar_perfil.php');
    exit();
}

$_SESSION['perfil'] = $perfil;
?>

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

        <?php if (isset($error) && !empty($error)): ?>
            <div class="alert alert-danger text-center">
                <?= htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card card-login shadow-lg">
                    <div class="card-body">
                        <h2 class="text-center mb-4">Login</h2>

                        <form method="POST" action="/Project_Nimval/public/index.php?page=login">
                            <input type="hidden" name="perfil" value="<?= htmlspecialchars($perfil); ?>">
                            <div class="form-group mb-3">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="senha">Senha</label>
                                <input type="password" class="form-control" id="senha" name="senha" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Entrar</button>
                        </form>

                        <?php if ($perfil === 'fornecedor'): ?>
                            <div class="text-center mt-3">
                                <p>Ainda não tem uma conta? <a href="/Project_Nimval/public/index.php?page=empresa_cadastro">Cadastre sua empresa</a></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/Project_Nimval/public/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
