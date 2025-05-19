<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation d'inscription</title>
<style>
    /* Styles de base */
    body {
        text-align:center;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        line-height: 1.6;
        margin: 0;
        padding: 0;
        background-color: #f8f9fa;
        color: #333;
    }

    /* Conteneur principal */
    .container {
        max-width: 900px;
        margin: 2rem auto;
        padding: 2rem;
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    /* Liens de navigation */
    h1 a {
        display: inline-block;
        padding: 12px 24px;
        background-color: #8B0000;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        margin: 10px 0;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    h1 a:hover {
        background-color: #a52a2a;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    /* Titres */
    h2 {
        color: #8B0000;
        margin: 1.5rem 0;
        font-size: 1.8rem;
        font-weight: 600;
        line-height: 1.3;
    }

    /* Messages d'état */
    .error {
        color: #dc3545;
        padding: 1rem;
        background: #f8d7da;
        border-left: 4px solid #dc3545;
        margin: 1.5rem 0;
        border-radius: 4px;
        font-size: 1.1rem;
        
    }

    .success {
        color: #28a745;
        padding: 1rem;
        background: #d4edda;
        border-left: 4px solid #28a745;
        margin: 1.5rem 0;
        border-radius: 4px;
        font-size: 1.1rem;
        text-align:center;
    }

    /* Boutons */
    #retryButton {
        padding: 10px 20px;
        background: #8B0000;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 1rem;
        transition: all 0.3s ease;
        margin-left: 10px;
    }

    #retryButton:hover {
        background: #a52a2a;
        transform: translateY(-1px);
    }

    /* Section vérification email */
    .check-email {
        margin-top: 1rem;
        font-size: 0.95rem;
        color: #6c757d;
    }

    .check-email a {
        color: #8B0000;
        text-decoration: none;
        font-weight: 500;
    }

    .check-email a:hover {
        text-decoration: underline;
    }

    /* Debug (optionnel) */
    .debug-toggle {
        color: #007bff;
        cursor: pointer;
        font-size: 0.85rem;
        display: inline-block;
        margin-top: 10px;
    }

    .debug-info {
        display: none;
        background: #f8f9fa;
        padding: 15px;
        border: 1px solid #dee2e6;
        margin-top: 15px;
        font-family: 'Courier New', monospace;
        white-space: pre-wrap;
        font-size: 0.85rem;
        border-radius: 4px;
        max-height: 300px;
        overflow-y: auto;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .container {
            padding: 1.5rem;
            margin: 1rem;
        }
        
        h2 {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 480px) {
        h1 a, #retryButton {
            width: 100%;
            text-align: center;
            margin: 5px 0;
        }
    }
</style>
    <!-- Ajout de SweetAlert pour de belles alertes -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Ajout de jQuery pour faciliter les requêtes AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<h1 class="hh"><a href="user.PHP">Retour</a></h1>

<?php
// Fonction pour valider l'email
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Vérification du numéro (uniquement des chiffres)
if (isset($_POST['numero'])) {
    $numero = trim($_POST['numero']);
    if (!preg_match('/^\d+$/', $numero)) {
        echo "<p class='error'>Le numéro doit contenir uniquement des chiffres.</p>";
        exit;
    }
}

// Vérification des mots-clés (1 à 6 mots séparés par virgules)
if (isset($_POST['mot'])) {
    $commentaire = trim($_POST["mot"]);
    $mots = array_map('trim', explode(',', $commentaire));
    $mots = array_filter($mots);
    if (count($mots) < 1 || count($mots) > 6) {
        echo "<p class='error'>Les mots-clés doivent être entre 1 et 6, séparés par des virgules.</p>";
        exit;
    }
    $mot = implode(',', $mots);
} else {
    $mot = '';
}

// Vérification du résumé
if (isset($_POST['message'])) {
    $resume = trim($_POST["message"]);
    $nb_mots = str_word_count($resume);
    if ($nb_mots > 15) {
        echo "<p class='error'>Le résumé ne doit pas dépasser 15 mots.</p>";
        exit;
    }
    if (strlen($resume) > 250) {
        echo "<p class='error'>Le résumé ne doit pas dépasser 250 caractères.</p>";
        exit;
    }
} else {
    $resume = '';
}

// Connexion à la base de données
$db_host = "localhost";
$db_name = "formulaireirss";
$db_user = "root";
$db_pass = "";

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$conn) {
    die("<p class='error'>Échec de la connexion à la base de données 😔 : " . mysqli_connect_error() . "</p>");
}

