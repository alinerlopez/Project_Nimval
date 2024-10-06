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
}
?>
