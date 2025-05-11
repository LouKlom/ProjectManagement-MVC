<?php



class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createUser($username, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password, role) VALUES (:username, :password, :role)";
        execute_query($this->pdo, $sql, [
            'username' => $username,
            'password' => $hashedPassword,
            'role' => "utilisateur"
        ]);
        return last_insert_id($this->pdo);
    }

    public function getUserByUsername($username) {
        $sql = "SELECT * FROM users where username = :username";
        return fetch_one($this->pdo, $sql, ['username' => $username]);
   }

    public function getUserById($id) {
        $sql = "SELECT * FROM users where id = :id";
        return fetch_one($this->pdo, $sql, ['id' => $id]);
    }

    public function getallUsers() {
        $sql = "Select * FROM users";
        return fetch_all($this->pdo, $sql);
    }

    public function deleteUser($id) {
        $sql = "DELETE FROM users WHERE id = :id";
        execute_query($this->pdo, $sql, ['id' => $id]);
        return true;
    }

    public function create() {
        return 'create';
    }

    public function update() {
        return 'UPDATE';
    }

    public function delete() {
        return 'DELETE';
    }

}