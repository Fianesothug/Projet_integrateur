<?php
session_start();

// Configuration email
define('SENDER_EMAIL', 'decidaisomar@gmail.com');
define('SMTP_USERNAME', 'decidaisomar@gmail.com');
define('SMTP_PASSWORD', 'dspkjjgzuahscwxp');
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_SECURE', 'tls');

// Inclure PHPMailer
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

// Vérification de la session
if (!isset($_SESSION['statut'])) {
    header("Location: ../../components/protection.php");
    exit();
}

// Récupération de l'ID de l'agent connecté
$id_agent_connecte = $_SESSION['user_id'] ?? null;

// Fonction pour envoyer un email avec PHPMailer
function sendPropertyEmail($to, $subject, $message) {
    $mail = new PHPMailer(true);
    
    try {
        // Configuration SMTP
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USERNAME;
        $mail->Password = SMTP_PASSWORD;
        $mail->SMTPSecure = SMTP_SECURE;
        $mail->Port = SMTP_PORT;
        $mail->CharSet = 'UTF-8';
        
        // Expéditeur et destinataire
        $mail->setFrom(SENDER_EMAIL, 'HAOUSE-COMPANY');
        $mail->addAddress($to);
        
        // Contenu
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->AltBody = strip_tags($message);
        
        return $mail->send();
    } catch (PHPMailerException $e) {
        error_log("Erreur PHPMailer: " . $mail->ErrorInfo);
        return false;
    }
}

