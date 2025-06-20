<?php
session_start();
header('Content-Type: application/json');

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['id']) || !is_numeric($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté']);
    exit();
}

$id_personne = intval($_SESSION['id']);
$action = $_POST['action'] ?? '';
$property_id = isset($_POST['property_id']) ? intval($_POST['property_id']) : 0;

if (!in_array($action, ['add', 'remove']) || $property_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Requête invalide']);
    exit();
}

try {
    $db = new PDO('mysql:host=localhost;dbname=gestion;charset=utf8', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($action === 'add') {
        // Vérifie si déjà en favori
        $stmt = $db->prepare("SELECT 1 FROM favoris WHERE id_personne = ? AND id_propriete = ?");
        $stmt->execute([$id_personne, $property_id]);

        if ($stmt->rowCount() === 0) {
            $insert = $db->prepare("INSERT INTO favoris (id_personne, id_propriete) VALUES (?, ?)");
            $insert->execute([$id_personne, $property_id]);
        }

        echo json_encode(['success' => true, 'message' => 'Ajouté aux favoris']);
    } elseif ($action === 'remove') {
        $delete = $db->prepare("DELETE FROM favoris WHERE id_personne = ? AND id_propriete = ?");
        $delete->execute([$id_personne, $property_id]);

        echo json_encode(['success' => true, 'message' => 'Retiré des favoris']);
    }
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Erreur de base de données : ' . $e->getMessage()
    ]);
}
