<?php
/**
 * CLASSE DE CONEXÃO COM BANCO DE DADOS (Padrão PDO - Orientado a Objetos)
 * Atende aos requisitos de encapsulamento e segurança do projeto.
 */
class Database {
    private $host = "localhost";
    private $db_name = "db_academia_24";
    private $username = "root";
    private $password = ""; // Configuração padrão do Laragon no Windows
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            // Instancia o driver PDO definindo o charset para evitar quebra de caracteres latinos
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            // Define o modo de tratamento de erros para lançar exceções capturáveis
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Erro na conexão com a Base de Dados: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>