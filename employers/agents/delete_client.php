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

// Récupération de l'ID du client à supprimer
$client_id = $_GET['id'] ?? null;

if (empty($client_id) || !is_numeric($client_id)) {
    $_SESSION['message'] = "ID client invalide";
    $_SESSION['success'] = false;
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}

try {
    $connexion_db = new PDO("mysql:host=localhost;dbname=gestion", "root", "");
    $connexion_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Commencer une transaction
    $connexion_db->beginTransaction();
    
    // Vérifier que le client appartient bien à l'agent connecté et récupérer les informations nécessaires
    $requete_verification = "SELECT c.id, c.id_personne, c.numero_propriete, p.nom, p.prenom 
                           FROM clients c 
                           JOIN personnes p ON c.id_personne = p.id
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
    
    // Mettre à jour le statut de la propriété à "disponible" si une propriété est associée
    if (!empty($client_data['numero_propriete'])) {
        $requete_update_propriete = "UPDATE proprietes SET statut = 'disponible' WHERE id = :numero_propriete";
        $preparation_update_propriete = $connexion_db->prepare($requete_update_propriete);
        $preparation_update_propriete->execute([':numero_propriete' => $client_data['numero_propriete']]);
        
        // Vérifier si la mise à jour a été effectuée
        if ($preparation_update_propriete->rowCount() == 0) {
            // Optionnel: log ou traiter le cas où la propriété n'existe pas
            error_log("Attention: Propriété avec ID " . $client_data['numero_propriete'] . " non trouvée lors de la mise à jour du statut");
        }
    }
    
    
    // Supprimer le client
    $requete_delete_client = "DELETE FROM clients WHERE id = :client_id";
    $preparation_delete_client = $connexion_db->prepare($requete_delete_client);
    $preparation_delete_client->execute([':client_id' => $client_id]);
    
    // Vérifier si la personne est utilisée ailleurs (par exemple, comme agent)
    $requete_check_personne = "SELECT COUNT(*) as count FROM agents WHERE id_personne = :id_personne";
    $preparation_check_personne = $connexion_db->prepare($requete_check_personne);
    $preparation_check_personne->execute([':id_personne' => $client_data['id_personne']]);
    $personne_usage = $preparation_check_personne->fetch(PDO::FETCH_ASSOC);
    
    // Si la personne n'est utilisée nulle part ailleurs, la supprimer aussi
    if ($personne_usage['count'] == 0) {
        $requete_delete_personne = "DELETE FROM personnes WHERE id = :id_personne";
        $preparation_delete_personne = $connexion_db->prepare($requete_delete_personne);
        $preparation_delete_personne->execute([':id_personne' => $client_data['id_personne']]);
    }
    
    // Valider la transaction
    $connexion_db->commit();
    
    $message_propriete = !empty($client_data['numero_propriete']) ? " et propriété remise à disponible" : "";
    $_SESSION['message'] = "Client " . htmlspecialchars($client_data['prenom'] . " " . $client_data['nom']) . " supprimé avec succès" . $message_propriete;
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