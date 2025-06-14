<?php
// Inclusion des fichiers PHPMailer une seule fois
require_once __DIR__ . '/PHPMailer/src/Exception.php';
require_once __DIR__ . '/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Fonction pour générer un code aléatoire (2 chiffres + 4 lettres majuscules)
function generatePVCode() {
    $numbers = str_pad(rand(0, 99), 2, '0', STR_PAD_LEFT);
    $letters = '';
    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    for ($i = 0; $i < 4; $i++) {
        $letters .= $chars[rand(0, strlen($chars) - 1)];
    }
    return $numbers . $letters;
}

// Fonction pour envoyer l'email avec PHPMailer
function sendPVEmail($to, $identifiant, $numero_pv, $type = 'Bailleur') {
    $mail = new PHPMailer(true);
    
    try {
        // Configuration SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'decidaisomar@gmail.com';
        $mail->Password = 'dspkjjgzuahscwxp';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        $mail->setFrom('decidaisomar@gmail.com', 'HOUSE-COMPANY|Service de generation PV');
        $mail->addAddress($to);
        $mail->isHTML(true);
        $mail->Subject = 'Votre numero PV ' . $type . ' genere';

        // Couleur selon le type
        $color = ($type == 'Agent') ? '#28a745' : (($type == 'Manager') ? '#dc3545' : (($type == 'Administrateur') ? '#6f42c1' : '#007bff'));

        // Corps de l'email avec style
        $email_content = '
        <html>
        <head>
            <style>
               body {
                    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
                    background-color: #f4f4f4;
                    margin: 0;
                    padding: 0;
                }

                .header {
                    text-align: center;
                    background-color: '.$color.';
                    color: #fff;
                    padding: 15px 10px;
                }

                .container {
                    max-width: 600px;
                    margin: 30px auto;
                    padding: 25px;
                    background-color: #fff;
                    border-radius: 10px;
                    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                }

                h2 {
                    margin: 0;
                    font-size: 1.8em;
                }

                h3 {
                    color: '.$color.';
                    border-bottom: 2px solid #eee;
                    padding-bottom: 8px;
                    margin-bottom: 20px;
                }

                p {
                    margin: 15px 0;
                    line-height: 1.6;
                }

                strong {
                    color: #000;
                }

                .pv-number {
                    color: '.$color.';
                    font-weight: bold;
                    font-size: 1.3em;
                }
            </style>
        </head>
        <body>
            <div class="header">
                <h2>Confirmation du N°PV '.$type.'</h2>
            </div>
            <div class="container">
                <h3>N°PV '.$type.' généré avec succès !</h3>
                <p><strong>Identifiant :</strong> '.htmlspecialchars($identifiant).'</p>
                <p><strong>N°PV :</strong> <span class="pv-number">'.htmlspecialchars($numero_pv).'</span></p>
                <p>Conservez précieusement ce numéro PV, il vous sera demandé pour toute correspondance.</p>
                <p>Veuillez conserver ces informations précieusement car elles sont indispensables pour accéder à votre compte.</p>
                <p>Cet email a été envoyé automatiquement, merci de ne pas y répondre.</p>
            </div>
        </body>
        </html>';

        $mail->Body = $email_content;
        $mail->AltBody = "N°PV $type généré avec succès!\n\nIdentifiant: $identifiant\nN°PV: $numero_pv";

        return $mail->send();
    } catch (Exception $e) {
        error_log("PHPMailer Error: " . $e->getMessage());
        return false;
    }
}

