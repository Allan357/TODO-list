<?php

require_once 'database.php';

class TaskController {
    private $db = null;
    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function novaTarefa($title, $description, $due_date=null, $user_id) {
        $stmt = $this->db->getConnection()->prepare("INSERT INTO tasks (title, description, due_date, user_id) VALUES (:title, :description, :due_date, :user_id)");
        $stmt->execute(['title' => $title, 'description' => $description, 'due_date' => $due_date, 'user_id' => $user_id]);
    }

    public function editarTarefa($id, $title, $description, $due_date) {
        $stmt = $this->db->getConnection()->prepare("UPDATE tasks SET title = :title, description = :description, due_date = :due_date  WHERE id = :id");
        $stmt->execute(['id' => $id, 'title' => $title, 'description' => $description, 'due_date' => $due_date]);
    }

    public function excluirTarefa($id) {
        $stmt = $this->db->getConnection()->prepare("DELETE FROM tasks WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }

    public function concluirTarefa($id) {
        $stmt = $this->db->getConnection()->prepare("UPDATE tasks SET completed = 1, completed_date = CURRENT_TIMESTAMP WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }

    public function getUserTask($task_id, $user_id) {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM tasks WHERE user_id = :user_id AND id = :id");
        $stmt->execute(['user_id' => $user_id, 'id' => $task_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserTasks($user_id, $filter = null) {
        $query = "SELECT * FROM tasks WHERE user_id = :user_id";
        if ($filter)
        {
            switch ($filter) {
                case 'completed':
                    $query .= " AND completed = 1";
                    break;
                case 'today':
                    $query .= " AND DATE(due_date) = date('now')";
                    break;
                case 'overdue':
                    $query .= " AND due_date IS NULL AND due_date < DATETIME('now') AND completed = 0";
                default:
                    break;
            }
        }
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}