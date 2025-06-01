<?php

class ActivityLog {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    

    public function logActivity($userId, $actionType, $description, $entityType = null, $entityId = null) {
        $ipAddress = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'UNKNOWN';

        $sql = "INSERT INTO activity_logs (user_id, action_type, description, entity_type, entity_id, ip_address, user_agent)
                VALUES (:user_id, :action_type, :description, :entity_type, :entity_id, :ip_address, :user_agent)";

        execute_query($this->pdo, $sql, [
            'user_id'     => $userId,
            'action_type' => $actionType,
            'description' => $description,
            'entity_type' => $entityType,
            'entity_id'   => $entityId,
            'ip_address'  => $ipAddress,
            'user_agent'  => $userAgent
        ]);
    }


    public function getAllLogs($limit = 50, $offset = 0) {
        $limit = (int) $limit;
        $offset = (int) $offset;

        $sql = "
            SELECT
                al.id,
                al.action_type,
                al.description,
                al.entity_type,
                al.entity_id,
                al.ip_address,
                al.created_at,
                u.username AS user_username
            FROM
                activity_logs al
            LEFT JOIN
                users u ON al.user_id = u.id
            ORDER BY
                al.created_at DESC
            LIMIT " . $limit . " OFFSET " . $offset;

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(); 
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur lors de l'exécution de la requête : " . $e->getMessage() . "<br>SQL: " . $sql);
        }
    }


    public function countAllLogs() {
        $sql = "SELECT COUNT(*) FROM activity_logs";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchColumn();
    }

}