<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['email'], $_POST['csrf_token'])) {
    echo json_encode(['success' => false, 'message' => 'Requête invalide.']);
    exit;
}

if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    echo json_encode(['success' => false, 'message' => 'Token CSRF invalide.']);
    exit;
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$email = strtolower(trim($_POST['email']));
$email = filter_var($email, FILTER_SANITIZE_EMAIL);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Adresse email invalide.']);
    exit;
}

$host = "localhost";
$user = "root";
$pass = "";
$db = "gestion";
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Connexion à la base échouée.']);
    exit;
}

$stmt = $conn->prepare("SELECT id FROM messages WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Cet email est déjà inscrit.']);
    $stmt->close();
    $conn->close();
    exit;
}
$stmt->close();

$conn->autocommit(false);

try {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'decidaisomar@gmail.com';
    $mail->Password = 'dspkjjgzuahscwxp';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;

    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        ]
    ];

    $mail->setFrom('no-reply@tonsite.com', 'HAOUSE-CONPANY');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'Recevez les dernieres offres exclusives';
    $mail->Body = '
    <div style="font-family: Arial, sans-serif; border:1px solid #ddd; border-radius:8px; overflow:hidden; max-width:600px; margin:auto;">
        <div style="background-color:#007BFF; color:white; padding:20px; text-align:center;">
            <h1 style="margin:0;">HAOUSE-CONPANY</h1>
            <p style="margin:0; font-size:18px;">Recevez les dernières offres exclusives</p>
        </div>
        <div style="padding:20px; background-color:#ffffff; color:#000000;">
            <h2 style="color:#333;">Merci pour votre inscription !</h2>
            <p>Vous êtes désormais inscrit à notre newsletter.</p>
            <p>Nous vous enverrons régulièrement nos meilleures offres, actualités et conseils personnalisés.</p>
            <p style="margin-top:30px;">Cordialement,<br>L\'équipe <strong>HAOUSE-CONPANY</strong></p>
        </div>
    </div>';

    $mail->send();

    $stmt = $conn->prepare("INSERT INTO messages (email, date_envoi) VALUES (?, NOW())");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $conn->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Inscription réussie. Un email a été envoyé à ' . htmlspecialchars($email)
    ]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => "Erreur : " . $e->getMessage()]);
} finally {
    $conn->autocommit(true);
    $conn->close();
}