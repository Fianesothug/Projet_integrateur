<?php
require_once('includes/init.php');
require_once('includes/connexion.php');

// Vérification de la connexion à la base de données
if (!isset($bdd)) {
    $_SESSION['erreur'] = "Erreur de connexion à la base de données";
    header('Location: vendre.php#estimation');
    exit();
}

// Vérification de la méthode POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: vendre.php');
    exit();
}

// Vérification et nettoyage des données
$type = isset($_POST['type']) ? htmlspecialchars(trim($_POST['type'])) : '';
$surface = isset($_POST['surface']) ? intval($_POST['surface']) : 0;
$localisation = isset($_POST['localisation']) ? htmlspecialchars(trim($_POST['localisation'])) : '';
$pieces = isset($_POST['pieces']) ? intval($_POST['pieces']) : null;
$message = isset($_POST['message']) ? htmlspecialchars(trim($_POST['message'])) : '';
$email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';
$telephone = isset($_POST['telephone']) ? htmlspecialchars(trim($_POST['telephone'])) : '';

// Validation des données
$erreurs = [];

if (empty($type)) {
    $erreurs[] = "Le type de bien est obligatoire";
}

if ($surface <= 0) {
    $erreurs[] = "La surface doit être supérieure à 0";
}

if (empty($localisation)) {
    $erreurs[] = "La localisation est obligatoire";
}

if ($pieces !== null && $pieces <= 0) {
    $erreurs[] = "Le nombre de pièces doit être supérieur à 0";
}

if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erreurs[] = "L'adresse email n'est pas valide";
}

// S'il y a des erreurs, rediriger avec les messages d'erreur
if (!empty($erreurs)) {
    $_SESSION['erreurs'] = $erreurs;
    $_SESSION['ancien_form'] = $_POST; // Pour restaurer les données du formulaire
    header('Location: vendre.php#estimation');
    exit();
}

try {
    // Préparation de la requête
    $sql = "INSERT INTO demandes_estimation (type_bien, surface, localisation, pieces, message, email_contact, telephone_contact) 
            VALUES (:type, :surface, :localisation, :pieces, :message, :email, :telephone)";
    
    $stmt = $bdd->prepare($sql);
    
    // Exécution de la requête
    $success = $stmt->execute([
        ':type' => $type,
        ':surface' => $surface,
        ':localisation' => $localisation,
        ':pieces' => $pieces,
        ':message' => $message,
        ':email' => $email,
        ':telephone' => $telephone
    ]);

    if ($success) {
        $_SESSION['success'] = true;
        ?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Demande d'estimation envoyée - HOUSE COMPANY</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/header.css">
  <link rel="stylesheet" href="assets/css/footer.css">
  <link rel="stylesheet" href="assets/css/pages.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
  <?php include_once('includes/header.php'); ?>

  <div class="page-container" style="min-height: 80vh; display: flex; align-items: center; justify-content: center;">
    <div class="content-section text-center" style="max-width: 600px;">
      <i class="fas fa-check-circle" style="font-size: 4rem; color: var(--success); margin-bottom: 1rem;"></i>
      <h1 class="section-title">Demande envoyée avec succès !</h1>
      <p class="section-text">
        Nous avons bien reçu votre demande d'estimation pour votre bien immobilier.
        Notre équipe d'experts va l'étudier et vous contactera dans les plus brefs délais.
      </p>
      <p class="section-text">
        Un email de confirmation vous sera envoyé avec un récapitulatif de votre demande.
      </p>
      <div style="margin-top: 2rem;">
        <a href="index.php" class="page-btn">
          <i class="fas fa-home"></i> Retour à l'accueil
        </a>
        <a href="vendre.php" class="page-btn secondary" style="margin-left: 1rem;">
          <i class="fas fa-arrow-left"></i> Retour aux services de vente
        </a>
      </div>
    </div>
  </div>

  <?php include_once('includes/footer.php'); ?>
</body>

</html>
<?php
        exit();
    } else {
        throw new Exception("Erreur lors de l'enregistrement de la demande");
    }

} catch (Exception $e) {
    $_SESSION['erreur'] = "Une erreur est survenue lors du traitement de votre demande. Veuillez réessayer plus tard.";
    error_log("Erreur traitement_estimation.php : " . $e->getMessage());
    header('Location: vendre.php#estimation');
    exit();
}
?>