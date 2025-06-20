<?php
// Vérification de la session
if (!isset($_SESSION['statut'])) {
    header("Location: ../../components/protection.php");
    exit();
}

// Récupération de l'ID de l'agent connecté
$utilisateur_id_courant = $_SESSION['user_id'] ?? null;
if (!$utilisateur_id_courant) {
    die("Erreur: ID agent non trouvé en session");
}
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
                $connexion_db = new PDO("mysql:host=localhost;dbname=gestion", "root", "");
                $connexion_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Construction de la requête avec filtre par utilisateur_id_courant
                $requete_sql = "SELECT c.*, p.nom, p.prenom, p.email, p.numero 
                          FROM clients c 
                          JOIN personnes p ON c.id_personne = p.id
                          WHERE c.id_agent = :utilisateur_id_courant";

                $parametres_sql = [':utilisateur_id_courant' => $utilisateur_id_courant];

                // Ajout du filtre de recherche si présent
                if (!empty($_GET['search'])) {
                    $terme_recherche = '%' . trim($_GET['search']) . '%';
                    $requete_sql .= " AND (p.nom LIKE :terme_recherche OR p.prenom LIKE :terme_recherche)";
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
                                <th>Actions</th>
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
                                <button class="customer-control-button customer-modify-button" onclick="displayModifyForm('.htmlspecialchars(json_encode($donnees_client)).')">
                                    <i class="fas fa-edit"></i> Modifier
                                </button>
                                <button class="customer-control-button customer-remove-button" onclick="confirmRemoval('.htmlspecialchars($donnees_client['id']).')">
                                    <i class="fas fa-trash"></i> Supprimer
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

        <!-- Formulaire de modification -->
        <div id="modifyFormContainer" class="customer-modify-form">
            <h2 class="customer-heading"><i class="fas fa-edit"></i> Modifier le client</h2>
            <form id="modifyForm" method="post" action="update_client.php">
                <input type="hidden" name="id" id="modify_id">
                
                <div class="customer-input-group">
                    <label for="modify_nom" class="customer-input-label">Nom:</label>
                    <input type="text" id="modify_nom" name="nom" class="customer-input-field" required>
                </div>
                
                <div class="customer-input-group">
                    <label for="modify_prenom" class="customer-input-label">Prénom:</label>
                    <input type="text" id="modify_prenom" name="prenom" class="customer-input-field" required>
                </div>
                
                <div class="customer-input-group">
                    <label for="modify_email" class="customer-input-label">Email:</label>
                    <input type="email" id="modify_email" name="email" class="customer-input-field" required>
                </div>
                
                <div class="customer-input-group">
                    <label for="modify_numero" class="customer-input-label">Téléphone:</label>
                    <input type="text" id="modify_numero" name="numero" class="customer-input-field" required>
                </div>
                
                <div class="customer-form-controls">
                    <button type="button" class="customer-control-button customer-remove-button" onclick="hideModifyForm()">
                        <i class="fas fa-times"></i> Annuler
                    </button>
                    <button type="submit" class="customer-control-button customer-modify-button">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Afficher le formulaire de modification
        function displayModifyForm(donnees_client) {
            document.getElementById('modify_id').value = donnees_client.id;
            document.getElementById('modify_nom').value = donnees_client.nom;
            document.getElementById('modify_prenom').value = donnees_client.prenom;
            document.getElementById('modify_email').value = donnees_client.email;
            document.getElementById('modify_numero').value = donnees_client.numero;
             
            document.getElementById('modifyFormContainer').style.display = 'block';
            document.getElementById('modifyFormContainer').scrollIntoView({ behavior: 'smooth' });
        }

        // Masquer le formulaire de modification
        function hideModifyForm() {
            document.getElementById('modifyFormContainer').style.display = 'none';
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