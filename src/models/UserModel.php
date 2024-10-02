<?php
require_once '../config/config.php';  

class UserModel {

    public static function createUser($nome, $email, $senha, $perfil, $fornecedor_id, $cpf, $telefone) {
        global $pdo;
        try {
            $token = bin2hex(random_bytes(16));

            error_log("Tentativa de criar usuário: Nome = $nome, Email = $email, CPF = $cpf, Telefone = $telefone, Fornecedor ID = $fornecedor_id");

            $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, cpf, telefone, nivel_acesso, id_fornecedor, token_confirmacao, email_validado) 
                                   VALUES (:nome, :email, :senha, :cpf, :telefone, :perfil, :fornecedor_id, :token, 0)");
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':senha', $senha);
            $stmt->bindParam(':cpf', $cpf);
            $stmt->bindParam(':telefone', $telefone);
            $stmt->bindParam(':perfil', $perfil);
            $stmt->bindParam(':fornecedor_id', $fornecedor_id);
            $stmt->bindParam(':token', $token);  

            $resultado = $stmt->execute();

            if ($resultado) {
                error_log("Usuário criado com sucesso.");
         
                $linkConfirmacao = "http://localhost/confirmar_email.php?token=$token";
                mail($email, "Confirme seu e-mail", "Clique no link para confirmar: $linkConfirmacao");
            } else {
                error_log("Falha ao criar usuário.");
            }

            return $resultado;  
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
