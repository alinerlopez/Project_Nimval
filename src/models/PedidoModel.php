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

    public static function getPedidosByFornecedor($id_fornecedor) {
        $pdo = Database::getConnection();
    
        $query = "
            SELECT 
                p.id_pedido,
                p.numero_pedido,
                p.descricao_pedido,
                p.data_pedido,
                sp.descricao_status AS status_pedido
            FROM 
                pedido p
            LEFT JOIN 
                status_pedidos sp ON p.id_pedido = sp.id_pedido
            WHERE 
                p.id_fornecedor = :id_fornecedor
            ORDER BY p.id_pedido 
        ";
    
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id_fornecedor', $id_fornecedor, PDO::PARAM_INT);
    
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            error_log("Erro ao buscar pedidos: " . implode(", ", $stmt->errorInfo()));
            return [];
        }
    }
    
    
    public static function atualizarStatus($id_pedido, $novo_status) {
        $pdo = Database::getConnection();
    
        $query = "UPDATE pedido SET status_pedido = :status WHERE id_pedido = :id";
        $stmt = $pdo->prepare($query);
    
        $stmt->bindParam(':status', $novo_status, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id_pedido, PDO::PARAM_INT);
    
        if (!$stmt->execute()) {
            throw new Exception("Erro ao atualizar o status do pedido.");
        }
    
        return true;
    }
}
?>
