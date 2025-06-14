<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['statut']) || !isset($_SESSION['identifiant'])) {
    header("Location: ../components/protection.php");
    exit();
}

// Dossier autorisé pour le statut actuel
$statut = $_SESSION['statut'];
$dossierActuel = basename(dirname($_SERVER['SCRIPT_FILENAME'])); // ex: bailleurs, clients, agence

// Correspondance entre statut et dossier
$correspondances = [
    'bailleurs' => 'bailleurs',
    'clients' => 'clients',
    'agents' => 'agents',
    'managers' => 'managers',
    'administrateurs' => 'agence'
];

// Vérifie que l'utilisateur accède bien à son espace
if (!isset($correspondances[$statut]) || $correspondances[$statut] !== $dossierActuel) {
    // Déconnecter l'utilisateur automatiquement s’il tente d'accéder à un autre espace
    session_unset();
    session_destroy();
    header("Location: ../components/protection.php");
    exit();
}
?>

 