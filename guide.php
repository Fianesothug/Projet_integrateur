<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Guide Immobilier - HOUSE COMPANY</title>
  <style>
  body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background-color: #f8fafc;
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
    font-size: 34px;
  }

  header p {
    font-size: 18px;
    margin-top: 10px;
  }

  .container {
    max-width: 1000px;
    margin: 40px auto;
    padding: 0 20px;
  }

  .section {
    background-color: white;
    border-radius: 8px;
    padding: 25px;
    margin-bottom: 30px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
  }

  .section h2 {
    color: #007acc;
    margin-top: 0;
  }

  .accordion-item {
    margin-bottom: 10px;
    border-bottom: 1px solid #ddd;
  }

  .accordion-header {
    cursor: pointer;
    padding: 10px;
    font-weight: bold;
    background-color: #f0f4f8;
    border-radius: 5px;
    transition: background-color 0.3s;
  }

  .accordion-header:hover {
    background-color: #e2ebf4;
  }

  .accordion-content {
    display: none;
    padding: 10px 15px;
    background-color: #f9f9f9;
    border-left: 3px solid #007acc;
    margin-top: 5px;
    border-radius: 5px;
  }
  </style>
</head>

<body>

  <header>
    <h1>Guide Immobilier</h1>
    <p>
      Accédez à des conseils pratiques, des informations sur le marché immobilier local<br>
      et des ressources pour vous aider dans vos démarches immobilières.
    </p>
  </header>

  <div class="container">

    <div class="section">
      <h2>📌 Conseils pratiques pour propriétaires</h2>

      <div class="accordion-item">
        <div class="accordion-header" onclick="toggleAccordion(this)">Comment bien choisir son locataire</div>
        <div class="accordion-content">
          Vérifiez les revenus, les garanties (garant ou assurance loyer impayé), l’historique locatif et demandez les
          pièces justificatives. Une bonne sélection évite les problèmes futurs.
        </div>
      </div>

      <div class="accordion-item">
        <div class="accordion-header" onclick="toggleAccordion(this)">Astuce pour maximiser le rendement locatif</div>
        <div class="accordion-content">
          Optimisez l’aménagement, proposez un logement meublé si le marché le permet, et fixez un loyer en cohérence
          avec le quartier pour éviter les vacances prolongées.
        </div>
      </div>

      <div class="accordion-item">
        <div class="accordion-header" onclick="toggleAccordion(this)">Comment entretenir votre bien régulièrement</div>
        <div class="accordion-content">
          Planifiez des visites annuelles, vérifiez l’état des installations (chauffage, électricité) et intervenez
          rapidement sur les petits travaux pour éviter les gros.
        </div>
      </div>

      <div class="accordion-item">
        <div class="accordion-header" onclick="toggleAccordion(this)">Les erreurs à éviter en gestion locative</div>
        <div class="accordion-content">
          Évitez les retards dans les relances de paiement, la mauvaise rédaction des baux, et surtout l’absence d’état
          des lieux complet. Utilisez un professionnel si besoin.
        </div>
      </div>
    </div>

    <div class="section">
      <h2>📊 Marché immobilier local</h2>
      <p>
        Découvrez les tendances actuelles du marché dans votre région : loyers moyens, quartiers attractifs, taux de
        vacance.
        Nous mettons à jour régulièrement nos analyses pour vous offrir une vision claire du marché.
      </p>
    </div>

    <div class="section">
      <h2>🛠️ Ressources utiles</h2>
      <ul>
        <li>Modèle de bail de location PDF</li>
        <li>Checklist pour état des lieux</li>
        <li>Liens vers les aides fiscales disponibles</li>
        <li>Foire aux questions (FAQ)</li>
      </ul>
    </div>

  </div>


  <script>
  function toggleAccordion(element) {
    const content = element.nextElementSibling;
    const isOpen = content.style.display === "block";

    // Fermer tous les autres
    document.querySelectorAll('.accordion-content').forEach(el => el.style.display = 'none');

    // Ouvrir ou fermer celui-ci
    content.style.display = isOpen ? "none" : "block";
  }
  </script>
  <?php include_once ('includes/footer.php'); ?>

</body>

</html>