<?php
// Vérification de la session et inclusion de protect2.php si nécessaire
if (!isset($_SESSION['statut'])) {
    header("Location: ../../components/protection.php");
    exit();
}

// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "gestion");
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Détermination de la table en fonction du statut
$statut = $_SESSION['statut'];
$identifiant = $_SESSION['identifiant'];

// Requête pour récupérer les infos utilisateur
$sql = "SELECT nom, prenom FROM $statut WHERE identifiant = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $identifiant);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $nom = htmlspecialchars($user['nom']);
    $prenom = htmlspecialchars($user['prenom']);
} else {
    $nom = "Utilisateur";
    $prenom = "";
}

$conn->close();
?>

<!-- le css du code  -->
 <link rel="stylesheet" href="../assets/css/entete_tableau_de_bord.css">
<!-- Inclusion de Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<header class="site-header <?php echo (basename($_SERVER['PHP_SELF']) != 'protection.php' ? 'with-sidebar' : ''); ?>">
    <div class="header-container">
        <div class="logo-section">
            <h1 class="page-title">Bienvenue à vous</h1>
        </div>

        <div class="user-section">
            <div class="user-info" id="userInfo">
                <i class="fas fa-user user-icon"></i>
                <span class="user-name"><?php echo trim($prenom . ' ' . $nom); ?></span>
                <div class="user-menu" id="userMenu">
                    <div class="user-menu-item">
                        <i class="fas fa-user"></i>
                        <span><?php echo trim($prenom . ' ' . $nom); ?></span>
                    </div>
                    <div class="user-menu-item logout-item">
                        <i class="fas fa-sign-out-alt"></i>
                        <a href="../components/protection.php">Déconnexion</a>
                    </div>
                </div>
            </div>
            <a href="../components/protection.php?logout=true" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                <span>Déconnexion</span>
            </a>
        </div>
    </div>
</header>

<script>
    // Gestion du menu utilisateur sur mobile
    document.addEventListener('DOMContentLoaded', function() {
        const userInfo = document.getElementById('userInfo');
        const userMenu = document.getElementById('userMenu');
        
        if (userInfo && userMenu) {
            userInfo.addEventListener('click', function(e) {
                // Vérifie si on est sur un écran mobile
                if (window.innerWidth <= 992) {
                    e.preventDefault();
                    e.stopPropagation(); // Empêche la propagation du clic
                    userMenu.classList.toggle('active');
                }
            });
            
            // Fermer le menu quand on clique ailleurs
            document.addEventListener('click', function(e) {
                if (!userInfo.contains(e.target) && !userMenu.contains(e.target) && userMenu.classList.contains('active')) {
                    userMenu.classList.remove('active');
                }
            });
            
            // Empêcher la fermeture du menu quand on clique dessus
            userMenu.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const page = document.body.dataset.page;

    // Sélectionne l'élément qui contient l'espacement (à adapter si nécessaire)
    const header = document.querySelector('.site-header');

    // Liste des pages qui doivent avoir un espace
    const pagesAvecEspace = ['tableau.php', 'dashboard.php', 'accueil.php'];

    if (header) {
        if (pagesAvecEspace.includes(page)) {
            header.classList.add('with-gap');
        } else {
            header.classList.remove('with-gap');
        }
    }
});
</script>

<br>
<br>
<br>
<br>