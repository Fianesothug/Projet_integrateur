<!-- login.php -->
<?php include_once './includes/header.php'; ?>
<link rel="stylesheet" href="<?= $baseURL ?>/assets/css/style.css">
<div class="card_container">
  <div class="card">
    <h2>Connexion</h2>

    <!-- FORMULAIRE -->
    <form class="form" action="traitement-login.php" method="POST">
      <input type="email" name="email" placeholder="Adresse e-mail" class="email" required>
      <input type="password" name="password" placeholder="Mot de passe" class="pass" required>


      <!-- BOUTON LOGIN -->
      <button type="submit" class="login_btn">Se connecter</button>
    </form>

    <!-- LIEN VERS INSCRIPTION -->
    <p class="fp">Pas encore de compte ? <a href="register.php"><span class="inscri">Inscrivez-vous</span></a></p>
  </div>


</div>
<?php include_once 'includes/footer.php'; ?>