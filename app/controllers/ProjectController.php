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
        $projects = $this->projectModel->getAll();
        include '../views/projects/list.php';
    }

    public function create() {
        include '../views/projects/create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];

            if (empty($name)) {
                echo "Le nom du projet est obligatoire.";
                return;
            }

            $projectId = $this->projectModel->create($name, $description, $start_date, $end_date);
            header("Location: /public/index.php?route=projects&action=list");
            exit();
        } else {
            header("Location: /public/index.php?route=projects&action=list");
            exit();
        }
    }

    public function edit($id) {
        if ($id) {
            $project = $this->projectModel->getById($id);
            if ($project) {
                include '../views/projects/edit.php';
                return;
            }
        }
        echo "Projet non trouvé.";
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id) {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];

            $this->projectModel->update($id, $name, $description, $start_date, $end_date);
            header("Location: /public/index.php?route=projects&action=list");
            exit();
        }
        echo "Erreur lors de la mise à jour du projet.";
    }

    public function delete($id) {
        if ($id) {
            $this->projectModel->delete($id);
            header("Location: /public/index.php?route=projects&action=list");
            exit();
        }
        echo "Projet non trouvé.";
    }

    public function details($id) {
        if ($id) {
            $project = $this->projectModel->getById($id);
            if ($project) {
                // Récupérer les tâches associées à ce projet
                $tasks = $this->taskModel->getByProjectId($id);
                include '../views/projects/details.php';
                return;
            }
        }
        echo "Projet non trouvé.";
    }
}