<?php
            header("Content-Type: application/json");

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $to = $_POST["email"] ?? "";
                $subject = $_POST["sujet"] ?? "";
                $message = $_POST["message"] ?? "";

                if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
                    echo json_encode(["success" => false, "message" => "Adresse email invalide"]);
                    exit;
                }

                // Essayer d'abord avec PHPMailer
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
                        $mail->Username = "ckprod7295@gmail.com";
                        $mail->Password = "dxclrvkugoqiqdly";
                        $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
                        $mail->Port = 465;
                        $mail->SMTPOptions = array(
                            "ssl" => array(
                                "verify_peer" => false,
                                "verify_peer_name" => false,
                                "allow_self_signed" => true
                            )
                        );

                        $mail->setFrom("ckprod7295@gmail.com", "Service d'inscription");
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
                $headers = "From: ckprod7295@gmail.com\r\n";
                $headers .= "Reply-To: ckprod7295@gmail.com\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

                if (mail($to, $subject, $message, $headers)) {
                    echo json_encode(["success" => true, "message" => "Email envoyé avec la méthode alternative"]);
                } else {
                    echo json_encode(["success" => false, "message" => "Échec de l'envoi de l'email"]);
                }
            } else {
                echo json_encode(["success" => false, "message" => "Méthode non autorisée"]);
            }
            ?>