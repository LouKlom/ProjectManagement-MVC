<?php

class Task {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getByProjectId($projectId) {
        $sql = "SELECT t.*, u.username AS assigned_user FROM tasks t LEFT JOIN users u ON t.assigned_to = u.id WHERE t.project_id = :project_id";
        return fetch_all($this->pdo, $sql, ['project_id' => $projectId]);
    }

    public function getById($id) {
        $sql = "SELECT * FROM tasks WHERE id = :id";
        return fetch_one($this->pdo, $sql, ['id' => $id]);
    }

    public function create($projectId, $title, $description, $dueDate, $status, $priority, $assignedTo) {
        $sql = "INSERT INTO tasks (project_id, title, description, due_date, status, priority, assigned_to) VALUES (:project_id, :title, :description, :due_date, :status, :priority, :assigned_to)";
        execute_query($this->pdo, $sql, [
            'project_id'  => $projectId,
            'title'       => $title,
            'description' => $description,
            'due_date'    => $dueDate,
            'status'      => $status,
            'priority'    => $priority,
            'assigned_to' => $assignedTo,
        ]);
        return last_insert_id($this->pdo);
    }

    public function update($id, $title, $description, $dueDate, $status, $priority, $assignedTo) {
        $sql = "UPDATE tasks SET title = :title, description = :description, due_date = :due_date, status = :status, priority = :priority, assigned_to = :assigned_to WHERE id = :id";
        execute_query($this->pdo, $sql, [
            'id'          => $id,
            'title'       => $title,
            'description' => $description,
            'due_date'    => $dueDate,
            'status'      => $status,
            'priority'    => $priority,
            'assigned_to' => $assignedTo,
        ]);
        return true;
    }

    public function delete($id) {
        $sql = "DELETE FROM tasks WHERE id = :id";
        execute_query($this->pdo, $sql, ['id' => $id]);
        return true;
    }
}