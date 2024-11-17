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
    
    
    public static function atualizarStatus($id_pedido, $descricao_status) {
        $pdo = Database::getConnection();
        $query = "UPDATE status_pedidos 
                  SET descricao_status = :descricao_status, data_status = NOW() 
                  WHERE id_pedido = :id_pedido";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':descricao_status', $descricao_status, PDO::PARAM_STR);
        $stmt->bindParam(':id_pedido', $id_pedido, PDO::PARAM_INT);
        
        if (!$stmt->execute()) {
            error_log("Erro ao atualizar status: " . implode(", ", $stmt->errorInfo()));
            throw new Exception("Erro ao atualizar o status do pedido.");
        }
    }

    public static function getPedidoById($id_pedido) {
        $pdo = Database::getConnection();
        $query = "
            SELECT 
                p.*, 
                sp.descricao_status AS status_pedido 
            FROM 
                pedido p
            LEFT JOIN 
                status_pedidos sp ON p.id_pedido = sp.id_pedido
            WHERE 
                p.id_pedido = :id_pedido
        ";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id_pedido', $id_pedido, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            error_log("Erro ao buscar pedido: " . implode(", ", $stmt->errorInfo()));
            return false;
        }
    }

    public static function getFornecedoresByCliente($id_cliente) {
        $pdo = Database::getConnection();
        $query = "
            SELECT DISTINCT f.id_fornecedor, f.nome_fornecedor
            FROM pedido p
            JOIN fornecedor f ON p.id_fornecedor = f.id_fornecedor
            WHERE p.id_cliente = :id_cliente
        ";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getPedidosByFornecedorAndCliente($id_fornecedor, $id_cliente) {
        $pdo = Database::getConnection();
        $query = "
            SELECT p.id_pedido, p.descricao_pedido, p.numero_pedido, sp.descricao_status
            FROM pedido p
            LEFT JOIN status_pedidos sp ON p.id_pedido = sp.id_pedido
            WHERE p.id_fornecedor = :id_fornecedor AND p.id_cliente = :id_cliente
        ";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id_fornecedor', $id_fornecedor, PDO::PARAM_INT);
        $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getFornecedoresComPedidos($id_cliente) {
        $pdo = Database::getConnection();
        $query = "
            SELECT DISTINCT f.id_fornecedor, f.nome_fornecedor
            FROM pedido p
            INNER JOIN fornecedor f ON p.id_fornecedor = f.id_fornecedor
            WHERE p.id_cliente = :id_cliente
        ";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
    
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            error_log("Erro ao buscar fornecedores: " . implode(", ", $stmt->errorInfo()));
            return [];
        }
    }
    
    public static function getPedidosPorFornecedor($id_fornecedor, $id_cliente) {
        $pdo = Database::getConnection();
        $query = "
            SELECT id_pedido, numero_pedido, status_pedido
            FROM pedido
            WHERE id_fornecedor = :id_fornecedor AND id_cliente = :id_cliente
        ";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id_fornecedor', $id_fornecedor, PDO::PARAM_INT);
        $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
