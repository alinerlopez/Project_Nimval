<?php
header('Content-Type: application/json');  

require_once __DIR__ . '/../src/models/EmpresaModel.php';


$response = ['status' => 'success', 'message' => ''];

if (isset($_POST['cnpj']) && isset($_POST['email'])) {
    $cnpj = $_POST['cnpj'];
    $email = $_POST['email'];

    error_log("CNPJ recebido: $cnpj");  
    error_log("Email recebido: $email");

    if (EmpresaModel::findFornecedorByCNPJ($cnpj)) {
        $response['status'] = 'error';
        $response['message'] = 'CNPJ já cadastrado.';
    }

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
exit;
?>
