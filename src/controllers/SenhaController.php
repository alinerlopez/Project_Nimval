<?php
require_once __DIR__ . '/../models/UserModel.php';

class SenhaController {
    public function criarSenha() {
        include __DIR__ . '/../views/criar_senha.php'; 
    }

    public function salvarSenha() {
        // Iniciar a sessão se não estiver ativa
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Receber e processar os dados
            $nome = $_POST['nome'];
            $cpf = preg_replace('/\D/', '', $_POST['cpf']); // Remover caracteres não numéricos
            $telefone = $_POST['telefone'];
            $senha = $_POST['senha'];
            $confirmar_senha = $_POST['confirmar_senha'];

            // Verificar se as senhas coincidem
            if ($senha !== $confirmar_senha) {
                $error = "As senhas não coincidem.";
                include __DIR__ . '/../views/criar_senha.php';
                return;
            }

            // Verificar se o CPF tem 11 dígitos
            if (strlen($cpf) !== 11) {
                $error = "CPF inválido. Certifique-se de que o CPF tenha 11 dígitos.";
                include __DIR__ . '/../views/criar_senha.php';
                return;
            }

            // Hash da senha
            $senha_hash = password_hash($senha, PASSWORD_BCRYPT);

            // Verificar se a sessão tem email e fornecedor_id
            if (!isset($_SESSION['email']) || !isset($_SESSION['fornecedor_id'])) {
                $error = "Erro no processo. Tente novamente.";
                include __DIR__ . '/../views/criar_senha.php';
                return;
            }

            // Dados da sessão
            $email = $_SESSION['email'];
            $fornecedor_id = $_SESSION['fornecedor_id']; 

            // Criar o usuário no banco de dados
            if (UserModel::createUser($nome, $email, $senha_hash, 'fornecedor', $fornecedor_id, $cpf, $telefone)) {
                // Redirecionar para a página de login com mensagem de sucesso
                header('Location: index.php?page=login&senha_criada=true');
                exit;
            } else {
                // Exibir erro se a criação falhar
                $error = "Erro ao criar usuário. Tente novamente.";
                include __DIR__ . '/../views/criar_senha.php';
            }
        }
    }    
}
?>
