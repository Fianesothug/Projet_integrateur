 <div class="wrapper">
   <div class="wrapper_container">
     <div class="box image1-box"></div> <!-- Ajoute image-box ici -->
   </div>


   <!-- Grid partie-->
   <div class="row">

     <div class="span1"></div>
     <div class="span2"></div>
     <div class="span3"></div>
     <div class="box"></div>
     <div class="box"></div>
     <div class="box"></div>
     <div class="box"></div>
     <div class="box"></div>
     <div class="box"></div>
     <div class="box"></div>
     <div class="box"></div>
     <div class="box"></div>


   </div>
 </div>



 <!-- login.php -->
 <?php include_once './includes/header.php'; ?>
 <link rel="stylesheet" href="<?= $baseURL ?>/assets/css/style.css">
 <main class="login-section">
   <h1>Connexion</h1>
   <form action="traitement-login.php" method="POST" class="login-form">
     <label for="email">Email</label>
     <input type="email" id="email" name="email" required>

     <label for="password">Mot de passe</label>
     <input type="password" id="password" name="password" required>

     <button type="submit">Se connecter</button>
     <p>Pas encore de compte ? <a href="register.php">Inscrivez-vous</a></p>
   </form>
 </main>