<?php
// supprimer_propriete.php
session_start();

// Vérification de l'accès
if (!isset($_SESSION['identifiant']) || !isset($_POST['id_propriete'])) {
    die(json_encode(['success' => false, 'message' => 'Accès non autorisé']));
}

// Connexion à la base de données
$host = 'localhost';
$dbname = 'gestion';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(['success' => false, 'message' => 'Erreur de connexion à la base de données']));
}

$id_propriete = (int)$_POST['id_propriete'];
$identifiant = $_SESSION['identifiant'];
$code_bailleur = $_SESSION['mot_de_passe'];

try {
    // Vérifier que la propriété appartient bien au bailleur
    $stmt = $pdo->prepare("SELECT id, images FROM proprietes WHERE id = :id AND identifiant = :identifiant AND code = :code");
    $stmt->bindParam(':id', $id_propriete, PDO::PARAM_INT);
    $stmt->bindParam(':identifiant', $identifiant);
    $stmt->bindParam(':code', $code_bailleur);
    $stmt->execute();
    
    $propriete = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($propriete) {
        // Supprimer les images associées
        if (!empty($propriete['images'])) {
            $images = explode(',', $propriete['images']);
            foreach ($images as $image) {
                $filePath = '../uploads/proprietes/' . $image;
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }

        // Supprimer la propriété
        $stmt = $pdo->prepare("DELETE FROM proprietes WHERE id = :id");
        $stmt->bindParam(':id', $id_propriete, PDO::PARAM_INT);
        $stmt->execute();

        echo json_encode(['success' => true, 'message' => 'Propriété supprimée avec succès']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Propriété non trouvée ou non autorisée']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur: ' . $e->getMessage()]);
}
?>