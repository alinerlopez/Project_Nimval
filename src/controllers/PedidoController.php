<?php
require_once __DIR__ . '/../models/ClienteModel.php';
require_once __DIR__ . '/../models/PedidoModel.php';
require_once __DIR__ . '/../utils/session_helper.php';


class PedidoController {
    
    public function cadastrarPedido() {
        verificarSessao('id_fornecedor');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_fornecedor = $_SESSION['id_fornecedor'];
            $id_cliente = $_POST['id_cliente'];
            $descricao_pedido = $_POST['descricao_pedido'];
            $num_pedido = $_POST['num_pedido'];
            $data_pedido = $_POST['data_pedido'];

            if (empty($id_cliente) || empty($descricao_pedido) || empty($num_pedido) || empty($data_pedido)) {
                $_SESSION['error'] = "Todos os campos são obrigatórios.";
                header('Location: index.php?page=cad_pedidos');
                exit();
            }

            try {
                $resultado = PedidoModel::cadastrarPedido(
                    $id_cliente, 
                    $id_fornecedor, 
                    $descricao_pedido, 
                    $num_pedido, 
                    $data_pedido
                );

                if ($resultado) {
                    $_SESSION['success'] = "Pedido cadastrado com sucesso!";
                    header('Location: index.php?page=cad_pedidos');
                    exit();
                } else {
                    $_SESSION['error'] = "Erro ao cadastrar pedido.";
                    header('Location: index.php?page=cad_pedidos');
                    exit();
                }
            } catch (Exception $e) {
                $_SESSION['error'] = "Erro: " . $e->getMessage();
                header('Location: index.php?page=cad_pedidos');
                exit();
            }
        } else {
            include __DIR__ . '/../views/cad_pedidos.php';
        }
    }

    public function exibirPedidos() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    
        if (!isset($_SESSION['id_fornecedor'])) {
            header('Location: index.php?page=login');
            exit();
        }
    
        $id_fornecedor = $_SESSION['id_fornecedor'];
        $pedidos = PedidoModel::getPedidosByFornecedor($id_fornecedor);
    
        include __DIR__ . '/../views/pedidos.php';
    }
    
    public function atualizarPedidos() {
        verificarSessao('id_fornecedor');

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'])) {
            $statusAtualizado = $_POST['status']; 

            if (empty($statusAtualizado)) {
                $_SESSION['error'] = "Nenhum pedido para atualizar.";
                header('Location: index.php?page=pedidos');
                exit();
            }

            foreach ($statusAtualizado as $id_pedido => $novo_status) {
                try {
                    PedidoModel::atualizarStatus($id_pedido, $novo_status);
                } catch (Exception $e) {
                    $_SESSION['error'] = "Erro ao atualizar o pedido $id_pedido: " . $e->getMessage();
                    header('Location: index.php?page=pedidos');
                    exit();
                }
            }

            $_SESSION['success'] = "Status dos pedidos atualizado com sucesso!";
            header('Location: index.php?page=pedidos');
            exit();
        } else {
            $_SESSION['error'] = "Nenhuma ação foi realizada.";
            header('Location: index.php?page=pedidos');
            exit();
        }
    }
}
?>
