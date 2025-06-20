<?php include_once('includes/init.php'); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guide Immobilier - HOUSE COMPANY</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/pages.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .accordion-item {
            margin-bottom: 1rem;
        }
        .accordion-header {
            padding: 1rem;
            background: var(--gray-50);
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.3s ease;
        }
        .accordion-header:hover {
            background: var(--gray-100);
        }
        .accordion-content {
            display: none;
            padding: 1rem;
            background: white;
            border-left: 4px solid var(--primary);
            margin-top: 0.5rem;
            border-radius: 0 8px 8px 0;
        }
        .accordion-header.active {
            background: var(--primary);
            color: white;
        }
        .accordion-header i {
            transition: transform 0.3s ease;
        }
        .accordion-header.active i {
            transform: rotate(180deg);
        }
    </style>
</head>
<body>
    <?php include_once('includes/header.php'); ?>

    <header class="page-header">
        <div class="page-header-content">
            <h1 class="page-title">Guide Immobilier</h1>
            <p class="page-subtitle">Découvrez nos conseils et astuces pour réussir tous vos projets immobiliers</p>
        </div>
    </header>

    <div class="page-container">
        <section class="content-section">
            <h2 class="section-title"><i class="fas fa-book"></i> Conseils pour propriétaires</h2>
            
            <div class="accordion-item">
                <div class="accordion-header">
                    <span><i class="fas fa-user-check"></i> Comment bien choisir son locataire</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="accordion-content">
                    <ul class="feature-list">
                        <li><i class="fas fa-check"></i> Vérifiez la stabilité professionnelle</li>
                        <li><i class="fas fa-check"></i> Analysez les garanties financières</li>
                        <li><i class="fas fa-check"></i> Demandez les trois derniers bulletins de salaire</li>
                        <li><i class="fas fa-check"></i> Examinez l'historique locatif</li>
                        <li><i class="fas fa-check"></i> Vérifiez la validité des documents fournis</li>
                    </ul>
                </div>
            </div>

            <div class="accordion-item">
                <div class="accordion-header">
                    <span><i class="fas fa-file-contract"></i> Les documents essentiels pour la location</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="accordion-content">
                    <ul class="feature-list">
                        <li><i class="fas fa-file"></i> Contrat de bail conforme à la législation</li>
                        <li><i class="fas fa-clipboard-list"></i> État des lieux détaillé</li>
                        <li><i class="fas fa-shield-alt"></i> Attestation d'assurance habitation</li>
                        <li><i class="fas fa-file-invoice-dollar"></i> Diagnostics techniques obligatoires</li>
                    </ul>
                </div>
            </div>
        </section>

        <section class="content-section">
            <h2 class="section-title"><i class="fas fa-home"></i> Guide de l'acheteur</h2>
            
            <div class="grid-container">
                <div class="content-section">
                    <h3><i class="fas fa-search"></i> Avant l'achat</h3>
                    <ul class="feature-list">
                        <li><i class="fas fa-check"></i> Définir son budget</li>
                        <li><i class="fas fa-check"></i> Étudier le marché local</li>
                        <li><i class="fas fa-check"></i> Vérifier sa capacité d'emprunt</li>
                    </ul>
                </div>

                <div class="content-section">
                    <h3><i class="fas fa-eye"></i> Pendant les visites</h3>
                    <ul class="feature-list">
                        <li><i class="fas fa-check"></i> Inspecter l'état général</li>
                        <li><i class="fas fa-check"></i> Vérifier l'isolation</li>
                        <li><i class="fas fa-check"></i> Examiner les installations</li>
                    </ul>
                </div>

                <div class="content-section">
                    <h3><i class="fas fa-handshake"></i> La négociation</h3>
                    <ul class="feature-list">
                        <li><i class="fas fa-check"></i> Analyser les prix du marché</li>
                        <li><i class="fas fa-check"></i> Préparer une offre</li>
                        <li><i class="fas fa-check"></i> Négocier les conditions</li>
                    </ul>
                </div>

                <div class="content-section">
                    <h3><i class="fas fa-key"></i> La finalisation</h3>
                    <ul class="feature-list">
                        <li><i class="fas fa-check"></i> Obtenir le financement</li>
                        <li><i class="fas fa-check"></i> Signer le compromis</li>
                        <li><i class="fas fa-check"></i> Finaliser l'acte de vente</li>
                    </ul>
                </div>
            </div>
        </section>

        <section class="content-section">
            <h2 class="section-title"><i class="fas fa-info-circle"></i> Ressources utiles</h2>
            <p class="section-text">Consultez nos ressources complémentaires pour approfondir vos connaissances :</p>
            
            <div class="grid-container" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));">
                <a href="#" class="content-section" style="text-decoration: none; color: inherit;">
                    <h3><i class="fas fa-calculator"></i> Simulateurs</h3>
                    <p>Calculez votre capacité d'emprunt et estimez vos mensualités</p>
                </a>

                <a href="#" class="content-section" style="text-decoration: none; color: inherit;">
                    <h3><i class="fas fa-file-alt"></i> Documents types</h3>
                    <p>Téléchargez nos modèles de documents juridiques</p>
                </a>

                <a href="#" class="content-section" style="text-decoration: none; color: inherit;">
                    <h3><i class="fas fa-map-marked-alt"></i> Prix du marché</h3>
                    <p>Consultez les prix au m² dans votre secteur</p>
                </a>
            </div>
        </section>
    </div>

    <script>
        document.querySelectorAll('.accordion-header').forEach(header => {
            header.addEventListener('click', () => {
                const content = header.nextElementSibling;
                const isOpen = content.style.display === 'block';
                
                // Ferme tous les accordéons
                document.querySelectorAll('.accordion-content').forEach(c => c.style.display = 'none');
                document.querySelectorAll('.accordion-header').forEach(h => h.classList.remove('active'));
                
                // Ouvre/ferme l'accordéon cliqué
                if (!isOpen) {
                    content.style.display = 'block';
                    header.classList.add('active');
                }
            });
        });
    </script>

    <?php include_once('includes/footer.php'); ?>
</body>
</html>