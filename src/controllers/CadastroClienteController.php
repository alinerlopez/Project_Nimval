<?php
require_once __DIR__ . '/../models/UserModel.php';

class CadastroClienteController {
    public function cadastrarCliente() {
        // Garantir que o fornecedor esteja logado
        session_start();
        if ($_SESSION['perfil'] != 'fornecedor') {
            header('Location: index.php?page=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email_cliente = $_POST['email'];
            $senha_cliente = password_hash($_POST['senha'], PASSWORD_BCRYPT);
            $id_fornecedor = $_SESSION['usuario'];  // ID do fornecedor logado

            // Cadastrar o cliente e associá-lo ao fornecedor logado
            $cliente_existe = UserModel::findUserByEmail($email_cliente);
            if ($cliente_existe) {
                $error = "Este cliente já está cadastrado.";
                include __DIR__ . '/../views/cadastro_cliente.php';
            } else {
                // Chama o método para criar o cliente vinculado ao fornecedor
                UserModel::createClient($email_cliente, $senha_cliente, $id_fornecedor);
                $success = "Cliente cadastrado com sucesso!";
                include __DIR__ . '/../views/cadastro_cliente.php';
            }
        } else {
            include __DIR__ . '/../views/cadastro_cliente.php';
        }
    }
}
