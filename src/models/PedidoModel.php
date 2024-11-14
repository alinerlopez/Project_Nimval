
<?php
class PedidoModel {
    private static function conectar() {
        $conexao = new mysqli("localhost", "root", "", "seu_banco");
        if ($conexao->connect_error) {
            die("Falha na conexão: " . $conexao->connect_error);
        }
        return $conexao;
    }

    public static function getClientes() {
        $conexao = self::conectar();
        $query = "SELECT id_cliente, nome_cliente FROM clientes";
        $result = $conexao->query($query);
        $clientes = [];
        while ($row = $result->fetch_assoc()) {
            $clientes[] = $row;
        }
        $conexao->close();
        return $clientes;
    }

    public static function getStatus() {
        $conexao = self::conectar();
        $query = "SELECT id_status, descricao_status FROM status_pedidos";
        $result = $conexao->query($query);
        $statusList = [];
        while ($row = $result->fetch_assoc()) {
            $statusList[] = $row;
        }
        $conexao->close();
        return $statusList;
    }

    public static function cadastrarPedido($id_cliente, $id_fornecedor, $descricao_pedido, $status_pedido, $data_pedido) {
        $conexao = self::conectar();
        $query = "INSERT INTO pedido (id_cliente, id_fornecedor, descricao_pedido, status_pedido, data_pedido) 
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = $conexao->prepare($query);
        $stmt->bind_param("iisis", $id_cliente, $id_fornecedor, $descricao_pedido, $status_pedido, $data_pedido);
        $result = $stmt->execute();
        $stmt->close();
        $conexao->close();
        return $result;
    }
}
?>
