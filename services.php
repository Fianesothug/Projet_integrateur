<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nos Services - HOUSE-COMPANY</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/header.css">
  <link rel="stylesheet" href="assets/css/footer.css">
  <link rel="stylesheet" href="assets/css/services.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
  <?php include_once('includes/header.php'); ?>
   <br>
   <br>
  <header class="services-header">
    <nav class="services-nav">
      <ul>
        <li><a href="vendre.php"><i class="fas fa-home"></i> Vendre un bien</a></li>
        <li><a href="gestion.php"><i class="fas fa-tasks"></i> Gestion locative</a></li>
        <li><a href="guide.php"><i class="fas fa-book"></i> Votre guide</a></li>
      </ul>
    </nav>
  </header>

  <div class="services-container">
    <div class="services-grid">
      <div class="service-card">
        <h2><i class="fas fa-home"></i> Vendre un bien</h2>
        <p>Vous souhaitez vendre rapidement votre parcelle, villa ou immeuble ? Confiez-nous votre bien et bénéficiez de
          notre expertise pour une transaction réussie.</p>
        <a href="vendre.php" class="service-cta">
          <span>Confier mon bien</span>
          <i class="fas fa-arrow-right"></i>
        </a>
      </div>

      <div class="service-card">
        <h2><i class="fas fa-tasks"></i> Gestion locative</h2>
        <p>Optimisez la rentabilité de votre investissement immobilier en nous confiant la gestion de vos biens. Nous
          assurons la location, l'entretien et la gestion administrative.</p>
        <a href="gestion.php" class="service-cta">
          <span>Déléguer la gestion</span>
          <i class="fas fa-arrow-right"></i>
        </a>
      </div>

      <div class="service-card">
        <h2><i class="fas fa-book"></i> Guide immobilier</h2>
        <p>Profitez de notre expertise et de nos conseils pour réussir vos projets immobiliers. Notre guide complet vous
          accompagne à chaque étape de votre parcours.</p>
        <a href="guide.php" class="service-cta">
          <span>Consulter le guide</span>
          <i class="fas fa-arrow-right"></i>
        </a>
      </div>

      <div class="service-card">
        <h2><i class="fas fa-handshake"></i> Accompagnement personnalisé</h2>
        <p>Bénéficiez d'un suivi sur mesure pour tous vos projets immobiliers. Notre équipe d'experts est à votre
          disposition pour vous conseiller et vous guider.</p>
        <a href="contact.php" class="service-cta">
          <span>Nous contacter</span>
          <i class="fas fa-arrow-right"></i>
        </a>
      </div>
    </div>
  </div>

  <section id="guide" class="services-section">
    <h2><i class="fas fa-book"></i> Votre guide immobilier</h2>
    <p>Accédez à des conseils pratiques, des informations sur le marché immobilier local et des ressources pour vous
      aider dans vos démarches immobilières.</p>
    <a href="guide.php" class="service-cta">
      <span>Lire le guide</span>
      <i class="fas fa-arrow-right"></i>
    </a>
  </section>

  <?php include_once('includes/footer.php'); ?>

  <script>
  // Animation des cartes au scroll
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.style.opacity = '1';
        entry.target.style.transform = 'translateY(0)';
      }
    });
  }, {
    threshold: 0.1
  });

  document.querySelectorAll('.service-card, #guide').forEach(element => {
    element.style.opacity = '0';
    element.style.transform = 'translateY(20px)';
    element.style.transition = 'all 0.6s ease';
    observer.observe(element);
  });
  </script>

</body>
</html>