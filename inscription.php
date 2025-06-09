<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Confirmation d'inscription</title>
  <link rel="stylesheet" href="assets/css/inscription.css">
  <!-- Ajout de SweetAlert pour de belles alertes -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Ajout de jQuery pour faciliter les requêtes AJAX -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body>
  <?php include_once ('includes/header.php'); ?>

  <div class="container">
    <h1 class="hh"><a href="login.php">CONNEXION</a></h1>

    <?php
        // Désactiver l'affichage des erreurs
        error_reporting(0);
        ini_set('display_errors', 0);

        // Fonction pour générer une chaîne aléatoire
        function generateRandomString($length = 4) {
            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, strlen($characters)) - 1];
            }
            return $randomString;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['inscription'])) {
            // Récupération des données du formulaire
            $nom = htmlspecialchars($_POST['nom'] ?? '');
            $prenom = htmlspecialchars($_POST['prenom'] ?? '');
            $sexe = htmlspecialchars($_POST['sexe'] ?? '');
            $pays = htmlspecialchars($_POST['pays'] ?? '');
            $numero = htmlspecialchars($_POST['numero'] ?? '');
            $email = htmlspecialchars($_POST['email'] ?? '');
            $adresse = htmlspecialchars($_POST['adresse'] ?? '');
            $identifiant = htmlspecialchars($_POST['identifiant'] ?? '');
            $password_input = $_POST['code'] ?? '';
            
            // Génération du suffixe aléatoire et création du mot de passe final
            $random_suffix = generateRandomString();
            $password = $random_suffix . '-' . $password_input;
            $code = password_hash($password, PASSWORD_DEFAULT);

            // Configuration de l'email
            $email_destinataire = $email;
            $email_sujet = "HOUSE COMPAGNY";

            $civilite = ($sexe == 'masculin') ? 'Monsieur' : 'Madame';
            $email_message = "
            <html>
            <head>
                <title>Vos informations d'inscription</title>
                <style>
                    body {
                     font-family: Arial, sans-serif;
                      line-height: 1.6;
                      }
                    .container { 
                       color: black;
                       max-width: 600px;
                       margin: 0 auto; padding: 20px;
                      border: 1px solid #ddd; 
                      border-radius: 5px;
                       }
                    .header { 
                    background-color: #007bff;
                     color: white; padding: 10px; 
                     text-align: center; 
                     border-radius: 5px 5px 0 0; 
                     }
                    .content {
                       padding: 20px; 
                      }
                    .footer {
                     margin-top: 20px;
                      font-size: 0.8em; 
                      text-align: center;
                       color: #777; 
                       }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h2>Confirmation d'inscription</h2>
                    </div>
                    <div class='content'>
                        <p>Bonjour $civilite $nom $prenom,</p>
                        <p>Votre inscription a été enregistrée avec succès. Voici vos informations :</p>
                        
                        <p><strong>Nom d'utilisateur :</strong> $identifiant</p>
                        <p><strong>Mot de passe :</strong> $password</p>
                        
                        <p>Veuillez conserver ces informations précieusement car elles sont indispensables pour accéder à votre compte.</p>
                    </div>
                    <div class='footer'>
                        <p>Cet email a été envoyé automatiquement, merci de ne pas y répondre.</p>
                    </div>
                </div>
            </body>
            </html>";

            // Fonction pour envoyer l'email avec plusieurs méthodes de secours
            function sendEmailWithRetry($to, $subject, $message) {
                // Méthode 1: PHPMailer (primaire)
                if (file_exists('PHPMailer/src/Exception.php') && 
                    file_exists('PHPMailer/src/PHPMailer.php') && 
                    file_exists('PHPMailer/src/SMTP.php')) {
                    
                    require_once 'PHPMailer/src/Exception.php';
                    require_once 'PHPMailer/src/PHPMailer.php';
                    require_once 'PHPMailer/src/SMTP.php';

                    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
                    
                    try {
                        // Configuration SMTP
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'decidaisomar@gmail.com';
                        $mail->Password = 'dspkjjgzuahscwxp';
                        $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
                        $mail->Port = 465;
                        $mail->SMTPOptions = array(
                            'ssl' => array(
                                'verify_peer' => false,
                                'verify_peer_name' => false,
                                'allow_self_signed' => true
                            )
                        );

                        $mail->setFrom('decidaisomar@gmail.com', 'Service d\'inscription');
                        $mail->addAddress($to);
                        $mail->isHTML(true);
                        $mail->Subject = $subject;
                        $mail->Body = $message;
                        $mail->AltBody = strip_tags($message);

                        if ($mail->send()) {
                            return true;
                        }
                    } catch (Exception $e) {
                        // On log l'erreur mais on ne l'affiche pas
                        error_log("PHPMailer Error: " . $e->getMessage());
                    }
                }

                // Méthode 2: Fonction mail() native de PHP (secondaire)
                try {
                    $headers = "From: decidaisomar@gmail.com\r\n";
                    $headers .= "Reply-To: decidaisomar@gmail.com\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

                    if (@mail($to, $subject, $message, $headers)) {
                        return true;
                    }
                } catch (Exception $e) {
                    // On log l'erreur mais on ne l'affiche pas
                    error_log("mail() Error: " . $e->getMessage());
                }

                return false;
            }

            // Vérification et envoi de l'email
            $email_sent = false;
            if (filter_var($email_destinataire, FILTER_VALIDATE_EMAIL)) {
                $email_sent = sendEmailWithRetry($email_destinataire, $email_sujet, $email_message);
            } else {
                echo "<h2 class='error'>L'adresse email fournie n'est pas valide.</h2>";
                exit;
            }

            // Si l'email n'a pas été envoyé, on ne procède pas à l'insertion dans la base
            if (!$email_sent) {
                echo "<h2 class='error'>Le système d'envoi d'emails est temporairement indisponible. Veuillez réessayer plus tard ou contacter l'administrateur.</h2>";
                exit;
            }

            // Si l'email a été envoyé, on procède à l'insertion dans la base
            try {
                // Connexion à la base de données
                $pdo = new PDO("mysql:host=localhost;dbname=gestion", "root", "");
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Vérification si l'identifiant ou l'email existe déjà
                $check_sql = "SELECT * FROM client WHERE identifiant = :identifiant OR email = :email";
                $check_stmt = $pdo->prepare($check_sql);
                $check_stmt->bindParam(':identifiant', $identifiant);
                $check_stmt->bindParam(':email', $email);
                $check_stmt->execute();

                if ($check_stmt->rowCount() > 0) {
                    // Vérifier lequel des deux est déjà utilisé (identifiant ou email)
                    $result = $check_stmt->fetch();
                    if ($result['identifiant'] === $identifiant) {
                        echo "<h2 class='error'>Cet identifiant est déjà utilisé.</h2>";
                    } elseif ($result['email'] === $email) {
                        echo "<h2 class='error'>Cet email est déjà utilisé.</h2>";
                    } else {
                        echo "<h2 class='error'>Identifiant ou email déjà utilisé.</h2>";
                    }
                    exit;
                }

                // Vérification du format de l'email
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    echo "<h2 class='error'>Format d'email invalide.</h2>";
                    exit;
                }

                // Requête d'insertion
                $sql = "INSERT INTO client (nom, prenom, sexe, pays, numero, email, adresse, identifiant, code) 
                        VALUES (:nom, :prenom, :sexe, :pays, :numero, :email, :adresse, :identifiant, :code)";
                $stmt = $pdo->prepare($sql);

                // Liaison des paramètres
                $stmt->bindParam(':nom', $nom);
                $stmt->bindParam(':prenom', $prenom);
                $stmt->bindParam(':sexe', $sexe);
                $stmt->bindParam(':pays', $pays);
                $stmt->bindParam(':numero', $numero);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':adresse', $adresse);
                $stmt->bindParam(':identifiant', $identifiant);
                $stmt->bindParam(':code', $code);

                // Exécution de la requête
                if ($stmt->execute()) {
                    echo "<h2> $civilite :<strong>$nom $prenom</strong> <br>votre inscription a été faite avec succès 😁</h2>";
                    echo "<h2>Votre nom d'utilisateur est : 👉 $identifiant 👈</h2>";
                    echo "<h2>Votre mot de passe est : 👉 $password 👈</h2>";
                    echo "<h2>Veuillez garder ces informations à l'abri <br> car elles sont inchangeables.</h2>";
                    echo "<p class='success'>Un email contenant vos informations a été envoyé à $email_destinataire  <br> veuillez vous rendre au niveau de <strong> l'onglet `≡`
                     </strong> dans votre compte Gmail (défilez vers le bas) puis clické sur <strong> spam </strong> pour voir vos informations (Afficher ci-dessus)</p>";
                } else {
                    echo "<h2 class='error'>Échec de l'inscription.</h2>";
                    exit;
                }
            } catch (PDOException $e) {
                echo "<h2 class='error'>Une erreur est survenue lors de l'inscription. Veuillez réessayer.</h2>";
                exit;
            }
        } else {
            echo "<h2 class='error'>Aucune donnée d'inscription reçue.</h2>";
        }
        ?>

    <script>
    // Fonction pour vérifier le numéro de téléphone
    function verifierNumero(numeroComplet) {
      const {
        parsePhoneNumberFromString
      } = window.libphonenumber;
      const phoneNumber = parsePhoneNumberFromString(numeroComplet);

      if (phoneNumber && phoneNumber.isValid()) {
        return true;
      } else {
        alert("Numéro de téléphone invalide.");
        return false;
      }
    }

    // Script pour réessayer l'envoi d'email via AJAX
    $(document).ready(function() {
      $('#retryButton').click(function() {
        Swal.fire({
          title: 'Envoi en cours...',
          allowOutsideClick: false,
          didOpen: () => {
            Swal.showLoading();

            $.ajax({
              type: "POST",
              url: "resend_email.php",
              data: {
                email: "<?php echo isset($email_destinataire) ? $email_destinataire : ''; ?>",
                sujet: "<?php echo isset($email_sujet) ? addslashes($email_sujet) : ''; ?>",
                message: `<?php echo isset($email_message) ? addslashes($email_message) : ''; ?>`
              },
              success: function(response) {
                Swal.fire({
                  icon: response.success ? 'success' : 'error',
                  title: response.success ? 'Email envoyé!' : 'Erreur',
                  text: response.message
                });

                if (response.success) {
                  $('#emailError').remove();
                }
              },
              error: function() {
                Swal.fire({
                  icon: 'error',
                  title: 'Erreur',
                  text: 'Une erreur est survenue lors de la communication avec le serveur'
                });
              }
            });
          }
        });
      });
    });
    </script>

    <?php
        // Création du fichier resend_email.php s'il n'existe pas
        if (!file_exists('resend_email.php')) {
            $resend_email_code = '<?php
            header("Content-Type: application/json");
            // Désactiver l\'affichage des erreurs
            error_reporting(0);
            ini_set(\'display_errors\', 0);

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $to = $_POST["email"] ?? "";
                $subject = $_POST["sujet"] ?? "";
                $message = $_POST["message"] ?? "";

                if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
                    echo json_encode(["success" => false, "message" => "Adresse email invalide"]);
                    exit;
                }

                // Essayer d\'abord avec PHPMailer
                if (file_exists("PHPMailer/src/Exception.php") && 
                    file_exists("PHPMailer/src/PHPMailer.php") && 
                    file_exists("PHPMailer/src/SMTP.php")) {
                    
                    require_once "PHPMailer/src/Exception.php";
                    require_once "PHPMailer/src/PHPMailer.php";
                    require_once "PHPMailer/src/SMTP.php";

                    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
                    
                    try {
                        $mail->isSMTP();
                        $mail->Host = "smtp.gmail.com";
                        $mail->SMTPAuth = true;
                        $mail->Username = "decidaisomar@gmail.com";
                        $mail->Password = "dspkjjgzuahscwxp";
                        $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
                        $mail->Port = 465;
                        $mail->SMTPOptions = array(
                            "ssl" => array(
                                "verify_peer" => false,
                                "verify_peer_name" => false,
                                "allow_self_signed" => true
                            )
                        );

                        $mail->setFrom("decidaisomar@gmail.com", "Service d\'inscription");
                        $mail->addAddress($to);
                        $mail->isHTML(true);
                        $mail->Subject = $subject;
                        $mail->Body = $message;
                        $mail->AltBody = strip_tags($message);

                        if ($mail->send()) {
                            echo json_encode(["success" => true, "message" => "Email envoyé avec succès"]);
                            exit;
                        }
                    } catch (Exception $e) {
                        error_log("PHPMailer Error: " . $e->getMessage());
                    }
                }

                // Si PHPMailer échoue, essayer avec la fonction mail() native
                $headers = "From: decidaisomar@gmail.com\r\n";
                $headers .= "Reply-To: decidaisomar@gmail.com\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

                if (@mail($to, $subject, $message, $headers)) {
                    echo json_encode(["success" => true, "message" => "Email envoyé avec la méthode alternative"]);
                } else {
                    echo json_encode(["success" => false, "message" => "Le système d\'envoi d\'emails est temporairement indisponible. Veuillez réessayer plus tard."]);
                }
            } else {
                echo json_encode(["success" => false, "message" => "Méthode non autorisée"]);
            }
            ?>';

    file_put_contents('resend_email.php', $resend_email_code);

    }
    ?>
  </div>
  <?php include_once ('includes/footer.php'); ?>
</body>

</html>