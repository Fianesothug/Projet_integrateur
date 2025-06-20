<?php include_once('includes/init.php'); ?>
<?php
// Vérifier si l'utilisateur est connecté
$isLoggedIn = isset($_SESSION['user_id']) ? 'true' : 'false';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HOUSE-COMPANY</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="assets/css/style.css">

</head>

<body data-user-logged-in="<?php echo $isLoggedIn; ?>">

  <?php include_once ('includes/header.php'); ?>
  <!-- HERO SECTION -->
  <section class="hero">
    <div class="container">
      <h1>Trouvez la propriété de vos rêves</h1>
      <p>Découvrez notre sélection exclusive de biens immobiliers à travers le pays</p>

      <div class="search-bar">
        <input type="text" id="search-input" placeholder="Rechercher par lieu, type, prix...">
        <button id="search-btn"><i class="fas fa-search"></i> Rechercher</button>
      </div>
    </div>
  </section>

  <!-- CATÉGORIES DE PROPRIÉTÉS -->
  <section class="container">
    <h2 class="section-title">Catégories de propriétés</h2>

    <div class="categories">
      <button class="category-btn active" data-category="all">Tous</button>
      <button class="category-btn" data-category="appartement">Appartements</button>
      <button class="category-btn" data-category="maison">Maisons/Villa</button>
      <button class="category-btn" data-category="bureau">Bureaux</button>
      <button class="category-btn" data-category="commercial">Commerces</button>
    </div>

    <!-- PROPRIÉTÉS GRID -->
    <div class="properties-grid" id="properties-grid">
      <!-- Propriétés chargées dynamiquement par JavaScript -->
    </div>
  </section>

  <script src="assets/js/script.js"></script>

  <?php include_once ('includes/footer.php'); ?>
</body>

</html>