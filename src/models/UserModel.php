<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../vendor/autoload.php';

class UserModel {
    public static function loadEnv($path)
    {
        if (!file_exists($path)) {
            throw new Exception(".env file not found at path: " . $path);
        }
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue;
            }
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);
            putenv("$name=$value");
            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;
        }
    }

    public static function createUser($nome, $email, $senha_hash, $nivel_acesso, $fornecedor_id, $cpf, $telefone) {
        global $pdo;
        self::loadEnv(__DIR__ . '/../../.env');

        try {
            $token = bin2hex(random_bytes(16)); 
            $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, cpf, telefone, nivel_acesso, id_fornecedor, token_confirmacao, email_validado) 
                                   VALUES (:nome, :email, :senha, :cpf, :telefone, :nivel_acesso, :fornecedor_id, :token, 0)");
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':senha', $senha_hash);
            $stmt->bindParam(':cpf', $cpf);
            $stmt->bindParam(':telefone', $telefone);
            $stmt->bindParam(':nivel_acesso', $nivel_acesso);
            $stmt->bindParam(':fornecedor_id', $fornecedor_id);
            $stmt->bindParam(':token', $token);

            $resultado = $stmt->execute();

            if ($resultado) {
                $linkConfirmacao = "http://localhost/Project_Nimval/src/views/confirmar_email.php?token=$token";
                $mail = new PHPMailer(true);

                try {
                    $mail->isSMTP();
                    $mail->Host       = getenv('SMTP_HOST');
                    $mail->SMTPAuth   = true;
                    $mail->Username   = getenv('SMTP_USERNAME'); 
                    $mail->Password   = getenv('SMTP_PASSWORD');            
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                    $mail->Port       = getenv('SMTP_PORT');

                    $mail->setFrom(getenv('SMTP_FROM_EMAIL'), getenv('SMTP_FROM_NAME'));
                    $mail->addAddress($email);  
                    
                    $mail->isHTML(true);
                    $mail->Subject = 'Confirme seu e-mail';
                    $mail->Body    = '
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
                    $mail->AltBody = "Olá, " . htmlspecialchars($nome) . "\n\nObrigado por se cadastrar em nosso sistema. Para ativar sua conta, copie e cole o link abaixo em seu navegador:\n\n$linkConfirmacao\n\nSe você não se cadastrou, ignore este e-mail.";

                    $mail->send();
                    error_log('Mensagem de confirmação enviada.');
                } catch (Exception $e) {
                    error_log("Erro ao enviar o e-mail: {$mail->ErrorInfo}");
                    return false;
                }
                return true;
            } else {
                error_log("Erro ao criar usuário no banco de dados.");
                return false;
            }
        } catch (PDOException $e) {
            error_log("Erro ao criar usuário: " . $e->getMessage());
            return false;
        }
    }
    public static function findUserByEmail($email) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT id_usuario, nome, email, senha, nivel_acesso, email_validado FROM usuarios WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
