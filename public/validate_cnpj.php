<?php
// Inclui o CNPJValidator.php para usar a função de validação
require_once __DIR__ . '/../src/utils/CNPJValidator.php';

// Verifica se o CNPJ foi enviado via POST
if (isset($_POST['cnpj'])) {
    $cnpj = $_POST['cnpj'];

    // Chama a função para validar o CNPJ
    $validacao = CNPJValidator::validarCNPJ($cnpj);

    // Verifica se o CNPJ é válido e responde em JSON
    if ($validacao) {
        // Inclui o nome da empresa na resposta, caso o CNPJ seja válido
        echo json_encode([
            'status' => 'success', 
            'message' => 'CNPJ válido', 
            'nome' => $validacao['nome']  // 'nome' é o nome da empresa retornado pela API
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'CNPJ inválido']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'CNPJ não fornecido']);
}
