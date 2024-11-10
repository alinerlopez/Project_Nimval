<?php
require_once __DIR__ . '/../database/Database.php';  

class PedidoModel {
    public static function getAll() {
        $pdo = Database::getConnection();
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
