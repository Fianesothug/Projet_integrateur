<?php
session_start();

// Connexion à la base de données
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

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $statut1 = $_POST['statut1'] ?? '';
    $matricule1 = trim($_POST['matricule1'] ?? '');
    $identifiant = trim($_POST['identifiant'] ?? '');
    $code = trim($_POST['code'] ?? '');
    $statut2 = $_POST['statut2'] ?? '';
    $matricule2 = trim($_POST['matricule2'] ?? '');

    // Vérification des champs vides
    if (empty($statut1) || empty($matricule1) || empty($identifiant) || empty($code) || empty($statut2) || empty($matricule2)) {
        $error = "Tous les champs sont obligatoires";
    } 
    // Vérification des matricules identiques
    elseif ($matricule1 === $matricule2) {
        $error = "Les matricules doivent être différents";
    } else {
        // Vérification de l'existence des matricules dans la table personnes
        $stmt = $pdo->prepare("SELECT id FROM personnes WHERE matricule = ?");
        $stmt->execute([$matricule1]);
        $personne1 = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $stmt->execute([$matricule2]);
        $personne2 = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$personne1 || !$personne2) {
            $error = "Un des matricules n'existe pas";
        } else {
            // Vérification dans les tables spécifiques
            $tables = [
                'bailleur' => 'bailleurs',
                'agent' => 'agents',
                'client' => 'personnes',
                'manager' => 'managers',
                'administrateur' => 'administrateurs'
            ];

            $table1 = $tables[$statut1] ?? null;
            $table2 = $tables[$statut2] ?? null;

            if (!$table1 || !$table2) {
                $error = "Statut invalide";
            } else {
                // Vérification pour l'utilisateur 1 (avec identifiant et code)
                $stmt = $pdo->prepare("SELECT id FROM $table1 WHERE id_personne = ? AND identifiant = ? AND code = ?");
                $stmt->execute([$personne1['id'], $identifiant, $code]);
                $user1 = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$user1) {
                    $error = "Identifiant ou code incorrect pour l'utilisateur 1";
                } else {
                    // Vérification pour l'utilisateur 2
                    $stmt = $pdo->prepare("SELECT id FROM $table2 WHERE id_personne = ?");
                    $stmt->execute([$personne2['id']]);
                    $user2 = $stmt->fetch(PDO::FETCH_ASSOC);

                    if (!$user2) {
                        $error = "L'utilisateur 2 n'existe pas dans la table correspondante";
                    } else {
                        // Tout est valide, on redirige vers le chat
                        $_SESSION['chat_data'] = [
                            'statut1' => $statut1,
                            'matricule1' => $matricule1,
                            'statut2' => $statut2,
                            'matricule2' => $matricule2,
                            'identifiant' => $identifiant
                        ];
                        header('Location: chat.php');
                        exit();
                    }
                }
            }
        }
    }
}
?>