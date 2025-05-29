 <!-- LIEN VERS INSCRIPTION -->
 <p class="fp">Pas encore de compte ? <a href="register.php"><span class="inscri">Inscrivez-vous</span></a></p>
 </div>



 <!-- pied de page  -->


 </div>
 <?php include_once 'includes/footer.php'; ?>



 <!DOCTYPE html>
 <html lang="fr">

 <head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <!-- Font Awesome CDN -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
     crossorigin="anonymous" referrerpolicy="no-referrer" />

   <title>IRSS FASO</title>
   <link rel="stylesheet" href="css/pied.css">
 </head>

 <body>
   <!-- Début du pied de page amélioré -->
   <section id="contact"></section>
   <footer>
     <div class="footer-container">
       <div class="footer-section">
         <h3>Plan du Site</h3>
         <ul>
           <li class="dropdown-footer">
             <a href="#" class="dropdown-toggle-footer">
               <i class="fas fa-home"></i> Accueil
             </a>
             <div class="dropdown-content-footer">
               <br>
               <a href="formulaire.PHP#presentation"><i class="fas fa-info-circle"></i> 1 - Présentation</a>
               <br>
               <a href="formulaire.PHP#instruction"><i class="fas fa-list-ol"></i> 2 - Instruction</a>
               <br>
               <a href="formulaire.PHP#calendrier"><i class="fas fa-calendar-alt"></i> 3 - Calendrier</a>
               <br>
               <a href="formulaire.PHP#thematique"><i class="fas fa-book-open"></i> 4 - Thématique</a>
               <br>
             </div>
           </li>
           <li class="dropdown-footer">
             <a href="#" class="dropdown-toggle-footer">
               <i class="fas fa-file-signature"></i> Souscription
             </a>
             <div class="dropdown-content-footer">
               <br>
               <a href="formulaire.PHP#soumission"><i class="fas fa-upload"></i> 1 - Soumission</a>
               <br>
               <a href="user.php"><i class="fas fa-user-plus"></i> 2 - Inscription</a>
               <br>
               <a href="paiement.php"><i class="fas fa-credit-card"></i> 3 - Paiement</a>
               <br>
               <a href="formulaire.PHP#modisup"><i class="fas fa-edit"></i> 4 - Modification</a>
               <br>
               <a href="formulaire.PHP#modisup"><i class="fas fa-trash-alt"></i> 5 - Suppression</a>
               <br>
             </div>
           </li>
           <li>
             <a href="resultat.php"><i class="fas fa-poll"></i> Résultat</a>
           </li>
           <li>
             <a href="#contact"><i class="fas fa-envelope"></i> Contact</a>
           </li>
           <li>
             <a href="admis.php"><i class="fas fa-check-circle"></i> Admis</a>
           </li>
         </ul>
       </div>

       <div class="footer-section">
         <h3>Contact</h3>
         <ul>
           <li>
             <a href="tel:+1234567890">
               <i class="fas fa-phone"></i> +123 456 7890
             </a>
           </li>
           <li>
             <a href="mailto:contact@irssfaso.bf">
               <i class="fas fa-envelope"></i> contact@irssfaso.bf
             </a>
           </li>
           <li>
             <a href="#">
               <i class="fas fa-map-marker-alt"></i> Ouagadougou, Burkina Faso
             </a>
           </li>
         </ul>
         <div class="social-links">
           <a href="https://wa.me/11234567890" target="_blank" aria-label="WhatsApp">
             <i class="fab fa-whatsapp" style="color:#25D366; font-size:30px;"></i>
           </a>
           <a href="https://www.facebook.com/YourPage" target="_blank" aria-label="Facebook">
             <i class="fab fa-facebook-f" style="color:#1877F3; font-size:30px;"></i>
           </a>
           <a href="https://www.instagram.com/YourPage" target="_blank" aria-label="Instagram">
             <i class="fab fa-instagram" style="color:#962fbf; font-size:30px;"></i>
           </a>
         </div>
       </div>

       <div class="footer-section">
         <h3>Nos Horaires</h3>
         <div class="opening-hours">
           <p><i class="fas fa-clock" style="color:white;margin-right:8px;"></i>Lun 18h-20h</p>
           <p><i class="fas fa-clock" style="color:white;margin-right:8px;"></i>Mar 18h-20h</p>
           <p><i class="fas fa-clock" style="color:white;margin-right:8px;"></i>Mer 18h-20h</p>
           <p><i class="fas fa-clock" style="color:white;margin-right:8px;"></i>Jeu 18h-20h</p>
           <p><i class="fas fa-clock" style="color:white;margin-right:8px;"></i>Ven 18h-20h</p>
           <p><i class="fas fa-clock" style="color:white;margin-right:8px;"></i>Sam 18h-20h</p>
         </div>
       </div>
     </div>

     <div class="footer-bottom">
       <h3>
         <p>&copy; 2025 IRSS FASO - Tous droits réservés |
           <a href="formulaire.PHP#presentation" style="color: white;">
             <i class="fas fa-info-circle"></i> Présentation des services
           </a>
           | <a href="formulaire.PHP#instruction" style="color: white;">
             <i class="fas fa-list-ol"></i> Instructions à suivre
           </a>
         </p>
       </h3>
     </div>
   </footer>
   <!-- Fin du pied de page -->

   <script>
   document.addEventListener("DOMContentLoaded", function() {
     const dropdownsFooter = document.querySelectorAll('.dropdown-footer');

     // Gestion des sous-menus dans le footer
     dropdownsFooter.forEach(dropdown => {
       const toggle = dropdown.querySelector('.dropdown-toggle-footer');

       toggle.addEventListener('click', function(event) {
         event.preventDefault();
         dropdown.classList.toggle('active-footer');

         // Fermer les autres dropdowns
         dropdownsFooter.forEach(otherDropdown => {
           if (otherDropdown !== dropdown) {
             otherDropdown.classList.remove('active-footer');
           }
         });
       });
     });

     // Clic en dehors du menu pour fermer
     window.addEventListener('click', function(event) {
       if (!event.target.closest('.dropdown-footer')) {
         dropdownsFooter.forEach(dropdown => {
           dropdown.classList.remove('active-footer');
         });
       }
     });
   });
   </script>
 </body>

 </html>

 <div class="header-actions">
   <div class="quick-actions">
     <a href="login.php" class="button secondary">Se connecter/S'inscrire</a>
     <a href="deposer-annonce" class="button primary">Déposer une annonce</a>
   </div>
   <form class="search-form" action="/recherche" method="get">
     <input type="search" name="q" placeholder="Rechercher..." aria-label="Recherche">
     <button type="submit" class="search-button">
       <span aria-hidden="true">🔍</span>
     </button>
   </form>
 </div>
 </div>
 </header>