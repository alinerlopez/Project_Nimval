<?php
require_once __DIR__ . '/../database/Database.php';  

class EmpresaModel {

    private static function findFornecedorByField($field, $value) {
        $db = Database::getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM fornecedor WHERE $field = :value");
            $stmt->bindParam(':value', $value);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);  
        } catch (PDOException $e) {
            error_log("Erro ao buscar fornecedor por $field: " . $e->getMessage());
            return false;
        }
    }

    public static function findFornecedorByCNPJ($cnpj) {
        return self::findFornecedorByField('cnpj_fornecedor', $cnpj);
    }

    public static function findFornecedorByEmail($email) {
        return self::findFornecedorByField('email_fornecedor', $email);
    }

    public static function getFornecedorById($id_fornecedor) {
        return self::findFornecedorByField('id_fornecedor', $id_fornecedor);
    }

    public static function createFornecedor($nome_fornecedor, $cnpj, $telefone, $email) {
        $db = Database::getConnection();  
        try {
            $stmt = $db->prepare("INSERT INTO fornecedor (nome_fornecedor, cnpj_fornecedor, tel_fornecedor, email_fornecedor)
                                   VALUES (:nome_fornecedor, :cnpj, :telefone, :email)");
            $stmt->bindParam(':nome_fornecedor', $nome_fornecedor);
            $stmt->bindParam(':cnpj', $cnpj);
            $stmt->bindParam(':telefone', $telefone);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            return $db->lastInsertId(); 
        } catch (PDOException $e) {
            error_log("Erro ao criar fornecedor: " . $e->getMessage());
            return false;
        }
    }

    public static function atualizarFornecedor($id_fornecedor, $telefone, $email) {
        $db = Database::getConnection();
    
        try {
            $stmt = $db->prepare("
                UPDATE fornecedor
                SET 
                    tel_fornecedor = :telefone,
                    email_fornecedor = :email
                WHERE 
                    id_fornecedor = :id_fornecedor
            ");
    
            $stmt->bindParam(':telefone', $telefone);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':id_fornecedor', $id_fornecedor);
    
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erro ao atualizar fornecedor: " . $e->getMessage());
            return false;
        }
    }

    public static function removerFornecedor($id_fornecedor) {
        $pdo = Database::getConnection();
        
        try {
            $pdo->beginTransaction();
    
            $stmtFuncionarios = $pdo->prepare("DELETE FROM funcionarios WHERE id_fornecedor = :id_fornecedor");
            $stmtFuncionarios->bindParam(':id_fornecedor', $id_fornecedor, PDO::PARAM_INT);
            $stmtFuncionarios->execute();
    
            $stmtFornecedor = $pdo->prepare("
                UPDATE fornecedor
                SET 
                    cnpj_fornecedor = NULL,
                    email_fornecedor = NULL
                WHERE 
                    id_fornecedor = :id_fornecedor
            ");
            $stmtFornecedor->bindParam(':id_fornecedor', $id_fornecedor, PDO::PARAM_INT);
            $stmtFornecedor->execute();
    
            $pdo->commit();
    
            return true;
        } catch (PDOException $e) {
            $pdo->rollBack();
            error_log("Erro ao remover fornecedor: " . $e->getMessage());
            return false;
        }
    }    
}
?>
