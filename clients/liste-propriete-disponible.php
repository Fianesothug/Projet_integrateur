<?php
// Connexion directe à la base de données
$host = 'localhost';
$dbname = 'gestion';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Propriétés Disponibles - HOUSE COMPANY</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
      /* Conteneur principal */
        .hc-properties-container {
            margin-top:-2%;
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
        }

        /* Titre */
        .hc-page-title {
            color: #1e40af;
            font-size: 1.8rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Grille des propriétés */
        .hc-properties-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        /* Carte de propriété */
        .hc-property-card {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            transition: all 0.2s ease;
            border: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
        }

        .hc-property-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0,0,0,0.1);
        }

        /* Image de la propriété */
        .hc-property-image {
            height: 200px;
            overflow: hidden;
            background-color: #f5f5f5;
            position: relative;
        }

        .hc-property-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .hc-property-card:hover .hc-property-image img {
            transform: scale(1.03);
        }

        /* Détails de la propriété */
        .hc-property-details {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .hc-property-details h3 {
            margin-top: 0;
            margin-bottom: 12px;
            color: #2563eb;
            font-size: 1.1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .hc-property-meta {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            color: #6b7280;
            font-size: 0.85rem;
        }

        .hc-property-price {
            font-size: 1.2rem;
            font-weight: bold;
            color: #3b82f6; /* Changé de vert à bleu */
            margin: 12px 0;
        }

        .hc-property-details p {
            color: #6b7280;
            font-size: 0.9rem;
            line-height: 1.5;
            margin: 12px 0;
            flex-grow: 1;
        }

        /* Boutons d'action */
        .hc-property-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .hc-btn {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            color: white;
            cursor: pointer;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: background-color 0.2s;
            text-decoration: none;
        }

        .hc-btn-view {
            background-color: #3b82f6;
        }

        .hc-btn-view:hover {
            background-color: #2563eb;
        }

        .hc-btn-contact {
            background-color: #3b82f6; /* Changé de vert à bleu */
        }

        .hc-btn-contact:hover {
            background-color: #2563eb; /* Changé de vert à bleu */
        }

        /* État vide */
        .hc-empty-state {
            text-align: center;
            padding: 40px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .hc-empty-state i {
            font-size: 3rem;
            color: #9ca3af;
            margin-bottom: 20px;
        }

        .hc-empty-state p {
            color: #6b7280;
            font-size: 1.1rem;
        }

        /* Message d'erreur */
        .hc-error-message {
            background-color: #fee2e2;
            color: #b91c1c;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="hc-properties-container">
      
      <?php
try {
    // Connexion à la base si non incluse ailleurs
    $pdo = new PDO('mysql:host=localhost;dbname=gestion', 'root', '');

    // Requête : propriétés disponibles
    $stmt = $pdo->prepare("SELECT * FROM proprietes WHERE statut = 'disponible' ORDER BY date_ajout DESC");
    $stmt->execute();
    $proprietes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($proprietes) {
        echo '<div class="hc-properties-list">';

        foreach ($proprietes as $propriete) {
            $images = explode(',', $propriete['images']);
            $mainImage = !empty($images[0]) ? '../uploads/proprietes/' . trim($images[0]) : 'default-property.jpg';
            $prixFormatted = number_format($propriete['prix'], 0, ',', ' ');

            echo '<div class="hc-property-card">';
            echo '    <div class="hc-property-image">';
            echo '        <img src="'.htmlspecialchars($mainImage).'" alt="'.htmlspecialchars($propriete['type']).'">';
            echo '    </div>';
            echo '    <div class="hc-property-details">';
            echo '        <h3><i class="fas fa-home"></i> N°'.$propriete['id'].' '.ucfirst(htmlspecialchars($propriete['type'])).' à '.ucfirst(htmlspecialchars($propriete['ville'])).'</h3>';
            echo '        <div class="hc-property-meta">';
            echo '            <span><i class="fas fa-ruler-combined"></i> '.htmlspecialchars($propriete['taille']).' m²</span>';
            echo '            <span><i class="fas fa-hand-holding-usd"></i> '.ucfirst(htmlspecialchars($propriete['utilisation'])).' - <strong>'.ucfirst(htmlspecialchars($propriete['statut'])).'</strong></span>';
            echo '        </div>';
            echo '        <div class="hc-property-price">'.htmlspecialchars($prixFormatted).' FCFA</div>';
            echo '        <p><i class="fas fa-info-circle"></i> '.htmlspecialchars(substr($propriete['description'], 0, 100)).'...</p>';
            echo '        <div class="hc-property-actions">';
            echo '            <a href="../chat/form.php" class="hc-btn hc-btn-contact"><i class="fas fa-user-tie"></i> Contactez Agent</a>';
            echo '        </div>';
            echo '    </div>';
            echo '</div>';
        }

        echo '</div>';
    } else {
        echo '<div class="hc-empty-state">';
        echo '    <i class="fas fa-home"></i>';
        echo '    <p>Aucune propriété disponible pour le moment</p>';
        echo '</div>';
    }
} catch (PDOException $e) {
    echo '<div class="hc-error-message">Erreur lors de la récupération des propriétés : '.htmlspecialchars($e->getMessage()).'</div>';
}
?>

    </div>

    <script>
    // Fonction pour afficher les notifications
    function showNotification(type, message) {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.textContent = message;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 5000);
    }

    // Vérifie si un message de succès est présent dans l'URL
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('success')) {
        showNotification('success', urlParams.get('success'));
    }
    </script>
</body>
</html>