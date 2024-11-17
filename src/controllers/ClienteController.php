<?php
require_once __DIR__ . '/../models/ClienteModel.php';
require_once __DIR__ . '/../utils/session_helper.php';

class ClienteController {
    public function exibirConsultaClientes() {
        verificarSessao('id_fornecedor');
        $clientes = ClienteModel::getAllClientes();
        include __DIR__ . '/../views/editar_clientes.php';
    }

    public function atualizarCliente() {
        verificarSessao('id_fornecedor');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_cliente = $_POST['id_cliente'];
            $email = $_POST['email'];
            $endereco = $_POST['endereco'];
            $telefone = $_POST['telefone'];
            $ativo = $_POST['ativo'];

            $resultado = ClienteModel::atualizarCliente($id_cliente, $email, $endereco, $telefone, $ativo);

            if ($resultado) {
                header('Location: index.php?page=editar_clientes&status=sucesso');
            } else {
                header('Location: index.php?page=editar_clientes&status=erro');
            }
            exit;
        }
    }
    
    public function listarFornecedores() {
        verificarSessao('usuario');

        $id_cliente = $_SESSION['usuario'];
        $fornecedores = PedidoModel::getFornecedoresByCliente($id_cliente);

        include __DIR__ . '/../views/meus_pedidos.php';
    }

    public function listarPedidosFornecedor() {
        verificarSessao('usuario');

        if (!isset($_GET['id_fornecedor'])) {
            $_SESSION['error'] = "Fornecedor não especificado.";
            header('Location: index.php?page=meus_pedidos');
            exit();
        }

        $id_fornecedor = $_GET['id_fornecedor'];
        $id_cliente = $_SESSION['usuario'];
        $pedidos = PedidoModel::getPedidosByFornecedorAndCliente($id_fornecedor, $id_cliente);

        include __DIR__ . '/../views/pedidos_fornecedor.php';
    }

    public function acompanharPedido() {
        verificarSessao('usuario');

        if (!isset($_GET['id_pedido'])) {
            $_SESSION['error'] = "Pedido não especificado.";
            header('Location: index.php?page=meus_pedidos');
            exit();
        }

        $id_pedido = $_GET['id_pedido'];
        $pedido = PedidoModel::getPedidoById($id_pedido);

        if (!$pedido) {
            $_SESSION['error'] = "Pedido não encontrado.";
            header('Location: index.php?page=meus_pedidos');
            exit();
        }

        include __DIR__ . '/../views/acompanhar_pedido.php';
    }
}
?>
