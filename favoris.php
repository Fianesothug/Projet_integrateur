<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit;
}

try {
    $pdo = new PDO("mysql:host=localhost;dbname=gestion", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("SELECT property_id FROM favoris WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $favorites = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo json_encode($favorites);
} catch(PDOException $e) {
    echo json_encode([]);
}