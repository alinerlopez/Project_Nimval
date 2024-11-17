<?php
require_once __DIR__ . '/../models/LoginModel.php';
require_once __DIR__ . '/../utils/session_helper.php';

class LoginController {
    public function login() {
        verificarSessao('id_fornecedor');

        if (isset($_SESSION['usuario'])) {
            $redirectPage = ($_SESSION['perfil'] === 'fornecedor') ? 'home' : 'home_cliente';
            header("Location: index.php?page=$redirectPage");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $senha = trim($_POST['senha']);
            $perfil = isset($_POST['perfil']) ? trim($_POST['perfil']) : null;

            if (!$perfil || !in_array($perfil, ['cliente', 'fornecedor'])) {
                $error = "Perfil inválido.";
                include __DIR__ . '/../views/selecionar_perfil.php';
                return;
            }

            $user = LoginModel::findUserByEmailAndPerfil($email, $perfil);

            if (!$user) {
                $error = "Dados inválidos.";
                include __DIR__ . '/../views/login.php';
                return;
            }

            if ($perfil === 'fornecedor' && (int)$user['email_validado'] !== 1) {
                $error = "Seu e-mail ainda não foi validado. Verifique sua caixa de entrada.";
                include __DIR__ . '/../views/login.php';
                return;
            }

            if ($perfil === 'cliente' && $user['ativo'] <> 1) {
                $error = "Sua conta está inativa. Entre em contato com o suporte.";
                include __DIR__ . '/../views/login.php';
                return;
            }

            if ($user && password_verify($senha, $user['senha'])) {
                
                $_SESSION['usuario'] = $user['id'];
                $_SESSION['nome_usuario'] = $user['nome'];
                $_SESSION['perfil'] = $perfil;

                if ($perfil === 'fornecedor') {
                    $_SESSION['id_fornecedor'] = $user['id_fornecedor'];
                    $_SESSION['nivel_acesso'] = $user['nivel_acesso'];
                    $_SESSION['tipo_usuario'] = 'funcionario';
                } else {
                    $_SESSION['tipo_usuario'] = 'cliente';
                }

                $redirectPage = ($perfil === 'fornecedor') ? 'home' : 'home_cliente';
                header("Location: index.php?page=$redirectPage");
                exit();
            } else {
                $error = "Dados inválidos ou perfil incorreto.";
                include __DIR__ . '/../views/login.php';
                return;
            }
        } else {
            include __DIR__ . '/../views/login.php';
        }
    }

    public function logout() {
        verificarSessao('id_fornecedor');

        session_unset();
        session_destroy();
        header("Location: index.php?page=selecionar_perfil");
        exit();
    }
}
