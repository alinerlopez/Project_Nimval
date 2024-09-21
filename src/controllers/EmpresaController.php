<?php
require_once __DIR__ . '/../models/EmpresaModel.php'; // Modelo para interagir com o banco de dados

class EmpresaController {

    // Função para validar o CNPJ através da API Receitaws
    private function validarCNPJ($cnpj) {
        // Remove os caracteres especiais
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

        // URL da API para consulta
        $url = "https://www.receitaws.com.br/v1/cnpj/" . $cnpj;

        // Faz a requisição à API
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        // Verifica o status da resposta
        if (isset($data['status']) && $data['status'] == 'ERROR') {
            return false; // CNPJ inválido ou não encontrado
        }

        return $data; // Retorna os dados se o CNPJ for válido
    }

    public function cadastrar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nome_fornecedor = $_POST['nome_fornecedor'];
            $cnpj_fornecedor = $_POST['cnpj_fornecedor'];
            $tel_fornecedor = $_POST['tel_fornecedor'];
            $email_fornecedor = $_POST['email_fornecedor'];

            // Validar CNPJ via API antes de prosseguir
            $validacao_cnpj = $this->validarCNPJ($cnpj_fornecedor);

            if (!$validacao_cnpj) {
                $error = "CNPJ inválido ou não encontrado.";
                include __DIR__ . '/../views/empresa_cadastro.php'; // Exibe o formulário com o erro
                return;
            }

            // Verifica se o email já está cadastrado
            if (EmpresaModel::findFornecedorByEmail($email_fornecedor)) {
                $error = "Este email já está cadastrado.";
                include __DIR__ . '/../views/empresa_cadastro.php'; // Exibe o formulário com o erro
            } else {
                // Cadastrar a nova empresa no banco de dados
                EmpresaModel::createFornecedor($nome_fornecedor, $cnpj_fornecedor, $tel_fornecedor, $email_fornecedor);
                header('Location: index.php?page=login'); // Redireciona para a página de login
                exit;
            }
        } else {
            // Exibir o formulário de cadastro
            include __DIR__ . '/../views/empresa_cadastro.php';
        }
    }
}
