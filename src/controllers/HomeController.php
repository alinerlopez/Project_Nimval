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
        
        $nivelAcesso = $_SESSION['nivel_acesso'] ?? null;
        if ($nivelAcesso === 'fornecedor') {
            require_once __DIR__ . '/../views/home.php';
        } elseif ($nivelAcesso === 'cliente') {
            require_once __DIR__ . '/../views/home.php';
        } else {
            echo "Erro: Tipo de usuário desconhecido.";
            exit();
        }
    }
}
