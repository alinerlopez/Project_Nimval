<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailModel {

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

    public static function enviarEmailConfirmacao($nome, $email, $linkConfirmacao) {
        self::loadEnv(__DIR__ . '/../../.env');  
        
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = getenv('SMTP_HOST');
            $mail->SMTPAuth   = true;
            $mail->Username   = getenv('SMTP_USERNAME');
            $mail->Password   = getenv('SMTP_PASSWORD');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = getenv('SMTP_PORT');

            $mail->setFrom('no-reply@nimval.com', 'Nimval Rastreamentos');
            $mail->addAddress($email); 

            $mail->isHTML(true);
            $mail->Subject = 'Confirme seu e-mail';

            require_once __DIR__ . '/../utils/email_template.php';
            $mail->Body    = emailConfirmacao($nome, $linkConfirmacao);
            $mail->AltBody = "Olá, $nome\n\nObrigado por se cadastrar em nosso sistema. Para ativar sua conta, copie e cole o link abaixo em seu navegador:\n\n$linkConfirmacao\n\nSe você não se cadastrou, ignore este e-mail.";

            $mail->send();
            error_log('Mensagem de confirmação enviada.');
            return true;
        } catch (Exception $e) {
            error_log("Erro ao enviar o e-mail: {$mail->ErrorInfo}");
            return false;
        }
    }
    public static function enviarEmailComSenha($nome_cliente, $email_cliente, $senha_gerada, $linkLogin) {
        self::loadEnv(__DIR__ . '/../../.env');
        $mail = new PHPMailer(true);
    
        try {
            $mail->isSMTP();
            $mail->Host       = getenv('SMTP_HOST');
            $mail->SMTPAuth   = true;
            $mail->Username   = getenv('SMTP_USERNAME');
            $mail->Password   = getenv('SMTP_PASSWORD');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = getenv('SMTP_PORT'); 
    
            $mail->setFrom('no-reply@nimval.com', 'Nimval Rastreamentos');
            $mail->addAddress($email_cliente);
            $mail->isHTML(true);
            $mail->Subject = "Bem-vindo, $nome_cliente! Sua senha de acesso";
            
            require_once __DIR__ . '/../utils/email_template.php';
            $mail->Body = emailSenhaLayout($nome_cliente, $senha_gerada, $linkLogin);
            $mail->AltBody = "Olá, $nome_cliente!\n\nAqui está sua senha: $senha_gerada\nAcesse: $linkLogin\nPor segurança, altere sua senha no primeiro acesso.";
    
            $mail->send();
            return true; 
        } catch (Exception $e) {
            error_log("Erro ao enviar o e-mail: {$mail->ErrorInfo}");
            return false;
        }
    }    
    
}
?>
