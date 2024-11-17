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
        
        if (!$pdo) {
            error_log('Erro ao conectar com o banco de dados.');
            return false;
        }
    
        try {
            $stmt = $pdo->prepare("
                SELECT id_cliente AS id, nome, email, senha, ativo 
                FROM clientes 
                WHERE email = :email
            ");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
    
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            self::logDatabaseError('cliente', $e);
            return false;
        }
    }
    

    public static function findFornecedorByEmail($email) {
        $pdo = Database::getConnection();
    
        if (!$pdo) {
            error_log('Erro ao conectar com o banco de dados.');
            return false;
        }
    
        try {
            $stmt = $pdo->prepare("
                SELECT id_usuario AS id, nome, email, senha, nivel_acesso, email_validado, id_fornecedor
                FROM funcionarios 
                WHERE email = :email
            ");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
    
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($result) {
                if (!isset($result['nivel_acesso']) || is_null($result['nivel_acesso'])) {
                    error_log('Nível de acesso não encontrado ou é nulo para o fornecedor: ' . $result['id']);
                }
            }
    
            return $result;
        } catch (PDOException $e) {
            self::logDatabaseError('fornecedor', $e);
            return false;
        }
    }

    private static function logDatabaseError($userType, $e) {
        error_log("Erro ao buscar $userType por e-mail: " . $e->getMessage());
    }
}
?>