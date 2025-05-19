<<<<<<< Updated upstream
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/login.css">
    <title>Connexion et Inscription</title>
</head>
<body>

<div class="container">
    <!-- Onglets -->
    <div class="tab">
        <button class="tablinks" onclick="openTab(event, 'Connexion')">Connexion</button>
        <button class="tablinks" onclick="openTab(event, 'Inscription')">Inscription</button>
    </div>

    <!-- Contenu des onglets -->
    <div id="Connexion" class="tabcontent">
        <h2>Connexion</h2>
        <form method="POST">
            <label for="identifiant">identifiant:</label>
            <input type="text" id="identifiant" name="identifiant" required>
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
            
            <label for="prenom">Prenom:</label>
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

            <label for="prenom">Identifiant:</label>
            <input type="text" id="identifiant" name="identifiant" required>

            <label for="code">Code:</label>
            <input type="password" id="code" name="code" required>

            <input type="submit" name="inscription" value="S'inscrire">
        </form>
    </div>
</div>

<script>
function openTab(evt, tabName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}

// Ouvrir le premier onglet par défaut
document.getElementsByClassName('tablinks')[0].click();
</script>

</body>
</html>
=======
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
>>>>>>> Stashed changes
