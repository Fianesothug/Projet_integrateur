 <?php include '../components/protect1.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Administrateur</title>
   <link rel="stylesheet" href="../assets/css/admis.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
     <!-- inclusion entete -->
      <?php include_once ('../includes/header.php'); ?>
    <!-- Menu Burger pour mobile -->
    <button class="menu-toggle" id="menuToggle">
        <i class="fas fa-bars"></i>
    </button>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <div class="admin-sidebar" id="adminSidebar">
        <h2><i class="fas fa-tachometer-alt  "></i> Tableau de bord <br> Administrative</h2>
        <ul>
            <li><a href="#tableau" class="active"><i class="fas fa-info-circle"></i> Description globale </a></li>
            <li><a href="#utilisateurs"><i class="fas fa-users"></i> Inscription-utilisateurs</a></li>
            <li><a href="#gest"><i class="fas fa-users-cog"></i> Gestion des rôles</a></li>
            <li><a href="#bail"><i class="fas fa-house-user"></i> Bailleurs</a></li>
            <li><a href="#agen"><i class="fas fa-user-tie"></i> Agents</a></li>
            <li><a href="#mana"><i class="fas fa-user-tie"></i> Managers</a></li>
            <li><a href="#admi"><i class="fas fa-user-tie"></i> Administrateurs</a></li>
            <li><a href="../components/protection.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
        </ul>
    </div>
    <div class="corp">
     <section id='tableau'>.</section>
     <br>
    <div class="admin-main" id="adminMain">
        <div class="admin-header">
            <h1><i class="fas fa-info-circle"></i> Description globale </h1>
        </div>
            <div class="admin-body">
     <p>
        <strong>Bienvenue dans le tableau de bord administrateur. Ce tableau vous permet de gérer les aspects de la plateforme </strong>
          <br> 
          <br> 
    </p>

    <div class="dashboard-cards">
        <div class="card">
            <i class="fas fa-users fa-2x"></i>
            <h3>Utilisateurs</h3>
            <p>Gérez les inscriptions, modifiez ou supprimez les comptes utilisateurs.</p>
            <a href="#utilisateurs" class="btn">Voir plus</a>
        </div>

        <div class="card">
            <i class="fas fa-users-cog fa-2x"></i>
            <h3>Rôles</h3>
            <p>Attribuez des rôles spécifiques : bailleur, agent ou manager.</p>
            <a href="#gest" class="btn">Voir plus</a>
        </div>

        <div class="card">
            <i class="fas fa-house-user fa-2x"></i>
            <h3>Bailleurs</h3>
            <p>Générez un numéro PV unique et envoyez les données par email.</p>
            <a href="#bail" class="btn">Voir plus</a>
        </div>

        <div class="card">
            <i class="fas fa-user-tie fa-2x"></i>
            <h3>Agents</h3>
            <p>Authentifiez les agents et fournissez leurs N° PV automatiquement.</p>
            <a href="#agen" class="btn">Voir plus</a>
        </div>

        <div class="card">
            <i class="fas fa-user-tie fa-2x"></i>
            <h3>Managers</h3>
            <p>Générez les PV et suivez les informations liées aux managers.</p>
            <a href="#mana" class="btn">Voir plus</a>
        </div>

        <div class="card">
            <i class="fas fa-sign-out-alt fa-2x"></i>
            <h3>Déconnexion</h3>
            <p>Terminez votre session en toute sécurité.</p>
            <a href="../page-admis.php" class="btn logout">Se déconnecter</a>
        </div>
    </div>
