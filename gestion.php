<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestion Locative - HOUSE COMPANY</title>
  <style>
  body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background-color: #f7f9fc;
    color: #333;
  }

  header {
    background-color: #007acc;
    color: white;
    padding: 40px 20px;
    text-align: center;
  }

  header h1 {
    margin: 0;
    font-size: 36px;
    letter-spacing: 1px;
  }

  header p {
    margin-top: 10px;
    font-size: 18px;
    font-style: italic;
  }

  .container {
    max-width: 1000px;
    margin: 40px auto;
    padding: 0 20px;
  }

  .intro {
    background-color: white;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
    margin-bottom: 30px;
  }

  .intro h2 {
    color: #002d5f;
    font-size: 28px;
  }

  .intro p {
    font-size: 18px;
    line-height: 1.6;
  }

  .services {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
  }

  .service-card {
    background-color: white;
    padding: 20px;
    border-left: 5px solid #007acc;
    border-radius: 6px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
  }

  .service-card h3 {
    margin-top: 0;
    color: #007acc;
  }

  .service-card p {
    font-size: 15px;
    color: #444;
  }
  </style>
</head>

<body>

  <header>
    <h1>Gestion Locative</h1>
    <p>HOUSE COMPANY - Votre tranquillité, notre priorité</p>
  </header>

  <div class="container">
    <div class="intro">
      <h2>Confiez-nous la gestion de vos biens immobiliers</h2>
      <p>
        Optimisez la rentabilité de votre investissement immobilier en nous confiant la gestion de vos biens.
        Nous assurons la <strong>location</strong>, l'<strong>entretien</strong> et la <strong>gestion
          administrative</strong>.
      </p>
    </div>

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
  </div>
  <?php include_once ('includes/footer.php'); ?>
</body>

</html>