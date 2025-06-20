<?php include_once('includes/init.php'); ?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vendre votre bien - HOUSE COMPANY</title>
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
      <h1 class="page-title">Vendre votre bien</h1>
      <p class="page-subtitle">Confiez la vente de votre bien à des experts et bénéficiez d'un accompagnement
        personnalisé</p>
    </div>
  </header>

  <div class="page-container">
    <section class="content-section">
      <h2 class="section-title"><i class="fas fa-home"></i> Confiez-nous votre bien</h2>
      <p class="section-text">
        Chez <strong>HOUSE COMPANY</strong>, nous mettons notre expertise et notre réseau à votre service pour vendre
        votre bien rapidement et au meilleur prix. Gagnez du temps et bénéficiez d'un accompagnement personnalisé à
        chaque
        étape.
      </p>
    </section>

    <section class="content-section">
      <h2 class="section-title"><i class="fas fa-chart-line"></i> Nos services de vente</h2>
      <div class="grid-container">
        <div class="content-section">
          <h3><i class="fas fa-calculator"></i> Estimation gratuite</h3>
          <p>Estimation professionnelle de votre bien basée sur une analyse approfondie du marché local.</p>
        </div>

        <div class="content-section">
          <h3><i class="fas fa-camera"></i> Photos professionnelles</h3>
          <p>Mise en valeur de votre bien avec des photos de qualité professionnelle et une visite virtuelle.</p>
        </div>

        <div class="content-section">
          <h3><i class="fas fa-bullhorn"></i> Marketing ciblé</h3>
          <p>Diffusion de votre annonce sur les meilleurs supports et réseaux immobiliers.</p>
        </div>

        <div class="content-section">
          <h3><i class="fas fa-file-signature"></i> Accompagnement juridique</h3>
          <p>Assistance complète pour toutes les démarches administratives et juridiques.</p>
        </div>
      </div>
    </section>

    <section class="content-section">
      <h2 class="section-title"><i class="fas fa-list-check"></i> Notre processus de vente</h2>
      <ul class="feature-list">
        <li><i class="fas fa-check"></i> Estimation gratuite de votre bien</li>
        <li><i class="fas fa-check"></i> Reportage photos professionnel</li>
        <li><i class="fas fa-check"></i> Diffusion sur les meilleurs supports</li>
        <li><i class="fas fa-check"></i> Organisation des visites</li>
        <li><i class="fas fa-check"></i> Négociation avec les acheteurs potentiels</li>
        <li><i class="fas fa-check"></i> Accompagnement jusqu'à la signature</li>
      </ul>
    </section>

    <section class="content-section">
      <h2 class="section-title"><i class="fas fa-handshake"></i> Demandez une estimation</h2>
      <form class="form-group" action="traitement_estimation.php" method="POST">
        <div class="grid-container" style="grid-template-columns: 1fr 1fr;">
          <div>
            <label for="type">Type de bien</label>
            <select id="type" name="type" required>
              <option value="">Sélectionnez</option>
              <option value="appartement">Appartement</option>
              <option value="maison">Maison</option>
              <option value="terrain">Terrain</option>
              <option value="commerce">Commerce</option>
            </select>
          </div>

          <div>
            <label for="surface">Surface (m²)</label>
            <input type="number" id="surface" name="surface" required>
          </div>

          <div>
            <label for="localisation">Localisation</label>
            <input type="text" id="localisation" name="localisation" required>
          </div>

          <div>
            <label for="pieces">Nombre de pièces</label>
            <input type="number" id="pieces" name="pieces" min="1">
          </div>
        </div>                <div class="grid-container" style="grid-template-columns: 1fr 1fr;">
                    <div>
                        <label for="email">Email de contact</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div>
                        <label for="telephone">Téléphone</label>
                        <input type="tel" id="telephone" name="telephone" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="message">Message complémentaire</label>
                    <textarea id="message" name="message" rows="4"></textarea>
                </div>

                <?php
                // Affichage des erreurs s'il y en a
                if (isset($_SESSION['erreurs']) && !empty($_SESSION['erreurs'])) {
                    echo '<div class="alert alert-danger" style="background: var(--danger); color: white; padding: 1rem; border-radius: 8px; margin: 1rem 0;">';
                    foreach ($_SESSION['erreurs'] as $erreur) {
                        echo '<p style="margin: 0.5rem 0;"><i class="fas fa-exclamation-circle"></i> ' . htmlspecialchars($erreur) . '</p>';
                    }
                    echo '</div>';
                    unset($_SESSION['erreurs']);
                }
                ?>

                <div style="text-align: center; margin-top: 2rem;">
                    <button type="submit" class="page-btn">
                        <i class="fas fa-paper-plane"></i> Demander une estimation
                    </button>
                </div>
            </form>
    </section>
  </div>

  <?php include_once('includes/footer.php'); ?>
</body>

</html>