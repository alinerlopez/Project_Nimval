<?php
session_start();
$page = isset($_GET['page']) ? $_GET['page'] : null;

require_once __DIR__ . '/../src/routes.php';

if ($page) {
    handleRequest($page);
} else {
    if (isset($_SESSION['usuario'])) {
        echo '<div class="container mt-5">';
        echo '<h1>Bem-vindo, ' . $_SESSION['perfil'] . '!</h1>';
        echo '<p>Aqui você pode gerenciar seus pedidos e rastreamentos.</p>';
        echo '</div>';
    } else {
        require_once __DIR__ . '/../src/views/login.php';
    }
}
?>
