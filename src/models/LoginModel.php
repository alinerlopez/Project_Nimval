<?php
require_once __DIR__ . '/../database/Database.php';  

class LoginModel {
    public static function findUserByEmail($email) {
        $pdo = Database::getConnection();

        try {
            $stmt = $pdo->prepare("
                SELECT id_usuario, nome, email, senha, nivel_acesso, email_validado 
                FROM funcionarios 
                WHERE email = :email
            ");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Erro ao buscar usuário por e-mail: ' . $e->getMessage());
            return false;
        }
    }
}
?>
