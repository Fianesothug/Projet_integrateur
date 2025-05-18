<!-- login.php -->
<?php include './includes/header.php'; ?>
<main class="login-section">
  <h1>Connexion</h1>
  <form action="traitement-login.php" method="POST" class="login-form">
    <label for="email">Email</label>
    <input type="email" id="email" name="email" required>

    <label for="password">Mot de passe</label>
    <input type="password" id="password" name="password" required>

    <button type="submit">Se connecter</button>
    <p>Pas encore de compte ? <a href="register.php">Inscrivez-vous</a></p>
  </form>
</main>