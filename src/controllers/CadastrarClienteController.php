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
            $email_cliente = $_POST['email'];
            $senha_cliente = password_hash($_POST['senha'], PASSWORD_BCRYPT);
            $id_fornecedor = $_SESSION['usuario'];  

            $cliente_existe = UserModel::findUserByEmail($email_cliente);
            if ($cliente_existe) {
                $error = "Este cliente já está cadastrado.";
                include __DIR__ . '/../views/cadastrar_cliente.php';  
            } else {
                UserModel::createClient($email_cliente, $senha_cliente, $id_fornecedor);
                $success = "Cliente cadastrado com sucesso!";
                include __DIR__ . '/../views/cadastrar_cliente.php'; 
            }
        } else {
            include __DIR__ . '/../views/cadastrar_cliente.php'; 
        }
    }
}
