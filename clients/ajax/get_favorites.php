<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['identifiant'])) {
    echo json_encode([]);
    exit;
}

require_once('../includes/connexion.php');

$clientId = $_SESSION['identifiant'];
$favorites = [];

$stmt = $conn->prepare("SELECT property_id FROM favoris WHERE client_id = ?");
$stmt->bind_param("s", $clientId);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $favorites[] = $row['property_id'];
}

echo json_encode($favorites);
?>