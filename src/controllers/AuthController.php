<?php
require_once __DIR__ . '/../models/UserModel.php';  // Caminho corrigido para o modelo

class AuthController {
    public function login() {
        // Verificar se a sessão já está ativa antes de iniciar
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $senha = $_POST['senha'];

            // Verificar se os campos de email e senha não estão vazios
            if (empty($email) || empty($senha)) {
                $error = "Por favor, preencha todos os campos.";
                include __DIR__ . '/../views/login.php';  // Exibir a view de login com erro
                return;
            }

            // Buscar o usuário pelo email
            $user = UserModel::findUserByEmail($email);

            // Verificar se o usuário existe e se a senha está correta
            if ($user && password_verify($senha, $user['senha'])) {
                // Armazenar o ID e o perfil do usuário na sessão
                $_SESSION['usuario'] = $user['id_usuario'];
                $_SESSION['perfil'] = $user['perfil'];

                // Redirecionar com base no perfil
                if ($user['perfil'] == 'empresa') {
                    header('Location: index.php?page=dashboard_empresa');
                } elseif ($user['perfil'] == 'cliente') {
                    header('Location: index.php?page=dashboard_cliente');
                }
                exit;
            } else {
                $error = "Email ou senha incorretos.";
                include __DIR__ . '/../views/login.php';  // Exibir a view de login com erro
            }
        } else {
            include __DIR__ . '/../views/login.php';  // Exibir a view de login
        }
    }

    public function logout() {
        // Verificar se a sessão já está ativa antes de iniciar
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        session_destroy();  // Destroi a sessão
        header('Location: index.php?page=login');  // Redireciona para a página de login
        exit;
    }
}
