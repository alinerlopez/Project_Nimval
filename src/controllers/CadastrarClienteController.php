<?php
require_once __DIR__ . '/../models/UserModel.php';

class CadastrarClienteController {
    public function cadastrarCliente() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SESSION['nivel_acesso'] != 'fornecedor') {
            header('Location: index.php?page=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nome_cliente = $_POST['nome']; 
            $email_cliente = $_POST['email'];
            $cpf_cliente = $_POST['cpf'];    
            $telefone_cliente = $_POST['telefone']; 
            $id_fornecedor = $_SESSION['usuario'];  
            
            $senha_gerada = bin2hex(random_bytes(4));  

            $cliente_existe = UserModel::findUserByEmail($email_cliente);
            if ($cliente_existe) {
                $error = "Este cliente já está cadastrado.";
                include __DIR__ . '/../views/cadastrar_cliente.php';  
            } else {
                $senha_hash = password_hash($senha_gerada, PASSWORD_BCRYPT);
                $cliente_cadastrado = UserModel::createClient($nome_cliente, $email_cliente, $senha_hash, $cpf_cliente, $telefone_cliente, $id_fornecedor);

                if ($cliente_cadastrado) {
                    $linkConfirmacao = ''; 
                    $email_enviado = EmailModel::enviarEmailComSenha($nome_cliente, $email_cliente, $senha_gerada, $linkConfirmacao);

                    if ($email_enviado) {
                        $success = "Cliente cadastrado com sucesso! A senha foi enviada para o e-mail do cliente.";
                    } else {
                        $error = "Erro ao enviar o e-mail com a senha.";
                    }
                } else {
                    $error = "Erro ao cadastrar o cliente.";
                }

                include __DIR__ . '/../views/cadastrar_cliente.php'; 
            }
        } else {
            include __DIR__ . '/../views/cadastrar_cliente.php'; 
        }
    }
}
?>
