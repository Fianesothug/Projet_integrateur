<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!-- HEADER -->
<link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="assets/css/header.css">
<style>
/* Affichage image  */
.user-image {
  height: 83px;
  width: 83px;
  object-fit: cover;
  border-radius: 15px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  transition: all 0.3s ease;
}
.nom{
  font-size:1.5rem;
}
</style>
<header class="site-header">
  <br>
  <div class="container">
    <div class="header-content">
      <!-- Logo et nom de l'entreprise -->
      <div class="logo-container">
        <a href="index.php" class="logo">
          <img src="assets/images/bannieres/logo.jpg" alt="Logo House-Company" class="user-image">
           <h2 class="nom"> HOUSE <br> COMPANY</h2>
        </a>
      </div>
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
        <a href="login.php" class="btn btn-outline">Connexion/Inscription</a>

        <a href="components/protection.php" class="btn btn-primary">admin</a>

      </div>
    </div>
  </div>
  <br>
</header>