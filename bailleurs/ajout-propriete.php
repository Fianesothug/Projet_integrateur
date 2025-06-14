<?php
// Démarrer la session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Configuration de la base de données
$host = 'localhost';
$dbname = 'gestion';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}

// Initialisation des variables
$message = '';
$message_type = '';

// Gestion du token CSRF
if (!isset($_SESSION['form_token'])) {
    $_SESSION['form_token'] = bin2hex(random_bytes(32));
}

// Fonction pour supprimer les images uploadées en cas d'erreur
function deleteUploadedImages(array $images, string $uploadDir): void {
    foreach ($images as $image) {
        $file_path = $uploadDir . $image;
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter_propriete'])) {

    // Vérification CSRF
    if (!isset($_POST['form_token']) || $_POST['form_token'] !== $_SESSION['form_token']) {
        $message = "Erreur de sécurité. Veuillez réessayer.";
        $message_type = 'error';
    } else {
        // Vérification des identifiants en session
        if (empty($_SESSION['identifiant']) || empty($_SESSION['mot_de_passe'])) {
            $message = "Vous devez être connecté pour ajouter une propriété.";
            $message_type = 'error';
        } else {
            // Validation des champs obligatoires
            $required_fields = ['type', 'adresse', 'ville'];
            $field_labels = [
                'type' => 'Type de propriété',
                'adresse' => 'Adresse',
                'ville' => 'Ville'
            ];
            $validation_error = false;

            foreach ($required_fields as $field) {
                if (empty(trim($_POST[$field] ?? ''))) {
                    $message = "Le champ '" . ($field_labels[$field] ?? ucfirst($field)) . "' est obligatoire.";
                    $message_type = 'error';
                    $validation_error = true;
                    break;
                }
            }

            if (!$validation_error) {
                // Nettoyage et validation des données
                $type = htmlspecialchars(trim($_POST['type']), ENT_QUOTES, 'UTF-8');
                $utilisation = htmlspecialchars(trim($_POST['utilisation'] ?? ''), ENT_QUOTES, 'UTF-8');
                $option_propriete = htmlspecialchars(trim($_POST['option'] ?? ''), ENT_QUOTES, 'UTF-8');
                $adresse = htmlspecialchars(trim($_POST['adresse']), ENT_QUOTES, 'UTF-8');
                $ville = htmlspecialchars(trim($_POST['ville']), ENT_QUOTES, 'UTF-8');
                $description = htmlspecialchars(trim($_POST['description'] ?? ''), ENT_QUOTES, 'UTF-8');

                // Validation et conversion des données numériques
                $taille = 0;
                if (!empty($_POST['taille'])) {
                    $taille = filter_var($_POST['taille'], FILTER_VALIDATE_INT);
                    if ($taille === false || $taille < 0) {
                        $message = "La taille doit être un nombre entier positif.";
                        $message_type = 'error';
                        $validation_error = true;
                    }
                }

                $prix = 0.0;
                if (!empty($_POST['prix'])) {
                    $prix = filter_var($_POST['prix'], FILTER_VALIDATE_FLOAT);
                    if ($prix === false || $prix < 0) {
                        $message = "Le prix doit être un nombre décimal positif.";
                        $message_type = 'error';
                        $validation_error = true;
                    }
                }

                if (!$validation_error) {
                    // Traitement des images
                    $images = [];
                    $upload_error = false;

                    if (!empty($_FILES['images']['name'][0])) {
                        $uploadDir = __DIR__ . '/../uploads/proprietes/';

                        // Créer le dossier s'il n'existe pas
                        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
                            $message = "Impossible de créer le dossier de téléchargement.";
                            $message_type = 'error';
                            $upload_error = true;
                        }

                        if (!$upload_error) {
                            $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                            $max_file_size = 5 * 1024 * 1024; // 5MB

                            foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                                $error_code = $_FILES['images']['error'][$key];
                                $originalName = $_FILES['images']['name'][$key];

                                if ($error_code === UPLOAD_ERR_NO_FILE) {
                                    // Aucun fichier uploadé à cet index, ignorer
                                    continue;
                                }

                                if ($error_code !== UPLOAD_ERR_OK) {
                                    $message = "Erreur de téléchargement pour " . htmlspecialchars($originalName);
                                    $message_type = 'error';
                                    $upload_error = true;
                                    break;
                                }

                                // Vérification de la taille du fichier
                                if ($_FILES['images']['size'][$key] > $max_file_size) {
                                    $message = "Le fichier " . htmlspecialchars($originalName) . " est trop volumineux (max 5MB).";
                                    $message_type = 'error';
                                    $upload_error = true;
                                    break;
                                }

                                // Vérification du type de fichier
                                $fileType = mime_content_type($tmp_name);
                                if (!in_array($fileType, $allowed_types)) {
                                    $message = "Type de fichier non autorisé pour " . htmlspecialchars($originalName) . ". Formats acceptés: JPEG, PNG, GIF, WebP.";
                                    $message_type = 'error';
                                    $upload_error = true;
                                    break;
                                }

                                // Génération d'un nom de fichier unique
                                $file_extension = pathinfo($originalName, PATHINFO_EXTENSION);
                                $fileName = uniqid('img_', true) . '.' . $file_extension;
                                $targetFile = $uploadDir . $fileName;

                                if (move_uploaded_file($tmp_name, $targetFile)) {
                                    $images[] = $fileName;
                                } else {
                                    $message = "Erreur lors du téléchargement de " . htmlspecialchars($originalName);
                                    $message_type = 'error';
                                    $upload_error = true;
                                    break;
                                }
                            }
                        }
                    }

                    if (!$upload_error) {
                        // Préparation des données pour l'insertion
                        $data = [
                            ':identifiant' => $_SESSION['identifiant'],
                            ':code' => $_SESSION['mot_de_passe'],
                            ':type' => $type,
                            ':utilisation' => $utilisation,
                            ':option_propriete' => $option_propriete,
                            ':adresse' => $adresse,
                            ':ville' => $ville,
                            ':taille' => $taille,
                            ':prix' => $prix,
                            ':description' => $description,
                            ':images' => implode(',', $images),
                            ':date_ajout' => date('Y-m-d H:i:s'),
                            ':statut' => 'disponible'
                        ];

                        // Insertion en base de données
                        try {
                            $sql = "INSERT INTO proprietes 
                                (identifiant, code, type, utilisation, option_propriete, adresse, ville, taille, prix, description, images, date_ajout, statut) 
                                VALUES 
                                (:identifiant, :code, :type, :utilisation, :option_propriete, :adresse, :ville, :taille, :prix, :description, :images, :date_ajout, :statut)";
                            $stmt = $pdo->prepare($sql);

                            if ($stmt->execute($data)) {
                                // Succès de l'insertion
                                $_SESSION['form_success'] = true;
                                $_SESSION['form_message'] = "La propriété a été ajoutée avec succès!";
                                $_SESSION['form_message_type'] = 'success';

                                // Régénérer le token CSRF pour la sécurité
                                $_SESSION['form_token'] = bin2hex(random_bytes(32));
                                exit();
                            } else {
                                $message = "Erreur lors de l'enregistrement de la propriété.";
                                $message_type = 'error';
                                // Supprimer les images téléchargées en cas d'erreur
                                if (!empty($images)) {
                                    deleteUploadedImages($images, $uploadDir);
                                }
                            }
                        } catch (PDOException $e) {
                            $message = "Erreur de base de données: " . $e->getMessage();
                            $message_type = 'error';
                            // Supprimer les images téléchargées en cas d'erreur
                            if (!empty($images)) {
                                deleteUploadedImages($images, $uploadDir);
                            }
                        }
                    } else {
                        // Supprimer les images déjà téléchargées en cas d'erreur
                        if (!empty($images)) {
                            deleteUploadedImages($images, $uploadDir);
                        }
                    }
                }
            }
        }
    }
}

// Récupérer le message de session s'il existe
if (isset($_SESSION['form_success'])) {
    $message = $_SESSION['form_message'] ?? '';
    $message_type = $_SESSION['form_message_type'] ?? '';
    unset($_SESSION['form_success'], $_SESSION['form_message'], $_SESSION['form_message_type']);
}
?>
<script>
        window.onload = function() {
            let reloadCount = parseInt(sessionStorage.getItem('reloadCount')) || 0;

            if (reloadCount < 2) {
                reloadCount++;
                sessionStorage.setItem('reloadCount', reloadCount);
                location.reload();
            } else {
                // Reset si tu veux que ça recommence à zéro à la prochaine ouverture
                sessionStorage.removeItem('reloadCount');
            }
        };
    </script>