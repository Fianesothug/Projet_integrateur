<?php

// Vérification de la session
if (!isset($_SESSION['statut'])) {
    header("Location: ../../components/protection.php");
    exit();
}

// Récupération de l'ID de l'agent connecté
$utilisateur_id_courant = $_SESSION['user_id'] ?? null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Clients</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="tableau.css">
</head>
<body>
    <div class="customer-wrapper">
        <!-- Section de filtrage -->
        <div class="customer-search-area">
            <h3 class="customer-heading"><i class="fas fa-filter"></i> Rechercher des clients</h3>
            <form method="get" action="" class="customer-search-form">
                <input type="text" name="search" placeholder="Rechercher par nom ou prénom" 
                       value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                <button type="submit" class="customer-search-button"><i class="fas fa-search"></i> Rechercher</button>
                <button type="button" class="customer-search-button" onclick="window.location.href=window.location.pathname">
                    <i class="fas fa-sync-alt"></i> Réinitialiser
                </button>
            </form>
        </div>

        <!-- Affichage des messages -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="customer-notification customer-notification-<?= $_SESSION['success'] ? 'success' : 'error' ?>">
                <?= htmlspecialchars($_SESSION['message']) ?>
            </div>
            <?php unset($_SESSION['message'], $_SESSION['success']); ?>
        <?php endif; ?>

        <!-- Tableau des clients -->
        <div id="customersDataTable">
            <?php
            try {
                // Connexion directe à la base de données
                $connexion_db = new PDO("mysql:host=localhost;dbname=gestion", "root", "");
                $connexion_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Récupération de la liste des agents
                $requete_agents = $connexion_db->query("SELECT id, nom, prenom FROM agents");
                $liste_agents = $requete_agents->fetchAll(PDO::FETCH_ASSOC);

                // Construction de la requête pour tous les clients
                $requete_sql = "SELECT c.*, p.nom, p.prenom, p.email, p.numero 
                          FROM clients c 
                          JOIN personnes p ON c.id_personne = p.id";

                $parametres_sql = [];

                // Ajout du filtre de recherche si présent
                if (!empty($_GET['search'])) {
                    $terme_recherche = '%' . trim($_GET['search']) . '%';
                    $requete_sql .= " WHERE (p.nom LIKE :terme_recherche OR p.prenom LIKE :terme_recherche)";
                    $parametres_sql[':terme_recherche'] = $terme_recherche;
                }

                $preparation_requete = $connexion_db->prepare($requete_sql);
                $preparation_requete->execute($parametres_sql);
                $liste_clients = $preparation_requete->fetchAll(PDO::FETCH_ASSOC);

                if (count($liste_clients) > 0) {
                    echo '<table class="customer-data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th>Propriété</th>
                                <th>Agent-attribuer</th>
                            </tr>
                        </thead>
                        <tbody>';

                    foreach ($liste_clients as $donnees_client) {
                        echo '<tr>
                            <td>'.htmlspecialchars($donnees_client['id']).'</td>
                            <td>'.htmlspecialchars($donnees_client['nom']).'</td>
                            <td>'.htmlspecialchars($donnees_client['prenom']).'</td>
                            <td>'.htmlspecialchars($donnees_client['email']).'</td>
                            <td>'.htmlspecialchars($donnees_client['numero']).'</td>
                            <td>'.htmlspecialchars($donnees_client['numero_propriete']).'</td>
                            <td>
                                <select id="agent_'.htmlspecialchars($donnees_client['id']).'" class="customer-select-agent">
                                    <option value="">-- Sélectionner --</option>';
                                    
                                    foreach ($liste_agents as $agent) {
                                        $selected = ($agent['id'] == $donnees_client['id_agent']) ? 'selected' : '';
                                        echo '<option value="'.htmlspecialchars($agent['id']).'" '.$selected.'>
                                            '.htmlspecialchars($agent['prenom'].' '.htmlspecialchars($agent['nom'])).'
                                        </option>';
                                    }
                                    
                        echo '</select>
                                <button class="customer-control-button customer-assign-button" 
                                        onclick="affecterAgent('.htmlspecialchars($donnees_client['id']).')">
                                    <i class="fas fa-user-check"></i> Affecter
                                </button>
                            </td>
                        </tr>';
                    }

                    echo '</tbody></table>';
                } else {
                    echo '<p>Aucun client trouvé'.(!empty($_GET['search']) ? ' pour la recherche "'.htmlspecialchars($_GET['search']).'"' : '').'</p>';
                }

            } catch (PDOException $erreur_db) {
                echo '<div class="customer-notification customer-notification-error">Erreur de connexion à la base de données: '.htmlspecialchars($erreur_db->getMessage()).'</div>';
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Fonction pour affecter un agent à un client
        function affecterAgent(client_id) {
            const selectElement = document.getElementById('agent_' + client_id);
            const nouvel_agent_id = selectElement.value;
            
            if (!nouvel_agent_id) {
                Swal.fire('Erreur', 'Veuillez sélectionner un agent', 'error');
                return;
            }

            Swal.fire({
                title: 'Confirmer l\'affectation',
                text: 'Êtes-vous sûr de vouloir affecter ce client à l\'agent sélectionné?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Oui, affecter',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Envoi de la requête AJAX pour mettre à jour l'agent
                    fetch('affecter_agent.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'client_id=' + client_id + '&agent_id=' + nouvel_agent_id
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Succès', 'Client affecté avec succès', 'success');
                        } else {
                            Swal.fire('Erreur', data.message || 'Erreur lors de l\'affectation', 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Erreur', 'Une erreur est survenue', 'error');
                        console.error('Error:', error);
                    });
                }
            });
        }

        // Confirmation de suppression
        function confirmRemoval(customer_id) {
            Swal.fire({
                title: 'Êtes-vous sûr?',
                text: "Vous ne pourrez pas annuler cette action!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Oui, supprimer!',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'delete_client.php?id=' + customer_id;
                }
            });
        }
    </script>
</body>
</html>