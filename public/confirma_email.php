<?php
// Conecte ao banco de dados
$conn = new mysqli('localhost', 'usuario', 'senha', 'database');

// Verifica se o token foi passado na URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Verifica se o token existe e se o e-mail ainda não foi confirmado
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE token = ? AND confirmado = 0");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Confirma o e-mail e limpa o token
        $stmt = $conn->prepare("UPDATE usuarios SET confirmado = 1, token = '' WHERE token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();

        echo "E-mail confirmado com sucesso! Agora você pode fazer login.";
    } else {
        echo "Token inválido ou e-mail já confirmado.";
    }
} else {
    echo "Token não encontrado.";
}
