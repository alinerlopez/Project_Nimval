<?php
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/EmpresaController.php'; 
require_once __DIR__ . '/controllers/CadastroClienteController.php'; 
require_once __DIR__ . '/controllers/PedidoController.php';
require_once __DIR__ . '/controllers/SenhaController.php'; 

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

        case 'empresa_cadastro':
            $controller = new EmpresaController(); 
            $controller->cadastrar();
            break;

        case 'salvar_empresa':
            $controller = new EmpresaController(); 
            $controller->salvarEmpresa(); 
            break;

        case 'pedidos':
            $controller = new PedidoController();
            $controller->index();
            break;

        case 'criar_senha':  
            $controller = new SenhaController();
            $controller->criarSenha();
            break;

        case 'salvar_senha':  
            $controller = new SenhaController();
            $controller->salvarSenha();
            break;

        case 'validar_email':  
            $controller = new AuthController();
            $controller->validarEmail();
            break;

        default:
            echo "Página não encontrada!";
            break;
    }
}
