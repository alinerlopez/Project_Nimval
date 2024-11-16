<?php
require_once __DIR__ . '/../models/ClienteModel.php';
require_once __DIR__ . '/../models/PedidoModel.php';

class PedidoController {
    
    public function cadastrarPedido() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    
        if (!isset($_SESSION['id_fornecedor'])) {
            error_log("Sessão perdida ou não configurada.");
            header('Location: index.php?page=login');
            exit();
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_fornecedor = $_SESSION['id_fornecedor'];
            $id_cliente = $_POST['id_cliente'];
            $descricao_pedido = $_POST['descricao_pedido'];
            $num_pedido = $_POST['num_pedido'];
            $data_pedido = $_POST['data_pedido'];
    
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
                    header('Location: index.php?page=cad_pedidos&status=sucesso');
                    exit();
                } else {
                    $_SESSION['error'] = "Erro ao cadastrar pedido.";
                    header('Location: index.php?page=cad_pedidos&status=erro');
                    exit();
                }
            } catch (Exception $e) {
                $_SESSION['error'] = "Erro: " . $e->getMessage();
                header('Location: index.php?page=cad_pedidos&status=erro');
                exit();
            }
        } else {
            include __DIR__ . '/../views/cad_pedidos.php';
        }
    }
    


    public function exibirPedidos() {
        include __DIR__ . '/../views/pedidos.php';
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['id_fornecedor'])) {
            error_log("Sessão perdida ou não configurada.");
            header('Location: index.php?page=login');
            exit();
        }
        
    }
}
?>
