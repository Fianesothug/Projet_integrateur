// modifier-propriete.js
document.addEventListener('DOMContentLoaded', function() {
    // Gestion des clics sur le bouton Modifier
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', function() {
            const idPropriete = this.getAttribute('data-id');
            chargerProprietePourModification(idPropriete);
        });
    });

    // Fonction pour charger les données de la propriété
    function chargerProprietePourModification(id) {
        fetch(`modifier_propriete.php?id=${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    afficherFormulaireModification(data.data);
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Une erreur est survenue lors du chargement des données');
            });
    }

    // Fonction pour afficher le formulaire de modification
    function afficherFormulaireModification(propriete) {
        // Création de la modale
        const modal = document.createElement('div');
        modal.className = 'modal';
        modal.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        `;

        // Contenu de la modale
        modal.innerHTML = `
            <div class="modal-content" style="background-color: white; padding: 25px; border-radius: 8px; width: 80%; max-width: 600px;">
                <h2 style="margin-top: 0; color: #2563eb; margin-bottom: 20px;">
                    <i class="fas fa-edit"></i> Modifier la propriété
                </h2>
                <form id="formModification">
                    <input type="hidden" name="id_propriete" value="${propriete.id}">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="edit_type"><i class="fas fa-building"></i> Type de propriété</label>
                            <select class="form-control" id="edit_type" name="type" required>
                                <option value="maison" ${propriete.type === 'maison' ? 'selected' : ''}>Maison</option>
                                <option value="appartement" ${propriete.type === 'appartement' ? 'selected' : ''}>Appartement</option>
                                <option value="terrain" ${propriete.type === 'terrain' ? 'selected' : ''}>Terrain</option>
                                <option value="bureau" ${propriete.type === 'bureau' ? 'selected' : ''}>Bureau</option>
                                <option value="commerce" ${propriete.type === 'commerce' ? 'selected' : ''}>Commerce</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_utilisation"><i class="fas fa-tag"></i> Utilisation</label>
                            <select class="form-control" id="edit_utilisation" name="utilisation" required>
                                <option value="residentiel" ${propriete.utilisation === 'residentiel' ? 'selected' : ''}>Résidentiel</option>
                                <option value="commercial" ${propriete.utilisation === 'commercial' ? 'selected' : ''}>Commercial</option>
                                <option value="mixte" ${propriete.utilisation === 'mixte' ? 'selected' : ''}>Mixte</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="edit_option"><i class="fas fa-hand-holding-usd"></i> Option</label>
                            <select class="form-control" id="edit_option" name="option" required>
                                <option value="location" ${propriete.option_propriete === 'location' ? 'selected' : ''}>Location</option>
                                <option value="vente" ${propriete.option_propriete === 'vente' ? 'selected' : ''}>Vente</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_taille"><i class="fas fa-ruler-combined"></i> Taille (m²)</label>
                            <input type="number" class="form-control" id="edit_taille" name="taille" value="${propriete.taille}" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="edit_adresse"><i class="fas fa-map-marker-alt"></i> Adresse</label>
                            <input type="text" class="form-control" id="edit_adresse" name="adresse" value="${propriete.adresse}" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_ville"><i class="fas fa-city"></i> Ville</label>
                            <input type="text" class="form-control" id="edit_ville" name="ville" value="${propriete.ville}" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="edit_prix"><i class="fas fa-euro-sign"></i> Prix (€)</label>
                            <input type="number" class="form-control" id="edit_prix" name="prix" value="${propriete.prix}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="edit_description"><i class="fas fa-align-left"></i> Description</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="4" required>${propriete.description}</textarea>
                    </div>

                    <div class="form-actions" style="margin-top: 20px; text-align: right;">
                        <button type="button" class="btn btn-secondary" id="btnAnnuler" style="margin-right: 10px;">Annuler</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        `;

        // Ajout de la modale au document
        document.body.appendChild(modal);

        // Gestion de la fermeture de la modale
        document.getElementById('btnAnnuler').addEventListener('click', function() {
            document.body.removeChild(modal);
        });

        // Gestion de la soumission du formulaire
        document.getElementById('formModification').addEventListener('submit', function(e) {
            e.preventDefault();
            enregistrerModifications(this);
        });
    }

    // Fonction pour enregistrer les modifications
    function enregistrerModifications(form) {
        const formData = new FormData(form);

        fetch('modifier_propriete.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                // Recharger la page pour voir les modifications
                location.reload();
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur est survenue lors de la mise à jour');
        });
    }
});