// Initialisation des variables de message
$error_bailleur = $success_bailleur = $error_agent = $success_agent = $error_manager = $success_manager = $error_admin = $success_admin = null;

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['type'])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "gestion";

    $conn = null;
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $identifiant = htmlspecialchars($_POST['identifiant']);
        $code = htmlspecialchars($_POST['code']);
        $type = $_POST['type'];
        
        if ($type == 'bailleur') {
            // Vérification de l'identifiant et du mot de passe dans la table personnes
            $stmt = $conn->prepare("SELECT id, nom, prenom, email, pays AS code_pays, numero AS telephone, code
                                   FROM personnes
                                   WHERE identifiant = :identifiant AND matricule = :code");
            $stmt->bindParam(':identifiant', $identifiant);
            $stmt->bindParam(':code', $code);
            $stmt->execute();
            $user_info = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$user_info) {
                $error_bailleur = "Identifiant ou matricule incorrect.";
            } else {
                // Vérification si l'utilisateur a déjà un N°PV
                $stmt_check = $conn->prepare("SELECT numero_pv FROM bailleurs WHERE id_personne = :id_personne");
                $stmt_check->bindParam(':id_personne', $user_info['id']);
                $stmt_check->execute();
                
                if ($stmt_check->rowCount() > 0) {
                    $existing_pv = $stmt_check->fetch(PDO::FETCH_ASSOC);
                    $error_bailleur = "Vous avez déjà un N°PV Bailleur : " . htmlspecialchars($existing_pv['numero_pv']);
                } else {
                    // Génération du N°PV
                    $numero_pv = generatePVCode();
                    
                    // Envoi de l'email
                    $email_sent = sendPVEmail($user_info['email'], $identifiant, $numero_pv, 'Bailleur');
                    
                    if (!$email_sent) {
                        $error_bailleur = "Le système d'envoi d'emails est temporairement indisponible. Veuillez réessayer.";
                    } else {
                        // Insertion dans la base de données
                        $stmt = $conn->prepare("INSERT INTO bailleurs (id_personne, nom, prenom, email, pays, numero, identifiant, code, numero_pv, date_creation) 
                                               VALUES (:id_personne, :nom, :prenom, :email, :pays, :numero, :identifiant, :code, :numero_pv, CURDATE())");
                        $stmt->bindParam(':id_personne', $user_info['id']);
                        $stmt->bindParam(':nom', $user_info['nom']);
                        $stmt->bindParam(':prenom', $user_info['prenom']);
                        $stmt->bindParam(':email', $user_info['email']);
                        $stmt->bindParam(':pays', $user_info['code_pays']);
                        $stmt->bindParam(':numero', $user_info['telephone']);
                        $stmt->bindParam(':identifiant', $identifiant);
                        $stmt->bindParam(':code', $user_info['code']);
                        $stmt->bindParam(':numero_pv', $numero_pv);
                        $stmt->execute();

                        $success_bailleur = array(
                            'identifiant' => $identifiant,
                            'nom_complet' => $user_info['prenom'] . ' ' . $user_info['nom'],
                            'email' => $user_info['email'],
                            'telephone' => $user_info['telephone'],
                            'numero_pv' => $numero_pv
                        );
                    }
                }
            }
        } elseif ($type == 'agent') {
            // Vérification dans la table personnes
            $stmt = $conn->prepare("SELECT id, nom, prenom, email, pays AS code_pays, numero AS telephone, code
                                   FROM personnes
                                   WHERE identifiant = :identifiant AND matricule = :code");
            $stmt->bindParam(':identifiant', $identifiant);
            $stmt->bindParam(':code', $code);
            $stmt->execute();
            $user_info = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$user_info) {
                $error_agent = "Identifiant ou matricule incorrect.";
            } else {
                // Vérification si l'agent a déjà un N°PV
                $stmt_check = $conn->prepare("SELECT numero_pv FROM agents WHERE id_personne = :id_personne");
                $stmt_check->bindParam(':id_personne', $user_info['id']);
                $stmt_check->execute();
                
                if ($stmt_check->rowCount() > 0) {
                    $existing_pv = $stmt_check->fetch(PDO::FETCH_ASSOC);
                    $error_agent = "Vous avez déjà un N°PV Agent : " . htmlspecialchars($existing_pv['numero_pv']);
                } else {
                    // Génération du N°PV Agent
                    $numero_pv = generatePVCode();
                    
                    // Envoi de l'email
                    $email_sent = sendPVEmail($user_info['email'], $identifiant, $numero_pv, 'Agent');
                    
                    if (!$email_sent) {
                        $error_agent = "Erreur d'envoi d'email. Veuillez réessayer.";
                    } else {
                        // Insertion dans la table agents
                        $stmt = $conn->prepare("INSERT INTO agents (id_personne, nom, prenom, email, pays, numero, identifiant, code, numero_pv, date_creation) 
                                               VALUES (:id_personne, :nom, :prenom, :email, :pays, :numero, :identifiant, :code, :numero_pv, CURDATE())");
                        $stmt->bindParam(':id_personne', $user_info['id']);
                        $stmt->bindParam(':nom', $user_info['nom']);
                        $stmt->bindParam(':prenom', $user_info['prenom']);
                        $stmt->bindParam(':email', $user_info['email']);
                        $stmt->bindParam(':pays', $user_info['code_pays']);
                        $stmt->bindParam(':numero', $user_info['telephone']);
                        $stmt->bindParam(':identifiant', $identifiant);
                        $stmt->bindParam(':code', $user_info['code']);
                        $stmt->bindParam(':numero_pv', $numero_pv);
                        $stmt->execute();

                        $success_agent = array(
                            'identifiant' => $identifiant,
                            'nom_complet' => $user_info['prenom'] . ' ' . $user_info['nom'],
                            'email' => $user_info['email'],
                            'telephone' => $user_info['telephone'],
                            'numero_pv' => $numero_pv
                        );
                    }
                }
            }
        } elseif ($type == 'manager') {
            // Vérification dans la table personnes
            $stmt = $conn->prepare("SELECT id, nom, prenom, email, pays AS code_pays, numero AS telephone, code
                                   FROM personnes
                                   WHERE identifiant = :identifiant AND matricule = :code");
            $stmt->bindParam(':identifiant', $identifiant);
            $stmt->bindParam(':code', $code);
            $stmt->execute();
            $user_info = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$user_info) {
                $error_manager = "Identifiant ou matricule incorrect.";
            } else {
                // Vérification si le manager a déjà un N°PV
                $stmt_check = $conn->prepare("SELECT numero_pv FROM managers WHERE id_personne = :id_personne");
                $stmt_check->bindParam(':id_personne', $user_info['id']);
                $stmt_check->execute();
                
                if ($stmt_check->rowCount() > 0) {
                    $existing_pv = $stmt_check->fetch(PDO::FETCH_ASSOC);
                    $error_manager = "Vous avez déjà un N°PV Manager : " . htmlspecialchars($existing_pv['numero_pv']);
                } else {
                    // Génération du N°PV Manager
                    $numero_pv = generatePVCode();
                    
                    // Envoi de l'email
                    $email_sent = sendPVEmail($user_info['email'], $identifiant, $numero_pv, 'Manager');

                    if (!$email_sent) {
                        $error_manager = "Erreur d'envoi d'email. Veuillez réessayer.";
                    } else {
                        // Insertion dans la table managers
                        $stmt = $conn->prepare("INSERT INTO managers (id_personne, nom, prenom, email, pays, numero, identifiant, code, numero_pv, date_creation) 
                                               VALUES (:id_personne, :nom, :prenom, :email, :pays, :numero, :identifiant, :code, :numero_pv, CURDATE())");
                        $stmt->bindParam(':id_personne', $user_info['id']);
                        $stmt->bindParam(':nom', $user_info['nom']);
                        $stmt->bindParam(':prenom', $user_info['prenom']);
                        $stmt->bindParam(':email', $user_info['email']);
                        $stmt->bindParam(':pays', $user_info['code_pays']);
                        $stmt->bindParam(':numero', $user_info['telephone']);
                        $stmt->bindParam(':identifiant', $identifiant);
                        $stmt->bindParam(':code', $user_info['code']);
                        $stmt->bindParam(':numero_pv', $numero_pv);
                        $stmt->execute();

                        // Insertion dans la table agents
                        $stmt_agent = $conn->prepare("INSERT INTO agents (id_personne, nom, prenom, email, pays, numero, identifiant, code, numero_pv, date_creation) 
                                               VALUES (:id_personne, :nom, :prenom, :email, :pays, :numero, :identifiant, :code, :numero_pv, CURDATE())");
                        $stmt_agent->bindParam(':id_personne', $user_info['id']);
                        $stmt_agent->bindParam(':nom', $user_info['nom']);
                        $stmt_agent->bindParam(':prenom', $user_info['prenom']);
                        $stmt_agent->bindParam(':email', $user_info['email']);
                        $stmt_agent->bindParam(':pays', $user_info['code_pays']);
                        $stmt_agent->bindParam(':numero', $user_info['telephone']);
                        $stmt_agent->bindParam(':identifiant', $identifiant);
                        $stmt_agent->bindParam(':code', $user_info['code']);
                        $stmt_agent->bindParam(':numero_pv', $numero_pv);
                        $stmt_agent->execute();

                        // Insertion dans la table bailleurs
                        $stmt_bailleur = $conn->prepare("INSERT INTO bailleurs (id_personne, nom, prenom, email, pays, numero, identifiant, code, numero_pv, date_creation) 
                                               VALUES (:id_personne, :nom, :prenom, :email, :pays, :numero, :identifiant, :code, :numero_pv, CURDATE())");
                        $stmt_bailleur->bindParam(':id_personne', $user_info['id']);
                        $stmt_bailleur->bindParam(':nom', $user_info['nom']);
                        $stmt_bailleur->bindParam(':prenom', $user_info['prenom']);
                        $stmt_bailleur->bindParam(':email', $user_info['email']);
                        $stmt_bailleur->bindParam(':pays', $user_info['code_pays']);
                        $stmt_bailleur->bindParam(':numero', $user_info['telephone']);
                        $stmt_bailleur->bindParam(':identifiant', $identifiant);
                        $stmt_bailleur->bindParam(':code', $user_info['code']);
                        $stmt_bailleur->bindParam(':numero_pv', $numero_pv);
                        $stmt_bailleur->execute();

                        $success_manager = array(
                            'identifiant' => $identifiant,
                            'nom_complet' => $user_info['prenom'] . ' ' . $user_info['nom'],
                            'email' => $user_info['email'],
                            'telephone' => $user_info['telephone'],
                            'numero_pv' => $numero_pv
                        );
                    }
                }
            }
        } elseif ($type == 'administrateur') {
            // Vérification dans la table personnes
            $stmt = $conn->prepare("SELECT id, nom, prenom, email, pays AS code_pays, numero AS telephone, code
                                   FROM personnes
                                   WHERE identifiant = :identifiant AND matricule = :code");
            $stmt->bindParam(':identifiant', $identifiant);
            $stmt->bindParam(':code', $code);
            $stmt->execute();
            $user_info = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$user_info) {
                $error_admin = "Identifiant ou matricule incorrect.";
            } else {
                // Vérification si l'administrateur a déjà un N°PV
                $stmt_check = $conn->prepare("SELECT numero_pv FROM administrateurs WHERE id_personne = :id_personne");
                $stmt_check->bindParam(':id_personne', $user_info['id']);
                $stmt_check->execute();
                
                if ($stmt_check->rowCount() > 0) {
                    $existing_pv = $stmt_check->fetch(PDO::FETCH_ASSOC);
                    $error_admin = "Vous avez déjà un N°PV Administrateur : " . htmlspecialchars($existing_pv['numero_pv']);
                } else {
                    // Génération du N°PV Administrateur
                    $numero_pv = generatePVCode();
                    
                    // Envoi de l'email
                    $email_sent = sendPVEmail($user_info['email'], $identifiant, $numero_pv, 'Administrateur');

                    if (!$email_sent) {
                        $error_admin = "Erreur d'envoi d'email. Veuillez réessayer.";
                    } else {
                        // Insertion dans la table administrateurs
                        $stmt = $conn->prepare("INSERT INTO administrateurs (id_personne, nom, prenom, email, pays, numero, identifiant, code, numero_pv, date_creation) 
                                               VALUES (:id_personne, :nom, :prenom, :email, :pays, :numero, :identifiant, :code, :numero_pv, CURDATE())");
                        $stmt->bindParam(':id_personne', $user_info['id']);
                        $stmt->bindParam(':nom', $user_info['nom']);
                        $stmt->bindParam(':prenom', $user_info['prenom']);
                        $stmt->bindParam(':email', $user_info['email']);
                        $stmt->bindParam(':pays', $user_info['code_pays']);
                        $stmt->bindParam(':numero', $user_info['telephone']);
                        $stmt->bindParam(':identifiant', $identifiant);
                        $stmt->bindParam(':code', $user_info['code']);
                        $stmt->bindParam(':numero_pv', $numero_pv);
                        $stmt->execute();

                        // Insertion dans la table managers
                        $stmt_manager = $conn->prepare("INSERT INTO managers (id_personne, nom, prenom, email, pays, numero, identifiant, code, numero_pv, date_creation) 
                                               VALUES (:id_personne, :nom, :prenom, :email, :pays, :numero, :identifiant, :code, :numero_pv, CURDATE())");
                        $stmt_manager->bindParam(':id_personne', $user_info['id']);
                        $stmt_manager->bindParam(':nom', $user_info['nom']);
                        $stmt_manager->bindParam(':prenom', $user_info['prenom']);
                        $stmt_manager->bindParam(':email', $user_info['email']);
                        $stmt_manager->bindParam(':pays', $user_info['code_pays']);
                        $stmt_manager->bindParam(':numero', $user_info['telephone']);
                        $stmt_manager->bindParam(':identifiant', $identifiant);
                        $stmt_manager->bindParam(':code', $user_info['code']);
                        $stmt_manager->bindParam(':numero_pv', $numero_pv);
                        $stmt_manager->execute();

                        // Insertion dans la table agents
                        $stmt_agent = $conn->prepare("INSERT INTO agents (id_personne, nom, prenom, email, pays, numero, identifiant, code, numero_pv, date_creation) 
                                               VALUES (:id_personne, :nom, :prenom, :email, :pays, :numero, :identifiant, :code, :numero_pv, CURDATE())");
                        $stmt_agent->bindParam(':id_personne', $user_info['id']);
                        $stmt_agent->bindParam(':nom', $user_info['nom']);
                        $stmt_agent->bindParam(':prenom', $user_info['prenom']);
                        $stmt_agent->bindParam(':email', $user_info['email']);
                        $stmt_agent->bindParam(':pays', $user_info['code_pays']);
                        $stmt_agent->bindParam(':numero', $user_info['telephone']);
                        $stmt_agent->bindParam(':identifiant', $identifiant);
                        $stmt_agent->bindParam(':code', $user_info['code']);
                        $stmt_agent->bindParam(':numero_pv', $numero_pv);
                        $stmt_agent->execute();

                        // Insertion dans la table bailleurs
                        $stmt_bailleur = $conn->prepare("INSERT INTO bailleurs (id_personne, nom, prenom, email, pays, numero, identifiant, code, numero_pv, date_creation) 
                                               VALUES (:id_personne, :nom, :prenom, :email, :pays, :numero, :identifiant, :code, :numero_pv, CURDATE())");
                        $stmt_bailleur->bindParam(':id_personne', $user_info['id']);
                        $stmt_bailleur->bindParam(':nom', $user_info['nom']);
                        $stmt_bailleur->bindParam(':prenom', $user_info['prenom']);
                        $stmt_bailleur->bindParam(':email', $user_info['email']);
                        $stmt_bailleur->bindParam(':pays', $user_info['code_pays']);
                        $stmt_bailleur->bindParam(':numero', $user_info['telephone']);
                        $stmt_bailleur->bindParam(':identifiant', $identifiant);
                        $stmt_bailleur->bindParam(':code', $user_info['code']);
                        $stmt_bailleur->bindParam(':numero_pv', $numero_pv);
                        $stmt_bailleur->execute();

                        $success_admin = array(
                            'identifiant' => $identifiant,
                            'nom_complet' => $user_info['prenom'] . ' ' . $user_info['nom'],
                            'email' => $user_info['email'],
                            'telephone' => $user_info['telephone'],
                            'numero_pv' => $numero_pv
                        );
                    }
                }
            }
        } 
    } catch(PDOException $e) {
        if ($type == 'administrateur') {
            $error_admin = "Erreur de base de données : " . $e->getMessage();
        } elseif ($type == 'agent') {
            $error_agent = "Erreur de base de données : " . $e->getMessage();
        } elseif ($type == 'manager') {
            $error_manager = "Erreur de base de données : " . $e->getMessage();
        } elseif ($type == 'bailleur') {
            $error_bailleur = "Erreur de base de données : " . $e->getMessage();
        }
    } finally {
        if ($conn !== null) {
            $conn = null;
        }
    }
}
?>