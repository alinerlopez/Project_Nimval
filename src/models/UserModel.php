<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../models/EmailModel.php';

class UserModel {

    public static function createClient($email, $senha, $id_fornecedor) {
        global $pdo;

        try {
            if (self::findUserByEmail($email)) {
                throw new Exception('Cliente já cadastrado com este email.');
            }

            $stmt = $pdo->prepare("INSERT INTO clientes (email, senha, id_fornecedor) 
                                   VALUES (:email, :senha, :id_fornecedor)");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':senha', $senha);
            $stmt->bindParam(':id_fornecedor', $id_fornecedor);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('Erro ao criar cliente: ' . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log('Erro: ' . $e->getMessage());
            return false;
        }
    }

    public static function createUser($nome, $email, $senha_hash, $nivel_acesso, $fornecedor_id, $cpf, $telefone) {
        global $pdo;

        try {
            $token = bin2hex(random_bytes(16)); 
            $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, cpf, telefone, nivel_acesso, id_fornecedor, token_confirmacao, email_validado) 
                                   VALUES (:nome, :email, :senha, :cpf, :telefone, :nivel_acesso, :fornecedor_id, :token, 0)");
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':senha', $senha_hash);
            $stmt->bindParam(':cpf', $cpf);
            $stmt->bindParam(':telefone', $telefone);
            $stmt->bindParam(':nivel_acesso', $nivel_acesso);
            $stmt->bindParam(':fornecedor_id', $fornecedor_id);
            $stmt->bindParam(':token', $token);

            $resultado = $stmt->execute();

            if ($resultado) {
                $linkConfirmacao = "http://localhost/Project_Nimval/src/views/confirmar_email.php?token=$token";
                
                if (EmailModel::enviarEmailConfirmacao($nome, $email, $linkConfirmacao)) {
                    error_log('Mensagem de confirmação enviada.');
                    return true;
                } else {
                    error_log("Erro ao enviar o e-mail.");
                    return false;
                }
            } else {
                error_log("Erro ao criar usuário no banco de dados.");
                return false;
            }
        } catch (PDOException $e) {
            error_log("Erro ao criar usuário: " . $e->getMessage());
            return false;
        }
    }

    public static function findUserByEmail($email) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT id_usuario, nome, email, senha, nivel_acesso 
                               FROM usuarios WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
}
