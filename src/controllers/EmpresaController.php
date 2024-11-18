<?php
require_once __DIR__ . '/../models/EmpresaModel.php';  
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../utils/CNPJValidator.php';
require_once __DIR__ . '/../utils/session_helper.php';
class EmpresaController {

    public function cadastrar() {
        verificarSessao('id_fornecedor');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $cnpj = trim($_POST['cnpj_fornecedor']);  
            $nome_fornecedor = trim($_POST['nome_fornecedor']);
            $email = trim($_POST['email_fornecedor']);
            $telefone = trim($_POST['tel_fornecedor']);

            $cnpjValidado = CNPJValidator::validarCNPJ($cnpj); 
            if (!$cnpjValidado) {
                $error = "CNPJ inválido ou não encontrado.";
                include __DIR__ . '/../views/empresa_cadastro.php';  
                return;
            }

            if (EmpresaModel::findFornecedorByCNPJ($cnpj)) {
                $error = "CNPJ já cadastrado.";
                include __DIR__ . '/../views/empresa_cadastro.php';  
                return;
            }

            if (EmpresaModel::findFornecedorByEmail($email)) {
                $error = "E-mail já cadastrado.";
                include __DIR__ . '/../views/empresa_cadastro.php';  
                return;
            }
            $fornecedor_id = EmpresaModel::createFornecedor($nome_fornecedor, $cnpj, $telefone, $email);
            if ($fornecedor_id) {
                $_SESSION['email'] = $email;
                $_SESSION['fornecedor_id'] = $fornecedor_id;
                header('Location: index.php?page=criar_senha');
                exit;
            } else {
                $error = "Erro ao criar fornecedor.";
                include __DIR__ . '/../views/empresa_cadastro.php';  
            }
        } else {
            include __DIR__ . '/../views/empresa_cadastro.php';  
        }
    }

    public function atualizarContaFornecedor() {
        verificarSessao('id_fornecedor');
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_fornecedor = $_SESSION['id_fornecedor'];
            $telefone = trim($_POST['tel_fornecedor']);
            $email = trim($_POST['email_fornecedor']);
    
            try {
                $resultado = EmpresaModel::atualizarFornecedor($id_fornecedor, $telefone, $email);
    
                if ($resultado) {
                    $_SESSION['success'] = "Dados atualizados com sucesso!";
                } else {
                    $_SESSION['error'] = "Erro ao atualizar os dados. Tente novamente.";
                }
            } catch (Exception $e) {
                $_SESSION['error'] = "Erro: " . $e->getMessage();
            }
        }
    
        header("Location: index.php?page=configuracoes_conta");
        exit();
    }

    public function removerContaFornecedor() {
        verificarSessao('id_fornecedor');
    
        $id_fornecedor = $_SESSION['id_fornecedor'];
    
        try {
            $resultado = EmpresaModel::removerFornecedor($id_fornecedor);
    
            if ($resultado) {
                $_SESSION['success'] = "Conta removida com sucesso. Entre em contato para reativá-la, se necessário.";
            } else {
                $_SESSION['error'] = "Erro ao tentar remover a conta. Tente novamente.";
            }
        } catch (Exception $e) {
            $_SESSION['error'] = "Erro: " . $e->getMessage();
        }
    
        header("Location: index.php?page=selecionar_perfil");
        exit();
    }
    
    
}
