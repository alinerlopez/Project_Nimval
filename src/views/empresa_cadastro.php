<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Empresa</title>
    <link rel="stylesheet" href="/Project_Nimval/public/assets/css/bootstrap.min.css">
    <!-- Incluindo jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7-beta.19/jquery.inputmask.min.js"></script>
    <style>
        /* Estilo para a mensagem de erro */
        .error-message {
            color: red;
            font-size: 12px;
        }

        .success-message {
            color: green;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Container principal -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">Cadastro de Empresa</h2>

        <!-- Exibição da mensagem de sucesso -->
        <?php if (isset($_GET['success']) && $_GET['success'] == 'true'): ?>
            <div class="alert alert-success success-message">
                Cadastro realizado com sucesso!
            </div>
        <?php endif; ?>

        <!-- Linha e coluna para centralizar e limitar a largura do formulário -->
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-6"> <!-- Limita o formulário a 60% da largura da tela -->

                <!-- Formulário de cadastro -->
                <form method="POST" action="index.php?page=cadastro_empresa">
                    <!-- Campo CNPJ como primeiro -->
                    <div class="form-group mb-3">
                        <label for="cnpj_fornecedor">CNPJ</label>
                        <input type="text" class="form-control" id="cnpj_fornecedor" name="cnpj_fornecedor" required>
                        <!-- Div para exibir a mensagem de erro -->
                        <small id="cnpj_error" class="error-message"></small>
                        <small id="cnpj_success" class="success-message"></small>
                    </div>

                    <!-- Campo Nome do Fornecedor que será preenchido automaticamente -->
                    <div class="form-group mb-3">
                        <label for="nome_fornecedor">Nome do Fornecedor</label>
                        <input type="text" class="form-control" id="nome_fornecedor" name="nome_fornecedor" readonly>
                    </div>

                    <!-- Outros campos -->
                    <div class="form-group mb-3">
                        <label for="tel_fornecedor">Telefone</label>
                        <input type="text" class="form-control" name="tel_fornecedor" id="tel_fornecedor" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="email_fornecedor">Email</label>
                        <input type="email" class="form-control" name="email_fornecedor" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Cadastrar Empresa</button>
                </form>

            </div>
        </div>
    </div>

    <!-- Script para aplicar a máscara ao campo de CNPJ e validar via AJAX -->
    <script>
        $(document).ready(function(){
            // Aplicando a máscara para CNPJ (99.999.999/9999-99)
            $('#cnpj_fornecedor').inputmask('99.999.999/9999-99', { clearIncomplete: true });
            $('#tel_fornecedor').inputmask('(99) 99999-9999', { clearIncomplete: true });

            // Evento quando o campo CNPJ perde o foco
            $('#cnpj_fornecedor').on('blur', function() {
                // Obtém o valor do CNPJ sem a máscara
                var cnpj = $('#cnpj_fornecedor').val().replace(/\D/g, '');

                // Se o campo estiver preenchido, fazer a validação
                if (cnpj.length === 14) {
                    // Fazendo a requisição AJAX para validar o CNPJ
                    $.ajax({
                        url: 'validate_cnpj.php', // URL do arquivo PHP que faz a validação
                        method: 'POST',
                        data: { cnpj: cnpj },
                        success: function(response) {
                            var data = JSON.parse(response);

                            if (data.status === 'error') {
                                // CNPJ inválido, exibe a mensagem de erro
                                $('#cnpj_error').text(data.message);
                                $('#cnpj_success').text('');
                                $('#nome_fornecedor').val(''); // Limpa o campo de nome se o CNPJ for inválido
                            } else {
                                // CNPJ válido, remove a mensagem de erro e preenche o nome da empresa
                                $('#cnpj_success').text(data.message);
                                $('#cnpj_error').text('');
                                $('#nome_fornecedor').val(data.nome); // Preenche o campo com o nome da empresa
                            }
                        },
                        error: function() {
                            $('#cnpj_error').text('Erro ao validar o CNPJ. Tente novamente.');
                            $('#cnpj_success').text('');
                        }
                    });
                } else {
                    $('#cnpj_error').text('CNPJ incompleto.');
                    $('#cnpj_success').text('');
                }
            });
        });
    </script>

    <script src="/Project_Nimval/public/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
