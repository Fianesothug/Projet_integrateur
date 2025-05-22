<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="/Projet_integrateur/assets/css/header.css">
</head>

<body>
  <header class="main-header">
    <div class="header-container">
      <a href="/" class="branding">
        <div class="logo">HC</div>
        <h1 class="site-name">HOUSE-COMPANY</h1>
      </a>

      <nav class="main-nav">
        <ul class="nav-list">
          <li class="nav-item"><a href="index.php">Accueil</a></li>
          <li class="nav-item dropdown">
            <a href="#">Propriétés ▼</a>
            <div class="dropdown-content">
              <a href="/appartements">Appartements</a>
              <a href="/villas">Villas</a>
              <a href="/terrains">Terrains</a>
              <a href="/locaux-commerciaux">Locaux Commerciaux</a>
              <a href="/locaux-commerciaux">Magasin</a>
              <a href="/locaux-commerciaux">Paillotes</a>
              <a href="/locaux-commerciaux">Paillotes</a>
              <a href="/locaux-commerciaux">Fermes</a>
            </div>
          </li>

        </ul>
      </nav>

      <div class="header-actions">
        <div class="quick-actions">
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

</body>

</html>