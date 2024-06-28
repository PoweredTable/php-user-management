<?php
require_once realpath(__DIR__ . "/../../vendor/autoload.php");


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../../");
$dotenv->load();

class Database
{
    private $host;
    private $port;
    private $dbName;
    private $username;
    private $password;

    public function __construct()
    {
        $this->host = $_ENV["DB_HOST"];
        $this->port = $_ENV["DB_PORT"];
        $this->dbName = $_ENV["DB_NAME"];
        $this->username = $_ENV["DB_USERNAME"];
        $this->password = $_ENV["DB_PASSWORD"];
    }

    public function getConnection()
    {
        $conn = null;
        try {
            $conn = new PDO("mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->dbName, $this->username, $this->password);
            // Set PDO to throw exceptions on errors
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->exec("set names utf8");
        } catch (PDOException $e) {
            throw new Exception("Connection error: " . $e->getMessage());
        }
        return $conn;
    }
}
