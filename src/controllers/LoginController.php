<?php
require_once __DIR__ . '/../models/LoginModel.php';

class LoginController {
    public function login() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $senha = $_POST['senha'];
            $user = LoginModel::findUserByEmail($email);

            if ($user && password_verify($senha, $user['senha'])) {
                $_SESSION['usuario'] = $user['id_usuario'];
                $_SESSION['nome_usuario'] = $user['nome']; 
                $_SESSION['nivel_acesso'] = $user['nivel_acesso'];

                header('Location: index.php?page=home');
                exit();
            } else {
                $error = "Email ou senha incorretos.";
                include __DIR__ . '/../views/login.php';
            }
        } else {
            include __DIR__ . '/../views/login.php';
        }
    }

    public function logout() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header('Location: index.php?page=login');
        exit();
    }
}
