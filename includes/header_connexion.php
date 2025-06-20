<style>
  .nom{
  margin-right: 50%;
}
</style>
<!-- HEADER -->
<link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="assets/css/header.css">
<link rel="stylesheet" href="assets/css/header_connexion.css">
<header class="site-header">
   <div class="container-hdconnexion">
     <div class="header-content">
       <!-- le logo qui bouge comporte un lien vers la presentation -->
       <a href="index.php">
         <img src="assets/images/bannieres/logo.jpg" alt="User" class="user-image">
       </a>
        <strong><h2> HOUSE <br> COMPANY</h2></strong>
       <button class="mobile-menu-btn">
         <i class="fas fa-bars"></i>
       </button>

       <ul class="nav-menu">
         <li><a href="index.php" class="nav-link active">Accueil</a></li>

         <li><a href="propriete.php">Propriétes</a>
           <ul class="dropdown">
             <li><a href="vente.php">Propriétes à vendre</a></li>
             <li><a href="louer.php">Propriétes à louer</a></li>
           </ul>
         </li>
         <li><a href="services.php" class="nav-link">Services</a></li>

         <li><a href="contact.php" class="nav-link">Contact</a></li>
       </ul>

       <div class="user-actions">

         <a href="components/protection.php" class="btn btn-primary">admin</a>

       </div>
     </div>
   </div>
 </header>

<script>
// JavaScript pour la responsivité du menu mobile
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const navMenu = document.querySelector('.nav-menu');
    
    mobileMenuBtn.addEventListener('click', function() {
        navMenu.classList.toggle('show');
    });
    
    // Fermer le menu déroulant quand on clique sur un lien
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(function(link) {
        link.addEventListener('click', function() {
            if (navMenu.classList.contains('show')) {
                navMenu.classList.remove('show');
            }
        });
    });
    
    // Gestion du redimensionnement de la fenêtre
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768 && navMenu.classList.contains('show')) {
            navMenu.classList.remove('show');
        }
    });
});
</script>