<?php
require_once '../config/config.php';  // Inclui a conexão com o banco

class UserModel {
    public static function findUserByEmail($email) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);  // Retorna os dados do usuário, incluindo o perfil
    }

    public static function createUser($email, $senha, $perfil) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO usuarios (email, senha, perfil) VALUES (:email, :senha, :perfil)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':perfil', $perfil);
        return $stmt->execute();  // Insere o novo usuário
    }

    public static function createClient($email, $senha, $empresa_id) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO usuarios (email, senha, perfil, empresa_id) VALUES (:email, :senha, 'cliente', :empresa_id)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':empresa_id', $empresa_id);
        return $stmt->execute();  // Insere um novo cliente vinculado à empresa
    }
}
?>
