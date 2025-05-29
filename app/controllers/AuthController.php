<?php

class AuthController{
    private $pdo;
    private $userModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->userModel = new User($pdo);
    }


    public function register() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $confimPassword = $_POST['confirmPassword'];

            if (empty($username) || empty($password) || empty($confimPassword)) {
                $error = "Tous les champs sont obligatoires.";
            } elseif ($password != $confimPassword) {
                $error = "Les mots de passe ne correspondent pas.";
            } elseif ($this->userModel->getUserByUsername($username)) {
                $error = "Ce nom d'utilisateur est déjà utilisé.";
            } else {
                $userId = $this->userModel->createUser($username, $password);
                $_SESSION['user_id'] = $userId;
                header('Location: /index.php?route=projects&action=list');
                exit();
            }
            include '../views/auth/register.php';   // formulaire avec erreur
            } else {
                include '../views/auth/register.php';  // formulaire vide
            }

        }


    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $this->userModel->getUserByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                header("Location: /index.php?route=projects&action=list");
                exit();
            } else {
                $error = "Nom d'utilisateur ou mot de passe incorrect.";
                include '../views/auth/login.php'; // Afficher le formulaire avec l'erreur
            }
        } else {
            include '../views/auth/login.php'; // Afficher le formulaire vide
        }
    }
    
    public function logout() {
        session_destroy();
        header("Location: /index.php?route=auth&action=login");
        exit();
    }
       

}