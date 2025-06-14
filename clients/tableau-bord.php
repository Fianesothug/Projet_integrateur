<?php include '../components/protect1.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Administrateur</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../assets/css/bailleurs.css">
</head>
<body>
    <!-- inclusion entete -->
      <?php include_once ('../includes/header.php'); ?>
      <br>
    <!-- Menu Burger pour mobile -->
    <button class="menu-toggle" id="menuToggle">
        <i class="fas fa-bars"></i>
    </button>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <div class="admin-sidebar" id="adminSidebar">
        <h2><i class="fas fa-tachometer-alt  "></i> Tableau de bord <br> Bailleurs</h2>
        <ul>
            <li><a href="#" class="active"><i class="fas fa-home"></i>Description globale</a></li>
            <li><a href="#ajout"><i class="fas fa-plus-circle"></i> Ajouter une propriété</a></li>
            <li><a href="#propri"><i class="fas fa-list"></i> Propriétés disponibles</a></li>
            <li><a href="#vendue"><i class="fas fa-list"></i> Propriétés vendues</a></li>
            <li><a href="#loue"><i class="fas fa-list"></i> Propriétés louées</a></li>
            <li><a href="../components/protection.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
         </ul>
    </div>
 <div class="corp">
     <section id='tableau'>.</section>
     <div class="admin-main" id="adminMain">
    <div class="admin-header">
        <h1><i class="fas fa-info-circle"></i> Description globale</h1>
    </div>
    
    <div class="admin-body">
        <p>
            <strong>Bienvenue dans votre espace bailleur. Cet espace vous permet de gérer efficacement vos propriétés immobilières.</strong>
        </p>
        <br>
    
        <div class="dashboard-cards">
            <div class="card" onclick="window.location.href='#ajout'">
                <i class="fas fa-plus-circle"></i>
                <h3>Ajouter une propriété</h3>
                <p>Publiez une nouvelle annonce immobilière</p>
            </div>
            
            <div class="card" onclick="window.location.href='#propri'">
                <i class="fas fa-home"></i>
                <h3>Mes propriétés</h3>
                <p>Gérez vos biens immobiliers</p>
            </div>
            <div class="card" onclick="window.location.href='../components/protection.php'">
                <i class="fas fa-sign-out-alt"></i>
                <h3>Déconnexion</h3>
                <p>Quitter votre espace personnel</p>
            </div>
        </div>
    </div>
    <br>
     <div class="centre">
        <p>
            <strong>Actualiser la page en cas de problème de chargement </strong>
            <br>
            <br>
             <a href="tableau-bord.php"><strong>EFFECTUER</strong></a>
        </p>
    </div>
    <br>
</div>
   <br>
   <div class="admin-header">
        <h1><i class="fas fa-plus-circle"></i> Ajouter une propriété</h1>
    </div>
    
   <br>
    <section id='ajout'>.</section>
    <br>
    
    <div class="add-property-form">
         <?php include 'ajout-propriete.php'; ?>
        <h2><i class="fas fa-plus-circle"></i> Ajouter une nouvelle propriété</h2>
        <form method="POST" enctype="multipart/form-data" action="">
            <input type="hidden" name="form_token" value="<?php echo $_SESSION['form_token']; ?>">
            <div class="form-row">
                <div class="form-group">
                    <label for="type"><i class="fas fa-building"></i> Type de propriété</label>
                    <select class="form-control" id="type" name="type" required>
                        <option value="">Sélectionnez un type</option>
                        <option value="maison">Maison</option>
                    <option value="appartement">Appartement</option>
                    <option value="terrain">Terrain</option>
                    <option value="bureau">Bureau</option>
                    <option value="commerce">Commerce</option>
                </select>
            </div>
            <div class="form-group">
                <label for="utilisation"><i class="fas fa-tag"></i> Utilisation</label>
                <select class="form-control" id="utilisation" name="utilisation" required>
                    <option value="">Sélectionnez une utilisation</option>
                    <option value="residentiel">Résidentiel</option>
                    <option value="commercial">Commercial</option>
                    <option value="mixte">Mixte</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="option"><i class="fas fa-hand-holding-usd"></i> Option</label>
                <select class="form-control" id="option" name="option" required>
                    <option value="">Location ou Vente</option>
                    <option value="location">Location</option>
                    <option value="vente">Vente</option>
                </select>
            </div>
            <div class="form-group">
                <label for="taille"><i class="fas fa-ruler-combined"></i> Taille (m²)</label>
                <input type="number" class="form-control" id="taille" name="taille" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="adresse"><i class="fas fa-map-marker-alt"></i> Adresse</label>
                <input type="text" class="form-control" id="adresse" name="adresse" required>
            </div>
            <div class="form-group">
                <label for="ville"><i class="fas fa-city"></i> Ville</label>
                <input type="text" class="form-control" id="ville" name="ville" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="prix"><i class=" "></i><strong>(FCFA)</strong> Prix </label>
                <input type="number" class="form-control" id="prix" name="prix" required>
            </div>
            <div class="form-group">
                <label for="images"><i class="fas fa-camera"></i> Photos de la propriété</label>
                <input type="file" class="form-control" id="images" name="images[]" multiple required>
            </div>
        </div>

        <div class="form-group">
            <label for="description"><i class="fas fa-align-left"></i> Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
        </div>
         <input type="submit" name="ajouter_propriete" value="Ajouter la propriété" class="btn btn-primary">
    </form>
    <br>
    <?php if (!empty($message)): ?>
        <div class="alert alert-<?= $message_type === 'success' ? 'success' : 'danger' ?> mt-3">
            <i class="fas <?= $message_type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle' ?>"></i>
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>
</div>
         <section id="propri">.</section>
        <br>
    <div class="admin-header">
        <h1><i class="fas fa-list"></i> Propriétés disponible</h1>
    </div>
    
        <br>
       <?php include 'liste-propriete-disponible.php'; ?>
        <br>
      <section id="vendue">.</section>
        <br>
    <div class="admin-header">
        <h1><i class="fas fa-list"></i> Propriétés vendues</h1>
    </div>
        <br>
       <?php include 'liste-propriete-vendue.php'; ?>
        <br>
          <section id="loue">.</section>
        <br>
        <div class="admin-header">
        <h1><i class="fas fa-list"></i> Propriétés louées</h1>
    </div>
        <br>
       <?php include 'liste-propriete-loue.php'; ?>
        <br>
    </div>
    <br><br>
    <!-- inclusion pied -->
      <?php include_once ('../includes/footer.php'); ?>
      <br>
    <script>
        // Toggle menu mobile
        document.getElementById('menuToggle').addEventListener('click', function() {
            document.getElementById('adminSidebar').classList.toggle('active');
            document.getElementById('sidebarOverlay').classList.toggle('active');
        });

        document.getElementById('sidebarOverlay').addEventListener('click', function() {
            document.getElementById('adminSidebar').classList.remove('active');
            this.classList.remove('active');
        });

        // Gestion des onglets
        const tabs = document.querySelectorAll('.tab');
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                tabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                // Ici vous pourriez ajouter du code pour charger le contenu approprié
            });
        });
        // Fermer le sidebar lorsqu'un lien est cliqué (pour version mobile)
document.querySelectorAll('.admin-sidebar a').forEach(link => {
    link.addEventListener('click', function() {
        // Vérifier si on est en mode mobile (sidebar caché)
        if (window.innerWidth <= 992) {
            document.getElementById('adminSidebar').classList.remove('active');
            document.getElementById('sidebarOverlay').classList.remove('active');
        }
    });
});
   
    </script> 
</body>
</html>