// Récupération et sécurisation des données
$nom = isset($_POST['nom']) ? mysqli_real_escape_string($conn, trim($_POST['nom'])) : '';
$prenom = isset($_POST['prenom']) ? mysqli_real_escape_string($conn, trim($_POST['prenom'])) : '';
$sexe = isset($_POST['sexe']) ? mysqli_real_escape_string($conn, trim($_POST['sexe'])) : '';
$numero = isset($_POST['numero']) ? mysqli_real_escape_string($conn, trim($_POST['numero'])) : '';
$adresse = isset($_POST['adresse']) ? mysqli_real_escape_string($conn, trim($_POST['adresse'])) : '';
$departement = isset($_POST['departement']) ? mysqli_real_escape_string($conn, trim($_POST['departement'])) : '';
$diplome = isset($_POST['diplome']) ? mysqli_real_escape_string($conn, trim($_POST['diplome'])) : '';
$fonction = isset($_POST['fonction']) ? mysqli_real_escape_string($conn, trim($_POST['fonction'])) : '';
$universite = isset($_POST['universite']) ? mysqli_real_escape_string($conn, trim($_POST['universite'])) : '';
$titreCa = isset($_POST['titreCa']) ? mysqli_real_escape_string($conn, trim($_POST['titreCa'])) : '';
$message = mysqli_real_escape_string($conn, $resume);
$country_code = isset($_POST['pays']) ? mysqli_real_escape_string($conn, trim($_POST['pays'])) : '';
$username = isset($_POST['username']) ? mysqli_real_escape_string($conn, trim($_POST['username'])) : '';
$password = isset($_POST['password']) ? mysqli_real_escape_string($conn, trim($_POST['password'])) : '';
$code_payement = isset($_POST['code_payement']) ? mysqli_real_escape_string($conn, trim($_POST['code_payement'])) : '';

// Vérification si username, password ou code_payement existent déjà
$check_sql = "SELECT * FROM formulaireirss 
              WHERE username = '$username' 
              OR password = '$password' 
              OR code_payement = '$code_payement'";
$result = mysqli_query($conn, $check_sql);

if (mysqli_num_rows($result) > 0) {
    header("Location: inva.php");
    exit;
}

// Requête SQL d'insertion
$sql = "INSERT INTO formulaireirss (nom, prenom, password, sexe, username, numero, adresse, fonction, diplome, universite, departement, titreCa, pays, code_payement)    
        VALUES ('$nom', '$prenom', '$password', '$sexe', '$username', '$numero', '$adresse', '$fonction', '$diplome', '$universite', '$departement', '$titreCa', '$country_code', '$code_payement')";

if (mysqli_query($conn, $sql)) {
    $civilite = ($sexe == 'masculin') ? 'Monsieur' : 'Madame';
    echo "<h2> $civilite :<strong>$nom $prenom</strong> <br>votre inscription a été faite avec succès 😁</h2>";
    echo "<h2>Votre nom d'utilisateur est : 👉 $username 👈</h2>";
    echo "<h2>Votre mot de passe est : 👉 $password 👈</h2>";
    echo "<h2>Votre code de paiement est : 👉 $code_payement 👈</h2>";
    echo "<h2>Veuillez garder ces informations à l'abri <br> car elles sont inchangeables.</h2>";
} else {
    echo "<h2 class='error'>Échec de l'envoi : " . mysqli_error($conn) . "</h2>";
    exit;
}

mysqli_close($conn);

// Configuration de l'email
$email_destinataire = $adresse;
$email_sujet = "Vos informations d'inscription";

$email_message = "
<html>
<head>
    <title>Vos informations d'inscription</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        .header { background-color: #8B0000; color: white; padding: 10px; text-align: center; border-radius: 5px 5px 0 0; }
        .content { padding: 20px; }
        .footer { margin-top: 20px; font-size: 0.8em; text-align: center; color: #777; }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h2>Confirmation d'inscription</h2>
        </div>
        <div class='content'>
            <p>Bonjour $civilite $nom $prenom,</p>
            <p>Votre inscription a été enregistrée avec succès. Voici vos informations :</p>
            
            <p><strong>Nom d'utilisateur :</strong> $username</p>
            <p><strong>Mot de passe :</strong> $password</p>
            <p><strong>Code de paiement :</strong> $code_payement</p>
            
            <p>Veuillez conserver ces informations précieusement car elles sont indispensables pour accéder à votre compte.</p>
        </div>
        <div class='footer'>
            <p>Cet email a été envoyé automatiquement, merci de ne pas y répondre.</p>
        </div>
    </div>
</body>
</html>";

// Fonction pour envoyer l'email avec plusieurs méthodes de secours
function sendEmailWithRetry($to, $subject, $message) {
    // Méthode 1: PHPMailer (primaire)
    require_once 'PHPMailer/src/Exception.php';
    require_once 'PHPMailer/src/PHPMailer.php';
    require_once 'PHPMailer/src/SMTP.php';

    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
    
    try {
        // Configuration SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ckprod7295@gmail.com';
        $mail->Password = 'dxclrvkugoqiqdly';
        $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        $mail->setFrom('ckprod7295@gmail.com', 'Service d\'inscription');
        $mail->addAddress($to);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->AltBody = strip_tags($message);

        if ($mail->send()) {
            return true;
        }
    } catch (Exception $e) {
        error_log("PHPMailer Error: " . $e->getMessage());
    }

    // Méthode 2: Fonction mail() native de PHP (secondaire)
    try {
        $headers = "From: ckprod7295@gmail.com\r\n";
        $headers .= "Reply-To: ckprod7295@gmail.com\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        if (mail($to, $subject, $message, $headers)) {
            return true;
        }
    } catch (Exception $e) {
        error_log("mail() Error: " . $e->getMessage());
    }

    return false;
}

