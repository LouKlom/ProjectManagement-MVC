<?php

class TaskController {
    private $pdo;
    private $taskModel;
    private $projectModel; 
    private $commentModel;


    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->taskModel = new Task($this->pdo);
        $this->projectModel = new Project($this->pdo);
        $this->commentModel = new Comment($this->pdo);
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


    public function addComment() {
        if (!is_logged_in()) {
            header("Location: /?route=auth&action=login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $taskId = isset($_POST['task_id']) ? intval($_POST['task_id']) : null;
            $userId = $_SESSION['user_id'];
            $content = $_POST['comment_content'] ?? '';

            if (empty($content) || !$taskId) {
                echo "Le contenu du commentaire et l'ID de la tâche sont obligatoires.";
                header("Location: /?route=tasks&action=details&id=" . $taskId);
                exit();
            }

            $task = $this->taskModel->getById($taskId);
            if (!$task) {
                echo "Tâche non trouvée.";
                header("Location: /?route=projects&action=list");
                exit();
            }

            $project = null;
            if (has_role('admin')) {
                $project = $this->projectModel->getById($task['project_id']);
            } else {
                $project = $this->projectModel->getById($task['project_id'], $userId);
            }

            if (!$project) {
                echo "Vous n'avez pas l'autorisation de commenter cette tâche.";
                header("Location: /?route=projects&action=list");
                exit();
            }

            $this->commentModel->createComment($taskId, $userId, $content);

            header("Location: /?route=tasks&action=details&id=" . $taskId);
            exit();
        }
        header("Location: /?route=projects&action=list");
        exit();
    }


    public function details($id) {
        if (!is_logged_in()) {
            header("Location: /?route=auth&action=login");
            exit();
        }

        $userId = $_SESSION['user_id'];
        $task = $this->taskModel->getById($id);

        if (!$task) {
            echo "Tâche non trouvée.";
            header("Location: /?route=projects&action=list");
            exit();
        }

        $project = null;
        if (has_role('admin')) {
            $project = $this->projectModel->getById($task['project_id']);
        } else {
            $project = $this->projectModel->getById($task['project_id'], $userId);
        }

        if (!$project) {
            echo "Vous n'avez pas l'autorisation d'accéder à cette tâche.";
            header("Location: /?route=projects&action=list");
            exit();
        }

        $comments = $this->commentModel->getCommentsByTaskId($id);

        include '../views/tasks/details.php'; 
    }




}