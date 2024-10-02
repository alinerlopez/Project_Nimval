<?php
require_once __DIR__ . '/../models/UserModel.php'; 

class AuthController {
    public function login() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $senha = $_POST['senha'];

            if (empty($senha)) {
                $error = "Por favor, preencha o campo senha.";
                include __DIR__ . '/../views/login.php';
                return;
            }
            if (empty($email)) {
                $error = "Por favor, preencha o campo email.";
                include __DIR__ . '/../views/login.php';
                return;
            }

            $user = UserModel::findUserByEmail($email);

            if ($user && password_verify($senha, $user['senha'])) {
                if ($user['email_validado'] != 1) {
                    $error = "Você precisa validar o seu e-mail antes de fazer login.";
                    include __DIR__ . '/../views/login.php';
                    return;
                }

                $_SESSION['usuario'] = $user['id_usuario'];
                $_SESSION['perfil'] = $user['perfil'];

                if ($user['perfil'] == 'fornecedor') {
                    header('Location: index.php?page=dashboard_empresa');
                } elseif ($user['perfil'] == 'cliente') {
                    header('Location: index.php?page=dashboard_cliente');
                }
                exit;
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
        exit;
    }

    public function validarEmail() {
        if (isset($_GET['token'])) {
            $token = $_GET['token'];
            $valido = UserModel::verificarTokenValidacao($token);

            if ($valido) {
                UserModel::validarEmail($token);
                header('Location: index.php?page=login&email_validado=true');
                exit;
            } else {
                header('Location: index.php?page=login&email_validado=false');
                exit;
            }
        } else {
            header('Location: index.php?page=login&email_validado=false');
            exit;
        }
    }
}
