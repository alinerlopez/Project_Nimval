<?php
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/EmailModel.php';
require_once __DIR__ . '/../utils/session_helper.php';

class CadastrarClienteController {
    public function cadastrarCliente() {
        verificarSessao('id_fornecedor');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome_cliente = trim($_POST['nome']); 
            $email_cliente = trim($_POST['email']);
            $cpf_cliente = trim($_POST['cpf']);    
            $telefone_cliente = trim($_POST['telefone']); 

            try {
                $cliente_cadastrado = UserModel::createClient(
                    $nome_cliente, 
                    $email_cliente, 
                    $cpf_cliente, 
                    $telefone_cliente
                );

                if ($cliente_cadastrado) {
                    $_SESSION['success'] = "Cliente cadastrado com sucesso! A senha foi enviada para o e-mail do cliente.";
                    header('Location: index.php?page=cadastrar_cliente'); 
                    exit();
                } else {
                    $_SESSION['error'] = "Erro ao cadastrar o cliente. Tente novamente.";
                }
            } catch (Exception $e) {
                $_SESSION['error'] = "Erro: " . $e->getMessage();
            }
            header('Location: index.php?page=cadastrar_cliente'); 
            exit();
        } else {
            include __DIR__ . '/../views/cadastrar_cliente.php'; 
        }
    }
}
?>
