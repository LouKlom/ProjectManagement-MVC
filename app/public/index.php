<?php

require '../database.php';
require '../models/User.php';
require '../models/Project.php';
require '../models/Task.php';
require '../controllers/AuthController.php';
require '../controllers/ProjectController.php';
require '../controllers/TaskController.php';
require '../controllers/UserController.php';
require '../controllers/AdminController.php';

session_start(); // Démarrer la session

$pdo = connect_db();

// Fonction pour vérifier si l'utilisateur est connecté
function is_logged_in() {
    return isset($_SESSION['user_id']) && is_numeric($_SESSION['user_id']);
}

function has_role($role) {
    global $loggedInUser; // Utilise la variable globale de l'utilisateur connecté

    return $loggedInUser && isset($loggedInUser['role']) && $loggedInUser['role'] === $role;
}

// Fonction pour récupérer l'utilisateur connecté
function get_logged_in_user($pdo) {
    if (is_logged_in()) {
        $userModel = new User($pdo);
        return $userModel->getUserById($_SESSION['user_id']);
    }
    return null;
}

$loggedInUser = get_logged_in_user($pdo);

$route = $_GET['route'] ?? 'projects';
$action = $_GET['action'] ?? 'list';

// Liste des routes publiques (accessibles sans connexion)
$publicRoutes = [
    'auth' => ['register', 'login'],
];

// Vérification de l'authentification pour les autres routes
if (!isset($publicRoutes[$route]) || !in_array($action, $publicRoutes[$route])) {
    if (!is_logged_in()) {
        //header("Location: /index.php?route=auth&action=login");
        //exit();
        $authController = new AuthController($pdo);
        $authController->login();
    }
}

// Reste de la logique de routage (comme précédemment)
switch ($route) {
    case 'auth':
        $authController = new AuthController($pdo);
        // Les actions 'register' et 'login' sont gérées ici
        if ($action === 'register') {
            $authController->register();
        } elseif ($action === 'login') {
            $authController->login();
        } elseif ($action === 'logout') {
            $authController->logout();
        } else {
            echo "Action d'authentification non valide.";
        }
        break;


        case 'projects':
            $projectController = new ProjectController($pdo);
            if ($action === 'list') {
                $projectController->list();
            } elseif ($action === 'create') {
                $projectController->create();
            } elseif ($action === 'store') {
                $projectController->store();
            } elseif (strpos($action, 'edit') === 0) {
                $projectId = isset($_GET['id']) ? intval($_GET['id']) : null;
                $projectController->edit($projectId);
            } elseif ($action === 'update') {
                $projectId = isset($_POST['id']) ? intval($_POST['id']) : null;
                $projectController->update($projectId);
            } elseif (strpos($action, 'delete') === 0) {
                $projectId = isset($_GET['id']) ? intval($_GET['id']) : null;
                $projectController->delete($projectId);
            } elseif ($action === 'details') {
                $projectId = isset($_GET['id']) ? intval($_GET['id']) : null;
                $projectController->details($projectId);
            } else {
                echo "Action de projet non valide.";
            }
        break;
        
        case 'tasks':
            $taskController = new TaskController($pdo);
            if ($action === 'list') {
                $projectId = isset($_GET['project_id']) ? intval($_GET['project_id']) : null;
                $taskController->list($projectId);
            } elseif ($action === 'create') {
                $projectId = isset($_GET['project_id']) ? intval($_GET['project_id']) : null;
                $taskController->create($projectId);
            } elseif ($action === 'store') {
                $taskController->store($_POST);
            } elseif (strpos($action, 'edit') === 0) {
                $taskId = isset($_GET['id']) ? intval($_GET['id']) : null;
                $taskController->edit($taskId);
            } elseif ($action === 'update') {
                $taskId = isset($_POST['id']) ? intval($_POST['id']) : null;
                $taskController->update($taskId);
            } elseif (strpos($action, 'delete') === 0) {
                $taskId = isset($_GET['id']) ? intval($_GET['id']) : null;
                $taskController->delete($taskId);
            } else {
                echo "Action de tâche non valide.";
            }
            break;
                
        case 'user':
            $userController = new UserController($pdo);
            if ($action === 'profile') {
                $userController->profile();
            } else {
                echo "Action d'utilisateur non valide.";
            }
            break;

            case 'admin':
                $adminController = new AdminController($pdo);
                if ($action === 'index') {
                    $adminController->index();
                } elseif ($action === 'listUsers') {
                    $adminController->listUsers();
                } elseif (strpos($action, 'editUser') === 0) {
                    $userId = isset($_GET['id']) ? intval($_GET['id']) : null;
                    $adminController->editUser($userId);
                } elseif (strpos($action, 'updateUser') === 0) {
                    $userId = isset($_GET['id']) ? intval($_GET['id']) : null;
                    $adminController->updateUser($userId);
                } elseif (strpos($action, 'deleteUser') === 0) {
                    $userId = isset($_GET['id']) ? intval($_GET['id']) : null;
                    $adminController->deleteUser($userId);
                } else {
                    echo "Action d'administration non valide.";
                }
                break;

        
    default:
        echo "Route non reconnue.";
}