<?php if (isset($_SESSION['role'])) {
    switch ($_SESSION['role']) {
        case 'client':
            echo '<a href="/client/tableau-bord.php">Mon compte</a>';
            break;
        case 'bailleur':
            echo '<a href="/bailleur/tableau-bord.php">Mes propriétés</a>';
            break;
        case 'manager':
            echo '<a href="/employe/manager/tableau-bord.php">Manager</a>';
            break;
    }
} else {
    echo '<a href="login.php">Connexion</a>';
}
?>