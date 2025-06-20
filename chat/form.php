<?php include('formphp.php') ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion au Chat</title>
    <link rel="stylesheet" href="form.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <link rel="stylesheet" href="../assets/css/header_connexion.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
 <style>
    .form-container{
        margin-top: 62%;
    }
    .nom{
      font-size:1.4rem;
      margin-top:-40%;
      margin-left:70%;
      color:#0084ff;
    }
   </style>
<body>
<header class="site-header">
   <div class="container-hdconnexion">
     <div class="header-content">
       <!-- le logo qui bouge comporte un lien vers la presentation -->
       <a href="index.php">
         <img src="../assets/images/bannieres/logo.jpg" alt="User" class="user-image">
          <strong><p class="nom">HOUSE CONPANY</p></strong>
       </a>
       <a href="#" class="logo">
       </a>

       <button class="mobile-menu-btn">
         <i class="fas fa-bars"></i>
       </button>

       <ul class="nav-menu">
         <li><a href="../index.php" class="nav-link active">Accueil</a></li>

         <li><a href="../propriete.php">Propriétes</a>
           <ul class="dropdown">
             <li><a href="../vente.php">Propriétes à vendre</a></li>
             <li><a href="../louer.php">Propriétes à louer</a></li>
           </ul>
         </li>
         <li><a href="../services.php" class="nav-link">Services</a></li>

         <li><a href="../contact.php" class="nav-link">Contact</a></li>
       </ul>

       <div class="user-actions">

         <a href="../components/protection.php" class="btn btn-primary">admin</a>

       </div>
     </div>
   </div>
 </header>

    <div class="form-container">
        <form method="POST" action="">
            <h1 class="titre">CONNEXION-CHAT</h1>
            
            <?php if (!empty($error)): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <div class="form-group">
                <label for="statut1">Votre statut</label>
                <select id="statut1" name="statut1" required>
                    <option value="" disabled selected>Choisir votre statut</option>
                    <option value="bailleur" <?= isset($_POST['statut1']) && $_POST['statut1'] === 'bailleur' ? 'selected' : '' ?>>Bailleur</option>
                    <option value="agent" <?= isset($_POST['statut1']) && $_POST['statut1'] === 'agent' ? 'selected' : '' ?>>Agent</option>
                    <option value="client" <?= isset($_POST['statut1']) && $_POST['statut1'] === 'client' ? 'selected' : '' ?>>Client</option>
                    <option value="manager" <?= isset($_POST['statut1']) && $_POST['statut1'] === 'manager' ? 'selected' : '' ?>>Manager</option>
                    <option value="administrateur" <?= isset($_POST['statut1']) && $_POST['statut1'] === 'administrateur' ? 'selected' : '' ?>>Administrateur</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="matricule1">Votre matricule :</label>
                <input type="text" id="matricule1" name="matricule1" placeholder="Entrez votre matricule" required 
                       value="<?= isset($_POST['matricule1']) ? htmlspecialchars($_POST['matricule1']) : '' ?>">
            </div>
            
            <div class="form-group">
                <label for="identifiant">Votre identifiant</label>
                <input type="text" id="identifiant" name="identifiant" placeholder="Entrez votre identifiant" required
                       value="<?= isset($_POST['identifiant']) ? htmlspecialchars($_POST['identifiant']) : '' ?>">
            </div>
            
            <div class="form-group">
                <label for="code">Votre code</label>
                <input type="password" id="code" name="code" placeholder="Entrez votre code" required>
            </div>
            
            <div class="form-group">
                <label for="statut2">Statut du destinataire</label>
                <select id="statut2" name="statut2" required>
                    <option value="" disabled selected>Choisir le statut du destinataire</option>
                    <option value="bailleur" <?= isset($_POST['statut2']) && $_POST['statut2'] === 'bailleur' ? 'selected' : '' ?>>Bailleur</option>
                    <option value="agent" <?= isset($_POST['statut2']) && $_POST['statut2'] === 'agent' ? 'selected' : '' ?>>Agent</option>
                    <option value="client" <?= isset($_POST['statut2']) && $_POST['statut2'] === 'client' ? 'selected' : '' ?>>Client</option>
                    <option value="manager" <?= isset($_POST['statut2']) && $_POST['statut2'] === 'manager' ? 'selected' : '' ?>>Manager</option>
                    <option value="administrateur" <?= isset($_POST['statut2']) && $_POST['statut2'] === 'administrateur' ? 'selected' : '' ?>>Administrateur</option>
                </select>
            </div>
             
            <div class="form-group">
                <label for="matricule2">Matricule du destinataire :</label>
                <input type="text" id="matricule2" name="matricule2" placeholder="Entrez le matricule du destinataire" required 
                       value="<?= isset($_POST['matricule2']) ? htmlspecialchars($_POST['matricule2']) : '' ?>">
            </div>
            
            <button type="submit" name="submit">Se connecter au chat</button>
        </form>
    </div>
    <?php include_once ('../includes/footer.php'); ?>
</body>
</html>