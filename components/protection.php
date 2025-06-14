<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="../assets/css/protection.css">
</head>
<body>
     <!-- inclusion entete -->
      <?php include_once ('../includes/header.php'); ?>
      <br>
 
    <div class="container">
        <form method="POST" action="">
            <h1 class="titre">CONNEXION</h1>
            
            <div class="form-group">
                <label for="statut">Choisir statut</label>
                <select id="statut" name="statut" required>
                    <option value="" disabled selected>Choisir votre statut</option>
                    <option value="bailleurs">Bailleur</option>
                    <option value="agents">Agent</option>
                    <option value="clients">Client</option>
                    <option value="managers">Manager</option>
                    <option value="administrateurs">Administrateur</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="identifiant">Votre identifiant</label>
                <input type="text" id="identifiant" name="identifiant" placeholder="Entrez votre identifiant" required>
            </div>
            
            <div class="form-group password-container">
                <label for="mot_de_passe">Mot de passe</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" placeholder="Entrez votre mot de passe" required>
            </div>
            
            <button type="submit" name="submit">Se connecter</button>
            <button type="submit"><a class="haut" href="#" onclick="history.back()">Retour</a></button>
             <h3>je n'ai pas de compte <a class="bas" href="../login.php"> S'inscrire.....</a></h3>
      
             <?php
            if (isset($_POST['submit'])) {
                $conn = new mysqli("localhost", "root", "", "gestion");
                if ($conn->connect_error) die("Erreur de connexion : " . $conn->connect_error);

                $statut = $conn->real_escape_string($_POST['statut']);
                $identifiant = $conn->real_escape_string($_POST['identifiant']);
                $mot_de_passe = $_POST['mot_de_passe'];

                $sql = "SELECT * FROM $statut WHERE identifiant = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $identifiant);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $user = $result->fetch_assoc();
                    
                    if ($mot_de_passe === $user['code']) {
                        $_SESSION['statut'] = $statut;
                        $_SESSION['identifiant'] = $identifiant;
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['mot_de_passe'] = $user['code']; // 🔸 ligne ajoutée
                        $_SESSION['last_activity'] = time();

                        switch ($statut) {
                            case 'bailleurs':
                                header("Location: ../bailleurs/tableau-bord.php"); break;
                            case 'agents':
                                header("Location: ../employers/agents/tableau-bord.php"); break;
                            case 'clients':
                                header("Location: ../clients/tableau-bord.php"); break;
                            case 'managers':
                                header("Location: ../employers/managers/tableau-bord.php"); break;
                            case 'administrateurs':
                                header("Location: ../agence/tableau-bord.php"); break;
                            default:
                                echo '<p class="error-message">Statut non reconnu.</p>'; break;
                        }
                        exit();
                    } else {
                        showError($statut);
                    }
                } else {
                    showError($statut);
                }

                $conn->close();
            }

            function showError($statut) {
                $statuts = [
                    'bailleurs' => 'bailleur',
                    'agents' => 'agent',
                    'clients' => 'client',
                    'managers' => 'manager',
                    'administrateurs' => 'administrateur'
                ];
                echo '<p class="error-message">Vous n\'êtes pas ' . $statuts[$statut] . ' ou vos identifiants sont incorrects.</p>';
            }
            ?> 
            
        </form>
          
    </div>
     <!-- inclusion pied -->
      <?php include_once ('../includes/footer.php'); ?>
 
</body>
</html>
