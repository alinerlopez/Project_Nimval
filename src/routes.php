<?php
// Use __DIR__ para garantir que o caminho seja relativo ao diretório do arquivo routes.php
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/EmpresaController.php'; // Controlador para cadastro de empresas
require_once __DIR__ . '/controllers/CadastroClienteController.php'; // Controlador para cadastro de clientes
require_once __DIR__ . '/controllers/PedidoController.php';

// Defina as rotas
function handleRequest($page) {
    switch ($page) {
        case 'login':
            $controller = new AuthController();
            $controller->login();
            break;

        case 'logout':
            $controller = new AuthController();
            $controller->logout();
            break;

        case 'cadastro_empresa':
            $controller = new EmpresaController(); // Usar o controlador correto para cadastro de empresas
            $controller->cadastrar();
            break;

        case 'salvar_empresa':
            $controller = new EmpresaController(); // Salvar a nova empresa
            $controller->salvarEmpresa(); // Esse método precisa ser implementado no controlador
            break;

        case 'pedidos':
            $controller = new PedidoController();
            $controller->index();
            break;

        default:
            echo "Página não encontrada!";
            break;
    }
}
