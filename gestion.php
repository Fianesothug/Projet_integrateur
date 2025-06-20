<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestion Locative - HOUSE COMPANY</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/header.css">
  <link rel="stylesheet" href="assets/css/footer.css">
  <link rel="stylesheet" href="assets/css/pages.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
  <?php include_once('includes/header.php'); ?>

  <header class="page-header">
    <div class="page-header-content">
      <h1 class="page-title">Gestion Locative</h1>
      <p class="page-subtitle">HOUSE COMPANY - Optimisez la rentabilité de vos biens immobiliers avec notre service de
        gestion locative professionnel</p>
    </div>
  </header>

  <div class="page-container">
    <section class="content-section">
      <h2 class="section-title"><i class="fas fa-building"></i> Confiez-nous la gestion de vos biens immobiliers</h2>
      <p class="section-text">
        Optimisez la rentabilité de votre investissement immobilier en nous confiant la gestion de vos biens.
        Nous assurons la <strong>location</strong>, l'<strong>entretien</strong> et la <strong>gestion
          administrative</strong>.
      </p>

      <div class="services">
        <div class="service-card">
          <h3>Location</h3>
          <p>
            Nous trouvons rapidement des locataires fiables grâce à notre réseau et nos outils de diffusion performants.
          </p>
        </div>
        <div class="service-card">
          <h3>Entretien</h3>
          <p>
            Gestion des réparations, entretien régulier, suivi des interventions techniques : votre bien est entre de
            bonnes mains.
          </p>
        </div>
        <div class="service-card">
          <h3>Gestion Administrative</h3>
          <p>
            Rédaction des baux, quittances, suivi des paiements et relances : on s'occupe de tout, pour vous.
          </p>
        </div>
      </div>
    </section>

    <section class="content-section">
      <h2 class="section-title"><i class="fas fa-list-check"></i> Nos Services de Gestion Locative</h2>
      <div class="grid-container">
        <div class="content-section">
          <h3><i class="fas fa-search"></i> Recherche et Sélection des Locataires</h3>
          <p>Nous effectuons une sélection rigoureuse des locataires avec vérification complète des dossiers et des
            garanties.</p>
        </div>

        <div class="content-section">
          <h3><i class="fas fa-file-contract"></i> Gestion Administrative</h3>
          <p>Rédaction des baux, états des lieux, quittances de loyer et gestion de toute la documentation légale.</p>
        </div>

        <div class="content-section">
          <h3><i class="fas fa-coins"></i> Gestion Financière</h3>
          <p>Encaissement des loyers, charges, et dépôts de garantie. Relance des impayés et gestion des contentieux.</p>
        </div>

        <div class="content-section">
          <h3><i class="fas fa-wrench"></i> Suivi Technique</h3>
          <p>Organisation et suivi des travaux d'entretien, coordination avec les artisans et gestion des urgences
            techniques.</p>
        </div>
      </div>
    </section>

    <section class="content-section">
      <h2 class="section-title"><i class="fas fa-shield-alt"></i> Nos Garanties</h2>
      <ul class="feature-list">
        <li><i class="fas fa-check"></i> Garantie des loyers impayés</li>
        <li><i class="fas fa-check"></i> Protection juridique complète</li>
        <li><i class="fas fa-check"></i> Assurance dégradations locatives</li>
        <li><i class="fas fa-check"></i> Bilan de gestion mensuel détaillé</li>
      </ul>
      <div class="text-center" style="margin-top: 2rem;">
        <a href="contact.php" class="page-btn">
          <i class="fas fa-envelope"></i> Contactez-nous pour plus d'informations
        </a>
      </div>
    </section>
  </div>

  <?php include_once('includes/footer.php'); ?>
</body>

</html>