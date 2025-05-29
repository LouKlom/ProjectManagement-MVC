<?php


class UserController {
    private $pdo;
    private $userModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->userModel = new User($pdo);
    }


    public function profile() {
        if (isset($_SESSION['user_id']) && is_numeric($_SESSION['user_id'])) {
            $userID = $_SESSION['user_id'];
            $user = $this->userModel->getUserById($userID);
            include '../views/user/profile.php';
        } else {
            header("Location: /index.php?route=auth&action=login");
            exit();
        }
    }


}