<?php
session_start();

// Vérification des données de session
if (!isset($_SESSION['chat_data'])) {
    header('Location: form.php');
    exit();
}

$statut1 = $_SESSION['chat_data']['statut1'];
$matricule1 = $_SESSION['chat_data']['matricule1'];
$statut2 = $_SESSION['chat_data']['statut2'];
$matricule2 = $_SESSION['chat_data']['matricule2'];

// Connexion à la base de données pour récupérer les informations des personnes
$host = 'localhost';
$dbname = 'gestion';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Récupération des informations des personnes
$stmt = $pdo->prepare("SELECT * FROM personnes WHERE matricule = ?");
$stmt->execute([$matricule1]);
$personne1 = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt->execute([$matricule2]);
$personne2 = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$personne1 || !$personne2) {
    header('Location: form.php');
    exit();
}

// Fonction pour formater le statut
function formatStatut($statut) {
    $statuts = [
        'bailleur' => 'Bailleur',
        'agent' => 'Agent',
        'client' => 'Client',
        'manager' => 'Manager',
        'administrateur' => 'Administrateur'
    ];
    return $statuts[$statut] ?? $statut;
}

// Fonction pour générer un nom de fichier unique pour une paire de matricules
function generateFilename($matricule1, $matricule2) {
    // On trie les matricules pour avoir toujours le même ordre
    $matricules = [$matricule1, $matricule2];
    sort($matricules);
    return $matricules[0] . '-' . $matricules[1];
}

// Fonction pour enregistrer un message dans le fichier
function saveMessage($filePath, $sender, $message, $isImage = false) {
    $timestamp = date('Y-m-d H:i:s');
    $data = [
        'timestamp' => $timestamp,
        'sender' => $sender,
        'message' => $message,
        'isImage' => $isImage,
        'id' => uniqid()
    ];
    
    $messages = [];
    if (file_exists($filePath)) {
        $content = file_get_contents($filePath);
        $messages = json_decode($content, true);
        if (!is_array($messages)) {
            $messages = [];
        }
    }
    
    $messages[] = $data;
    file_put_contents($filePath, json_encode($messages, JSON_PRETTY_PRINT));
    return $data;
}

// Fonction pour charger les messages depuis le fichier
function loadMessages($filePath) {
    if (!file_exists($filePath)) {
        return [];
    }
    
    $content = file_get_contents($filePath);
    $messages = json_decode($content, true);
    return is_array($messages) ? $messages : [];
}

// Traitement de l'envoi de message
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Créer le dossier histoire s'il n'existe pas
    if (!file_exists('histoire')) {
        mkdir('histoire', 0777, true);
    }
    
    // Créer le dossier images s'il n'existe pas
    if (!file_exists('images')) {
        mkdir('images', 0777, true);
    }
    
    // Générer un nom de fichier unique pour cette conversation
    $baseFilename = generateFilename($matricule1, $matricule2);
    $filePath = "histoire/" . $baseFilename . ".txt";
    
    $response = ['success' => false, 'message' => '', 'data' => null];
    
    if (isset($_POST['message']) && !empty(trim($_POST['message']))) {
        $message = trim($_POST['message']);
        $savedMessage = saveMessage($filePath, $matricule1, $message);
        $response = ['success' => true, 'message' => 'Message envoyé', 'data' => $savedMessage];
    } elseif (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Validation du type de fichier
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $fileType = $_FILES['image']['type'];
        
        if (!in_array($fileType, $allowedTypes)) {
            $response = ['success' => false, 'message' => 'Type de fichier non autorisé'];
        } elseif ($_FILES['image']['size'] > 5 * 1024 * 1024) { // 5MB max
            $response = ['success' => false, 'message' => 'Fichier trop volumineux (max 5MB)'];
        } else {
            // Traitement de l'image
            $imageCount = count(glob("images/" . $baseFilename . "-*.*"));
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $imageName = $baseFilename . "-" . ($imageCount + 1) . "." . $extension;
            $imagePath = "images/" . $imageName;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                $savedMessage = saveMessage($filePath, $matricule1, $imagePath, true);
                $response = ['success' => true, 'message' => 'Image envoyée', 'data' => $savedMessage];
            } else {
                $response = ['success' => false, 'message' => 'Erreur lors de l\'upload'];
            }
        }
    } else {
        $response = ['success' => false, 'message' => 'Aucun contenu à envoyer'];
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

// Charger les messages existants
$baseFilename = generateFilename($matricule1, $matricule2);
$filePath = "histoire/" . $baseFilename . ".txt";
$messages = loadMessages($filePath);

// Si c'est une requête AJAX pour rafraîchir les messages
if (isset($_GET['refresh'])) {
    $lastId = $_GET['last_id'] ?? '';
    
    // Filtrer les messages après le dernier ID connu
    $newMessages = [];
    $foundLastId = empty($lastId);
    
    foreach ($messages as $msg) {
        if ($foundLastId) {
            $newMessages[] = $msg;
        } elseif (isset($msg['id']) && $msg['id'] === $lastId) {
            $foundLastId = true;
        }
    }
    
    header('Content-Type: application/json');
    echo json_encode($newMessages);
    exit();
}
?>
