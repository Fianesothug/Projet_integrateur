 <!-- HEADER -->
 <link rel="stylesheet" href="assets/css/style.css">
 <link rel="stylesheet" href="assets/css/header.css">

 <header class="site-header">
   <div class="container">
     <div class="header-content">
         <!-- le logo qui bouge comporte un lien vers la presentation -->
        <a href="formulaire.PHP#presentation">
            <img src="assets/images/bannieres/logo.jpg" alt="User" class="user-image">
        </a>
       <a href="#" class="logo">
        <span>HOUSE-COMPANY</span>
       </a>

       <button class="mobile-menu-btn">
         <i class="fas fa-bars"></i>
       </button>

       <ul class="nav-menu">
         <li><a href="index.php" class="nav-link active">Accueil</a></li>

         <li><a href="agences.php" class="nav-link">Agences</a></li>
         <li><a href="propriete.php">Propriétes</a>
           <ul class="dropdown">
             <li><a href="vente.php">Propriétes à vendre</a></li>
             <li><a href="louer.php">Propriétes à louer</a></li>
           </ul>
         </li>
         <li><a href="contact.php" class="nav-link">Contact</a></li>
       </ul>

       <div class="user-actions">
         <a href="login.php" class="btn btn-outline">Connexion/Inscription</a>
         <a href="components/protection.php" class="btn btn-primary">admis</a>
       </div>
     </div>
   </div>
 </header>