</div>

        </div>
      <br>
     <section id='utilisateurs'>.</section>
     <br>
    <!-- inscription-utilisateur -->
    <div class="admin-main" id="adminMain">
        <div class="admin-header">
            <h1><i class="fas fa-users"></i>Inscription-utilisateurs</h1>
    </div>

        <div id="Inscription" class="tabcontent">
        <h2>Inscription-utilisateur</h2>
        <form method="POST" action="../includes/inscription.php">
          <label for="nom">Nom:</label>
          <input type="text" id="nom" name="nom" placeholder="Entrez votre nom" required>

          <label for="prenom">Prénom:</label>
          <input type="text" id="prenom" name="prenom" placeholder="Entrez votre prénom" required>

          <label for="sexe">Sexe:</label>
          <select id="sexe" name="sexe" required>
            <option value="">Sélectionner sexe</option>
            <option value="masculin">Masculin</option>
            <option value="feminin">Féminin</option>
          </select>

          <label for="pays">Code pays:</label>
          <select id="pays" name="pays" required>
            <option value="">Sélectionner un pays</option>
            <?php include('../includes/listepays.php') ?>
          </select>

          <label for="numero">Numéro de téléphone:</label>
          <input type="tel" id="numero" name="numero" required placeholder="Format XXXXXXXX...">

          <label for="email">Email:</label>
          <input type="email" id="email" name="email" placeholder="Entrez votre email" required>

          <label for="adresse">Adresse:</label>
          <input type="text" id="adresse" name="adresse" placeholder="Entrez votre adresse" required>

          <label for="identifiant_inscription">Identifiant:</label>
          <input type="text" id="identifiant_inscription" name="identifiant" placeholder="Entrez votre identifiant" required>

          <label for="code">Code : <br> (un renforcement de la sécurité est prévu)</label>
          <input type="password" id="code" name="code" placeholder="Entrez votre mot de passe" required>

          <input type="submit" name="inscription" value="S'inscrire">
        </form>
      </div>
       <br>

      <h1><i class="fas fa-users"></i> Gestion des employées</h1>
       <section id="gest-util">.</section>
     <?php include 'tableau-agence.php'; ?>

    <!-- Formulaire de modification -->
    <div id="editForm">
        <h2>Modifier l'utilisateur</h2>
        <form method="POST" action="">
            <input type="hidden" name="id" id="edit_id">
            
            <div class="form-row">
                <div class="form-group">
                    <label for="edit_nom">Nom:</label>
                    <input type="text" id="edit_nom" name="nom" required>
                </div>
                
                <div class="form-group">
                    <label for="edit_pays">Pays:</label>
                    <input type="text" id="edit_pays" name="pays" required>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="edit_prenom">Prénom:</label>
                    <input type="text" id="edit_prenom" name="prenom" required>
                </div>
                
                <div class="form-group">
                    <label for="edit_numero">Numéro de téléphone:</label>
                    <input type="tel" id="edit_numero" name="numero" required>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="edit_sexe">Sexe:</label>
                    <select id="edit_sexe" name="sexe" required>
                        <option value="masculin">Masculin</option>
                        <option value="feminin">Féminin</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="edit_adresse">Adresse:</label>
                    <input type="text" id="edit_adresse" name="adresse" required>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="edit_email">Email:</label>
                    <input type="email" id="edit_email" name="email" required>
                </div>
                
            </div>
            
            <div class="form-actions">
                <button type="button" class="cancel-btn" onclick="hideEditForm()">Annuler</button>
                <button type="submit" class="save-btn" name="update">Enregistrer</button>
            </div>
        </form>
    </div>


       <br>
     <section id='gest'>.</section>
     <br>
     <!-- gestion-utilisateur -->
    <div class="admin-mai" id="adminMain">
        <div class="admin-header">
            <h1><i class=" fa fa-users-cog"></i>Gestion des rôles</h1>
        </div>
    </div>
 <!-- inclusion du fichier PHP -->
    <?php include '../includes/admisphp.php'; ?>
 <!-- FORMULAIRE BAILLEUR -->
     <section id='bail'>.</section>
    
    <div class="container">
        <h1>Génération de N°PV POUR BAILLEUR</h1>
        <form method="POST">
            <input type="hidden" name="type" value="bailleur">
            <div class="form-group">
                <label for="identifiantBailleur">Identifiant :</label>
                <input type="text" id="identifiantBailleur" name="identifiant" placeholder="Entrez votre identifiant" required>
            </div>
            
            <div class="form-group">
                <label for="codeBailleur">Matricule :</label>
                <input type="text" id="codeBailleur" name="code" placeholder="Entrez votre Matricule" required>
            </div>
           <a href="#resultBailleur"><button type="submit">Générer le N°PV</button></a>
        </form>
        
        <div id="resultBailleur" class="result">
            <?php if (isset($error_bailleur)): ?>
                <p class="error"><?php echo htmlspecialchars($error_bailleur); ?></p>
            <?php elseif (isset($success_bailleur)): ?>
                <div class="success">
                    <h3>N°PV Bailleur généré avec succès !</h3>
                    <p><strong>Identifiant :</strong> <?php echo htmlspecialchars($success_bailleur['identifiant']); ?></p>
                    <p><strong>Nom complet :</strong> <?php echo htmlspecialchars($success_bailleur['nom_complet']); ?></p>
                    <p><strong>Email :</strong> <?php echo htmlspecialchars($success_bailleur['email']); ?></p>
                    <p><strong>Téléphone :</strong> <?php echo htmlspecialchars($success_bailleur['telephone']); ?></p>
                    <p><strong>N°PV :</strong> <span style="color: #007bff; font-weight: bold;"><?php echo htmlspecialchars($success_bailleur['numero_pv']); ?></span></p>
                    <p style="color:green;">Un email a été envoyé à <?php echo htmlspecialchars($success_bailleur['email']); ?> (vérifiez vos spams si vous ne le voyez pas).</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <br><br>

    <!-- FORMULAIRE AGENT -->
     <br>
     <section id='agen'>.</section>
     <br>
    <div class="container">
        <h1>Génération de N°PV POUR AGENTS</h1>
        <form method="POST">
            <input type="hidden" name="type" value="agent">
            <div class="form-group">
                <label for="identifiantAgent">Identifiant :</label>
                <input type="text" id="identifiantAgent" name="identifiant" placeholder="Entrez votre identifiant" required>
            </div>
            
            <div class="form-group">
                <label for="codeAgent">Matricule:</label>
                <input type="text" id="codeAgent" name="code" placeholder="Entrez votre Matricule" required>
            </div>
            <a href="#resultAgent"><button type="submit">Générer le N°PV</button></a>
        </form>
        
        <div id="resultAgent" class="result">
            <?php if (isset($error_agent)): ?>
                <p class="error"><?php echo htmlspecialchars($error_agent); ?></p>
            <?php elseif (isset($success_agent)): ?>
                <div class="success">
                    <h3>N°PV Agent généré avec succès !</h3>
                    <p><strong>Identifiant :</strong> <?php echo htmlspecialchars($success_agent['identifiant']); ?></p>
                    <p><strong>Nom complet :</strong> <?php echo htmlspecialchars($success_agent['nom_complet']); ?></p>
                    <p><strong>Email :</strong> <?php echo htmlspecialchars($success_agent['email']); ?></p>
                    <p><strong>Téléphone :</strong> <?php echo htmlspecialchars($success_agent['telephone']); ?></p>
                    <p><strong>N°PV Agent :</strong> <span style="color: #007bff; font-weight: bold;"><?php echo htmlspecialchars($success_agent['numero_pv']); ?></span></p>
                    <p style="color:green;">Un email a été envoyé à <?php echo htmlspecialchars($success_agent['email']); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <br><br>

    <!-- FORMULAIRE MANAGER -->
     <br>
     <section id='mana'>.</section>
     <br>
    <div class="container">
        <h1>Génération de N°PV POUR MANAGERS</h1>
        <form method="POST">
            <input type="hidden" name="type" value="manager">
            <div class="form-group">
                <label for="identifiantManager">Identifiant :</label>
                <input type="text" id="identifiantManager" name="identifiant" placeholder="Entrez votre identifiant" required>
            </div>
            
            <div class="form-group">
                <label for="codeManager">Matricule :</label>
                <input type="text" id="codeManager" name="code" placeholder="Entrez votre Matricule" required>
            </div>
            <a href="#resultManager"><button type="submit">Générer le N°PV</button></a>
        </form>
        
        <div id="resultManager" class="result">
            <?php if (isset($error_manager)): ?>
                <p class="error"><?php echo htmlspecialchars($error_manager); ?></p>
            <?php elseif (isset($success_manager)): ?>
                <div class="success">
                    <h3>N°PV Manager généré avec succès !</h3>
                    <p><strong>Identifiant :</strong> <?php echo htmlspecialchars($success_manager['identifiant']); ?></p>
                    <p><strong>Nom complet :</strong> <?php echo htmlspecialchars($success_manager['nom_complet']); ?></p>
                    <p><strong>Email :</strong> <?php echo htmlspecialchars($success_manager['email']); ?></p>
                    <p><strong>Téléphone :</strong> <?php echo htmlspecialchars($success_manager['telephone']); ?></p>
                    <p><strong>N°PV :</strong> <span style="color: #007bff; font-weight: bold;"><?php echo htmlspecialchars($success_manager['numero_pv']); ?></span></p>
                    <p style="color:green;">Un email a été envoyé à <?php echo htmlspecialchars($success_manager['email']); ?> (vérifiez vos spams si vous ne le voyez pas).</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
 </div>    


 
    <br><br>

    <!-- FORMULAIRE administrateur -->
     <br>
     <section id='admi'>.</section>
     <br>
    <div  id="admi" class="container">
        <h1>Génération de N°PV POUR ADMINISTRATEURS</h1>
        <form method="POST">
            <input type="hidden" name="type" value="administrateur">
            <div class="form-group">
                <label for="identifiantAdmin">Identifiant :</label>
                <input type="text" id="identifiantAdmin" name="identifiant" placeholder="Entrez votre identifiant" required>
            </div>

            <div class="form-group">
                <label for="codeAdmin">Matricule :</label>
                <input type="text" id="codeAdmin" name="code" placeholder="Entrez votre Matricule" required>
            </div>
           <a href="#resultAdmin"><button type="submit">Générer le N°PV</button></a> 
        </form>

        <div id="resultAdmin" class="result">
            <?php if (isset($error_admin)): ?>
                <p class="error"><?php echo htmlspecialchars($error_admin); ?></p>
            <?php elseif (isset($success_admin)): ?>
                <div class="success">
                    <h3>N°PV Administrateur généré avec succès !</h3>
                    <p><strong>Identifiant :</strong> <?php echo htmlspecialchars($success_admin['identifiant']); ?></p>
                    <p><strong>Nom complet :</strong> <?php echo htmlspecialchars($success_admin['nom_complet']); ?></p>
                    <p><strong>Email :</strong> <?php echo htmlspecialchars($success_admin['email']); ?></p>
                    <p><strong>Téléphone :</strong> <?php echo htmlspecialchars($success_admin['telephone']); ?></p>
                    <p><strong>N°PV :</strong> <span style="color: #007bff; font-weight: bold;"><?php echo htmlspecialchars($success_admin['numero_pv']); ?></span></p>
                    <p style="color:green;">Un email a été envoyé à <?php echo htmlspecialchars($success_admin['email']); ?> (vérifiez vos spams si vous ne le voyez pas).</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
 </div>  
  <!-- inclusion pied -->
      <?php include_once ('../includes/footer.php'); ?>
 
 </div>  
    <br><br>
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
      
        // Fonction pour afficher le formulaire de modification
        function showEditForm(user) {
            document.getElementById('edit_id').value = user.id;
            document.getElementById('edit_nom').value = user.nom;
            document.getElementById('edit_prenom').value = user.prenom;
            document.getElementById('edit_sexe').value = user.sexe;
            document.getElementById('edit_pays').value = user.pays;
            document.getElementById('edit_numero').value = user.numero;
            document.getElementById('edit_email').value = user.email;
            document.getElementById('edit_adresse').value = user.adresse;
            
            document.getElementById('editForm').style.display = 'block';
            window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
        }
        
        // Fonction pour cacher le formulaire de modification
        function hideEditForm() {
            document.getElementById('editForm').style.display = 'none';
        }
// Pour chaque formulaire de la page, on le réinitialise au chargement
         window.addEventListener('load', () => {
  document.querySelectorAll('form').forEach(form => {
    form.reset();
  });
});

window.addEventListener('beforeunload', () => {
  // Réinitialise tous les formulaires avant de quitter la page
  document.querySelectorAll('form').forEach(form => {
    form.reset();
  });
});

</script>
</body>
</html>