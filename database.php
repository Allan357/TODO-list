<?php
require_once 'config.php';

class Database
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
        try {
            $this->pdo = new PDO(DB_DSN);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->createTable();
        } catch (PDOException $e) {
            die("Erro na conexão: " . $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->pdo;
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function createTable()
    {
        $stmt = $this->pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='users'");
        $tableExists = $stmt->fetch() !== false;
        
        if (!$tableExists) {
            $sql = "CREATE TABLE users ( 
                    id INTEGER PRIMARY KEY AUTOINCREMENT, 
                    nome VARCHAR(100) NOT NULL, 
                    email VARCHAR(100) UNIQUE NOT NULL, 
                    senha VARCHAR(255) NOT NULL
                )";
            $this->pdo->exec($sql);
        }

        $stmt = $this->pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='tasks'");
        $tableExists = $stmt->fetch() !== false;
        
        if (!$tableExists) {
            $sql = "CREATE TABLE tasks ( 
                    id INTEGER PRIMARY KEY AUTOINCREMENT, 
                    title TEXT NOT NULL, 
                    description TEXT NOT NULL, 
                    due_date DATETIME,
                    completed_date DATETIME,
                    completed BOOLEAN NOT NULL DEFAULT 0,
                    user_id INTEGER NOT NULL,
                    FOREIGN KEY (user_id) REFERENCES users (id)
                )";
            $this->pdo->exec($sql);
        }

    }
}

$db = Database::getInstance();