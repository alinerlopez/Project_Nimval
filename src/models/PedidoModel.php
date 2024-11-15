<?php
require_once __DIR__ . '/../database/Database.php';

class PedidoModel {

    public static function getStatus() {
        $pdo = Database::getConnection(); 

        $query = "SELECT id_status, descricao_status FROM status_pedidos";
        $stmt = $pdo->prepare($query);  
        
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC); 
        }
        
        return []; 
    }

    public static function cadastrarPedido($id_cliente, $id_fornecedor, $descricao_pedido, $data_pedido, $num_pedido) {
      
        $pdo = Database::getConnection(); 
        if (!$pdo) {
            error_log("Erro ao conectar com o banco de dados.");
            return false;
        }

        $query = "INSERT INTO pedido (id_cliente, id_fornecedor, descricao_pedido, numero_pedido, data_pedido) 
                  VALUES (?, ?, ?, ?, ?)";

        $stmt = $pdo->prepare($query);

        $stmt->bindValue(1, $id_cliente, PDO::PARAM_INT);
        $stmt->bindValue(2, $id_fornecedor, PDO::PARAM_INT);
        $stmt->bindValue(3, $descricao_pedido, PDO::PARAM_STR);
        $stmt->bindValue(4, $num_pedido, PDO::PARAM_STR);  
        $stmt->bindValue(5, $data_pedido, PDO::PARAM_STR);  

        if ($stmt->execute()) {
            return true;  
        } else {
            error_log("Erro ao executar a consulta: " . implode(", ", $stmt->errorInfo()));  
            return false;  
        }
    }
}
?>
