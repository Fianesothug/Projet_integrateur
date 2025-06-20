<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']) ? 'true' : 'false';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Propriétés à vendre - HOUSE-CONPANY</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body data-user-logged-in="<?php echo $isLoggedIn; ?>">
  <?php include 'includes/header.php'; ?>

  <main class="container">
    <h1 class="section-title">Propriétés à vendre</h1>

    <!-- Barre de recherche -->
    <div class="search-bar">
      <input type="text" id="search-input" placeholder="Rechercher une propriété...">
      <button id="search-btn"><i class="fas fa-search"></i> Rechercher</button>
    </div>
      <br>
      <br>
    <!-- Catégories -->
    <div class="categories">
      <button class="category-btn active" data-category="all">Tout</button>
      <button class="category-btn" data-category="appartement">Appartements</button>
      <button class="category-btn" data-category="commercial">Commerces</button>
    </div>

    <!-- Grille des propriétés -->
    <div id="properties-grid" class="properties-grid"></div>
  </main>

  <?php include 'includes/footer.php'; ?>

  <script src="assets/js/script.js"></script>
  <script>
  // Fonction pour filtrer et afficher uniquement les propriétés à vendre
  function displaySaleProperties() {
    // Filtrer uniquement les propriétés avec le tag "À vendre"
    const saleProperties = properties.filter(property => property.tag === "À vendre");

    // Afficher ces propriétés
    displayProperties(saleProperties);
  }

  // Modifier la gestion des catégories pour ne travailler qu'avec les propriétés à vendre
  document.querySelectorAll('.category-btn').forEach(button => {
    button.addEventListener('click', function() {
      document.querySelectorAll('.category-btn').forEach(btn => {
        btn.classList.remove('active');
      });
      this.classList.add('active');

      const category = this.getAttribute('data-category');
      let filteredProperties = properties.filter(property => property.tag === "À vendre");

      if (category !== 'all') {
        filteredProperties = filteredProperties.filter(property => property.type === category);
      }

      displayProperties(filteredProperties);
    });
  });

  // Modifier la fonction de recherche pour ne chercher que dans les propriétés à vendre
  function performSearch() {
    const searchTerm = document.getElementById('search-input').value.toLowerCase();
    let filteredProperties = properties.filter(property => property.tag === "À vendre");

    if (searchTerm.trim() !== '') {
      filteredProperties = filteredProperties.filter(property => {
        return (
          property.title.toLowerCase().includes(searchTerm) ||
          property.location.toLowerCase().includes(searchTerm) ||
          property.price.toLowerCase().includes(searchTerm) ||
          property.type.toLowerCase().includes(searchTerm)
        );
      });
    }

    displayProperties(filteredProperties);
  }

  // Événements de recherche
  document.getElementById('search-btn').addEventListener('click', performSearch);
  document.getElementById('search-input').addEventListener('keyup', function(event) {
    if (event.key === 'Enter') {
      performSearch();
    }
  });

  // Au chargement de la page, afficher uniquement les propriétés à vendre
  document.addEventListener('DOMContentLoaded', displaySaleProperties);
  </script>
</body>

</html>