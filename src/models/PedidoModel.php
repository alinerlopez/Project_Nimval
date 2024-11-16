<?php
require_once __DIR__ . '/../database/Database.php';

class PedidoModel {

    public static function cadastrarPedido($id_cliente, $id_fornecedor, $descricao_pedido, $numero_pedido, $data_pedido) {
            $pdo = Database::getConnection();
            if (!$pdo) {
                error_log("Erro ao conectar ao banco de dados.");
                return false;
            }

        try {
            $stmt = $pdo->prepare("INSERT INTO pedido (id_cliente, id_fornecedor, descricao_pedido, numero_pedido, data_pedido) 
                      VALUES (?, ?, ?, ?, ?)");

            $stmt->bindParam(1, $id_cliente, PDO::PARAM_INT);
            $stmt->bindParam(2, $id_fornecedor, PDO::PARAM_INT);
            $stmt->bindParam(3, $descricao_pedido, PDO::PARAM_STR);
            $stmt->bindParam(4, $numero_pedido, PDO::PARAM_STR);
            $stmt->bindParam(5, $data_pedido, PDO::PARAM_STR);

            $resultado = $stmt->execute();


            if ($resultado) {
                error_log("Pedido cadastrado com sucesso. Número do Pedido: $numero_pedido");
                return true;
            } else {
                error_log("Erro ao executar a consulta: " . implode(", ", $stmt->errorInfo()));
                return false;
            }

        } catch (Exception $e) {
            error_log("Exceção capturada ao cadastrar pedido: " . $e->getMessage());
            return false;
        }
    }

    public static function getStatus() {
        $pdo = Database::getConnection(); 

        $query = "SELECT id_status, descricao_status FROM status_pedidos";
        $stmt = $pdo->prepare($query);  
        
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC); 
        }
        return []; 
    }
}
?>
