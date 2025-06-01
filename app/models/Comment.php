<?php

class Comment {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createComment($taskId, $userId, $content) {
        $sql = "INSERT INTO comments (task_id, user_id, content) VALUES (:task_id, :user_id, :content)";
        execute_query($this->pdo, $sql, [
            'task_id' => $taskId,
            'user_id' => $userId,
            'content' => $content
        ]);
        return last_insert_id($this->pdo);
    }


    public function getCommentsByTaskId($taskId) {
        $sql = "
            SELECT
                c.id,
                c.content,
                c.created_at,
                u.username
            FROM
                comments c
            JOIN
                users u ON c.user_id = u.id
            WHERE
                c.task_id = :task_id
            ORDER BY
                c.created_at ASC";
        return fetch_all($this->pdo, $sql, ['task_id' => $taskId]);
    }

    // Not implemented yet
    public function deleteComment($commentId) {
        $sql = "DELETE FROM comments WHERE id = :id";
        execute_query($this->pdo, $sql, ['id' => $commentId]);
        return true;
    }
}