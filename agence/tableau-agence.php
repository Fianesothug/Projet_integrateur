<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Utilisateurs - Suppression avec Filtre</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .filtre .bout:hover {
            background-color: #0056b3; 
        }
        .filtre .bout {
            background-color: #007bff; 
            color: white;           
            border: none;           
            padding: 10px 20px;     
            font-size: 16px;        
            font-weight: bold;      
            border-radius: 8px;      
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); 
            transition: background-color 0.3s ease;
        }
        .filtre select, .filtre input[type="text"] {
            font: 1em sans-serif;
            font-size: 1.3rem;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        .filter-section {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

    </style>
</head>
<body>
    <div class="container">      
        <!-- Section de filtrage -->
        <div class="filter-section">
            <h3><i class="fas fa-filter"></i> Filtrer le personnels</h3>
            <br>
            <form method="get" action="" class="filtre">
                <div class="form-group">
                    <label for="search_term">Recherche par nom/prénom:</label>
                    <input type="text" name="search_term" id="search_term" placeholder="Entrez un nom ou prénom..." value="<?php echo isset($_GET['search_term']) ? htmlspecialchars($_GET['search_term']) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="status_filter">Filtrer par statut:</label>
                    <select name="status_filter" id="status_filter">
                        <option value="">Tous les statuts</option>
                        <option value="Agent" <?php echo (isset($_GET['status_filter']) && $_GET['status_filter'] == 'Agent') ? 'selected' : ''; ?>>Agent</option>
                        <option value="Manager" <?php echo (isset($_GET['status_filter']) && $_GET['status_filter'] == 'Manager') ? 'selected' : ''; ?>>Manager</option>
                        <option value="Bailleur" <?php echo (isset($_GET['status_filter']) && $_GET['status_filter'] == 'Bailleur') ? 'selected' : ''; ?>>Bailleur</option>
                        <option value="Administrateur" <?php echo (isset($_GET['status_filter']) && $_GET['status_filter'] == 'Administrateur') ? 'selected' : ''; ?>>Administrateur</option>
                        <option value="Client" <?php echo (isset($_GET['status_filter']) && $_GET['status_filter'] == 'Client') ? 'selected' : ''; ?>>Client</option>
                    </select>
                </div>
                
                <button type="submit" class="bout">Filtrer</button>
                <button class="bout" type="button" onclick="window.location.href=window.location.pathname">Réinitialiser</button>
            </form>
        </div>
        <br>

        <!-- Formulaire de modification -->
        <section id="edit">.</section>
        <br>
        <div id="editFormContainer" class="edit-form">
            <h2><i class="fas fa-edit"></i> Modifier le personnels</h2>
            <form id="editForm" method="post">
                <input type="hidden" name="id" id="edit_id">
                <input type="hidden" name="update" value="1">
                
                <div class="form-group">
                    <label for="edit_nom">Nom:</label>
                    <input type="text" id="edit_nom" name="nom" required>
                </div>
                
                <div class="form-group">
                    <label for="edit_prenom">Prénom:</label>
                    <input type="text" id="edit_prenom" name="prenom" required>
                </div>
                
                <div class="form-group">
                    <label for="edit_sexe">Sexe:</label>
                    <select id="edit_sexe" name="sexe" required>
                        <option value="Masculin">Masculin</option>
                        <option value="feminin">Féminin</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="edit_pays">Code pays:</label>
                    <input type="text" id="edit_pays" name="pays" required>
                </div>
                
                <div class="form-group">
                    <label for="edit_numero">Numéro:</label>
                    <input type="text" id="edit_numero" name="numero" required>
                </div>
                
                <div class="form-group">
                    <label for="edit_email">Email:</label>
                    <input type="email" id="edit_email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="edit_adresse">Adresse:</label>
                    <input type="text" id="edit_adresse" name="adresse" required>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="cancel-btn" onclick="hideEditForm()">
                        <i class="fas fa-times"></i> Annuler
                    </button>
                    <button type="submit" class="update-btn">
                        <i class="fas fa-save"></i> Mettre à jour
                    </button>
                </div>
            </form>
        </div>

        <!-- Tableau des utilisateurs sera inséré ici par PHP -->
        <div id="usersTable">
            <!-- Contenu généré par PHP -->
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        /**
         * Fonction améliorée de confirmation de suppression avec options détaillées
         */
        function confirmDelete(id, nom, prenom, roles) {
            // Vérifier que les paramètres sont valides
            if (!id || !roles) {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: 'Informations utilisateur manquantes pour la suppression.'
                });
                return;
            }

            // Préparer les informations utilisateur
            const userName = `${prenom} ${nom}`;
            const rolesArray = roles.split(',').map(role => role.trim());
            
            // Créer les options de suppression de manière dynamique
            const deleteOptions = {};
            
            // Option 1: Suppression complète
            deleteOptions['complete'] = '🗑️ Suppression complète (toutes les tables)';
            
            // Option 3: Suppression par rôle spécifique
            rolesArray.forEach(role => {
                const cleanRole = role.trim();
                if (cleanRole) {
                    deleteOptions[cleanRole] = `🏷️ Supprimer du rôle "${cleanRole}" uniquement`;
                }
            });

            // Afficher la boîte de dialogue avec les options
            Swal.fire({
                title: '⚠️ Confirmation de suppression',
                html: `
                    <div class="alert alert-warning">
                        <strong>Utilisateur:</strong> ${userName}<br>
                        <strong>Rôles actuels:</strong> ${roles}<br>
                        <strong>ID:</strong> ${id}
                    </div>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> 
                        Choisissez le type de suppression à effectuer:
                    </div>
                `,
                input: 'select',
                inputOptions: deleteOptions,
                inputPlaceholder: 'Sélectionnez une option de suppression...',
                showCancelButton: true,
                confirmButtonText: '<i class="fas fa-trash"></i> Confirmer la suppression',
                cancelButtonText: '<i class="fas fa-times"></i> Annuler',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                width: '600px',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Vous devez sélectionner une option de suppression!';
                    }
                },
                preConfirm: (selectedOption) => {
                    // Validation supplémentaire avant confirmation
                    return new Promise((resolve) => {
                        let confirmationMessage = '';
                        
                        switch(selectedOption) {
                            case 'complete':
                                confirmationMessage = 'Êtes-vous sûr de vouloir supprimer COMPLÈTEMENT cet utilisateur de toutes les tables? Cette action est IRRÉVERSIBLE!';
                                break;
                            case 'personnes':
                                confirmationMessage = 'Supprimer seulement de la table personnes? Les données de rôles seront conservées.';
                                break;
                            default:
                                confirmationMessage = `Supprimer l'utilisateur du rôle "${selectedOption}" uniquement?`;
                        }
                        
                        Swal.fire({
                            title: 'Confirmation finale',
                            text: confirmationMessage,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Oui, supprimer',
                            cancelButtonText: 'Non, annuler',
                            confirmButtonColor: '#d33'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                resolve(selectedOption);
                            } else {
                                resolve(false);
                            }
                        });
                    });
                }
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    const selectedOption = result.value;
                    
                    // Construire l'URL de suppression selon l'option choisie
                    let deleteUrl = `${window.location.pathname}?delete_id=${id}`;
                    
                    // Ajouter le paramètre de table selon l'option
                    if (selectedOption === 'complete') {
                        deleteUrl += '&table=all';
                    } else if (selectedOption === 'personnes') {
                        deleteUrl += '&table=personnes';
                    } else {
                        // C'est un rôle spécifique
                        deleteUrl += `&table=${encodeURIComponent(selectedOption)}`;
                    }
                    
                    // Afficher un message de traitement
                    Swal.fire({
                        title: 'Suppression en cours...',
                        text: 'Veuillez patienter',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Redirection vers l'URL de suppression
                    window.location.href = deleteUrl;
                }
            });
        }

        /**
         * Afficher le formulaire de modification
         */
        function showEditForm(user) {
            document.getElementById('edit_id').value = user.id;
            document.getElementById('edit_nom').value = user.nom;
            document.getElementById('edit_prenom').value = user.prenom;
            document.getElementById('edit_sexe').value = user.sexe;
            document.getElementById('edit_pays').value = user.pays;
            document.getElementById('edit_numero').value = user.numero;
            document.getElementById('edit_email').value = user.email;
            document.getElementById('edit_adresse').value = user.adresse;
            
            document.getElementById('editFormContainer').style.display = 'block';
            document.getElementById('editFormContainer').scrollIntoView({ behavior: 'smooth' });
        }

        /**
         * Masquer le formulaire de modification
         */
        function hideEditForm() {
            document.getElementById('editFormContainer').style.display = 'none';
        }

        /**
         * Initialisation de la page
         */
        document.addEventListener('DOMContentLoaded', function() {
            // Maintenir la valeur du filtre après soumission
            const urlParams = new URLSearchParams(window.location.search);
            const statusFilter = urlParams.get('status_filter');
            const searchTerm = urlParams.get('search_term');
            
            if (statusFilter) {
                document.getElementById('status_filter').value = statusFilter;
            }
            if (searchTerm) {
                document.getElementById('search_term').value = searchTerm;
            }
        });
    </script>

    <?php
    // Connexion à la base de données
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=gestion", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Traitement de la suppression avec gestion améliorée
        if (isset($_GET['delete_id'])) {
            $delete_id = (int)$_GET['delete_id'];
            $table_to_delete = isset($_GET['table']) ? $_GET['table'] : null;
            
            // Validation de l'ID
            if ($delete_id <= 0) {
                echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: 'ID utilisateur invalide'
                    }).then(() => {
                        window.location.href = window.location.pathname;
                    });
                </script>";
                exit;
            }
            
            try {
                $pdo->beginTransaction();
                
                // Mapping des rôles vers les tables
                $role_tables = [
                    'Agent' => 'agents',
                    'Manager' => 'managers',
                    'Bailleur' => 'bailleurs',
                    'Administrateur' => 'administrateurs',
                    'Client' => 'clients'
                ];
                
                $message = '';
                $success = false;
                
                // Vérifier d'abord que l'utilisateur existe
                $check_user = $pdo->prepare("SELECT nom, prenom FROM personnes WHERE id = ?");
                $check_user->execute([$delete_id]);
                $user_info = $check_user->fetch(PDO::FETCH_ASSOC);
                
                if (!$user_info) {
                    throw new Exception("Utilisateur avec l'ID $delete_id non trouvé");
                }
                
                $user_name = $user_info['nom'] . ' ' . $user_info['prenom'];
                
                // Traitement selon le type de suppression
                switch ($table_to_delete) {
                    case 'all':
                        // Suppression complète
                        $deleted_roles = [];
                        foreach ($role_tables as $role => $table) {
                            $stmt = $pdo->prepare("DELETE FROM $table WHERE id_personne = ?");
                            $stmt->execute([$delete_id]);
                            if ($stmt->rowCount() > 0) {
                                $deleted_roles[] = $role;
                            }
                        }
                        
                        $stmt = $pdo->prepare("DELETE FROM personnes WHERE id = ?");
                        $stmt->execute([$delete_id]);
                        
                        if ($stmt->rowCount() > 0) {
                            $message = "Utilisateur '$user_name' et toutes ses données supprimés avec succès!";
                            if (!empty($deleted_roles)) {
                                $message .= " (Rôles supprimés: " . implode(', ', $deleted_roles) . ")";
                            }
                            $success = true;
                        } else {
                            throw new Exception("Erreur lors de la suppression de l'utilisateur");
                        }
                        break;
                        
                    case 'personnes':
                        // Suppression seulement de la table personnes
                        $stmt = $pdo->prepare("DELETE FROM personnes WHERE id = ?");
                        $stmt->execute([$delete_id]);
                        
                        if ($stmt->rowCount() > 0) {
                            $message = "Utilisateur '$user_name' supprimé de la table personnes uniquement";
                            $success = true;
                        } else {
                            throw new Exception("Aucune ligne supprimée de la table personnes");
                        }
                        break;
                        
                    default:
                        // Suppression d'un rôle spécifique
                        if (isset($role_tables[$table_to_delete])) {
                            $table = $role_tables[$table_to_delete];
                            $stmt = $pdo->prepare("DELETE FROM $table WHERE id_personne = ?");
                            $stmt->execute([$delete_id]);
                            
                            if ($stmt->rowCount() > 0) {
                                // Vérifier les rôles restants
                                $remaining_roles_query = "
                                    SELECT role FROM (
                                        SELECT 'Agent' AS role FROM agents WHERE id_personne = ?
                                        UNION SELECT 'Manager' FROM managers WHERE id_personne = ?
                                        UNION SELECT 'Bailleur' FROM bailleurs WHERE id_personne = ?
                                        UNION SELECT 'Administrateur' FROM administrateurs WHERE id_personne = ?
                                        UNION SELECT 'Client' FROM clients WHERE id_personne = ? 
                                    ) AS roles
                                ";
                                $check_roles = $pdo->prepare($remaining_roles_query);
                                $check_roles->execute([$delete_id, $delete_id, $delete_id, $delete_id, $delete_id]);
                                $remaining_roles = $check_roles->fetchAll(PDO::FETCH_COLUMN);
                                
                                if (empty($remaining_roles)) {
                                    // Plus aucun rôle, supprimer aussi de la table personnes
                                    $stmt = $pdo->prepare("DELETE FROM personnes WHERE id = ?");
                                    $stmt->execute([$delete_id]);
                                    $message = "Utilisateur '$user_name' supprimé du rôle '$table_to_delete' et de la table personnes (plus aucun rôle)";
                                } else {
                                    $message = "Utilisateur '$user_name' supprimé du rôle '$table_to_delete' (rôles restants: " . implode(', ', $remaining_roles) . ")";
                                }
                                $success = true;
                            } else {
                                throw new Exception("Utilisateur n'avait pas le rôle '$table_to_delete' ou erreur lors de la suppression");
                            }
                        } else {
                            throw new Exception("Rôle '$table_to_delete' non reconnu");
                        }
                        break;
                }
                
                if ($success) {
                    $pdo->commit();
                    echo "<script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Suppression réussie',
                            text: '".addslashes($message)."',
                            timer: 3000,
                            showConfirmButton: true
                        }).then(() => {
                            window.location.href = window.location.pathname;
                        });
                    </script>";
                } else {
                    throw new Exception("Aucune suppression effectuée");
                }
                
            } catch (Exception $e) {
                $pdo->rollBack();
                echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur de suppression',
                        text: '".addslashes($e->getMessage())."',
                        footer: 'Veuillez réessayer ou contacter l\\'administrateur'
                    });
                </script>";
            }
        }
        
        // Traitement de la modification (inchangé)
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
            $id = (int)$_POST['id'];
            $nom = htmlspecialchars(trim($_POST['nom']));
            $prenom = htmlspecialchars(trim($_POST['prenom']));
            $sexe = htmlspecialchars($_POST['sexe']);
            $pays = htmlspecialchars(trim($_POST['pays']));
            $numero = htmlspecialchars(trim($_POST['numero']));
            $email = htmlspecialchars(trim($_POST['email']));
            $adresse = htmlspecialchars(trim($_POST['adresse']));
            
            try {
                $update_stmt = $pdo->prepare("UPDATE personnes SET 
                    nom = ?, prenom = ?, sexe = ?, pays = ?, numero = ?, email = ?, adresse = ?
                    WHERE id = ?");
                
                $success = $update_stmt->execute([
                    $nom, $prenom, $sexe, $pays, $numero, $email, $adresse, $id
                ]);
                
                if ($success && $update_stmt->rowCount() > 0) {
                    echo "<script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Modification réussie',
                            text: 'Utilisateur modifié avec succès!'
                        }).then(() => {
                            window.location.href = window.location.pathname;
                        });
                    </script>";
                } else {
                    echo "<script>
                        Swal.fire({
                            icon: 'info',
                            title: 'Aucune modification',
                            text: 'Aucune modification détectée ou utilisateur non trouvé'
                        });
                    </script>";
                }
            } catch (PDOException $e) {
                echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur de modification',
                        text: 'Erreur lors de la modification: ".addslashes($e->getMessage())."'
                    });
                </script>";
            }
        }
        
        // Affichage des utilisateurs avec filtrage
        $status_filter = isset($_GET['status_filter']) ? trim($_GET['status_filter']) : '';
        $search_term = isset($_GET['search_term']) ? trim($_GET['search_term']) : '';
        
        $query = "SELECT 
            p.id,
            p.matricule,
            p.nom,
            p.prenom,
            p.sexe,
            p.pays,
            p.numero,
            p.email,
            p.adresse,
            GROUP_CONCAT(DISTINCT r.role ORDER BY r.role SEPARATOR ', ') AS roles
        FROM 
            personnes p
        LEFT JOIN (
            SELECT id_personne, 'Agent' AS role FROM agents
            UNION SELECT id_personne, 'Manager' FROM managers
            UNION SELECT id_personne, 'Bailleur' FROM bailleurs
            UNION SELECT id_personne, 'Administrateur' FROM administrateurs
            UNION SELECT id_personne, 'Client' FROM clients
        ) r ON p.id = r.id_personne
        WHERE 1=1 ";
        
        $params = [];
        
        // Ajout du filtre par recherche
        if (!empty($search_term)) {
            $query .= " AND (p.nom LIKE ? OR p.prenom LIKE ?)";
            $search_param = "%$search_term%";
            $params[] = $search_param;
            $params[] = $search_param;
        }
        
        // Ajout du filtre par statut
        if (!empty($status_filter)) {
            $query .= " AND r.role = ?";
            $params[] = $status_filter;
        }
        
        $query .= " GROUP BY p.id, p.matricule, p.nom, p.prenom, p.sexe, p.pays, p.numero, p.email, p.adresse
                   HAVING roles IS NOT NULL
                   ORDER BY p.nom, p.prenom";
        
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Affichage du tableau
        if (count($users) > 0) {
            echo '<table>';
            echo '<thead><tr>
                <th>N°</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Sexe</th>
                <th>Code</th>
                <th>Numéro</th>
                <th>Email</th>
                <th>Adresse</th>
                <th>Rôle(s)</th>
                <th>Actions</th>
            </tr></thead>';
            echo '<tbody>';
            $i=1;
            foreach ($users as $user) {
                $userJson = htmlspecialchars(json_encode($user), ENT_QUOTES);
                echo '<tr>
                    <td>'.$i++.'</td>
                    <td>'.htmlspecialchars($user['nom']).'</td>
                    <td>'.htmlspecialchars($user['prenom']).'</td>
                    <td>'.htmlspecialchars($user['sexe']).'</td>
                    <td>'.htmlspecialchars($user['pays']).'</td>
                    <td>'.htmlspecialchars($user['numero']).'</td>
                    <td>'.htmlspecialchars($user['email']).'</td>
                    <td>'.htmlspecialchars($user['adresse']).'</td>
                    <td><span class="badge">'.htmlspecialchars($user['roles']).'</span></td>
                    <td>
                     <a href="#edit">
                       <button class="action-btn edit-btn" onclick="showEditForm('.$userJson.')">
                           <i class="fas fa-edit"></i> Éditer
                       </button>
                     </a>  
                       <button class="action-btn delete-btn" onclick="confirmDelete('.htmlspecialchars($user['id']).', \''.htmlspecialchars($user['nom']).'\', \''.htmlspecialchars($user['prenom']).'\', \''.htmlspecialchars($user['roles']).'\')">
                           <i class="fas fa-trash"></i> Supprimer
                       </button>
                    </td>
                </tr>';
            }
            
            echo '</tbody></table>';
        } else {
            echo '<div class="alert alert-info">
                <i class="fas fa-info-circle"></i> 
                Aucun utilisateur trouvé'.(!empty($search_term) ? ' avec le terme "'.htmlspecialchars($search_term).'"' : '').(!empty($status_filter) ? ' et avec le statut "'.htmlspecialchars($status_filter).'"' : '').'.
            </div>';
        }
        
    } catch (PDOException $e) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Erreur de base de données',
                text: 'Erreur de connexion: ".addslashes($e->getMessage())."'
            });
        </script>";
    }
    ?>
</body>
</html>