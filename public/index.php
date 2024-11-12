<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$page = isset($_GET['page']) ? $_GET['page'] : 'selecionar_perfil';

require_once __DIR__ . '/../src/routes.php';
handleRequest($page);
