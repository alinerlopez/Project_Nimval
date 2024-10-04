<?php
require_once __DIR__ . '/../../config/config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../vendor/autoload.php';

class UserModel {

    public static function createUser($nome, $email, $senha_hash, $perfil, $fornecedor_id, $cpf, $telefone) {
        global $pdo;
        try {
            // Gerar o token de confirmação
            $token = bin2hex(random_bytes(16));

            // Inserir o usuário no banco de dados
            $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, cpf, telefone, nivel_acesso, id_fornecedor, token_confirmacao, email_validado) 
                                   VALUES (:nome, :email, :senha, :cpf, :telefone, :perfil, :fornecedor_id, :token, 0)");
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':senha', $senha_hash);
            $stmt->bindParam(':cpf', $cpf);
            $stmt->bindParam(':telefone', $telefone);
            $stmt->bindParam(':perfil', $perfil);
            $stmt->bindParam(':fornecedor_id', $fornecedor_id);
            $stmt->bindParam(':token', $token);

            $resultado = $stmt->execute();

            if ($resultado) {
                // Gerar o link de confirmação
                $linkConfirmacao = "http://localhost/Project_Nimval/src/views/confirmar_email.php?token=$token";
                // Enviar o e-mail de confirmação usando PHPMailer
                $mail = new PHPMailer(true);

                try {
                    // Configurações do servidor SMTP do Gmail
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'ultimacachaca@gmail.com';  // Seu e-mail do Gmail
                    $mail->Password   = 'hzqk jeyw vmeh cbgu';              // Sua senha do Gmail ou senha de aplicativo
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                    $mail->Port       = 465;

                    // Configurações do e-mail
                    $mail->setFrom('ultimacachaca@gmail.com', 'Seu Nome');
                    $mail->addAddress($email);  // Endereço de e-mail do destinatário

                    // Conteúdo do e-mail
                    $mail->isHTML(true);
                    $mail->Subject = 'Confirme seu e-mail';
                    $mail->Body    = "Clique no link para confirmar: <a href='$linkConfirmacao'>$linkConfirmacao</a>";
                    $mail->AltBody = "Clique no link para confirmar: $linkConfirmacao";

                    // Enviar o e-mail
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
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
