<?php
require_once __DIR__ . '/../models/PedidoModel.php'; 

class PedidoController {
    public function index() {
        $pedidos = PedidoModel::getAll();
        include __DIR__ . '/../views/pedido.php'; 
    }
}
?>
