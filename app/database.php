<?php

function connect_db() {
    $config = require 'config/database.php';
    try {
        $pdo = new PDO("mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8", $config['user'], $config['password']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }
}

function execute_query($pdo, $sql, $params = []) {
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    } catch (PDOException $e) {
        die("Erreur lors de l'exécution de la requête : " . $e->getMessage() . "<br>SQL: " . $sql);
    }
}

function fetch_one($pdo, $sql, $params = []) {
    $stmt = execute_query($pdo, $sql, $params);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function fetch_all($pdo, $sql, $params = []) {
    $stmt = execute_query($pdo, $sql, $params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function last_insert_id($pdo) {
    return $pdo->lastInsertId();
}