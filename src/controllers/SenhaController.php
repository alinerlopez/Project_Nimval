<?php
require_once __DIR__ . '/../utils/session_helper.php';

class SenhaController {
    public function criarSenha() {
        include __DIR__ . '/../views/criar_senha.php'; 
    }

    public function salvarSenha() {
        verificarSessao('id_fornecedor');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nome = $_POST['nome'];
            $cpf = preg_replace('/\D/', '', $_POST['cpf']);  
            $telefone = $_POST['telefone'];
            $senha = $_POST['senha'];
            $confirmar_senha = $_POST['confirmar_senha'];

            if ($senha !== $confirmar_senha) {
                $error = "As senhas não coincidem.";
                include __DIR__ . '/../views/criar_senha.php';
                return;
            }

            if (strlen($cpf) !== 11) {
                $error = "CPF inválido. Certifique-se de que o CPF tenha 11 dígitos.";
                include __DIR__ . '/../views/criar_senha.php';
                return;
            }

            $senha_hash = password_hash($senha, PASSWORD_BCRYPT);  

            if (!isset($_SESSION['email']) || !isset($_SESSION['fornecedor_id'])) {
                $error = "Erro no processo. Tente novamente.";
                include __DIR__ . '/../views/criar_senha.php';
                return;
            }

            $email = $_SESSION['email'];
            $fornecedor_id = $_SESSION['fornecedor_id'];  

            if (UserModel::createUser($nome, $email, $senha_hash, 'admin', $fornecedor_id, $cpf, $telefone)) {
                header('Location: index.php?page=login&senha_criada=true');
                exit();  
            } else {
                $error = "Erro ao criar usuário. Tente novamente.";
                include __DIR__ . '/../views/criar_senha.php';
            }
        }
    }
}
?>
