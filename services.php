<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nos Services - Gestion Immobilière</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/contact.css">
  <link rel="stylesheet" href="assets/css/footer.css">
  <link rel="stylesheet" href="assets/css/services.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
  <style>
  .services-container {
    background-color: #0056b3;
    color: #fff;
    padding: 1rem;

  }

  .services-container nav ul {
    list-style: none;
    display: flex;
    justify-content: center;
  }

  .services-container nav ul li {
    margin: 0 15px;
  }

  .services-container nav ul li a {
    color: #fff;
    text-decoration: none;
    font-weight: bold;
  }

  main {
    padding: 2rem;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
  }

  section {
    background-color: #fff;
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }

  section h2 {
    margin-bottom: 1rem;
    color: #0056b3;
  }

  section p {
    margin-bottom: 1.5rem;
  }

  .cta {
    display: inline-block;
    background-color: #0056b3;
    color: #fff;
    padding: 0.75rem 1.5rem;
    text-decoration: none;
    border-radius: 4px;
    font-weight: bold;
    text-align: center;
  }

  .cta:hover {
    background-color: #004494;
  }
  </style>
  <header class="services-container">
    <nav>
      <ul>
        <li><a href="vendre.php">Vendre un bien</a></li>
        <li><a href="gestion.php">Gestion locative</a></li>
        <li><a href="guide.php">Votre guide</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <section id="vendre">
      <h2>Vendre un bien</h2>
      <p>Vous souhaitez vendre rapidement votre parcelle, villa ou immeuble ? Confiez-nous votre bien et bénéficiez de
        notre expertise pour une transaction réussie.</p>
      <a href="vendre.php" class="cta">Confier mon bien</a>
    </section>

    <section id="gestion">
      <h2>Gestion locative</h2>
      <p>Optimisez la rentabilité de votre investissement immobilier en nous confiant la gestion de vos biens. Nous
        assurons la location, l'entretien et la gestion administrative.</p>
      <a href="gestion.php" class="cta">Déléguer la gestion</a>
    </section>

    <section id="guide">
      <h2>Votre guide</h2>
      <p>Accédez à des conseils pratiques, des informations sur le marché immobilier local et des ressources pour vous
        aider dans vos démarches immobilières.</p>
      <a href="guide.php" class="cta">Lire le guide</a>
    </section>
  </main>

  <?php include_once ('includes/footer.php'); ?>

</body>

</html>