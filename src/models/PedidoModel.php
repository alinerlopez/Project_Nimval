<?php
require_once '../config/config.php';  

class PedidoModel {
    public static function getAll() {
        global $pdo;
        try {
            $stmt = $pdo->prepare("SELECT * FROM pedido");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);  
        } catch (PDOException $e) {
            die("Erro ao buscar pedidos: " . $e->getMessage());
        }
    }
}
?>
