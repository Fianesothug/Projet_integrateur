<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/css/login.css">
  <title>login</title>
</head>

<body>

  <?php include("includes/header_connexion.php"); ?>
  <br>
  <br>
  <div class="page-center">
    <div class="main_content">
      <!-- Onglets -->
      <div class="tab">
        <button class="tablinks" onclick="openTab(event, 'Connexion')">Connexion</button>
        <button class="tablinks" onclick="openTab(event, 'Inscription')">Inscription</button>
      </div>

      <!-- Contenu des onglets -->
      <div id="Connexion" class="tabcontent">
        <h2>Saisir vos informations</h2>
        <!-- inclusion du php de la connexion -->
        <?php include('includes/connexion.php') ?>

        <form method="POST" action="">
          <label for="identifiant">Identifiant:</label>
          <input type="text" id="identifiant" name="identifiant" placeholder="Entrez votre identifiant" required>

          <label for="code">Mot de passe :</label>
          <input type="password" id="code" name="code" placeholder="Entrez votre mot de passe" required>

          <?php if (!empty($erreur)): ?>
          <div class="erreur"><?php echo htmlspecialchars($erreur); ?></div>
          <?php endif; ?>
          <br>
          <input type="submit" name="connexion" value="Se connecter">
        </form>
      </div>

      <div id="Inscription" class="tabcontent">
        <h2>Saisir vos informations</h2>
        <form method="POST" action="includes/inscription.php">
          <label for="nom">Nom:</label>
          <input type="text" id="nom" name="nom" placeholder="Entrez votre nom" required>

          <label for="prenom">Prénom:</label>
          <input type="text" id="prenom" name="prenom" placeholder="Entrez votre prénom" required>

          <label for="sexe">Sexe:</label>
          <select id="sexe" name="sexe" required>
            <option value="">Sélectionner sexe</option>
            <option value="masculin">Masculin</option>
            <option value="feminin">Féminin</option>
          </select>

          <label for="pays">Code pays:</label>
          <select id="pays" name="pays" required>
            <option value="">Sélectionner un pays</option>
            <?php include('includes/listepays.php') ?>
          </select>

          <label for="numero">Numéro de téléphone:</label>
          <input type="tel" id="numero" name="numero" required placeholder="Format XXXXXXXX...">

          <label for="email">Email:</label>
          <input type="email" id="email" name="email" placeholder="Entrez votre email" required>

          <label for="adresse">Adresse:</label>
          <input type="text" id="adresse" name="adresse" placeholder="Entrez votre adresse" required>

          <label for="identifiant_inscription">Identifiant:</label>
          <input type="text" id="identifiant_inscription" name="identifiant" placeholder="Entrez votre identifiant"
            required>

          <label for="code">Code : <br> (un renforcement de la sécurité est prévu)</label>
          <input type="password" id="code" name="code" placeholder="Entrez votre mot de passe" required>

          <input type="submit" name="inscription" value="S'inscrire">
        </form>
      </div>
      <script src="assets/js/script.js"></script>
    </div>
  </div>

  <?php include("includes/footer.php"); ?>
  <script>
  // Pour chaque formulaire de la page, on le réinitialise au chargement
  window.addEventListener('load', () => {
    document.querySelectorAll('form').forEach(form => {
      form.reset();
    });
  });

  window.addEventListener('beforeunload', () => {
    // Réinitialise tous les formulaires avant de quitter la page
    document.querySelectorAll('form').forEach(form => {
      form.reset();
    });
  });
  </script>
</body>

</html>