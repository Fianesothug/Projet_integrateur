<?php
// protection.php
session_start(); // Démarre la session

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['identifiant']) || !isset($_SESSION['statut'])) {
    // Redirection vers la page de connexion
    header("Location: protection.php?error=1");
    exit();
}

// Facultatif : gestion du délai d’inactivité (ex : 30 min)
$inactivity_limit = 1800; // 1800 secondes = 30 minutes
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $inactivity_limit)) {
    session_unset(); // Supprime toutes les variables de session
    session_destroy(); // Détruit la session
    header("Location: protection.php?timeout=1");
    exit();
}
$_SESSION['last_activity'] = time(); // Mise à jour de l'activité
?>
