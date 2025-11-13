<?php
require_once 'database.php';
class AuthController {
    private $db = null;
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->db = Database::getInstance();
    }

    public function logged()
    {
        return isset($_SESSION['user']);
    }

    public function logout()
    {
        unset($_SESSION['user']);
    }

    private function validateEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email inválido!");
        }
    }


    private function getUser($email, $senha): array | null
    {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($senha, $user['senha'])) {
                return $user;
            }

            throw new Exception("Senha incorreta.", 1);
        }

        return null;
    }
    public function login($email, $senha)
    {
        if (empty($email) || empty($senha)) {
            throw new Exception("Todos os campos devem ser preenchidos.");
        }

        $this->validateEmail($email);

        $user = $this->getUser($email, $senha);

        if (!$user) {
            throw new Exception("Usuário não encontrado.", 1);
        }

        if ($user) {
            $_SESSION['user'] = $user;
            return true;
        }

        return false;
    }

    public function register($nome, $email, $senha)
    {
        if (empty($nome) || empty($email) || empty($senha)) {
            throw new Exception("Todos os campos devem ser preenchidos.");
        }

        $this->validateEmail($email);

        $user = $this->getUser($email, $senha);

        if ($user) {
            throw new Exception("Usuário já cadastrado.", 1);
        }

        $stmt = $this->db->getConnection()->prepare("INSERT INTO users (nome, email, senha) VALUES (:nome, :email, :senha)");
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $stmt->execute(['nome' => $nome, 'email' => $email, 'senha' => $senha_hash]);

        return true;
    }
}