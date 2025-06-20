<?php
session_start();
header('Content-Type: application/json');

// Configuration de la base de données
define('DB_HOST', 'localhost');
define('DB_NAME', 'gestion');
define('DB_USER', 'root');
define('DB_PASS', '');

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

try {
    // Vérification de la méthode HTTP
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Méthode non autorisée');
    }

    // Vérification et validation des données reçues
    $required_fields = ['client_id', 'agent_id'];
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            throw new Exception("Le champ '$field' est requis");
        }
    }

    // Validation et nettoyage des données
    $client_id = filter_var($_POST['client_id'], FILTER_VALIDATE_INT);
    $agent_id = filter_var($_POST['agent_id'], FILTER_VALIDATE_INT);

    // Validation des données
    if (!$client_id || $client_id <= 0) {
        throw new Exception('ID client invalide');
    }
    if (!$agent_id || $agent_id <= 0) {
        throw new Exception('ID agent invalide');
    }

    // Connexion à la base de données avec gestion d'erreur
    try {
        $pdo = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", 
            DB_USER, 
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]
        );
    } catch (PDOException $e) {
        error_log("Erreur de connexion DB: " . $e->getMessage());
        throw new Exception('Erreur de connexion à la base de données');
    }

    // Récupération des informations complètes du client
    $stmt_client = $pdo->prepare("
        SELECT c.id, c.matricule, c.nom, c.prenom, c.email, c.numero, c.id_agent as ancien_agent_id
        FROM clients c 
        WHERE c.id = ?
    ");
    $stmt_client->execute([$client_id]);
    $client_info = $stmt_client->fetch();

    if (!$client_info) {
        throw new Exception('Client introuvable');
    }

    // Validation de l'email du client
    $client_email = filter_var($client_info['email'], FILTER_VALIDATE_EMAIL);
    if (!$client_email) {
        throw new Exception('Email du client invalide ou manquant');
    }

    // Récupération des informations complètes de l'agent
    $stmt_agent = $pdo->prepare("
        SELECT a.id, a.id_personne, a.nom, a.prenom, a.email, a.numero, a.numero_pv
        FROM agents a 
        WHERE a.id = ?
    ");
    $stmt_agent->execute([$agent_id]);
    $agent_info = $stmt_agent->fetch();

    if (!$agent_info) {
        throw new Exception('Agent introuvable');
    }

    // Validation de l'email de l'agent
    $agent_email = filter_var($agent_info['email'], FILTER_VALIDATE_EMAIL);
    if (!$agent_email) {
        throw new Exception('Email de l\'agent invalide ou manquant');
    }

    // Vérification si le client n'est pas déjà affecté à cet agent
    if ($client_info['ancien_agent_id'] == $agent_id) {
        throw new Exception('Le client est déjà affecté à cet agent');
    }

    // Transaction pour la mise à jour
    $pdo->beginTransaction();

    try {
        // Mise à jour de l'agent du client
        $stmt_update = $pdo->prepare("UPDATE clients SET id_agent = ? WHERE id = ?");
        $stmt_update->execute([$agent_id, $client_id]);

        // Vérification que la mise à jour a bien eu lieu
        if ($stmt_update->rowCount() === 0) {
            throw new Exception('Aucune modification effectuée');
        }

        // Enregistrement de la notification dans la table messages (si nécessaire)
        try {
            $stmt_message = $pdo->prepare("
                INSERT INTO messages (email, date_envoi) 
                VALUES (?, NOW()) 
                ON DUPLICATE KEY UPDATE date_envoi = NOW()
            ");
            $stmt_message->execute([$client_email]);
            $stmt_message->execute([$agent_email]);
        } catch (Exception $e) {
            error_log("Erreur lors de l'enregistrement des messages: " . $e->getMessage());
        }

        $pdo->commit();
    } catch (Exception $e) {
        $pdo->rollback();
        throw $e;
    }

    // Fonction pour envoyer un email avec PHPMailer
    function sendSecureEmail($to, $subject, $message, $from = SENDER_EMAIL) {
        if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

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
            $mail->setFrom($from, 'HAOUSE-CONPANY');
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

    // Template HTML pour les emails
    function getEmailTemplate($title, $content) {
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

    // Préparation des informations pour les emails
    $client_nom_complet = trim($client_info['prenom'] . ' ' . $client_info['nom']);
    $agent_nom_complet = trim($agent_info['prenom'] . ' ' . $agent_info['nom']);
    $client_matricule = $client_info['matricule'] ?? 'Non défini';
    $agent_numero_pv = $agent_info['numero_pv'] ?? 'Non défini';

    // Envoi de l'email au client
    $subject_client = 'Affectation à un nouvel agent - Notification importante';
    $content_client = '
        <p>Bonjour <strong>' . htmlspecialchars($client_nom_complet) . '</strong>,</p>
        <p>Nous vous informons que vous avez été affecté(e) à un nouvel agent pour le suivi de votre dossier immobilier.</p>
        
        <div style="background-color: #e8f4f8; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #3498db;">
            <h3 style="margin-top: 0; color: #2c3e50;">Informations de votre nouvel agent :</h3>
            <p><strong>Nom :</strong> ' . htmlspecialchars($agent_nom_complet) . '</p>
            <p><strong>Email :</strong> ' . htmlspecialchars($agent_email) . '</p>
            <p><strong>Numéro PV :</strong> ' . htmlspecialchars($agent_numero_pv) . '</p>
            ' . (!empty($agent_info['numero']) ? '<p><strong>Téléphone :</strong> ' . htmlspecialchars($agent_info['numero']) . '</p>' : '') . '
        </div>
        
        <p>Nous vous invitons à prendre contact avec votre nouvel agent dans les plus brefs délais pour la continuité de votre dossier.</p>
        <p>Nous nous excusons pour tout désagrément que ce changement pourrait occasionner et vous remercions de votre compréhension.</p>
        
        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
            <p style="margin-bottom: 5px;">Cordialement,</p>
            <p style="margin: 0;"><strong>L\'équipe de gestion immobilière</strong></p>
        </div>';

    $email_client_sent = sendSecureEmail(
        $client_email, 
        $subject_client, 
        getEmailTemplate('Affectation à un nouvel agent', $content_client)
    );

    if (!$email_client_sent) {
        error_log("Erreur lors de l'envoi de l'email au client: $client_email");
    }

    // Envoi de l'email à l'agent
    $subject_agent = 'Nouveau client affecté - Action requise';
    $content_agent = '
        <p>Bonjour <strong>' . htmlspecialchars($agent_nom_complet) . '</strong>,</p>
        <p>Un nouveau client vous a été affecté et nécessite votre attention immédiate.</p>
        
        <div style="background-color: #f0f8e8; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #27ae60;">
            <h3 style="margin-top: 0; color: #2c3e50;">Informations du client :</h3>
            <p><strong>Nom :</strong> ' . htmlspecialchars($client_nom_complet) . '</p>
            <p><strong>Email :</strong> ' . htmlspecialchars($client_email) . '</p>
            <p><strong>Matricule :</strong> ' . htmlspecialchars($client_matricule) . '</p>
            ' . (!empty($client_info['numero']) ? '<p><strong>Téléphone :</strong> ' . htmlspecialchars($client_info['numero']) . '</p>' : '') . '
        </div>
        
        <div style="background-color: #fff3cd; padding: 15px; border-radius: 5px; margin: 20px 0; border-left: 4px solid #ffc107;">
            <p style="margin: 0;"><strong>Action requise :</strong> Merci de prendre contact avec ce client dans les 24 heures pour assurer un suivi optimal de son dossier.</p>
        </div>
        
        <p>Nous comptons sur votre professionnalisme pour offrir un service de qualité à ce client.</p>
        
        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
            <p style="margin-bottom: 5px;">Cordialement,</p>
            <p style="margin: 0;"><strong>L\'équipe de gestion immobilière</strong></p>
        </div>';

    $email_agent_sent = sendSecureEmail(
        $agent_email, 
        $subject_agent, 
        getEmailTemplate('Nouveau client affecté', $content_agent)
    );

    if (!$email_agent_sent) {
        error_log("Erreur lors de l'envoi de l'email à l'agent: $agent_email");
    }

    // Messages de session
    $_SESSION['message'] = 'Affectation réussie et notifications envoyées';
    $_SESSION['success'] = true;

    // Réponse JSON détaillée
    $response = [
        'success' => true,
        'message' => 'Affectation réussie et notifications envoyées',
        'data' => [
            'client' => [
                'id' => $client_id,
                'nom' => $client_nom_complet,
                'email' => $client_email,
                'matricule' => $client_matricule,
                'email_sent' => $email_client_sent
            ],
            'agent' => [
                'id' => $agent_id,
                'nom' => $agent_nom_complet,
                'email' => $agent_email,
                'numero_pv' => $agent_numero_pv,
                'email_sent' => $email_agent_sent
            ],
            'ancien_agent_id' => $client_info['ancien_agent_id'],
            'timestamp' => date('Y-m-d H:i:s')
        ]
    ];

    echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

} catch (Exception $e) {
    // Rollback de la transaction si elle est encore active
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollback();
    }
    
    // Log de l'erreur pour le débogage
    error_log("Erreur dans affectation agent: " . $e->getMessage());
    
    // Réponse d'erreur
    http_response_code(400);
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage(),
        'timestamp' => date('Y-m-d H:i:s')
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}