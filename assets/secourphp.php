<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Font Awesome CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <title>IRSS FASO</title>
  <link rel="stylesheet" href="cssSsecours.css">
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


    </div>
    <?php include_once 'includes/footer.php'; ?>

    <li class="dropdown-footer">
      <a href="#" class="dropdown-toggle-footer">
        <i class="fas fa-file-signature"></i> Menbre de l'équipe
      </a>
      <div class="dropdown-content-footer">
        <br>
        <p> 1 - </p>
        <p> 2 - </p>
        <p> 3 - </p>
        <p> 4 - </p>
        <p> 5 - </p>
        <p> 6 - </p>
      </div>
    </li>

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