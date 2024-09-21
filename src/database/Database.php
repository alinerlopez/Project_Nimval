<?php
class Database {
    private static $instance = null;

    // Método para obter a conexão com o banco de dados
    public static function getConnection() {
        if (self::$instance === null) {
            try {
                // Cria a conexão com o banco de dados usando PDO
                // Ajuste as credenciais conforme necessário
                self::$instance = new PDO("mysql:host=localhost;dbname=bd_nimval", "root", "");
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                // Exibe uma mensagem de erro se a conexão falhar
                die("Erro de conexão com o banco de dados: " . $e->getMessage());
            }
        }
        // Retorna a instância de conexão
        return self::$instance;
    }
}
