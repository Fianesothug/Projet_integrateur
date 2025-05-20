
 <link rel="stylesheet" href="assets/css/header.css">

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
            </div>
          </li>
          <li class="nav-item"><a href="/connexion">Connexion</a></li>
        </ul>
      </nav>

      <div class="header-actions">
        <div class="quick-actions">
          <a href="/inscription" class="button secondary">Inscription</a>
          <a href="/deposer-annonce" class="button primary">Déposer une annonce</a>
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
 