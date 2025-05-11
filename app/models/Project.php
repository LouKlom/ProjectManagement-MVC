<?php

class Project {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $sql = "SELECT * FROM projects";
        return fetch_all($this->pdo, $sql);
    }

    public function getById($id) {
        $sql = "SELECT * FROM projects WHERE id = :id";
        return fetch_one($this->pdo, $sql, ['id' => $id]);
    }

    public function create($name, $description, $start_date, $end_date) {
        $sql = "INSERT INTO projects (name, description, start_date, end_date) VALUES (:name, :description, :start_date, :end_date)";
        execute_query($this->pdo, $sql, [
            'name'        => $name,
            'description' => $description,
            'start_date'  => $start_date,
            'end_date'    => $end_date,
        ]);
        return last_insert_id($this->pdo);
    }

    public function update($id, $name, $description, $start_date, $end_date) {
        $sql = "UPDATE projects SET name = :name, description = :description, start_date = :start_date, end_date = :end_date WHERE id = :id";
        execute_query($this->pdo, $sql, [
            'id'          => $id,
            'name'        => $name,
            'description' => $description,
            'start_date'  => $start_date,
            'end_date'    => $end_date,
        ]);
        return true;
    }

    public function delete($id) {
        $sql = "DELETE FROM projects WHERE id = :id";
        execute_query($this->pdo, $sql, ['id' => $id]);
        return true;
    }
}