// Fonction pour générer le template email
function getPropertyEmailTemplate($title, $content) {
    return '
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>' . htmlspecialchars($title) . '</title>
    </head>
    <body style="margin: 0; padding: 20px; font-family: Arial, sans-serif; background-color: #f4f4f4;">
        <div style="max-width: 600px; margin: 0 auto; background-color: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <div style="background-color: #3498db; color: white; padding: 20px; text-align: center;">
                <h2 style="margin: 0;">' . htmlspecialchars($title) . '</h2>
            </div>
            <div style="padding: 30px; line-height: 1.6;">
                ' . $content . '
            </div>
            <div style="background-color: #f8f9fa; padding: 15px; text-align: center; font-size: 12px; color: #666;">
                <p style="margin: 0;">Cet email a été envoyé automatiquement, merci de ne pas répondre.</p>
                <p style="margin: 5px 0 0 0;">Système de gestion immobilière</p>
            </div>
        </div>
    </body>
    </html>';
}

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

                            $update = $db->prepare("UPDATE proprietes SET statut = :nouveau_statut WHERE id = :id");
                            $update->execute([
                                ':nouveau_statut' => $nouveau_statut,
                                ':id' => $numero_propriete
                            ]);
                           
                            $insert = $db->prepare("INSERT INTO clients 
                                (id_personne, id_agent, matricule, numero_propriete, nom, prenom, email, pays, numero, identifiant, code, date_creation) 
                                VALUES 
                                (:id_personne, :id_agent, :matricule, :numero_propriete, :nom, :prenom, :email, :pays, :numero, :identifiant, :code, NOW())");

                            $insert->execute([
                                ':id_personne' => $personne['id'],
                                ':id_agent' => $id_agent_connecte,
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

                            // Récupération des informations de l'agent
                            $stmt_agent = $db->prepare("SELECT * FROM agents WHERE id = :id");
                            $stmt_agent->execute([':id' => $id_agent_connecte]);
                            $agent_info = $stmt_agent->fetch();

                            if (!$agent_info) {
                                throw new Exception("Agent introuvable dans la base de données");
                            }

                            // Vérification des matricules
                            $matricule_agent = $agent_info['matricule'] ?? 'N/A';
                            $matricule_client = $personne['matricule'] ?? 'N/A';

                            // Envoi des emails de notification
                            if (filter_var($personne['email'], FILTER_VALIDATE_EMAIL)) {
                                // Email au client
                                $subject_client = 'Attribution de propriété - Notification importante';
                                $content_client = '
                                    <p>Bonjour <strong>' . htmlspecialchars($personne['prenom'] . ' ' . $personne['nom']) . '</strong>,</p>
                                    <p>Nous vous informons qu\'une propriété vous a été attribuée avec succès.</p>
                                    
                                    <div style="background-color: #e8f4f8; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #3498db;">
                                        <h3 style="margin-top: 0; color: #2c3e50;">Détails de la propriété :</h3>
                                        <p><strong>Référence :</strong> ' . htmlspecialchars($propriete['id']) . '</p>
                                        <p><strong>Adresse :</strong> ' . htmlspecialchars($propriete['adresse']) . '</p>
                                        <p><strong>Type :</strong> ' . htmlspecialchars($propriete['type']) . '</p>
                                        <p><strong>Prix :</strong> ' . htmlspecialchars($propriete['prix']) . ' €</p>
                                        <p><strong>Votre matricule :</strong> ' . htmlspecialchars($matricule_client) . '</p>
                                    </div>
                                    
                                    <div style="background-color: #f0fff4; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #28a745;">
                                        <h3 style="margin-top: 0; color: #2c3e50;">Votre agent :</h3>
                                        <p><strong>Nom :</strong> ' . htmlspecialchars($agent_info['prenom'] ). ' ' . htmlspecialchars($agent_info['nom']) . '</p>
                                        <p><strong>Email :</strong> ' . htmlspecialchars($agent_info['email']) . '</p>
                                        <p><strong>Téléphone :</strong> ' . htmlspecialchars($agent_info['numero']) . '</p>
                                        <p><strong>Matricule agent :</strong> ' . htmlspecialchars($matricule_agent) . '</p>
                                    </div>
                                    
                                    <p>Votre agent prendra contact avec vous dans les plus brefs délais pour finaliser les détails.</p>
                                    
                                    <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
                                        <p style="margin-bottom: 5px;">Cordialement,</p>
                                        <p style="margin: 0;"><strong>L\'équipe de gestion immobilière</strong></p>
                                    </div>';

                                $email_client_sent = sendPropertyEmail(
                                    $personne['email'],
                                    $subject_client,
                                    getPropertyEmailTemplate('Attribution de propriété', $content_client)
                                );

                                if (!$email_client_sent) {
                                    error_log("Erreur lors de l'envoi de l'email au client: " . $personne['email']);
                                }
                            }

                            if (filter_var($agent_info['email'], FILTER_VALIDATE_EMAIL)) {
                                // Email à l'agent
                                $subject_agent = 'Nouvelle propriété attribuée - Action requise';
                                $content_agent = '
                                    <p>Bonjour <strong>' . htmlspecialchars($agent_info['prenom']) . ' ' . htmlspecialchars($agent_info['nom']) . '</strong>,</p>
                                    <p>Une nouvelle propriété vous a été assignée avec un client.</p>
                                    
                                    <div style="background-color: #f0f8e8; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #27ae60;">
                                        <h3 style="margin-top: 0; color: #2c3e50;">Détails de la propriété :</h3>
                                        <p><strong>Référence :</strong> ' . htmlspecialchars($propriete['id']) . '</p>
                                        <p><strong>Adresse :</strong> ' . htmlspecialchars($propriete['adresse']) . '</p>
                                        <p><strong>Type :</strong> ' . htmlspecialchars($propriete['type']) . '</p>
                                        <p><strong>Prix :</strong> ' . htmlspecialchars($propriete['prix']) . ' €</p>
                                        <p><strong>Votre matricule :</strong> ' . htmlspecialchars($matricule_agent) . '</p>
                                    </div>
                                    
                                    <div style="background-color: #e8f4f8; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #3498db;">
                                        <h3 style="margin-top: 0; color: #2c3e50;">Informations du client :</h3>
                                        <p><strong>Nom :</strong> ' . htmlspecialchars($personne['prenom'] . ' ' . $personne['nom']) . '</p>
                                        <p><strong>Email :</strong> ' . htmlspecialchars($personne['email']) . '</p>
                                        <p><strong>Téléphone :</strong> ' . htmlspecialchars($personne['numero']) . '</p>
                                        <p><strong>Matricule client :</strong> ' . htmlspecialchars($matricule_client) . '</p>
                                    </div>
                                    
                                    <div style="background-color: #fff3cd; padding: 15px; border-radius: 5px; margin: 20px 0; border-left: 4px solid #ffc107;">
                                        <p style="margin: 0;"><strong>Action requise :</strong> Merci de prendre contact avec ce client dans les 24 heures pour finaliser les détails de la transaction.</p>
                                    </div>
                                    
                                    <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
                                        <p style="margin-bottom: 5px;">Cordialement,</p>
                                        <p style="margin: 0;"><strong>L\'équipe de gestion immobilière</strong></p>
                                    </div>';

                                $email_agent_sent = sendPropertyEmail(
                                    $agent_info['email'],
                                    $subject_agent,
                                    getPropertyEmailTemplate('Nouvelle attribution', $content_agent)
                                );

                                if (!$email_agent_sent) {
                                    error_log("Erreur lors de l'envoi de l'email à l'agent: " . $agent_info['email']);
                                }
                            }

                            $db->commit();
                            $_SESSION['message'] = "Opération effectuée avec succès et notifications envoyées.";
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
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opération Propriété</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: 2rem auto;
            padding: 2rem;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .alert {
            padding: 1.2rem 1.5rem;
            margin: 1.5rem auto;
            border-radius: 8px;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            max-width: 80%;
            position: relative;
            overflow: hidden;
            border: none;
            transition: all 0.3s ease;
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
            color: #dc3545;
            border-left: 4px solid #dc3545;
        }
        .alert-danger::after {
            background-color: #dc3545;
        }
        .alert-success {
            background-color: #f0fff4;
            color: #28a745;
            border-left: 4px solid #28a745;
        }
        .alert-success::after {
            background-color: #28a745;
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
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0 0;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border: none;
            cursor: pointer;
            gap: 8px;
        }
        .return-btn:hover {
            background-color: #0056b3;
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