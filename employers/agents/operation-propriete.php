<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de propriétés</title>
    <style>
        :root {
            --primary-color: #007bff;
            --primary-hover: #0056b3;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --text-color: #333;
            --bg-color: #f8f9fa;
            --white: #ffffff;
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            --border-radius: 8px;
            --transition: all 0.3s ease;
        }
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            background-color: var(--bg-color);
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: 2rem auto;
            padding: 2rem;
            background: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
        }
        .alert {
            padding: 1.2rem 1.5rem;
            margin: 1.5rem auto;
            border-radius: var(--border-radius);
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            max-width: 80%;
            position: relative;
            overflow: hidden;
            border: none;
            transition: var(--transition);
        }
        .alert::after {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 5px;
        }
        .alert-danger {
            background-color: #fff5f5;
            color: var(--danger-color);
            border-left: 4px solid var(--danger-color);
        }
        .alert-danger::after {
            background-color: var(--danger-color);
        }
        .alert-success {
            background-color: #f0fff4;
            color: var(--success-color);
            border-left: 4px solid var(--success-color);
        }
        .alert-success::after {
            background-color: var(--success-color);
        }
        .alert-icon {
            width: 24px;
            height: 24px;
            margin-right: 12px;
            flex-shrink: 0;
        }
        .return-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 24px;
            background-color: var(--primary-color);
            color: var(--white);
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0 0;
            font-size: 1.1rem;
            transition: var(--transition);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border: none;
            cursor: pointer;
            gap: 8px;
        }
        .return-btn:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }
        .return-btn::before {
            content: '←';
            font-size: 1.2rem;
        }
        @media (max-width: 768px) {
            .container {
                padding: 1.5rem;
                margin: 1rem;
            }
            .alert {
                max-width: 90%;
                padding: 1rem;
                font-size: 1rem;
            }
        }
        @media (max-width: 480px) {
            .alert {
                flex-direction: column;
                text-align: center;
            }
            .alert-icon {
                margin-right: 0;
                margin-bottom: 8px;
            }
            .return-btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="tableau-bord.php" class="return-btn">Retour au tableau de bord</a>

        <?php
           if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['operation_propriete'])) {
            if (!isset($_SESSION['form_submitted'])) {
                $_SESSION['form_submitted'] = true;

                try {
                    $db = new PDO('mysql:host=localhost;dbname=gestion', 'root', '');
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $matricule = trim($_POST['matricule']);
                    $numero_propriete = trim($_POST['numero']);

                    $_SESSION['message'] = '';
                    $_SESSION['success'] = false;

                    // Vérification du matricule
                    $stmt = $db->prepare("SELECT * FROM personnes WHERE matricule = :matricule");
                    $stmt->execute([':matricule' => $matricule]);
                    $personne = $stmt->fetch(PDO::FETCH_ASSOC);

                    if (!$personne) {
                        $_SESSION['message'] = "Matricule non trouvé.";
                    } else {
                        // Vérification de la propriété
                        $stmt = $db->prepare("SELECT * FROM proprietes WHERE id = :id");
                        $stmt->execute([':id' => $numero_propriete]);
                        $propriete = $stmt->fetch(PDO::FETCH_ASSOC);

                        if (!$propriete) {
                            $_SESSION['message'] = "Propriété inexistante.";
                        } else {
                            $statut_actuel = strtolower($propriete['statut']);

                            // Vérification si déjà attribuée
                            $stmt = $db->prepare("SELECT * FROM clients WHERE numero_propriete = :numero_propriete");
                            $stmt->execute([':numero_propriete' => $numero_propriete]);
                            $attribution_existante = $stmt->fetch();

                            if ($attribution_existante && $statut_actuel !== 'disponible') {
                                $_SESSION['message'] = "Propriété déjà attribuée et non disponible.";
                            } else {
                                $db->beginTransaction();
                                try {
                                    // Supprimer l'ancienne affectation si elle existe
                                    if ($attribution_existante) {
                                        $del = $db->prepare("DELETE FROM clients WHERE numero_propriete = :numero_propriete");
                                        $del->execute([':numero_propriete' => $numero_propriete]);
                                    }

                                    $nouveau_statut = "attribuée";

                                    // CORRECTION : Ajout des guillemets autour de la variable $nouveau_statut
                                    $update = $db->prepare("UPDATE proprietes SET statut = :nouveau_statut WHERE id = :id");
                                    $update->execute([
                                        ':nouveau_statut' => $nouveau_statut,
                                        ':id' => $numero_propriete
                                    ]);
                                   
                                    $insert = $db->prepare("INSERT INTO clients 
                                        (id_personne, matricule, numero_propriete, nom, prenom, email, pays, numero, identifiant, code, date_creation) 
                                        VALUES 
                                        (:id_personne, :matricule, :numero_propriete, :nom, :prenom, :email, :pays, :numero, :identifiant, :code, NOW())");

                                    $insert->execute([
                                        ':id_personne' => $personne['id'],
                                        ':matricule' => $personne['matricule'],
                                        ':numero_propriete' => $numero_propriete,
                                        ':nom' => $personne['nom'],
                                        ':prenom' => $personne['prenom'],
                                        ':email' => $personne['email'] ?? null,
                                        ':pays' => $personne['pays'] ?? null,
                                        ':numero' => $personne['numero'] ?? null,
                                        ':identifiant' => $personne['identifiant'] ?? null,
                                        ':code' => $personne['code'] ?? null
                                    ]);

                                    $db->commit();
                                    $_SESSION['message'] = "Opération effectuée avec succès.";
                                    $_SESSION['success'] = true;
                                } catch (Exception $e) {
                                    $db->rollBack();
                                    $_SESSION['message'] = "Erreur lors de l'opération : " . $e->getMessage();
                                }
                            }
                        }
                    }
                } catch (PDOException $e) {
                    $_SESSION['message'] = "Connexion à la base de données impossible : " . $e->getMessage();
                }
            }
        }

        if (isset($_SESSION['message'])) {
            $alertType = $_SESSION['success'] ? 'success' : 'danger';
            $icon = $_SESSION['success'] ? '✔️' : '❌';

            echo '<div class="alert alert-' . $alertType . '">';
            echo '<span class="alert-icon">' . $icon . '</span>';
            echo htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8');
            echo '</div>';

            unset($_SESSION['message'], $_SESSION['success'], $_SESSION['form_submitted']);
        }
        ?>
    </div>
</body>
</html>