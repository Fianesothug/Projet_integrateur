<?php
session_start();

// Vérification de la session
if (!isset($_SESSION['statut'])) {
    header("Location: ../../components/protection.php");
    exit();
}

// Récupération de l'ID de l'agent connecté
$utilisateur_id_courant = $_SESSION['user_id'] ?? null;
if (!$utilisateur_id_courant) {
    $_SESSION['message'] = "Erreur: ID agent non trouvé en session";
    $_SESSION['success'] = false;
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}

// Vérification que la requête est en POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['message'] = "Méthode non autorisée";
    $_SESSION['success'] = false;
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}

// Récupération et validation des données du formulaire
$client_id = $_POST['id'] ?? null;
$nom = trim($_POST['nom'] ?? '');
$prenom = trim($_POST['prenom'] ?? '');
$email = trim($_POST['email'] ?? '');
$numero = trim($_POST['numero'] ?? '');

// Validation des données
if (empty($client_id) || empty($nom) || empty($prenom) || empty($email) || empty($numero)) {
    $_SESSION['message'] = "Tous les champs sont obligatoires";
    $_SESSION['success'] = false;
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}

// Validation de l'email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['message'] = "Format d'email invalide";
    $_SESSION['success'] = false;
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}

try {
    $connexion_db = new PDO("mysql:host=localhost;dbname=gestion", "root", "");
    $connexion_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Commencer une transaction
    $connexion_db->beginTransaction();
    
    // Vérifier que le client appartient bien à l'agent connecté
    $requete_verification = "SELECT c.id, c.id_personne 
                           FROM clients c 
                           WHERE c.id = :client_id AND c.id_agent = :utilisateur_id_courant";
    
    $preparation_verification = $connexion_db->prepare($requete_verification);
    $preparation_verification->execute([
        ':client_id' => $client_id,
        ':utilisateur_id_courant' => $utilisateur_id_courant
    ]);
    
    $client_data = $preparation_verification->fetch(PDO::FETCH_ASSOC);
    
    if (!$client_data) {
        throw new Exception("Client non trouvé ou accès non autorisé");
    }
    
    // Vérifier que l'email n'est pas déjà utilisé par une autre personne
    $requete_email_check = "SELECT id FROM personnes 
                           WHERE email = :email AND id != :id_personne";
    
    $preparation_email_check = $connexion_db->prepare($requete_email_check);
    $preparation_email_check->execute([
        ':email' => $email,
        ':id_personne' => $client_data['id_personne']
    ]);
    
    if ($preparation_email_check->fetch()) {
        throw new Exception("Cet email est déjà utilisé par une autre personne");
    }
    
    // 1. Mettre à jour les informations dans la table personnes (table principale)
    $requete_update_personne = "UPDATE personnes 
                               SET nom = :nom, prenom = :prenom, email = :email, numero = :numero 
                               WHERE id = :id_personne";
    
    $preparation_update_personne = $connexion_db->prepare($requete_update_personne);
    $preparation_update_personne->execute([
        ':nom' => $nom,
        ':prenom' => $prenom,
        ':email' => $email,
        ':numero' => $numero,
        ':id_personne' => $client_data['id_personne']
    ]);
    
    // 2. Mettre à jour les informations dans la table clients
    $requete_update_client = "UPDATE clients 
                             SET nom = :nom, prenom = :prenom, email = :email, numero = :numero
                             WHERE id = :client_id";
    
    $preparation_update_client = $connexion_db->prepare($requete_update_client);
    $preparation_update_client->execute([
        ':nom' => $nom,
        ':prenom' => $prenom,
        ':email' => $email,
        ':numero' => $numero,
        ':numero_propriete' => $numero_propriete,
        ':client_id' => $client_id
    ]);
    
    // 3. Mettre à jour dans la table agents si cette personne est aussi un agent
    $requete_update_agent = "UPDATE agents 
                            SET nom = :nom, prenom = :prenom, email = :email, numero = :numero 
                            WHERE id_personne = :id_personne";
    
    $preparation_update_agent = $connexion_db->prepare($requete_update_agent);
    $preparation_update_agent->execute([
        ':nom' => $nom,
        ':prenom' => $prenom,
        ':email' => $email,
        ':numero' => $numero,
        ':id_personne' => $client_data['id_personne']
    ]);
    
    // 4. Mettre à jour dans la table bailleurs si cette personne est aussi un bailleur
    $requete_update_bailleur = "UPDATE bailleurs 
                               SET nom = :nom, prenom = :prenom, email = :email, numero = :numero 
                               WHERE id_personne = :id_personne";
    
    $preparation_update_bailleur = $connexion_db->prepare($requete_update_bailleur);
    $preparation_update_bailleur->execute([
        ':nom' => $nom,
        ':prenom' => $prenom,
        ':email' => $email,
        ':numero' => $numero,
        ':id_personne' => $client_data['id_personne']
    ]);
    
    // 5. Mettre à jour dans la table managers si cette personne est aussi un manager
    $requete_update_manager = "UPDATE managers 
                              SET nom = :nom, prenom = :prenom, email = :email, numero = :numero 
                              WHERE id_personne = :id_personne";
    
    $preparation_update_manager = $connexion_db->prepare($requete_update_manager);
    $preparation_update_manager->execute([
        ':nom' => $nom,
        ':prenom' => $prenom,
        ':email' => $email,
        ':numero' => $numero,
        ':id_personne' => $client_data['id_personne']
    ]);
    
    // 6. Mettre à jour dans la table administrateurs si cette personne est aussi un administrateur
    $requete_update_admin = "UPDATE administrateurs 
                            SET nom = :nom, prenom = :prenom, email = :email, numero = :numero 
                            WHERE id_personne = :id_personne";
    
    $preparation_update_admin = $connexion_db->prepare($requete_update_admin);
    $preparation_update_admin->execute([
        ':nom' => $nom,
        ':prenom' => $prenom,
        ':email' => $email,
        ':numero' => $numero,
        ':id_personne' => $client_data['id_personne']
    ]);
    
    // Compter le nombre de lignes affectées dans toutes les tables
    $total_updates = $preparation_update_personne->rowCount() + 
                    $preparation_update_client->rowCount() + 
                    $preparation_update_agent->rowCount() + 
                    $preparation_update_bailleur->rowCount() + 
                    $preparation_update_manager->rowCount() + 
                    $preparation_update_admin->rowCount();
    
    // Valider la transaction
    $connexion_db->commit();
    
    $_SESSION['message'] = "Client mis à jour avec succès. $total_updates enregistrement(s) modifié(s) dans la base de données.";
    $_SESSION['success'] = true;
    
} catch (PDOException $erreur_db) {
    // Annuler la transaction en cas d'erreur
    if ($connexion_db->inTransaction()) {
        $connexion_db->rollBack();
    }
    
    $_SESSION['message'] = "Erreur de base de données: " . $erreur_db->getMessage();
    $_SESSION['success'] = false;
    
} catch (Exception $erreur_generale) {
    // Annuler la transaction en cas d'erreur
    if (isset($connexion_db) && $connexion_db->inTransaction()) {
        $connexion_db->rollBack();
    }
    
    $_SESSION['message'] = $erreur_generale->getMessage();
    $_SESSION['success'] = false;
}

// Redirection vers la page précédente
header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
?>