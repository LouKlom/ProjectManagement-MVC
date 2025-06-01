<?php

class AdminController {
    private $pdo;
    private $userModel;
    private $activityLogModel;


    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->userModel = new User($this->pdo);
        $this->activityLogModel = new ActivityLog($this->pdo);
    }

    public function index() {
        if (has_role('ADMIN')) {
            include '../views/admin/index.php';
        } else {
            echo "Accès non autorisé à la section d'administration.";
        }
    }

    public function listUsers() {
        if (has_role('ADMIN')) {
            $users = $this->userModel->getAllUsers();
            include '../views/admin/list_users.php';
        } else {
            echo "Accès non autorisé.";
        }
    }

    public function editUser($id) {
        if (has_role('ADMIN')) {
            $user = $this->userModel->getUserById($id);
            if ($user) {
                include '../views/admin/edit_user.php';
            } else {
                echo "Utilisateur non trouvé.";
            }
        } else {
            echo "Accès non autorisé.";
        }
    }

    public function updateUser($id) {
        if (has_role('ADMIN') && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $role = $_POST['role'];


            $sql = "UPDATE users SET username = :username, role = :role WHERE id = :id";
            execute_query($this->pdo, $sql, [
                'id' => $id,
                'username' => $username,
                'role' => $role,
            ]);
            header("Location: /index.php?route=admin&action=listUsers");
            exit();
        } else {
            echo "Méthode non autorisée ou accès refusé.";
        }
    }

    public function deleteUser($id) {
        if (has_role('ADMIN')) {
            if ($id == $_SESSION['user_id']) {
                echo "Vous ne pouvez pas supprimer votre propre compte administrateur.";
                return;
            }
            $this->userModel->deleteUser($id);
            header("Location: /index.php?route=admin&action=listUsers");
            exit();
        } else {
            echo "Accès non autorisé.";
        }
    }


    public function viewActivityLogs() {
        if (!has_role('ADMIN')) {
            echo "Accès non autorisé à l'historique d'activité.";
            return;
        }

        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = 20; 
        $offset = ($page - 1) * $limit;

        $logs = $this->activityLogModel->getAllLogs($limit, $offset);
        $totalLogs = $this->activityLogModel->countAllLogs();
        $totalPages = ceil($totalLogs / $limit);

        include '../views/admin/activity_logs.php';
    }
}