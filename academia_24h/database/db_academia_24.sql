<?php
class DB {
    private static $host = "localhost";
    private static $dbname = "db_academia_24h";
    private static $username = "root";
    private static $password = ""; // Senha padrão vazia do Laragon
    private static $connect = null;

    public static function getConnection() {
        if (self::$connect == null) {
            try {
                self::$connect = new PDO(
                    "mysql:host=" . self::$host . ";dbname=" . self::$dbname . ";charset=utf8",
                    self::$username,
                    self::$password
                );
                self::$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erro de conexão: " . $e->getMessage());
            }
        }
        return self::$connect;
    }
}