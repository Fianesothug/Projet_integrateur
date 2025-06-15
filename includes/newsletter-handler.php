<?php
session_start();
header('Content-Type: application/json');

// Validation de la requête
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['email'], $_POST['csrf_token'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Requête invalide.']);
    exit;
}

// Protection CSRF
if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Token CSRF invalide.']);
    exit;
}

// Régénération du token
unset($_SESSION['csrf_token']);

// Configuration
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Validation email
$email = filter_var(strtolower(trim($_POST['email'])), FILTER_VALIDATE_EMAIL);
if (!$email) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Adresse email invalide.']);
    exit;
}

// Connexion DB (à mettre dans un fichier séparé)
$config = include 'config/db.php'; // Créez ce fichier avec vos credentials
$conn = new mysqli($config['host'], $config['user'], $config['pass'], $config['db']);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erreur de base de données.']);
    exit;
}

// Vérification existence
$stmt = $conn->prepare("SELECT id FROM newsletter_subscriptions WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();

if ($stmt->get_result()->num_rows > 0) {
    http_response_code(409);
    echo json_encode(['success' => false, 'message' => 'Email déjà inscrit.']);
    exit;
}

// Envoi email
try {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'votre.email@gmail.com'; // Utiliser une variable d'environnement
    $mail->Password = getenv('SMTP_PASSWORD'); // Beaucoup plus sécurisé
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;

    $mail->setFrom('no-reply@votresite.com', 'HOUSE-COMPANY');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'Dernières offres exclusives';
    $mail->Body = generateEmailTemplate($email); // Fonction à créer

    $mail->send();

    // Enregistrement en DB
    $stmt = $conn->prepare("INSERT INTO newsletter_subscriptions (email, subscribed_at) VALUES (?, NOW())");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    echo json_encode([
        'success' => true,
        'message' => 'Inscription réussie. Email envoyé.'
    ]);
} catch (Exception $e) {
    http_response_code(500);
    error_log('Erreur newsletter: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'inscription.']);
}