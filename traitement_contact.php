<?php
session_start();

// Configuration : désactiver l'affichage des erreurs en production
error_reporting(E_ALL);
ini_set('display_errors', 0); // Désactivé en production

// Vérification de la méthode POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = "Méthode non autorisée.";
    header("Location: contact.php");
    exit();
}

// Vérification du token CSRF
if (!isset($_POST['csrf_token']) || !isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    $_SESSION['error'] = "Erreur de sécurité. Veuillez réessayer.";
    header("Location: contact.php");
    exit();
}

// Configuration de la base de données (à externaliser dans un fichier de config)
define('DB_HOST', 'localhost');
define('DB_NAME', 'gestion');
define('DB_USER', 'root'); // Remplacer par un utilisateur dédié avec des permissions limitées
define('DB_PASS', '');     // Utiliser un mot de passe sécurisé

// Nettoyage et validation des données
function cleanInput($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

$nom       = cleanInput($_POST['nom'] ?? '');
$prenom    = cleanInput($_POST['prenom'] ?? '');
$email     = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$telephone = cleanInput($_POST['telephone'] ?? '');
$message   = cleanInput($_POST['message'] ?? '');

$errors = [];

if (empty($nom))       $errors[] = "Le nom est obligatoire.";
if (empty($prenom))    $errors[] = "Le prénom est obligatoire.";
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "L'adresse email n'est pas valide.";
}
if (empty($message))   $errors[] = "Le message est obligatoire.";
if (strlen($message) > 1000) $errors[] = "Le message est trop long (max 1000 caractères).";

if (!empty($errors)) {
    $_SESSION['error'] = implode("<br>", $errors);
    $_SESSION['form_data'] = [
        'nom' => $nom,
        'prenom' => $prenom,
        'email' => $email,
        'telephone' => $telephone,
        'message' => $message
    ];
    header("Location: contact.php");
    exit();
}

// Connexion à la base de données
try {
    $dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4';
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);

    // Insertion dans la base avec validation supplémentaire
    $stmt = $pdo->prepare("
        INSERT INTO contacts (nom, prenom, email, telephone, message, ip, date_creation)
        VALUES (:nom, :prenom, :email, :telephone, :message, :ip, NOW())
    ");

    $stmt->execute([
        ':nom'       => $nom,
        ':prenom'    => $prenom,
        ':email'     => $email,
        ':telephone' => $telephone,
        ':message'   => $message,
        ':ip'        => $_SERVER['REMOTE_ADDR']
    ]);

    // Configuration de l'email (à externaliser dans un fichier de config)
    define('SMTP_HOST', 'smtp.gmail.com');
    define('SMTP_USER', 'decidaisomar@gmail.com'); // Remplacer
    define('SMTP_PASS', 'dspkjjgzuahscwxp');      // Remplacer par un mot de passe sécurisé
    define('EMAIL_FROM', 'decidaisomar@gmail.com');
    define('EMAIL_FROM_NAME', 'Formulaire de contact HOUSE-COMPANY');
    define('EMAIL_TO', 'decidaisomar@gmail.com');
    define('EMAIL_TO_NAME', 'Destinataire');

    // Envoi d'email avec PHPMailer
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    $mail = new PHPMailer\PHPMailer\PHPMailer(true);

    try {
        // Configuration SMTP
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USER;
        $mail->Password   = SMTP_PASS;
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';

        // Expéditeur et destinataire
        $mail->setFrom(EMAIL_FROM, EMAIL_FROM_NAME);
        $mail->addAddress(EMAIL_TO, EMAIL_TO_NAME);

        // Contenu de l'email
        $mail->isHTML(true);
        $mail->Subject = "Nouveau message de contact de $nom $prenom";
        
        $emailContent = "
            <!DOCTYPE html>
            <html>
            <head>
                <style>
                    body { 
                    font-size:1.3rem;
                    font-family: Arial, sans-serif; line-height: 1.6;
                     }
                    .container { 
                        color: black;
                        max-width: 600px;
                        margin: 0 auto; 
                        padding: 20px;
                        border: 1px solid #ddd; 
                        border-radius: 5px;
                    }
                    .header { 
                        background-color: #007bff;
                        color: white; 
                        padding: 10px; 
                        text-align: center; 
                        border-radius: 5px 5px 0 0; 
                    }
                    .content { padding: 20px; }
                    .footer {
                        margin-top: 20px;
                        font-size: 0.8em; 
                        text-align: center;
                        color: #777; 
                    }

                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h2>Nouveau message de contact</h2>
                    </div>
                    <div class='content'>
                        <p><strong>Nom:</strong> $nom $prenom</p>
                        <p><strong>Email:</strong> $email</p>
                        <p><strong>Téléphone:</strong> $telephone</p>
                        <p><strong>Message:</strong><br>".$message."</p>
                        <p><strong>Date:</strong> ".date('Y-m-d H:i:s')."</p>
                    </div>
                    <div class='footer'>
                        Ce message a été envoyé via le formulaire de contact.
                    </div>
                </div>
            </body>
            </html>
        ";

        $mail->Body = $emailContent;
        $mail->AltBody = strip_tags(str_replace("<br>", "\n", $emailContent));

        if ($mail->send()) {
            $_SESSION['success'] = "Votre message a bien été envoyé. Nous vous contacterons bientôt.";
        } else {
            throw new Exception("L'email n'a pas pu être envoyé.");
        }
    } catch (Exception $e) {
        error_log("Erreur PHPMailer: ".$e->getMessage());
        // On ne montre pas l'erreur exacte à l'utilisateur pour des raisons de sécurité
        $_SESSION['error'] = "Message enregistré mais une erreur est survenue lors de l'envoi de l'email.";
    }

    header("Location: contact.php");
    exit();

} catch (PDOException $e) {
    error_log("Erreur PDO: ".$e->getMessage());
    $_SESSION['error'] = "Une erreur est survenue. Veuillez réessayer plus tard.";
    header("Location: contact.php");
    exit();
} catch (Exception $e) {
    error_log("Erreur générale: ".$e->getMessage());
    $_SESSION['error'] = "Une erreur inattendue est survenue.";
    header("Location: contact.php");
    exit();
}