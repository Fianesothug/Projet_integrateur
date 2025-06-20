<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['identifiant'])) {
    echo json_encode(['success' => false, 'message' => 'Non connecté']);
    exit;
}

require_once('../includes/connexion.php');

$data = json_decode(file_get_contents('php://input'), true);
$propertyId = intval($data['property_id']);
$clientId = $_SESSION['identifiant'];

try {
    // Vérifie si le favori existe déjà
    $stmt = $conn->prepare("SELECT id FROM favoris WHERE client_id = ? AND property_id = ?");
    $stmt->bind_param("si", $clientId, $propertyId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Supprimer le favori
        $stmt = $conn->prepare("DELETE FROM favoris WHERE client_id = ? AND property_id = ?");
        $stmt->bind_param("si", $clientId, $propertyId);
        $stmt->execute();
        echo json_encode(['success' => true, 'message' => 'Supprimé des favoris', 'is_favorite' => false]);
    } else {
        // Ajouter le favori
        $stmt = $conn->prepare("INSERT INTO favoris (client_id, property_id) VALUES (?, ?)");
        $stmt->bind_param("si", $clientId, $propertyId);
        $stmt->execute();
        echo json_encode(['success' => true, 'message' => 'Ajouté aux favoris', 'is_favorite' => true]);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur: ' . $e->getMessage()]);
}
?>