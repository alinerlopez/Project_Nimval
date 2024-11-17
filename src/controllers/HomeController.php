<?php
require_once __DIR__ . '/../utils/session_helper.php';

class HomeController {
    public function index() {
        verificarSessao('id_fornecedor');

        if (!isset($_SESSION['usuario'])) {
            $this->redirectToLogin("Sessão expirada. Faça login novamente.");
        }

        $tipoUsuario = $_SESSION['tipo_usuario'] ?? null;

        switch ($tipoUsuario) {
            case 'funcionario':
                $this->renderFuncionarioHome();
                break;

            case 'cliente':
                $this->renderClienteHome();
                break;

            default:
                $this->handleError("Tipo de usuário desconhecido. Contate o administrador.");
        }
    }

    private function renderFuncionarioHome() {
        $nivelAcesso = $_SESSION['nivel_acesso'] ?? null;

        if ($nivelAcesso === 'admin' || $nivelAcesso === 'operador') {
            require_once __DIR__ . '/../views/home.php';
        } else {
            $this->handleError("Erro: Nível de acesso desconhecido. Contate o administrador.");
        }
    }

    private function renderClienteHome() {
        require_once __DIR__ . '/../views/home_cliente.php';
    }

    private function redirectToLogin($message) {
        $_SESSION['error'] = $message;
        header('Location: index.php?page=login');
        exit();
    }

    private function handleError($message) {
        error_log($message);
        echo $message;
        exit();
    }
}
