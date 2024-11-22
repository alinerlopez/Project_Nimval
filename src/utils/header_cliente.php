<?php
require_once __DIR__ . '/session_helper.php';
verificarSessao('id_cliente');

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php?page=login");
    exit();
}

$nomeUsuario = $_SESSION['nome_usuario'];
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php?page=home_cliente">Nimval Rastreamentos</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=editar_conta_cliente">Conta</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=meus_pedidos">Meus Pedidos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=logout" onclick="return confirm('Você realmente deseja sair?');" class="nav-link btn btn-danger">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

