<?php
require_once __DIR__ . '/../database/Database.php';  

class EmpresaModel {

    // Função genérica para buscar fornecedor por qualquer campo
    private static function findFornecedorByField($field, $value) {
        $db = Database::getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM fornecedor WHERE $field = :value");
            $stmt->bindParam(':value', $value);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);  // Retorna os dados do fornecedor se existir
        } catch (PDOException $e) {
            error_log("Erro ao buscar fornecedor por $field: " . $e->getMessage());
            return false;
        }
    }

    // Função para buscar fornecedor por CNPJ
    public static function findFornecedorByCNPJ($cnpj) {
        return self::findFornecedorByField('cnpj_fornecedor', $cnpj);
    }

    // Função para buscar fornecedor por email
    public static function findFornecedorByEmail($email) {
        return self::findFornecedorByField('email_fornecedor', $email);
    }

    // Função para criar um novo fornecedor
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

            return $db->lastInsertId();  // Retorna o ID do fornecedor inserido
        } catch (PDOException $e) {
            error_log("Erro ao criar fornecedor: " . $e->getMessage());
            return false;
        }
    }
}
?>
