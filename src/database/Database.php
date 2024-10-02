<?php
class Database {
    private static $instance = null;
    private static $host = 'localhost';
    private static $dbname = 'bd_nimval';
    private static $username = 'root';
    private static $password = '';

    public static function getConnection() {
        if (self::$instance === null) {
            try {
                self::$instance = new PDO("mysql:host=" . self::$host . ";dbname=" . self::$dbname, self::$username, self::$password);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                error_log("Erro de conexão com o banco de dados: " . $e->getMessage());  
                die("Erro de conexão com o banco de dados. Entre em contato com o administrador."); 
            }
        }
        return self::$instance;
    }
}
?>
