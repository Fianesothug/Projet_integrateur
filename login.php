<?php include_once './includes/header.php'; ?>

<link rel="stylesheet" href="<?= $baseURL ?>/assets/css/login.css">
<link rel="stylesheet" href="<?= $baseURL ?>/assets/css/style.css">

<div class="page-center">
  <div class="main_content">
    <!-- Onglets -->
    <div class="tab">
      <button class="tablinks" onclick="openTab(event, 'Connexion')">Connexion</button>
      <button class="tablinks" onclick="openTab(event, 'Inscription')">Inscription</button>
    </div>

    <!-- Contenu des onglets -->
    <div id="Connexion" class="tabcontent">
      <h2>Connexion</h2>
      <form method="POST">
        <label for="identifiant_connexion">Identifiant:</label>
        <input type="text" id="identifiant_connexion" name="identifiant" required>
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>
        <input type="submit" name="connexion" value="Se connecter">
      </form>
    </div>

    <div id="Inscription" class="tabcontent">
      <h2>Inscription</h2>
      <form method="POST" action="inscription.php">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" required>

        <label for="prenom">Prénom:</label>
        <input type="text" id="prenom" name="prenom" required>

        <label for="sexe">Sexe:</label>
        <select id="sexe" name="sexe" required>
          <option value="">Sélectionner sexe</option>
          <option value="masculin">Masculin</option>
          <option value="feminin">Féminin</option>
        </select>

        <label for="pays">Code pays:</label>
        <select id="pays" name="pays" required>
          <option value="">Sélectionner un pays</option>
          <option value="+226">Burkina Faso (+226)</option>
          <option value="+258">Mozambique (+258)</option>
        </select>

        <label for="numero">Numéro de téléphone:</label>
        <input type="tel" id="numero" name="numero" required placeholder="Format XXXXXXXX...">

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="adresse">Adresse:</label>
        <input type="text" id="adresse" name="adresse" required>

        <label for="identifiant_inscription">Identifiant:</label>
        <input type="text" id="identifiant_inscription" name="identifiant" required>

        <label for="code">Code:</label>
        <input type="password" id="code" name="code" required>

        <input type="submit" name="inscription" value="S'inscrire">
      </form>
    </div>
    <script src="./assets/js/script.js"></script>
  </div>
</div>

<?php include_once 'includes/footer.php'; ?>