<?php
session_start();

header('Content-Type: application/json');

// Connexion à la base de données
$host = 'localhost';
$dbname = 'gestion'; // remplace par le nom réel de ta base
$username = 'root';         // ou ton identifiant MySQL
$password = '';             // ou ton mot de passe MySQL

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Connexion échouée : ' . $e->getMessage()]);
    exit;
}

if (!isset($_SESSION['identifiant']) || !isset($_SESSION['mot_de_passe'])) {
    echo json_encode(['success' => false, 'message' => 'Non autorisé']);
    exit;
}

if (!isset($_POST['id_propriete']) || empty($_POST['id_propriete'])) {
    echo json_encode(['success' => false, 'message' => 'ID propriété manquant']);
    exit;
}

$id_propriete = $_POST['id_propriete'];
$identifiant = $_SESSION['identifiant'];
$code_bailleur = $_SESSION['mot_de_passe'];

try {
    // Vérifier que la propriété appartient bien au bailleur
    $stmt = $pdo->prepare("SELECT id FROM proprietes WHERE id = :id AND identifiant = :identifiant AND code = :code");
    $stmt->bindParam(':id', $id_propriete);
    $stmt->bindParam(':identifiant', $identifiant);
    $stmt->bindParam(':code', $code_bailleur);
    $stmt->execute();
    
    if ($stmt->rowCount() === 0) {
        echo json_encode(['success' => false, 'message' => 'Propriété non trouvée ou non autorisée']);
        exit;
    }
    
    // Mettre à jour le statut
    $update = $pdo->prepare("UPDATE proprietes SET statut = 'disponible' WHERE id = :id");
    $update->bindParam(':id', $id_propriete);
    $update->execute();
    
    echo json_encode(['success' => true, 'message' => 'Réservation annulée avec succès']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur de base de données: ' . $e->getMessage()]);
}
?>
