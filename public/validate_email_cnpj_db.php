<?php
header('Content-Type: application/json');  // Define o tipo de conteúdo como JSON

require_once __DIR__ . '/../src/models/EmpresaModel.php';


$response = ['status' => 'success', 'message' => ''];

// Verifica se o CNPJ e o email foram enviados
if (isset($_POST['cnpj']) && isset($_POST['email'])) {
    $cnpj = $_POST['cnpj'];
    $email = $_POST['email'];

    error_log("CNPJ recebido: $cnpj");  // Log para verificar o que foi recebido
    error_log("Email recebido: $email");

    // Verificar se o CNPJ já está no banco de dados
    if (EmpresaModel::findFornecedorByCNPJ($cnpj)) {
        $response['status'] = 'error';
        $response['message'] = 'CNPJ já cadastrado.';
    }

    // Verificar se o email já está no banco de dados
    if (EmpresaModel::findFornecedorByEmail($email)) {
        $response['status'] = 'error';
        $response['message'] = 'E-mail já cadastrado.';
    }

    echo json_encode($response);
} else {
    $response['status'] = 'error';
    $response['message'] = 'Dados não fornecidos corretamente.';
    echo json_encode($response);
}

exit;  // Certifique-se de que não há mais saída após isso
?>
