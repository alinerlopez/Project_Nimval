<?php
function verificarSessao($chaveSessao, $paginaRedirecionamento = 'index.php?page=login') {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION[$chaveSessao])) {
        header("Location: $paginaRedirecionamento");
        exit();
    }
}
?>
