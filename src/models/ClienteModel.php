<?php
require_once __DIR__ . '/../database/Database.php';

class ClienteModel {
    public static function getAllClientes() {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT id_cliente, nome, cpf, email, endereco, telefone, ativo FROM clientes ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function atualizarCliente($id_cliente, $email, $endereco, $telefone, $ativo) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE clientes SET email = :email, endereco = :endereco, telefone = :telefone, ativo = :ativo WHERE id_cliente = :id_cliente");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':endereco', $endereco);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':ativo', $ativo);
        $stmt->bindParam(':id_cliente', $id_cliente);
        return $stmt->execute();
    }

    public static function getClienteById($id_cliente) {
        $pdo = Database::getConnection();
        $query = "SELECT nome, cpf, email, endereco, telefone FROM clientes WHERE id_cliente = :id_cliente";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }     
}
?>
