<?php
function emailConfirmacao($nome, $linkConfirmacao) {
    return '
        <!DOCTYPE html>
        <html lang="pt-BR">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <style>
                .email-container {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f9;
                    padding: 20px;
                    text-align: center;
                }
                .email-header {
                    background-color: #001133;
                    color: white;
                    padding: 10px;
                }
                .email-body {
                    background-color: white;
                    padding: 20px;
                    margin: 20px 0;
                    border-radius: 8px;
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                    text-align: center;
                }
                .email-footer {
                    font-size: 12px;
                    color: #555;
                    margin-top: 20px;
                }
            </style>
        </head>
        <body>
            <div class="email-container">
                <div class="email-header">
                    <h1>Confirmação de E-mail</h1>
                </div>
                <div class="email-body">
                    <p>Olá, <strong>' . htmlspecialchars($nome, ENT_QUOTES, "UTF-8") . '</strong>!</p>
                    <p>Obrigado por se cadastrar em nosso sistema. Para ativar sua conta e validar seu e-mail, clique no botão abaixo:</p>
                    <a href="' . htmlspecialchars($linkConfirmacao, ENT_QUOTES, "UTF-8") . '" 
                       style="background-color: #001133; color: #ffffff; padding: 10px 20px; 
                       text-decoration: none; border-radius: 4px; display: inline-block; 
                       font-size: 16px; font-weight: bold;">
                        Confirmar E-mail
                    </a>
                </div>
                <div class="email-footer">
                     © 2024 Nimval Rastreamentos. Todos os direitos reservados.
                </div>
            </div>
        </body>
        </html>
    ';
}
function emailSenhaLayout($nome, $senha_gerada, $linkLogin) {
    return "
    <html lang='pt-br'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Bem-vindo ao Nimval Rastreamentos</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 0;
            }
            .container {
                max-width: 600px;
                margin: 50px auto;
                background-color: #ffffff;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                overflow: hidden;
            }
            .header {
                background-color: #001133; 
                color: #ffffff;
                text-align: center;
                padding: 20px;
                font-size: 24px;
            }
            .content {
                padding: 20px;
                line-height: 1.6;
                color: #333;
            }
            .content p {
                margin-bottom: 15px;
            }
            .content a {
                background-color: #007bff;
                color: #ffffff;
                padding: 10px 20px;
                text-decoration: none;
                border-radius: 4px;
                display: inline-block;
                margin-top: 10px;
            }
            .footer {
                background-color: #f1f1f1;
                text-align: center;
                padding: 10px;
                font-size: 12px;
                color: #888;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>Bem-vindo ao Nimval Rastreamentos</div>
            <div class='content'>
                <p>Olá, <strong>$nome</strong>!</p>
                <p>Seu cadastro foi realizado com sucesso. Aqui está sua senha para acessar o sistema:</p>
                <p><strong>Senha: $senha_gerada</strong></p>
                <p>Você pode acessar o sistema através do seguinte link:</p>
                <a href='$linkLogin'>Acessar Sistema</a>
                <p>Se você não fez este cadastro, ignore este e-mail.</p>
                <p>Seus dados ficaram visíveis para todos os fornecedores cadastrados em nossa plataforma</p>
            </div>
            <div class='footer'>
                © 2024 Nimval Rastreamentos. Todos os direitos reservados.
            </div>
        </div>
    </body>
    </html>
    ";
}

?>
