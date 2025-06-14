<?php
// modifier_propriete.php
session_start();

// Vérification de l'accès
if (!isset($_SESSION['identifiant'])) {
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

// Traitement de la requête GET (récupération des données)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id_propriete = (int)$_GET['id'];
    $identifiant = $_SESSION['identifiant'];
    $code_bailleur = $_SESSION['mot_de_passe'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM proprietes WHERE id = :id AND identifiant = :identifiant AND code = :code");
        $stmt->bindParam(':id', $id_propriete, PDO::PARAM_INT);
        $stmt->bindParam(':identifiant', $identifiant);
        $stmt->bindParam(':code', $code_bailleur);
        $stmt->execute();
        
        $propriete = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($propriete) {
            echo json_encode(['success' => true, 'data' => $propriete]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Propriété non trouvée ou non autorisée']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Erreur: ' . $e->getMessage()]);
    }
    exit;
}

// Traitement de la requête POST (mise à jour)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_propriete'])) {
    $id_propriete = (int)$_POST['id_propriete'];
    $identifiant = $_SESSION['identifiant'];
    $code_bailleur = $_SESSION['mot_de_passe'];

    // Récupération et validation des données
    $data = [
        'type' => htmlspecialchars(stripslashes($_POST['type'] ?? '')),
        'utilisation' => htmlspecialchars(stripslashes($_POST['utilisation'] ?? '')),
        'option_propriete' => htmlspecialchars(stripslashes($_POST['option'] ?? '')),
        'adresse' => htmlspecialchars(stripslashes($_POST['adresse'] ?? '')),
        'ville' => htmlspecialchars(stripslashes($_POST['ville'] ?? '')),
        'taille' => (int)($_POST['taille'] ?? 0),
        'prix' => (float)($_POST['prix'] ?? 0.0),
        'description' => htmlspecialchars(stripslashes($_POST['description'] ?? ''))
    ];

    try {
        // Vérification que la propriété appartient bien au bailleur
        $stmt = $pdo->prepare("SELECT id FROM proprietes WHERE id = :id AND identifiant = :identifiant AND code = :code");
        $stmt->bindParam(':id', $id_propriete, PDO::PARAM_INT);
        $stmt->bindParam(':identifiant', $identifiant);
        $stmt->bindParam(':code', $code_bailleur);
        $stmt->execute();
        
        if ($stmt->fetch()) {
            // Mise à jour de la propriété
            $stmt = $pdo->prepare("UPDATE proprietes SET 
                type = :type, 
                utilisation = :utilisation, 
                option_propriete = :option_propriete, 
                adresse = :adresse, 
                ville = :ville, 
                taille = :taille, 
                prix = :prix, 
                description = :description 
                WHERE id = :id");

            $stmt->bindParam(':type', $data['type']);
            $stmt->bindParam(':utilisation', $data['utilisation']);
            $stmt->bindParam(':option_propriete', $data['option_propriete']);
            $stmt->bindParam(':adresse', $data['adresse']);
            $stmt->bindParam(':ville', $data['ville']);
            $stmt->bindParam(':taille', $data['taille'], PDO::PARAM_INT);
            $stmt->bindParam(':prix', $data['prix']);
            $stmt->bindParam(':description', $data['description']);
            $stmt->bindParam(':id', $id_propriete, PDO::PARAM_INT);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Propriété mise à jour avec succès']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Propriété non trouvée ou non autorisée']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Erreur: ' . $e->getMessage()]);
    }
    exit;
}
?>