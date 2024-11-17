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
        verificarSessao('id_fornecedor');
    
        $id_fornecedor = $_SESSION['id_fornecedor'];
        $pedidos = PedidoModel::getPedidosByFornecedor($id_fornecedor);
    
        include __DIR__ . '/../views/pedidos.php';
    }
    
    public function atualizarStatusPedido() {
        verificarSessao('id_fornecedor');
        
        if (!isset($_GET['id_pedido'])) {
            $_SESSION['error'] = "Nenhum pedido selecionado para atualização.";
            header('Location: index.php?page=pedidos');
            exit();
        }
    
        $id_pedido = $_GET['id_pedido'];
    
        try {
            $pedido = PedidoModel::getPedidoById($id_pedido); 
            if (!$pedido) {
                $_SESSION['error'] = "Pedido não encontrado.";
                header('Location: index.php?page=pedidos');
                exit();
            }
        } catch (Exception $e) {
            $_SESSION['error'] = "Erro ao carregar o pedido: " . $e->getMessage();
            header('Location: index.php?page=pedidos');
            exit();
        }
        include __DIR__ . '/../views/status_pedido.php';
    }
    

    public function salvarStatusPedido() {
        verificarSessao('id_fornecedor');
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_pedido = $_POST['id_pedido'];
            $descricao_status = $_POST['descricao_status'];
    
            try {
                PedidoModel::atualizarStatus($id_pedido, $descricao_status);
                $_SESSION['success'] = "Status atualizado com sucesso!";
            } catch (Exception $e) {
                $_SESSION['error'] = "Erro ao atualizar status: " . $e->getMessage();
            }
            header('Location: index.php?page=pedidos');
            exit();
        }
    }

    public function exibirMeusPedidos() {
        verificarSessao('id_cliente');
    
        $id_cliente = $_SESSION['usuario'];
        try {
            $fornecedores = PedidoModel::getFornecedoresComPedidos($id_cliente);
        } catch (Exception $e) {
            $_SESSION['error'] = "Erro ao carregar fornecedores: " . $e->getMessage();
            header('Location: index.php?page=home');
            exit();
        }
    
        include __DIR__ . '/../views/meus_pedidos.php';
    }
    
    public function getFornecedoresComPedidos($id_cliente) {
        return PedidoModel::getFornecedoresComPedidos($id_cliente);
    }
    
    public function getPedidosPorFornecedor($id_fornecedor, $id_cliente) {
        return PedidoModel::getPedidosPorFornecedor($id_fornecedor, $id_cliente);
    }
}
?>
