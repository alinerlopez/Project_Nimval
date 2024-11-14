<?php
require_once __DIR__ . '/../models/ClienteModel.php';

class PedidoController {

    public function cadastrarPedido() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        include __DIR__ . '/../models/pedidoModel.php';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['id_fornecedor'])) {
                die("Erro: Fornecedor não autenticado!");
            }

            $id_fornecedor = $_SESSION['id_fornecedor'];
            $id_cliente = $_POST['id_cliente'];
            $descricao_pedido = $_POST['descricao_pedido'];
            $status_pedido = $_POST['status_pedido'];
            $data_pedido = $_POST['data_pedido'];

            $resultado = PedidoModel::cadastrarPedido($id_cliente, $id_fornecedor, $descricao_pedido, $status_pedido, $data_pedido);

            if ($resultado) {
                echo "Pedido cadastrado com sucesso!";
            } else {
                echo "Erro ao cadastrar o pedido.";
            }
        } else {
            include __DIR__ . '/../views/cad_pedidos.php';
        }
    }

    public function exibirCadastroPedido() {
        $clientes = ClienteModel::getAllClientes();
        include __DIR__ . '/../views/cad_pedidos.php';
    }
}
?>
