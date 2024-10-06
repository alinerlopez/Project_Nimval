<?php
session_start();  
$page = isset($_GET['page']) ? $_GET['page'] : null;
require_once __DIR__ . '/../src/routes.php';  

if ($page) {
    handleRequest($page);  
} else {
    if (isset($_SESSION['usuario'])) {
        header('Location: index.php?page=home');
    } else {
        header('Location: index.php?page=login'); 
        exit;
    }
}
