<?php


class HomeController {
    public function index() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario'])) {
            header('Location: index.php?page=login');
            exit();
        }

        $tipoUsuario = $_SESSION['tipo_usuario'] ?? null;

        if ($tipoUsuario === 'funcionario') {
            $nivelAcesso = $_SESSION['nivel_acesso'] ?? null;
            if ($nivelAcesso === 'admin' || $nivelAcesso === 'operador') {
                require_once __DIR__ . '/../views/home.php';
            } else {
                echo "Erro: Nível de acesso desconhecido. Contate o administrador.";
                exit();
            }
        } elseif ($tipoUsuario === 'cliente') {
            require_once __DIR__ . '/../views/home_cliente.php';
        } else {
            echo "Erro: Tipo de usuário desconhecido. Contate o administrador.";
            exit();
        }
    }
}

