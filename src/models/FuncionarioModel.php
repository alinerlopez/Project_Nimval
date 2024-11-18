<?php
require_once __DIR__ . '/../database/Database.php';

class FuncionarioModel {
    public static function getFuncionariosPorFornecedor($id_fornecedor) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            SELECT id_usuario, nome, email, cpf, telefone, nivel_acesso
            FROM funcionarios
            WHERE id_fornecedor = :id_fornecedor
        ");
        $stmt->bindParam(':id_fornecedor', $id_fornecedor, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function cadastrarFuncionario($id_fornecedor, $nome, $email, $cpf, $telefone, $nivel_acesso, $senha, $email_validado) {
        $pdo = Database::getConnection();
    
        $stmt = $pdo->prepare("
            INSERT INTO funcionarios (id_fornecedor, nome, email, cpf, telefone, nivel_acesso, senha, email_validado, token_confirmacao)
            VALUES (:id_fornecedor, :nome, :email, :cpf, :telefone, :nivel_acesso, :senha, :email_validado,'')
        ");
        
        $stmt->bindParam(':id_fornecedor', $id_fornecedor, PDO::PARAM_INT);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':cpf', $cpf, PDO::PARAM_STR);
        $stmt->bindParam(':telefone', $telefone, PDO::PARAM_STR);
        $stmt->bindParam(':nivel_acesso', $nivel_acesso, PDO::PARAM_STR);
        $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
        $stmt->bindParam(':email_validado', $email_validado, PDO::PARAM_INT);
    
        return $stmt->execute();
    }
    

    public static function editarFuncionario($id_usuario, $nome, $email, $cpf, $telefone, $nivel_acesso) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            UPDATE funcionarios
            SET nome = :nome, email = :email, cpf = :cpf, telefone = :telefone, nivel_acesso = :nivel_acesso
            WHERE id_usuario = :id_usuario
        ");
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':nivel_acesso', $nivel_acesso);
        return $stmt->execute();
    }

    public static function removerFuncionario($id_usuario) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("DELETE FROM funcionarios WHERE id_usuario = :id_usuario");
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public static function getFuncionarioById($id_usuario) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            SELECT id_usuario, nome, email, cpf, telefone, nivel_acesso
            FROM funcionarios
            WHERE id_usuario = :id_usuario
        ");
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
