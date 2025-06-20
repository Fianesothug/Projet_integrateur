<?php
session_start();

// Initialisation du message d'erreur
$erreur = '';

// Vérifie si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Informations de connexion à la base de données
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $dbname = 'gestion';

    // Connexion à MySQL
    $conn = new mysqli($host, $user, $password, $dbname);

    // Vérification de la connexion
    if ($conn->connect_error) {
        die("Erreur de connexion à la base de données : " . $conn->connect_error);
    }

    // Récupération des données du formulaire
    $identifiant = trim($_POST['identifiant'] ?? '');
    $code = trim($_POST['code'] ?? '');

    // Vérifie que les champs ne sont pas vides
    if (!empty($identifiant) && !empty($code)) {
        // Requête préparée pour sécuriser contre les injections SQL
        $stmt = $conn->prepare("SELECT * FROM personnes WHERE identifiant = ? AND code = ?");
        if ($stmt) {
            $stmt->bind_param("ss", $identifiant, $code);
            $stmt->execute();
            $result = $stmt->get_result();

            // Vérifie si un utilisateur correspondant a été trouvé
            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();

                // Connexion réussie : enregistrement de la session
                $_SESSION['identifiant'] = $row['identifiant'];
                $_SESSION['statut'] = 'personnes'; // Ajout du statut pour savoir quelle table utiliser
                $_SESSION['nom'] = $row['nom']; // Stockage du nom en session
                $_SESSION['prenom'] = $row['prenom']; // Stockage du prénom en session

                header("Location: clients/tableau-bord.php");
                exit();
            } else {
                $erreur = "Identifiant ou code incorrect.";
            }

            $stmt->close();
        } else {
            $erreur = "Erreur lors de la préparation de la requête.";
        }
    } else {
        $erreur = "Veuillez remplir tous les champs.";
    }

    $conn->close();
}
?>