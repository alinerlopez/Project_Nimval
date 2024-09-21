<?php
session_start();

// Verifique se a variável 'page' está definida
$page = isset($_GET['page']) ? $_GET['page'] : null;

// Inclua o arquivo de rotas
require_once __DIR__ . '/../src/routes.php';

// Verifique se existe uma página solicitada e delegue para o roteamento
if ($page) {
    handleRequest($page);
} else {
    // Exibir o conteúdo padrão ou a página de login se não houver página definida
    if (isset($_SESSION['usuario'])) {
        // Conteúdo para usuários logados
        echo '<div class="container mt-5">';
        echo '<h1>Bem-vindo, ' . $_SESSION['perfil'] . '!</h1>';
        echo '<p>Aqui você pode gerenciar seus pedidos e rastreamentos.</p>';
        echo '</div>';
    } else {
        // Exibir a tela de login
        require_once __DIR__ . '/../src/views/login.php';
    }
}
?>
