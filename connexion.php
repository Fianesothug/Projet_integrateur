<?php
session_start();

// Initialisation
$erreur = '';

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $dbname = 'gestion';

    $conn = new mysqli($host, $user, $password, $dbname);

    if ($conn->connect_error) {
        die("Erreur de connexion à la base de données : " . $conn->connect_error);
    }

    $identifiant = $_POST['identifiant'];
    $code = $_POST['code'];

    // Requête préparée pour éviter les injections SQL
    $stmt = $conn->prepare("SELECT * FROM client WHERE identifiant = ?");
    $stmt->bind_param("s", $identifiant);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if (password_verify($code, $row['code'])) {
            $_SESSION['identifiant'] = $row['identifiant'];
             $_SESSION['email'] = $row['email']; 
            header("Location: page_apres_connexion.php");
            exit();
        } else {
            $erreur = "Mot de passe incorrect.";
        }
    } else {
        $erreur = "Identifiant introuvable.";
    }

    $stmt->close();
    $conn->close();
}
?>
