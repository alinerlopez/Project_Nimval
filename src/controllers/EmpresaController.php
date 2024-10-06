<?php
require_once __DIR__ . '/../models/EmpresaModel.php';  
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../utils/CNPJValidator.php'; 

class EmpresaController {

    public function cadastrar() {

        if (session_status() == PHP_SESSION_NONE) {
            session_start();  
        }
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
}
