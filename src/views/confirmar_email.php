<?php
// Conecte ao banco de dados
$conn = new mysqli('localhost', 'root', '', 'bd_nimval');

// Verifica a conexão com o banco de dados
if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}

// Variável para armazenar a mensagem de status
$statusMessage = "";
$statusClass = "";

// Verifica se o token foi passado na URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Verifica se o token existe e se o e-mail ainda não foi confirmado
    $stmt = $conn->prepare("SELECT id_usuario FROM usuarios WHERE token_confirmacao = ? AND email_validado = 0");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Confirma o e-mail e limpa o token
        $stmt = $conn->prepare("UPDATE usuarios SET email_validado = 1, token_confirmacao = '' WHERE token_confirmacao = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();

        $statusMessage = "E-mail confirmado com sucesso! Agora você pode fazer login.";
        $statusClass = "success";
    } else {
        $statusMessage = "Token inválido ou e-mail já confirmado.";
        $statusClass = "error";
    }
    // Fecha o statement
    $stmt->close();
} else {
    $statusMessage = "Token não encontrado.";
    $statusClass = "error";
}

// Fecha a conexão com o banco de dados
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação de E-mail</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
        }
        .container {
            text-align: center;
            background-color: #fff;
            padding: 2em;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        .success {
            color: #4CAF50;
        }
        .error {
            color: #f44336;
        }
        h1 {
            font-size: 1.5em;
            color: #333;
        }
        p {
            font-size: 1em;
            color: #555;
        }
        .button {
            display: inline-block;
            margin-top: 1.5em;
            padding: 0.7em 1.5em;
            background-color: #4CAF50;
            color: white;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
        }
        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Confirmação de E-mail</h1>
        <p class="<?php echo $statusClass; ?>"><?php echo $statusMessage; ?></p>
        <?php if ($statusClass == "success"): ?>
            <a href="login.php" class="button">Fazer Login</a>
        <?php endif; ?>
    </div>
</body>
</html>
