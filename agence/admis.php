<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Génération de N°PV</title>
    <style>
      body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    margin: 0;
    padding: 20px;
    background-color: #f5f5f5;
}

.container {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin-bottom: 30px;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

h1 {
    color: #007bff;
    text-align: center;
    margin-top: 0;
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

input[type="text"],
input[type="password"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-sizing: border-box;
}

button {
    background-color: #007bff;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    width: 100%;
}

button:hover {
    background-color: #007bff;
}

.result {
    margin-top: 20px;
    padding: 15px;
    border-radius: 4px;
}

.error {
    background-color: #ffebee;
    color:rgb(255, 0, 0);
    border: 1px solidrgb(255, 0, 0);
}

.success {
    background-color: #e8f5e9;
    color: #007bff;
    border: 1px solid #007bff;
    text-align: center;
}

.success h3 {
    margin-top: 0;
    color: #007bff;
    font-size: 1.5em;
    margin-bottom: 15px;
}

.success p {
    margin: 10px 0;
    font-size: 1.1em;
}

.success strong {
    display: block;
    margin-top: 5px;
    font-size: 1.2em;
}

.success span {
    color: #007bff;
    font-weight: bold;
    font-size: 1.3em;
}

.success .email-notice {
    color: #007bff;
    font-style: italic;
    margin-top: 15px;
}
    </style>
</head>

<body>

    <!-- inclusion du fichier PHP -->
    <?php include 'admisphp.php'; ?>
    
    <!-- FORMULAIRE BAILLEUR -->
    <div class="container">
        <h1>Génération de N°PV POUR BAILLEUR</h1>
        <form method="POST">
            <input type="hidden" name="type" value="bailleur">
            <div class="form-group">
                <label for="identifiantBailleur">Identifiant :</label>
                <input type="text" id="identifiantBailleur" name="identifiant" placeholder="Entrez votre identifiant" required>
            </div>
            
            <div class="form-group">
                <label for="codeBailleur">Mot de passe :</label>
                <input type="password" id="codeBailleur" name="code" placeholder="Entrez votre mot de passe" required>
            </div>
            <button type="submit">Générer le N°PV</button>
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
    <div class="container">
        <h1>Génération de N°PV POUR AGENTS</h1>
        <form method="POST">
            <input type="hidden" name="type" value="agent">
            <div class="form-group">
                <label for="identifiantAgent">Identifiant :</label>
                <input type="text" id="identifiantAgent" name="identifiant" placeholder="Entrez votre identifiant" required>
            </div>
            
            <div class="form-group">
                <label for="codeAgent">Mot de passe :</label>
                <input type="password" id="codeAgent" name="code" placeholder="Entrez votre mot de passe" required>
            </div>
            <button type="submit">Générer le N°PV</button>
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
    <div class="container">
        <h1>Génération de N°PV POUR MANAGERS</h1>
        <form method="POST">
            <input type="hidden" name="type" value="manager">
            <div class="form-group">
                <label for="identifiantManager">Identifiant :</label>
                <input type="text" id="identifiantManager" name="identifiant" placeholder="Entrez votre identifiant" required>
            </div>
            
            <div class="form-group">
                <label for="codeManager">Mot de passe :</label>
                <input type="password" id="codeManager" name="code" placeholder="Entrez votre mot de passe" required>
            </div>
            <button type="submit">Générer le N°PV</button>
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
   
</body>
</html>