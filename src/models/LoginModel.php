<?php
require_once __DIR__ . '/../database/Database.php';

class LoginModel {
    public static function findUserByEmailAndPerfil($email, $perfil) {
        if ($perfil === 'cliente') {
            return self::findClienteByEmail($email);
        } elseif ($perfil === 'fornecedor') {
            return self::findFornecedorByEmail($email);
        } else {
            error_log("Perfil inválido: $perfil");
            return false; 
        }
    }

    private static function findClienteByEmail($email) {
        $pdo = Database::getConnection();

        try {
            $stmt = $pdo->prepare("
                SELECT id_cliente AS id, nome, email, senha 
                FROM clientes 
                WHERE email = :email
            ");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar cliente por e-mail: " . $e->getMessage());
            return false;
        }
    }

    private static function findFornecedorByEmail($email) {
        $pdo = Database::getConnection();

        try {
            $stmt = $pdo->prepare("
                SELECT id_usuario AS id, nome, email, senha, nivel_acesso, email_validado 
                FROM funcionarios 
                WHERE email = :email
            ");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar fornecedor por e-mail: " . $e->getMessage());
            return false;
        }
    }
}

