<?php
require_once __DIR__ . '/../database/Database.php'; // Certifique-se de que o caminho está correto

class EmpresaModel {
    
    // Verificar se o fornecedor (empresa) já existe pelo email
    public static function findFornecedorByEmail($email) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM fornecedor WHERE email_fornecedor = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(); // Retorna o fornecedor, ou false se não encontrado
    }

    // Criar um novo fornecedor (empresa)
    public static function createFornecedor($nome_fornecedor, $cnpj_fornecedor, $tel_fornecedor, $email_fornecedor) {
        $db = Database::getConnection();
        $stmt = $db->prepare(
            "INSERT INTO fornecedor (nome_fornecedor, cnpj_fornecedor, tel_fornecedor, email_fornecedor) 
             VALUES (?, ?, ?, ?)"
        );
        return $stmt->execute([$nome_fornecedor, $cnpj_fornecedor, $tel_fornecedor, $email_fornecedor]);
    }
}
