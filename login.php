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
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="code">Code:</label>
            <input type="password" id="code" name="code" required>
            <input type="submit" name="connexion" value="Se connecter">
        </form>
    </div>

    <div id="Inscription" class="tabcontent">
        <h2>Inscription</h2>
        <form method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
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