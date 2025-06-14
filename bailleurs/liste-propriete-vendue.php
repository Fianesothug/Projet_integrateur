<?php
// Récupération des variables de session
$identifiant = isset($_SESSION['identifiant']) ? $_SESSION['identifiant'] : '';
$code_bailleur = isset($_SESSION['mot_de_passe']) ? $_SESSION['mot_de_passe'] : '';

if (!empty($identifiant) && !empty($code_bailleur)) {
    try {
        // Requête pour récupérer les propriétés du bailleur connecté
        $stmt = $pdo->prepare("SELECT * FROM proprietes 
                              WHERE identifiant = :identifiant 
                              AND code = :code 
                              AND (statut = 'attribuée')
                              AND (option_propriete = 'vente')
                              ORDER BY date_ajout DESC");
        $stmt->bindParam(':identifiant', $identifiant);
        $stmt->bindParam(':code', $code_bailleur);
        $stmt->execute();
        $proprietes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($proprietes) > 0) {
            echo '<div class="properties-list">';
            
            foreach ($proprietes as $propriete) {
                // Traitement des images (on prend la première image si plusieurs)
                $images = explode(',', $propriete['images']);
                $mainImage = !empty($images[0]) ? '../uploads/proprietes/'.$images[0] : 'default-property.jpg';
                
                // Formatage du prix
                $prixFormatted = number_format($propriete['prix'], 0, ',', ' ');
                
                echo '<div class="property-card">';
                echo '    <div class="property-image">';
                echo '        <img src="'.$mainImage.'" alt="'.$propriete['type'].'">';
                echo '    </div>';
                echo '    <div class="property-details">';
                echo '        <h3><i class="fas fa-home"></i> N°'.$propriete['id'].' '.ucfirst($propriete['type']).' à '.ucfirst($propriete['ville']).'</h3>';
                echo '        <div class="property-meta">';
                echo '            <span><i class="fas fa-ruler-combined"></i> '.$propriete['taille'].' m²</span>';
                echo '            <span><i class="fas fa-hand-holding-usd"></i> '.ucfirst($propriete['utilisation']).' il est <strong>'.ucfirst($propriete['statut']).'</strong></span>';
                echo '        </div>';
                echo '        <div class="property-price"><i class=""></i> '.$prixFormatted.' FCFA</div>';
                echo '        <p><i class="fas fa-info-circle"></i> '.substr($propriete['description'], 0, 100).'...</p>';
                echo '        <div class="property-actions">';
                echo '            <button class="btn btn-edit" data-id="'.$propriete['id'].'"><i class="fas fa-edit"></i> Modifier</button>';
                echo '            <button class="btn btn-delete" onclick="supprimerPropriete('.$propriete['id'].', this)"><i class="fas fa-trash"></i> Supprimer</button>';
                
                // Ajout du bouton Annuler seulement si le statut est "vendue"
                if ($propriete['statut'] === 'attribuée') {
                    echo '            <button class="btn btn-cancel" onclick="annulerReservation('.$propriete['id'].', this)"><i class="fas fa-times"></i> Annuler</button>';
                }
                
                echo '        </div>';
                echo '    </div>';
                echo '</div>';
            }
            
            echo '</div>';
        } else {
            echo '<p>Aucune propriété trouvée pour ce bailleur.</p>';
        }
    } catch (PDOException $e) {
        echo '<p>Erreur lors de la récupération des propriétés: '.$e->getMessage().'</p>';
    }
} else {
    echo '<p>Vous devez être connecté pour voir vos propriétés.</p>';
}
?>

<script>
function supprimerPropriete(id, element) {
    if (confirm("Êtes-vous sûr de vouloir supprimer cette propriété ?")) {
        fetch("supprimer_propriete.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: "id_propriete=" + id
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Supprime visuellement la carte de propriété
                element.closest(".property-card").remove();
                
                // Affiche un message de succès
                alert(data.message);
            } else {
                alert("Erreur: " + data.message);
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("Une erreur est survenue lors de la suppression");
        });
    }
}

function annulerReservation(id, element) {
    if (confirm("Êtes-vous sûr de vouloir annuler la réservation de cette propriété ?")) {
        fetch("annuler_reservation.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: "id_propriete=" + id
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Met à jour le statut visuellement
                const statusElement = element.closest(".property-card").querySelector("strong");
                if (statusElement) {
                    statusElement.textContent = "vendue";
                }
                
                // Cache le bouton Annuler car le statut n'est plus "réservé"
                element.style.display = "none";
                
                // Affiche un message de succès
                alert(data.message);
            } else {
                alert("Erreur: " + data.message);
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("Une erreur est survenue lors de l'annulation");
        });
    }
}
</script>