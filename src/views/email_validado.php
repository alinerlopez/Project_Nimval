<!-- email_validado.php -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validação de E-mail</title>
    <link rel="stylesheet" href="/Project_Nimval/public/assets/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <?php if (isset($sucesso) && $sucesso): ?>
            <div class="alert alert-success text-center">
                <h4>Seu e-mail foi validado com sucesso!</h4>
                <p>Agora você pode fazer login no sistema.</p>
                <a href="index.php?page=login" class="btn btn-primary">Ir para Login</a>
            </div>
        <?php else: ?>
            <div class="alert alert-danger text-center">
                <h4>Falha na validação do e-mail.</h4>
                <p>O token de validação é inválido ou expirou.</p>
            </div>
        <?php endif; ?>
    </div>
    <script src="/Project_Nimval/public/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
