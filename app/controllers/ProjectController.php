<?php

class ProjectController {
    private $pdo;
    private $projectModel;
    private $taskModel; // Ajoute le modèle Task

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->projectModel = new Project($this->pdo);
        $this->taskModel = new Task($this->pdo); // Instancie le modèle Task
    }

    public function list() {
        if (!is_logged_in()) {
            header("Location: /?route=auth&action=login");
            exit();
        }

        $userId = $_SESSION['user_id'];
        $ongoingProjects = [];
        $finishedProjects = [];

        if (has_role('ADMIN')) {
            $allProjects = $this->projectModel->getAll();
        } else {
            $allProjects = $this->projectModel->getProjectsByCreator($userId);
        }

        foreach ($allProjects as $project) {
            if ($project['finish'] == 1) {
                $finishedProjects[] = $project;
            } else {
                $ongoingProjects[] = $project;
            }
        }

        include '../views/projects/list.php';
    }

    public function create() {
        if (!is_logged_in()) {
            header("Location: /?route=auth&action=login");
            exit();
        }
        include '../views/projects/create.php';
    }

    public function store() {
        if (!is_logged_in()) {
            header("Location: /?route=auth&action=login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];
            $creatorId = $_SESSION['user_id'];

            if (empty($name)) {
                echo "Le nom du projet est obligatoire.";
                return;
            }

            $projectId = $this->projectModel->create($name, $description, $start_date, $end_date, $creatorId);
            header("Location: /?route=projects&action=list");
            exit();
        } else {
            header("Location: /?route=projects&action=list");
            exit();
        }
    }

    public function edit($id) {
        if (!is_logged_in()) {
            header("Location: /?route=auth&action=login");
            exit();
        }
        $userId = $_SESSION['user_id'];
        $project = null;

        if (has_role('ADMIN')) {
            $project = $this->projectModel->getById($id);
        } else {
            $project = $this->projectModel->getById($id, $userId);
        }

        if ($project) {
            include '../views/projects/edit.php';
            return;
        }
        echo "Projet non trouvé ou vous n'avez pas l'autorisation d'éditer ce projet.";
    }


    public function update($id) {
        if (!is_logged_in()) {
            header("Location: /?route=auth&action=login");
            exit();
        }
        $userId = $_SESSION['user_id'];
        $project = null;

        if (has_role('ADMIN')) {
            $project = $this->projectModel->getById($id);
        } else {
            $project = $this->projectModel->getById($id, $userId);
        }

        if (!$project) {
            echo "Projet non trouvé ou vous n'avez pas l'autorisation de mettre à jour ce projet.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];

            $this->projectModel->update($id, $name, $description, $start_date, $end_date);
            header("Location: /?route=projects&action=list");
            exit();
        }
        echo "Erreur lors de la mise à jour du projet.";
    }

    public function delete($id) {
        if (!is_logged_in()) {
            header("Location: /?route=auth&action=login");
            exit();
        }
        $userId = $_SESSION['user_id'];
        $project = null;

        if (has_role('ADMIN')) {
            $project = $this->projectModel->getById($id);
        } else {
            $project = $this->projectModel->getById($id, $userId);
        }

        if (!$project) {
            echo "Projet non trouvé ou vous n'avez pas l'autorisation de supprimer ce projet.";
            return;
        }

        $this->projectModel->delete($id);
        header("Location: /?route=projects&action=list");
        exit();
    }

    public function details($id) {
        if (!is_logged_in()) {
            header("Location: /?route=auth&action=login");
            exit();
        }
        $userId = $_SESSION['user_id'];
        $project = null;

        if (has_role('ADMIN')) {
            $project = $this->projectModel->getById($id);
        } else {
            $project = $this->projectModel->getById($id, $userId);
        }

        if ($project) {
            $tasks = $this->taskModel->getByProjectId($id);
            include '../views/projects/details.php';
            return;
        }
        echo "Projet non trouvé ou vous n'avez pas l'autorisation d'y accéder.";
    }
    
    public function markAsFinishedAction($id) {
        if (!is_logged_in()) {
            header("Location: /?route=auth&action=login");
            exit();
        }
        $userId = $_SESSION['user_id'];
        $project = null;

        if (has_role('ADMIN')) {
            $project = $this->projectModel->getById($id);
        } else {
            $project = $this->projectModel->getById($id, $userId);
        }

        if ($project) {
            $this->projectModel->markAsFinished($id);
            header("Location: /?route=projects&action=list");
            exit();
        } else {
            echo "Accès non autorisé ou projet non trouvé.";
        }
    }

    public function markAsOngoingAction($id) {
        if (!is_logged_in()) {
            header("Location: /?route=auth&action=login");
            exit();
        }
        $userId = $_SESSION['user_id'];
        $project = null;

        if (has_role('ADMIN')) {
            $project = $this->projectModel->getById($id);
        } else {
            $project = $this->projectModel->getById($id, $userId);
        }

        if ($project) {
            $this->projectModel->markAsOngoing($id);
            header("Location: /?route=projects&action=list");
            exit();
        } else {
            echo "Accès non autorisé ou projet non trouvé.";
        }
    }
}