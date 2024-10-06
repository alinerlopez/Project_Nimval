<?php
require_once __DIR__ . '/../../config/config.php';

class LoginModel {
    public static function findUserByEmail($email) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT id_usuario, nome, email, senha, nivel_acesso FROM usuarios WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }
}
?>

