<?php
require_once __DIR__ . '/../models/UserModel.php';

class CadastroClienteController {
    public function cadastrarCliente() {
        session_start();

        // Verifica se a empresa está logada
        if ($_SESSION['perfil'] != 'empresa') {
            header('Location: index.php?page=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);

            // Cadastrar o cliente e associar à empresa logada
            UserModel::createClient($email, $senha, $_SESSION['usuario']);
            header('Location: index.php?page=dashboard_empresa');
            exit;
        } else {
            include __DIR__ . '/../views/cadastro_cliente.php';
        }
    }
}
