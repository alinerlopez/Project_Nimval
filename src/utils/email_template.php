<?php
function emailLayout($nome, $linkConfirmacao) {
    return '
        <html>
        <head>
            <style>
                .email-container {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f9;
                    padding: 20px;
                    text-align: center;
                }
                .email-header {
                    background-color: #4CAF50;
                    color: white;
                    padding: 10px;
                }
                .email-body {
                    background-color: white;
                    padding: 20px;
                    margin: 20px 0;
                    border-radius: 8px;
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                }
                .email-button {
                    background-color: #4CAF50;
                    color: white;
                    padding: 10px 20px;
                    border-radius: 5px;
                    text-decoration: none;
                    font-size: 16px;
                    margin-top: 20px;
                    display: inline-block;
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
                    <p>Olá, <strong>' . htmlspecialchars($nome) . '</strong>!</p>
                    <p>Obrigado por se cadastrar em nosso sistema. Para ativar sua conta e validar seu e-mail, clique no botão abaixo:</p>
                    <a href="' . $linkConfirmacao . '" class="email-button">Confirmar E-mail</a>
                </div>
                <div class="email-footer">
                    <p>Se você não se cadastrou, por favor, ignore este e-mail.</p>
                    <p>&copy; Nimval - Rastreamentos. Todos os direitos reservados.</p>
                </div>
            </div>
        </body>
        </html>
    ';
}
