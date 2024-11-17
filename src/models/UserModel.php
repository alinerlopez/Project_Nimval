<?php
require_once __DIR__ . '/../database/Database.php';  
require_once __DIR__ . '/../models/EmailModel.php';

class UserModel {

    public static function createClient($nome, $email, $cpf, $telefone) {
        $pdo = Database::getConnection();
        
        $existingClientByCPF = self::findClientByCPF($cpf);
        if ($existingClientByCPF) {
            if ($existingClientByCPF['ativo'] == 1) {
                throw new Exception("Cliente com este CPF já está ativo.");
            }
        }

     
        $existingClientByEmail = self::findClientByEmail($email);
        if ($existingClientByEmail) {
            if ($existingClientByEmail['ativo'] == 1) {
                throw new Exception("Cliente com este e-mail já está ativo.");
            }
         }

        $senha = bin2hex(random_bytes(4)); 
        $senha_hash = password_hash($senha, PASSWORD_BCRYPT); 

        try {
            $stmt = $pdo->prepare("INSERT INTO clientes (nome, email, senha, cpf, telefone, ativo) 
                                   VALUES (:nome, :email, :senha, :cpf, :telefone, 1)");
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':senha', $senha_hash);
            $stmt->bindParam(':cpf', $cpf);
            $stmt->bindParam(':telefone', $telefone);

            $resultado = $stmt->execute();

            if ($resultado) {
                $linkLogin = 'http://localhost/Project_Nimval/public/index.php'; 
                if (EmailModel::enviarEmailComSenha($nome, $email, $senha, $linkLogin)) {
                    error_log('Senha enviada para o e-mail do cliente.');
                    return true;
                } else {
                    error_log("Erro ao enviar a senha para o e-mail do cliente.");
                    return false;
                }
            } else {
                error_log("Erro ao criar cliente no banco de dados.");
                return false;
            }
        } catch (PDOException $e) {
            error_log("Erro ao criar cliente: " . $e->getMessage());
            return false;
        }
    }


    public static function createUser($nome, $email, $senha_hash, $nivel_acesso, $fornecedor_id, $cpf, $telefone) {
        $pdo = Database::getConnection();  
        if (!$pdo) {
            error_log("Erro: conexão com o banco de dados não está disponível.");
            return false;
        }
    
        try {
            $token = bin2hex(random_bytes(16)); 
            $stmt = $pdo->prepare("INSERT INTO funcionarios (nome, email, senha, cpf, telefone, nivel_acesso, id_fornecedor, token_confirmacao, email_validado) 
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
                if ($nivel_acesso === 'admin') {
                    $linkConfirmacao = "http://localhost/Project_Nimval/src/views/confirmar_email.php?token=$token";
    
                    if (EmailModel::enviarEmailConfirmacao($nome, $email, $linkConfirmacao)) {
                        error_log('Mensagem de confirmação enviada.');
                        return true;
                    } else {
                        error_log("Erro ao enviar o e-mail.");
                        return false;
                    }
                }
                return true; 
            } else {
                error_log("Erro ao criar usuário no banco de dados.");
                return false;
            }
        } catch (PDOException $e) {
            error_log("Erro ao criar usuário: " . $e->getMessage());
            return false;
        }
    }

    public static function findClientByEmail($email) {
        $pdo = Database::getConnection();
        try {
            $stmt = $pdo->prepare("SELECT id_cliente, nome, email, ativo
                                   FROM clientes WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Erro ao buscar cliente por e-mail: ' . $e->getMessage());
            return false;
        }
    }

    public static function findClientByCPF($cpf) {
        $pdo = Database::getConnection();
        try {
            $stmt = $pdo->prepare("SELECT id_cliente, nome, email, cpf, ativo 
                                   FROM clientes WHERE cpf = :cpf");
            $stmt->bindParam(':cpf', $cpf);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Erro ao buscar cliente por CPF: ' . $e->getMessage());
            return false;
        }
    }
}
?>
