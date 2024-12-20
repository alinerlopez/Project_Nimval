<?php
require_once __DIR__ . '/controllers/LoginController.php'; 
require_once __DIR__ . '/controllers/AuthController.php'; 
require_once __DIR__ . '/controllers/EmpresaController.php'; 
require_once __DIR__ . '/controllers/CadastrarClienteController.php'; 
require_once __DIR__ . '/controllers/PedidoController.php';
require_once __DIR__ . '/controllers/SenhaController.php'; 
require_once __DIR__ . '/controllers/HomeController.php';
require_once __DIR__ . '/controllers/ClienteController.php';
require_once __DIR__ . '/controllers/FuncionarioController.php';

function handleRequest($page) {
    switch ($page) {
        case 'login':  
            $controller = new LoginController();
            $controller->login();
            break;

        case 'logout':  
            $controller = new LoginController();
            $controller->logout();
            break;

        case 'empresa_cadastro': 
            $controller = new EmpresaController(); 
            $controller->cadastrar();
            break;

        case 'cadastrar_cliente':
            $controller = new CadastrarClienteController();
            $controller->cadastrarCliente();
            break;

        case 'pedidos':  
            $controller = new PedidoController();
            $controller->exibirPedidos();
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

        case 'home': 
        case 'home_cliente':  
            $controller = new HomeController();
            $controller->index();
            break;
            
        case 'selecionar_perfil':
            include __DIR__ . '/../public/selecionar_perfil.php';
            break;
        
        case 'cad_pedidos':
            $controller = new PedidoController();
            $controller->cadastrarPedido();
            break;
        
        case 'editar_clientes':
            $controller = new ClienteController();
            $controller->exibirConsultaClientes();
            break;

        case 'atualizar_cliente':
            $controller = new ClienteController();
            $controller->atualizarCliente();
            break;
            
        case 'cadastrar_pedido':
            $controller = new PedidoController();
            $controller->cadastrarPedido();
            break;
        
        case 'atualizar_status_pedido': 
            $controller = new PedidoController();
            $controller->atualizarStatusPedido();
            break;

        case 'salvar_status_pedido':
            $controller = new PedidoController();
            $controller->salvarStatusPedido();
            break;

        case 'meus_pedidos':
            $controller = new PedidoController();
            $controller->exibirMeusPedidos();
            break;
        
        case 'acompanhar_pedido':
            $controller = new PedidoController();
            $controller->acompanharPedido();
            break;
        
        case 'editar_conta_cliente':
            $controller = new ClienteController();
            $controller->editarContaCliente();
            break;
        
        case 'salvar_conta_cliente':
            $controller = new ClienteController();
            $controller->salvarContaCliente();
            break;
        ;
        case 'remover_conta_cliente':
            $controller = new ClienteController();
            $controller->removerContaCliente();
            break;
        case 'configuracoes_conta':
            include __DIR__ . '/views/configuracoes_conta.php';
            break;
        
        case 'atualizar_conta_fornecedor':
            $controller = new EmpresaController();
            $controller->atualizarContaFornecedor();
            break;
        
        case 'remover_conta_fornecedor':
            $controller = new EmpresaController();
            $controller->removerContaFornecedor();
            break;

        case 'funcionarios':
            include __DIR__ . '/views/funcionarios.php';
            break;
        
        case 'cadastrar_funcionario':
            $controller = new FuncionarioController();
            $controller->cadastrarFuncionario();
            break;
        
        case 'editar_funcionario':
            $controller = new FuncionarioController();
            $controller->editarFuncionario();
            break;
        
        case 'remover_funcionario':
            $controller = new FuncionarioController();
            $controller->removerFuncionario();
            break;

    default:
        header('HTTP/1.1 404 Not Found');
        include __DIR__ . '/views/404.php';
        exit;
}
}
