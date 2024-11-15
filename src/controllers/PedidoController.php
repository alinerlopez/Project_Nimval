<?php
require_once __DIR__ . '/../models/ClienteModel.php';
require_once __DIR__ . '/../models/PedidoModel.php';

class PedidoController {

    public function cadastrarPedido() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['id_fornecedor'])) {
                die("Erro: Fornecedor não autenticado!");
            }

            $id_fornecedor = $_SESSION['id_fornecedor']; 
            $id_cliente = $_POST['id_cliente'];
            $num_pedido = $_POST['num_pedido']; 
            $descricao_pedido = $_POST['descricao_pedido'];  
            $data_pedido = $_POST['data_pedido'];  

            error_log("Dados do Pedido: Cliente ID: $id_cliente, Fornecedor ID: $id_fornecedor, Descrição: $descricao_pedido, Data: $data_pedido, Número do Pedido: $num_pedido");

            $resultado = PedidoModel::cadastrarPedido($id_cliente, $id_fornecedor, $descricao_pedido, $num_pedido, $data_pedido);

            if ($resultado) {
                header("Location: sucesso.php?mensagem=Pedido cadastrado com sucesso!");
                exit();
            } else {
                echo "Erro ao cadastrar o pedido. Tente novamente.";
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
