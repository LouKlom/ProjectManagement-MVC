<?php

class TaskController {
    private $pdo;
    private $taskModel;
    private $projectModel; // Pour vérifier l'existence du projet

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->taskModel = new Task($this->pdo);
        $this->projectModel = new Project($this->pdo);
    }

    public function list($projectId) {
        if (!$this->projectModel->getById($projectId)) {
            echo "Projet non trouvé.";
            return;
        }
        $tasks = $this->taskModel->getByProjectId($projectId);
        include '../views/tasks/list.php';
    }

    public function create($projectId) {
        if (!$this->projectModel->getById($projectId)) {
            echo "Projet non trouvé.";
            return;
        }
        // Ici, tu pourrais récupérer la liste des utilisateurs pour l'assignation
        include '../views/tasks/create.php';
    }

    public function store($data) {
        $projectId = $data['project_id'] ?? null;
        if (!$this->projectModel->getById($projectId)) {
            echo "Projet non trouvé.";
            return;
        }
    
        $title = $data['title'] ?? '';
        $description = $data['description'] ?? '';
        $dueDate = $data['due_date'] ?? null;
        $status = $data['status'] ?? 'à faire';
        $priority = $data['priority'] ?? null;
        $assignedTo = $data['assigned_to'] ?? null;
    
        if (empty($title)) {
            echo "Le titre de la tâche est obligatoire.";
            return;
        }
    
        // Gérer la valeur vide pour assigned_to
        $assignedTo = ($assignedTo === '') ? null : $assignedTo;
    
        $taskId = $this->taskModel->create($projectId, $title, $description, $dueDate, $status, $priority, $assignedTo);
        header("Location: /index.php?route=tasks&action=list&project_id=" . $projectId);
        exit();
    }

    public function edit($id) {
        $task = $this->taskModel->getById($id);
        if (!$task) {
            echo "Tâche non trouvée.";
            return;
        }
        // Ici, tu pourrais récupérer la liste des utilisateurs pour l'assignation
        include '../views/tasks/edit.php';
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $dueDate = $_POST['due_date'] ?? null;
            $status = $_POST['status'] ?? 'à faire';
            $priority = $_POST['priority'] ?? null;
            $assignedTo = $_POST['assigned_to'] ?? null;
    
            if (empty($title)) {
                echo "Le titre de la tâche est obligatoire.";
                return;
            }
    
            // Gérer la valeur vide pour assigned_to
            $assignedTo = ($assignedTo === '') ? null : $assignedTo;
    
            $this->taskModel->update($id, $title, $description, $dueDate, $status, $priority, $assignedTo);
            $task = $this->taskModel->getById($id);
            header("Location: /index.php?route=tasks&action=list&project_id=" . $task['project_id']);
            exit();
        }
    }

    public function delete($id) {
        $task = $this->taskModel->getById($id);
        if ($task) {
            $this->taskModel->delete($id);
            header("Location: /index.php?route=tasks&action=list&project_id=" . $task['project_id']);
            exit();
        }
        echo "Tâche non trouvée.";
    }
}