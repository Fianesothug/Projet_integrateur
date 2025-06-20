<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>


  <?php 
include_once ('includes/header.php'); 

// Debug des sessions
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Vérifier si la session est active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Générer un token CSRF
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Debug - à retirer en production
echo "<!-- Debug: Session ID=" . session_id() . " -->";
echo "<!-- Debug: CSRF Token=" . $_SESSION['csrf_token'] . " -->";
?>
  <link rel="stylesheet" href="assets/css/contact.css">
  
  <main>
    <div class="wrapper">
      <?php
      if(isset($_SESSION['error'])) {
          echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
          unset($_SESSION['error']);
      }
      if(isset($_SESSION['success'])) {
          echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
          unset($_SESSION['success']);
      }
      ?>
    <h2>Contactez nous</h2>

    <form action="traitement_contact.php" method="POST" id="contactForm">
      <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
      <div class="input_field">
        <input type="text" name='nom' placeholder="Nom" id="nom" required>
      </div>
      <div class="input_field">
        <input type="text" name='prenom' placeholder="Prenom" id="prenom" required>
      </div>
      <div class="input_field">
        <input type="text" name='telephone' placeholder="Telephone" id="phone" required>
      </div>
      <div class="input_field">
        <input type="text" name='email' placeholder="Email" id="email" required>
      </div>
      <div class="input_field">
        <textarea name='message' placeholder="Message" id="message" required></textarea>
      </div>
      <div class="btn">
        <input type="submit" value="Soummetre" id="submit">
      </div>
    </form>
  </div>
  </main>
  
  <?php include_once ('includes/footer.php'); ?>
</body>

</html>