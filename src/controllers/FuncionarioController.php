<?php
require_once __DIR__ . '/../models/FuncionarioModel.php';
require_once __DIR__ . '/../utils/session_helper.php';

class FuncionarioController {
    public function cadastrarFuncionario() {
        verificarSessao('id_fornecedor');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_fornecedor = $_SESSION['id_fornecedor'];
            $nome = trim($_POST['nome']);
            $email = trim($_POST['email']);
            $cpf = trim($_POST['cpf']);
            $telefone = trim($_POST['telefone']);
            $nivel_acesso = trim($_POST['nivel_acesso']);
            $senha = password_hash(trim($_POST['senha']), PASSWORD_BCRYPT);
            $email_validado = 1; 

            $resultado = FuncionarioModel::cadastrarFuncionario($id_fornecedor, $nome, $email, $cpf, $telefone, $nivel_acesso, $senha, $email_validado);
            if ($resultado) {
                $_SESSION['success'] = 'Funcionário cadastrado com sucesso!';
            } else {
                $_SESSION['error'] = 'Erro ao cadastrar funcionário.';
            }

            header('Location: index.php?page=funcionarios');
            exit();
        }

        include __DIR__ . '/../views/cadastrar_funcionario.php';
    }

    public function editarFuncionario() {
      verificarSessao('id_fornecedor');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_usuario = $_POST['id_usuario'];
            $nome = trim($_POST['nome']);
            $email = trim($_POST['email']);
            $cpf = trim($_POST['cpf']);
            $telefone = trim($_POST['telefone']);
            $nivel_acesso = trim($_POST['nivel_acesso']);

            $resultado = FuncionarioModel::editarFuncionario($id_usuario, $nome, $email, $cpf, $telefone, $nivel_acesso);
            if ($resultado) {
                $_SESSION['success'] = 'Funcionário atualizado com sucesso!';
            } else {
                $_SESSION['error'] = 'Erro ao atualizar funcionário.';
            }

            header('Location: index.php?page=funcionarios');
            exit();
        }

        $id_usuario = $_GET['id'] ?? null;
        if ($id_usuario) {
            $funcionario = FuncionarioModel::getFuncionarioById($id_usuario);
            if (!$funcionario) {
                $_SESSION['error'] = 'Funcionário não encontrado.';
                header('Location: index.php?page=funcionarios');
                exit();
            }
        }

        include __DIR__ . '/../views/editar_funcionario.php';
    }

    public function removerFuncionario() {
      verificarSessao('id_fornecedor');
        $id_usuario = $_GET['id'] ?? null;

        if ($id_usuario && FuncionarioModel::removerFuncionario($id_usuario)) {
            $_SESSION['success'] = 'Funcionário removido com sucesso!';
        } else {
            $_SESSION['error'] = 'Erro ao remover funcionário.';
        }

        header('Location: index.php?page=funcionarios');
        exit();
    }
}