// Vérification et envoi de l'email
if (validateEmail($email_destinataire)) {
    $email_sent = sendEmailWithRetry($email_destinataire, $email_sujet, $email_message);
    
    if ($email_sent) {
        echo "<p class='success'>Un email contenant vos informations a été envoyé à $email_destinataire  <br> veuillez vous rendre au niveau de <strong> l'onglet `≡` </strong> dans votre compte Gmail puis clické sur <strong> spam </strong> pour voir vos informations</p>";
    } else {
        echo "<p class='error' id='emailError'>L'email n'a pas pu être envoyé. <button id='retryButton'>Réessayer</button></p>";
    }
} else {
    echo "<p class='error'>L'adresse email fournie n'est pas valide.</p>";
}
?>

<h1 class="hh"><a href="formulaire.PHP#soumission">soumissions</a></h1>

<script>
// Script pour réessayer l'envoi d'email via AJAX
$(document).ready(function() {
    $('#retryButton').click(function() {
        Swal.fire({
            title: 'Envoi en cours...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
                
                $.ajax({
                    type: "POST",
                    url: "resend_email.php",
                    data: {
                        email: "<?php echo $email_destinataire; ?>",
                        sujet: "<?php echo addslashes($email_sujet); ?>",
                        message: `<?php echo addslashes($email_message); ?>`
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: response.success ? 'success' : 'error',
                            title: response.success ? 'Email envoyé!' : 'Erreur',
                            text: response.message
                        });
                        
                        if (response.success) {
                            $('#emailError').remove();
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: 'Une erreur est survenue lors de la communication avec le serveur'
                        });
                    }
                });
            }
        });
    });
});
</script>

<!-- Création du fichier resend_email.php dans le même dossier -->
<?php
// Code pour créer le fichier resend_email.php
$resend_email_code = '<?php
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $to = $_POST["email"] ?? "";
    $subject = $_POST["sujet"] ?? "";
    $message = $_POST["message"] ?? "";

    if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["success" => false, "message" => "Adresse email invalide"]);
        exit;
    }

    // Essayer d\'abord avec PHPMailer
    require_once "PHPMailer/src/Exception.php";
    require_once "PHPMailer/src/PHPMailer.php";
    require_once "PHPMailer/src/SMTP.php";

    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
    
    try {
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "ckprod7295@gmail.com";
        $mail->Password = "dxclrvkugoqiqdly";
        $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;
        $mail->SMTPOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
                "allow_self_signed" => true
            )
        );

        $mail->setFrom("ckprod7295@gmail.com", "Service d\'inscription");
        $mail->addAddress($to);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->AltBody = strip_tags($message);

        if ($mail->send()) {
            echo json_encode(["success" => true, "message" => "Email envoyé avec succès"]);
            exit;
        }
    } catch (Exception $e) {
        error_log("PHPMailer Error: " . $e->getMessage());
    }

    // Si PHPMailer échoue, essayer avec la fonction mail() native
    $headers = "From: ckprod7295@gmail.com\r\n";
    $headers .= "Reply-To: ckprod7295@gmail.com\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    if (mail($to, $subject, $message, $headers)) {
        echo json_encode(["success" => true, "message" => "Email envoyé avec la méthode alternative"]);
    } else {
        echo json_encode(["success" => false, "message" => "Échec de l\'envoi de l\'email"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Méthode non autorisée"]);
}
?>';

// Créer le fichier resend_email.php s'il n'existe pas
if (!file_exists('resend_email.php')) {
    file_put_contents('resend_email.php', $resend_email_code);
}
?>
</body>
</html>