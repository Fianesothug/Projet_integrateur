<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vendre votre bien - HOUSE COMPANY</title>
  <style>
  body {
    font-family: 'Segoe UI', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f6f9;
    color: #333;
  }

  header {
    background-color: #0056b3;
    padding: 1rem 2rem;
    color: #fff;
    text-align: center;
  }

  header h1 {
    margin: 0;
    font-size: 1.8rem;
  }

  main {
    max-width: 900px;
    margin: 2rem auto;
    padding: 2rem;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  }

  h2 {
    color: #1b1f3b;
    margin-bottom: 1rem;
  }

  p {
    margin-bottom: 1.5rem;
  }

  form {
    display: grid;
    gap: 1rem;
  }

  label {
    font-weight: bold;
    margin-bottom: 0.5rem;
    display: block;
  }

  input,
  textarea,
  select {
    width: 100%;
    padding: 0.8rem;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 1rem;
  }

  button {
    background-color: #0056b3;
    color: #fff;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 5px;
    font-size: 1rem;
    cursor: pointer;
    margin-top: 1rem;
    transition: background-color 0.3s ease;
  }

  button:hover {
    background-color: #323765;
  }
  </style>
</head>

<body>

  <header>
    <h1>Vendre votre bien avec HOUSE COMPANY</h1>
  </header>

  <main>
    <h2>Confiez-nous votre bien</h2>
    <p>Chez <strong>HOUSE COMPANY</strong>, nous mettons notre expertise et notre réseau à votre service pour vendre
      votre bien rapidement et au meilleur prix. Gagnez du temps et bénéficiez d’un accompagnement personnalisé à chaque
      étape.</p>

    <form action="traitement-formulaire.php" method="post">
      <label for="nom">Votre nom complet</label>
      <input type="text" id="nom" name="nom" required>

      <label for="email">Votre adresse email</label>
      <input type="email" id="email" name="email" required>

      <label for="telephone">Votre numéro de téléphone</label>
      <input type="tel" id="telephone" name="telephone" required>

      <label for="type_bien">Type de bien</label>
      <select id="type_bien" name="type_bien" required>
        <option value="">-- Sélectionner --</option>
        <option value="maison">Maison</option>
        <option value="appartement">Appartement</option>
        <option value="terrain">Terrain</option>
        <option value="autre">Autre</option>
      </select>

      <label for="adresse">Adresse du bien</label>
      <input type="text" id="adresse" name="adresse" required>

      <label for="description">Description du bien</label>
      <textarea id="description" name="description" rows="5" placeholder="Superficie, nombre de pièces, état, atouts..."
        required></textarea>

      <label for="prix">Prix souhaité (FCFA)</label>
      <input type="number" id="prix" name="prix" required>

      <button type="submit">Soumettre mon bien</button>
    </form>
  </main>
  <?php include_once ('includes/footer.php'); ?>
</body>

</html>