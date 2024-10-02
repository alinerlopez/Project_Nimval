<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar usuário</title>
    <link rel="stylesheet" href="/Project_Nimval/public/assets/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7-beta.19/jquery.inputmask.min.js"></script>
</head>
<body>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Criar usuário</h2>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger text-center">
                <?= htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="index.php?page=salvar_senha">
                            <div class="form-group mb-3">
                                <label for="nome">Nome Completo</label>
                                <input type="text" class="form-control" name="nome" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="cpf">CPF</label>
                                <input type="text" class="form-control" id="cpf" name="cpf" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="telefone">Telefone</label>
                                <input type="text" class="form-control" id="telefone" name="telefone" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="senha">Nova Senha</label>
                                <input type="password" class="form-control" name="senha" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="confirmar_senha">Confirmar Senha</label>
                                <input type="password" class="form-control" name="confirmar_senha" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Salvar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
      $(document).ready(function(){
        $('#cpf').inputmask('999.999.999-99', { clearIncomplete: true });
        $('#telefone').inputmask('(99) 99999-9999', { clearIncomplete: true });

        $('form').on('submit', function(e) {
        var senha = $('input[name="senha"]').val();
        var confirmarSenha = $('input[name="confirmar_senha"]').val();

        if (senha !== confirmarSenha) {
            e.preventDefault(); 
            alert('As senhas não coincidem!');
        }
        });
    });
    </script>

    <script src="/Project_Nimval/public/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
