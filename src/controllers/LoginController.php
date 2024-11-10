<?php
require_once __DIR__ . '/../models/LoginModel.php';

class LoginController {
    public function login() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email']);
            $senha = trim($_POST['senha']);

            $user = LoginModel::findUserByEmail($email);

            if (!$user) {
                $error = "E-mail não encontrado.";
                include __DIR__ . '/../views/login.php';
                return;
            }

            if ((int)$user['email_validado'] !== 1) {
                $error = "Seu e-mail ainda não foi validado. Verifique sua caixa de entrada.";
                include __DIR__ . '/../views/login.php';
                return;
            }

            if (password_verify($senha, $user['senha'])) {
                $_SESSION['usuario'] = $user['id_usuario'];
                $_SESSION['nome_usuario'] = $user['nome'];
                $_SESSION['nivel_acesso'] = $user['nivel_acesso'];

                if ($user['nivel_acesso'] == 'admin' || $user['nivel_acesso'] == 'operador') {
                    $_SESSION['tipo_usuario'] = 'funcionario';
                } else {
                    $_SESSION['tipo_usuario'] = 'cliente';
                }

                header('Location: index.php?page=home');
                exit();
            } else {
                $error = "Senha incorreta.";
                include __DIR__ . '/../views/login.php';
                return;
            }
        } else {
            include __DIR__ . '/../views/login.php';
        }
    }

    public function logout() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();
        header('Location: index.php?page=login');
        exit();
    }
}
