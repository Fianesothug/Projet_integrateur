 <!-- HEADER -->
 <link rel="stylesheet" href="assets/css/style.css">
 <link rel="stylesheet" href="assets/css/header.css">
 <style>
/* Affichage image  */
.user-image {
  height: 83px;
  width: 83px;
  object-fit: cover;
  margin-right: 20px;
  border-radius: 24%;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  animation: bounceImage 2s infinite ease-in-out;
}

@keyframes bounceImage {

  0%,
  100% {
    transform: translateY(0);
  }

  50% {
    transform: translateY(-10px);
  }
}

.user-image:hover {
  animation: bounceImageHover 0.5s ease-in-out;
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
}

@keyframes bounceImageHover {

  0%,
  100% {
    transform: translateY(0);
  }

  50% {
    transform: translateY(-12px);
  }
}
.nom{
  color:#0a42bb;
  font-size:1.5rem;
  margin-top:-70%;
  margin-left:105%;
}
 </style>
 <header class="site-header">
   <div class="container-hdconnexion">
     <div class="header-content">
       <!-- le logo qui bouge comporte un lien vers la presentation -->
       <a href="index.php">
         <img src="assets/images/bannieres/logo.jpg" alt="User" class="user-image">
           <strong> <p class="nom"> HAUOSE <br> COMPANY</p></strong>
       </a>
      
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
         <a href="login.php" class="btn btn-outline">Connexion/Inscription</a>
       </ul>

       <div class="user-actions">

         <a href="components/protection.php" class="btn btn-primary">admin</a>

       </div>
     </div>
   </div>
   <br>
 </header>