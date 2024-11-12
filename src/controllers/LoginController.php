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
            $perfil = isset($_POST['perfil']) ? trim($_POST['perfil']) : null;

            if (!$perfil) {
                header('Location: selecionar_perfil.php');
                exit();
            }

            if ($perfil !== 'cliente' && $perfil !== 'fornecedor') {
                $error = "Perfil inválido.";
                include __DIR__ . '/../views/login.php';
                return;
            }

            $user = LoginModel::findUserByEmailAndPerfil($email, $perfil);

            if (!$user) {
                $error = "Dados inválidos.";
                include __DIR__ . '/../views/login.php';
                return;
            }

            // Se for fornecedor, verifica o campo email_validado
            if ($perfil === 'fornecedor' && (int)$user['email_validado'] !== 1) {
                $error = "Seu e-mail ainda não foi validado. Verifique sua caixa de entrada.";
                include __DIR__ . '/../views/login.php';
                return;
            }

            // Verifica a senha e define as variáveis de sessão
            if (password_verify($senha, $user['senha'])) {
                $_SESSION['usuario'] = $user['id'];
                $_SESSION['nome_usuario'] = $user['nome'];
                $_SESSION['perfil'] = $perfil;
                $_SESSION['tipo_usuario'] = ($perfil === 'cliente') ? 'cliente' : 'funcionario';

                // Define o nível de acesso para o fornecedor
                if ($perfil === 'fornecedor') {
                    $_SESSION['nivel_acesso'] = $user['nivel_acesso'];
                    header('Location: index.php?page=home');
                } else {
                    header('Location: index.php?page=home_cliente');
                }
                exit();
            } else {
                $error = "Dados inválidos.";
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
?>