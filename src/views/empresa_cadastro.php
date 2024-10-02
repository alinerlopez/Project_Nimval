<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Empresa</title>
    <link rel="stylesheet" href="/Project_Nimval/public/assets/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7-beta.19/jquery.inputmask.min.js"></script>
    <style>
        /* Estilo para mensagens de erro e sucesso */
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

        .form-control.success {
            border-color: #28a745;
        }

        .form-control.error {
            border-color: #dc3545;
        }

        /* Ícones de validação */
        .validation-icon {
            position: absolute;
            right: 10px;
            top: 35px;
            font-size: 20px;
        }

        .validation-icon.success {
            color: #28a745;
        }

        .validation-icon.error {
            color: #dc3545;
        }
    </style>
</head>
<body>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Cadastro de Empresa</h2>

        <!-- Exibição da mensagem de sucesso -->
        <?php if (isset($_GET['success']) && $_GET['success'] == 'true'): ?>
            <div class="alert alert-success success-message">
                Cadastro realizado com sucesso! Verifique seu e-mail para ativar sua conta.
            </div>
        <?php endif; ?>

        <!-- Exibição da mensagem de erro na validação do e-mail -->
        <?php if (isset($_GET['email_validado']) && $_GET['email_validado'] == 'false'): ?>
            <div class="alert alert-danger text-center">
                O token de validação é inválido ou expirou.
            </div>
        <?php endif; ?>

        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-6">

                <!-- Formulário de cadastro -->
                <form id="form_cadastro_empresa" method="POST" action="index.php?page=empresa_cadastro">
                    <!-- Campo CNPJ com validação visual -->
                    <div class="form-group mb-3 position-relative">
                        <label for="cnpj_fornecedor">CNPJ</label>
                        <input type="text" class="form-control" id="cnpj_fornecedor" name="cnpj_fornecedor" required>
                        <small id="cnpj_error" class="error-message"></small>
                        <span class="validation-icon" id="cnpj_icon"></span>
                    </div>

                    <!-- Campo Nome do Fornecedor -->
                    <div class="form-group mb-3">
                        <label for="nome_fornecedor">Nome do Fornecedor</label>
                        <input type="text" class="form-control" id="nome_fornecedor" name="nome_fornecedor" readonly>
                    </div>

                    <!-- Campo Telefone -->
                    <div class="form-group mb-3">
                        <label for="tel_fornecedor">Telefone</label>
                        <input type="text" class="form-control" name="tel_fornecedor" id="tel_fornecedor" required>
                    </div>

                    <!-- Campo Email -->
                    <div class="form-group mb-3">
                        <label for="email_fornecedor">Email</label>
                        <input type="email" class="form-control" name="email_fornecedor" id="email_fornecedor" required>
                        <small id="email_error" class="error-message"></small>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Cadastrar Empresa</button>
                </form>

            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
    // Máscara para os campos de CNPJ e Telefone
    $('#cnpj_fornecedor').inputmask('99.999.999/9999-99', { clearIncomplete: true });
    $('#tel_fornecedor').inputmask('(99) 99999-9999', { clearIncomplete: true });

    // Validação de CNPJ ao perder o foco
    $('#cnpj_fornecedor').on('blur', function() {
        var cnpj = $('#cnpj_fornecedor').val().replace(/\D/g, '');

        if (cnpj.length === 14) {
            $.ajax({
                url: '/Project_Nimval/public/validate_cnpj.php', 
                method: 'POST',
                data: { cnpj: cnpj },
                success: function(response) {
                    try {
                        var data = JSON.parse(response);
                        if (data.status === 'error') {
                            $('#cnpj_fornecedor').addClass('error').removeClass('success');
                            $('#cnpj_icon').addClass('error').removeClass('success').text('✗');
                            $('#cnpj_error').text(data.message);
                            $('#nome_fornecedor').val('');
                        } else {
                            $('#cnpj_fornecedor').addClass('success').removeClass('error');
                            $('#cnpj_icon').addClass('success').removeClass('error').text('✓');
                            $('#cnpj_error').text('');
                            $('#nome_fornecedor').val(data.nome);
                        }
                    } catch (error) {
                        console.error("Erro ao processar a resposta JSON: ", error);
                        $('#cnpj_error').text('Erro ao validar o CNPJ.');
                    }
                },
                error: function() {
                    $('#cnpj_error').text('Erro ao validar o CNPJ. Tente novamente.');
                }
            });
        } else {
            $('#cnpj_fornecedor').addClass('error').removeClass('success');
            $('#cnpj_icon').addClass('error').removeClass('success').text('✗');
            $('#cnpj_error').text('CNPJ incompleto.');
        }
    });

    // Validação de CNPJ e Email no envio do formulário
    $('#form_cadastro_empresa').on('submit', function(e) {
    e.preventDefault();  // Evita o envio do formulário até a validação ser concluída

    var cnpj = $('#cnpj_fornecedor').val().replace(/\D/g, '');
    var email = $('#email_fornecedor').val();

    console.log("CNPJ: ", cnpj);  // Verifique se o CNPJ está sendo capturado corretamente
    console.log("Email: ", email);  // Verifique se o email está sendo capturado corretamente

    $.ajax({
        url: '/Project_Nimval/public/validate_email_cnpj_db.php',  // Verifica se o caminho está correto
        method: 'POST',
        data: { cnpj: cnpj, email: email },
        success: function(response) {
            console.log("Resposta do servidor (bruta): ", response);
            try {
                var data = response; // A resposta já está em JSON, então não precisa de JSON.parse
                if (data.status === 'error') {
                    alert(data.message);
                } else {
                    $('#form_cadastro_empresa')[0].submit();  // Envia o formulário se a validação passar
                }
            } catch (error) {
                console.error("Erro ao processar a resposta JSON: ", error);
                alert("Ocorreu um erro ao validar os dados. Tente novamente.");
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("Erro na requisição: ", textStatus, errorThrown);
            alert("Erro ao comunicar com o servidor.");
        }
    });
    });
});
    </script>

    <script src="/Project_Nimval/public/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
