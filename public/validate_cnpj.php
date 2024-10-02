<?php
require_once __DIR__ . '/../src/utils/CNPJValidator.php';

if (isset($_POST['cnpj'])) {
    $cnpj = $_POST['cnpj'];

    $validacao = CNPJValidator::validarCNPJ($cnpj);

    if ($validacao) {
        echo json_encode([
            'status' => 'success', 
            'message' => 'CNPJ válido', 
            'nome' => $validacao['nome'] 
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'CNPJ inválido']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'CNPJ não fornecido']);
}
