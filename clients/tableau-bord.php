<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['identifiant']) || empty($_SESSION['identifiant'])) {
    // Redirection vers la page de connexion
    header("Location: ../login.php");
    exit();
}

// Récupération des informations de l'utilisateur depuis la session
$nom = $_SESSION['nom'] ?? 'Utilisateur';
$prenom = $_SESSION['prenom'] ?? '';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Client</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../assets/css/client.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- CSS supplémentaire -->
    <link rel="stylesheet" href="../assets/css/entete_tableau_de_bord.css">
    <style>
        /* Styles supplémentaires pour une meilleure présentation */
        .corp {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s;
        }
        
        @media (max-width: 992px) {
            .corp {
                margin-left: 0;
            }
        }

        /* Styles pour la barre de recherche */
        .custom-search-bar {
            display: flex;
            max-width: 800px;
            margin: 20px auto;
        }

        .custom-search-input {
            flex: 1;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 4px 0 0 4px;
            font-size: 16px;
        }

        .custom-search-btn {
            padding: 12px 20px;
            background-color:rgb(5, 96, 193);
            color: white;
            border: none;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
            font-size: 16px;
        }

        .custom-search-btn:hover {
            background-color:rgba(0, 123, 255, 0.86);
        }

        /* Styles pour les notifications */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 5px;
            color: white;
            z-index: 1000;
            animation: slideIn 0.5s, fadeOut 0.5s 2.5s;
        }

        .notification.success {
            background-color: #4CAF50;
        }

        .notification.error {
            background-color: #f44336;
        }

        @keyframes slideIn {
            from { right: -300px; opacity: 0; }
            to { right: 20px; opacity: 1; }
        }

        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
    </style>
</head>
<body>
    <header class="site-header with-sidebar">
        <div class="header-container">
            <div class="logo-section">
                <h1 class="page-title">Bienvenue à vous</h1>
            </div>

            <div class="user-section">
                <div class="user-info" id="userInfo">
                    <i class="fas fa-user user-icon"></i>
                    <span class="user-name"><?php echo htmlspecialchars(trim($prenom . ' ' . $nom)); ?></span>
                    <div class="user-menu" id="userMenu">
                        <div class="user-menu-item">
                            <i class="fas fa-user"></i>
                            <span><?php echo htmlspecialchars(trim($prenom . ' ' . $nom)); ?></span>
                        </div>
                        <div class="user-menu-item logout-item">
                            <i class="fas fa-sign-out-alt"></i>
                            <a href="../login.php">Déconnexion</a>
                        </div>
                    </div>
                </div>
                <a href="../login.php" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Déconnexion</span>
                </a>
            </div>
        </div>
    </header>

    <br><br><br><br>

    <!-- Menu Burger pour mobile -->
    <button class="menu-toggle" id="menuToggle">
        <i class="fas fa-bars"></i>
    </button>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <div class="admin-sidebar" id="adminSidebar">
        <h2><i class="fas fa-tachometer-alt"></i> Tableau de bord <br> client</h2>
        <ul>
            <li><a href="#" class="active"><i class="fas fa-home"></i> Description globale</a></li>
            <li><a href="#pro"><i class="fas fa-plus-circle"></i> Les propriétés</a></li>
            <li><a href="#dispo"><i class="fas fa-list"></i> Propriétés disponibles</a></li>
            <li><a href="../chat/form.php"><i class="fas fa-comments"></i> Chat de messagerie</a></li>
        </ul>
    </div>

    <div class="corp">
        <section id='tableau'></section>
        <div class="admin-main" id="adminMain">
            <div class="admin-header">
                <h1><i class="fas fa-info-circle"></i> Description globale</h1>
            </div>
            
            <div class="admin-body">
                <p>
                    <strong>Bienvenue dans votre espace client. Cet espace vous permet de gérer efficacement vos propriétés immobilières.</strong>
                </p>
                <br>
            
                <div class="dashboard-cards">
                    <div class="card" onclick="window.location.href='#pro'">
                        <i class="fas fa-plus-circle"></i>
                        <h3>Les propriétés</h3>
                        <p>Publiez une large liste de bien immobiliers</p>
                        <a href="#pro" class="btn">Voir plus</a>
                    </div>
                    
                    <div class="card" onclick="window.location.href='#dispo'">
                        <i class="fas fa-home"></i>
                        <h3>Les propriétés disponibles</h3>
                        <p>Choisis vos biens immobiliers</p>
                        <a href="#dispo" class="btn">Voir plus</a>
                    </div>
                                        
                    <div class="card">
                        <i class="fas fa-users"></i>
                        <h3>Chat de messagerie</h3>
                        <p>Contactez l'agent qui vous est affecter.</p>
                        <a href="../login.php" class="btn">Voir plus</a>
                    </div>
                </div>
            </div>
            <br>
        </div>
        
        <br>
        <section id="pro"></section>
        <br>
        
        <div class="admin-header">
            <h1><i class="fas fa-plus-circle"></i> Les propriétés</h1>
        </div>
        
        <!-- HERO SECTION PERSONNALISÉE -->
        <section class="custom-hero-section">
            <div class="custom-container">
                <h1 class="custom-hero-title">Trouvez la propriété de vos rêves</h1>
                <p class="custom-hero-subtitle">Découvrez notre sélection exclusive de biens immobiliers à travers le pays</p>

                <div class="custom-search-bar">
                    <input type="text" id="search-input" class="custom-search-input" placeholder="Rechercher par lieu, type, prix...">
                    <button id="search-btn" class="custom-search-btn"><i class="fas fa-search"></i> Rechercher</button>
                </div>
            </div>
        </section>

        <!-- CATÉGORIES DE PROPRIÉTÉS -->
        <section class="container">
            <h2 class="section-title">Catégories de propriétés</h2>

            <div class="categories">
                <button class="category-btn active" data-category="all">Tous</button>
                <button class="category-btn" data-category="appartement">Appartements</button>
                <button class="category-btn" data-category="maison">Maisons</button>
                <button class="category-btn" data-category="villa">Villas</button>
                <button class="category-btn" data-category="bureau">Bureaux</button>
                <button class="category-btn" data-category="commercial">Commerces</button>
            </div>

            <!-- PROPRIÉTÉS GRID -->
            <div class="properties-grid" id="properties-grid">
                <!-- Propriétés chargées dynamiquement par JavaScript -->
            </div>
        </section>

        <section id="dispo"></section>
        <br>
        
        <div class="admin-header">
            <h1><i class="fas fa-list"></i> Propriétés disponibles (Contactez l'agent qui vous est affecter)</h1>
        </div>
        
        <br>
        <?php include 'liste-propriete-disponible.php'; ?>
        <br>
        
        <section id="favo"></section>
        <br>
    </div>

    <script>
        // Fonction pour gérer les onglets
        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;

            // Masquer tous les contenus d'onglets
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }

            // Désactiver tous les boutons d'onglets
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }

            // Afficher l'onglet courant et activer le bouton
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        // Afficher le premier onglet par défaut
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelector('.tablinks').click();

            // Réinitialiser les formulaires
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

        // Données des propriétés (simulation de base de données)
        const properties = [
            
  // ***********************APPARTEMENTS***************************
  {
    id: 1,
    title: "Appartement moderne",
    type: "appartement",
    location: "Ouaga 2000",
    price: "3,000,000",
    size: "850m²",
    bedrooms: 12,
    bathrooms: 8,
    image: "../assets/images/proprietes/images/appartements/appart1/appart01.png",
    tag: "Location"
  },
  {
    id: 2,
    title: "Appartement simple",
    type: "appartement",
    location: "Ouaga 2000 zone A ",
    price: "175,000",
    size: "110m²",
    bedrooms: 2,
    bathrooms: 1,
    image: "../assets/images/proprietes/images/appartements/appart2/appart02.png",
    tag: "À vendre"
  },
  {
    id: 3,
    title: "Appartement spacieux",
    type: "appartement",
    location: "Larlé",
    price: "300,000",
    size: "150m²",
    bedrooms: 4,
    bathrooms: 2,
    image: "../assets/images/proprietes/images/appartements/appart3/appart03.png",
    tag: "Location"
  },
  {
    id: 4,
    title: "Appartement moderne",
    type: "appartement",
    location: "Tanghin",
    price: "400,000",
    size: "300m²",
    bedrooms: 4,
    bathrooms: 2,
    image: "../assets/images/proprietes/images/appartements/appart4/appart04.png",
    tag: "Location"
  },
  {
    id: 5,
    title: "Appartement de luxe",
    type: "appartement",
    location: "Nagrin",
    price: "100,000",
    size: "100m²",
    bedrooms: 2,
    bathrooms: 1,
    image: "../assets/images/proprietes/images/appartements/appart5/appart05.png",
    tag: "Location"
  },
  {
    id: 6,
    title: "Appartement simple",
    type: "appartement",
    location: "Nonssin",
    price: "150,000",
    size: "110m²",
    bedrooms: 2,
    bathrooms: 1,
    image: "../assets/images/proprietes/images/appartements/appart6/appart06.png",
    tag: "Location"
  },
  {
    id: 7,
    title: "Appartement moderne",
    type: "appartement",
    location: "Ouaga 2000",
    price: "550,000",
    size: "500m²",
    bedrooms: 6,
    bathrooms: 4,
    image: "../assets/images/proprietes/images/appartements/appart7/appart07.png",
    tag: "Location"
  },
  {
    id: 8,
    title: "Appartement contemporain",
    type: "appartement",
    location: "Patte d'oie",
    price: "350,000",
    size: "250m²",
    bedrooms: 2,
    bathrooms: 1,
    image: "../assets/images/proprietes/images/appartements/appart8/appart08.png",
    tag: "Location"
  },
  {
    id: 9,
    title: "Appartement spacieux",
    type: "appartement",
    location: "Zone du bois",
    price: "420,000",
    size: "450m²",
    bedrooms: 5,
    bathrooms: 3,
    image: "../assets/images/proprietes/images/appartements/appart9/appart09.png",
    tag: "Location"
  },




  //*******************MAISON*****************************
  {
    id: 10,
    title: "Villa 3 pièces",
    type: "villa",
    location: "Saba",
    price: "20,000,000",
    size: "150m²",
    bedrooms: 4,
    bathrooms: 3,
    image: "../assets/images/proprietes/images/vendre/vendre01/vendre01.png",
    tag: "À vendre"
  },
  {
    id: 11,
    title: "Villa 3 pièces",
    type: "maison",
    location: "Cité Rimkièta",
    price: "25,000,000",
    size: "200m²",
    bedrooms: 3,
    bathrooms: 2,
    image: "../assets/images/proprietes/images/vendre/vendre02/vendre02.png",
    tag: "À vendre"
  },
  {
    id: 12,
    title: "Villa 6 pièces",
    type: "maison",
    location: "Somgandé",
    price: "280,000,000",
    size: "400m²",
    bedrooms: 6,
    bathrooms: 3,
    image: "../assets/images/proprietes/images/vendre/vendre03/vendre03.png",
    tag: "À vendre"
  },
  {
    id: 13,
    title: "Maison de luxe",
    type: "maison",
    location: "Ouaga 2000",
    price: "1000,000",
    size: "850m²",
    bedrooms: 8,
    bathrooms: 5,
    image: "../assets/images/proprietes/images/vendre/vendre04/vendre04.png",
    tag: "Location"
  },
  {
    id: 14,
    title: "Maison de campagne",
    type: "maison",
    location: "Karpala",
    price: "90,000,000",
    size: "300m²",
    bedrooms: 4,
    bathrooms: 3,
    image: "../assets/images/proprietes/images/vendre/vendre05/vendre05.png",
    tag: "À vendre"
  },
  {
    id: 15,
    title: "Maison de campagne",
    type: "maison",
    location: "Normandie",
    price: "520,000",
    size: "150m²",
    bedrooms: 4,
    bathrooms: 3,
    image: "../assets/images/proprietes/images/vendre/vendre06/vendre06.png",
    tag: "À vendre"
  },


  // *****************VILLA********************************
  {
    id: 4,
    title: "Villa duplex 06 pièces",
    type: "villa",
    location: "Balkuy",
    price: "200,000",
    size: "300m²",
    bedrooms: 6,
    bathrooms: 4,
    image: "../assets/images/proprietes/images/louer/louer1/villa1.png",
    tag: "Location"
  },
  {
    id: 4,
    title: "Villa duplex 06 pièces",
    type: "villa",
    location: "Balkuy",
    price: "200,000",
    size: "300m²",
    bedrooms: 6,
    bathrooms: 4,
    image: "../assets/images/proprietes/images/louer/louer02/villa2.png",
    tag: "Location"
  },
  {
    id: 4,
    title: "villa duplex 07 pièces",
    type: "villa",
    location: "Cité Azimo",
    price: "900,000",
    size: "500m²",
    bedrooms: 7,
    bathrooms: 5,
    image: "../assets/images/proprietes/images/louer/louer03/villa3.png",
    tag: "Location"
  },
  {
    id: 4,
    title: "Villa 7 pièces",
    type: "villa",
    location: "Ouaga 2000",
    price: "350,000",
    size: "300m²",
    bedrooms: 7,
    bathrooms: 4,
    image: "../assets/images/proprietes/images/louer/louer04/villa4.png",
    tag: "Location"
  },
  {
    id: 4,
    title: "Villa duplex 07 pièces",
    type: "villa",
    location: "0uaga 2000 Zone B",
    price: "600,000",
    size: "300m²",
    bedrooms: 7,
    bathrooms: 3,
    image: "../assets/images/proprietes/images/louer/louer05/villa5.png",
    tag: "Location"
  },
  {
    id: 4,
    title: "Villa duplex 07 pièces",
    type: "villa",
    location: "Ouaga 2000",
    price: "500,000",
    size: "400m²",
    bedrooms: 7,
    bathrooms: 4,
    image: "../assets/images/proprietes/images/louer/louer06/villa6.png",
    tag: "Location"
  },
  {
    id: 4,
    title: "Villa 08 pièces",
    type: "villa",
    location: "Somgandé villa 08 pièces",
    price: "6X00,000",
    size: "500m²",
    bedrooms: 8,
    bathrooms: 7,
    image: "../assets/images/proprietes/images/louer/louer07/villa7.png",
    tag: "Location"
  },
  {
    id: 4,
    title: "Villa duplex 08 pièces",
    type: "villa",
    location: "Ouaga 2000",
    price: "1,000,000",
    size: "800m²",
    bedrooms: 8,
    bathrooms: 7,
    image: "../assets/images/proprietes/images/louer/louer08/villa8.png",
    tag: "Location"
  },
  {
    id: 4,
    title: "Villa duplex 09 pièces",
    type: "villa",
    location: "Ouaga 2000",
    price: "600,000",
    size: "800m²",
    bedrooms: 9,
    bathrooms: 7,
    image: "../assets/images/proprietes/images/louer/louer09/villa9.png",
    tag: "Location"
  },
  // ****************BUREAU **********************************
  {
    id: 5,
    title: "Bureau moderne",
    type: "bureau",
    location: "La Défense",
    price: "780,000",
    size: "120m²",
    bedrooms: 0,
    bathrooms: 2,
    image: "../assets/images/proprietes/images/burreau/burreau1.jpg",
    tag: "Location"
  },
  {
    id: 5,
    title: "Bureau moderne",
    type: "bureau",
    location: "La Défense",
    price: "780,000",
    size: "120m²",
    bedrooms: 0,
    bathrooms: 2,
    image: "../assets/images/proprietes/images/burreau/burreau2.jpg",
    tag: "Location"
  },
  {
    id: 5,
    title: "Bureau moderne",
    type: "bureau",
    location: "La Défense",
    price: "780,000",
    size: "120m²",
    bedrooms: 0,
    bathrooms: 2,
    image: "../assets/images/proprietes/images/burreau/burreau3.jpg",
    tag: "Location"
  },
  {
    id: 5,
    title: "Bureau moderne",
    type: "bureau",
    location: "La Défense",
    price: "780,000",
    size: "120m²",
    bedrooms: 0,
    bathrooms: 2,
    image: "../assets/images/proprietes/images/burreau/burreau4.jpg",
    tag: "Location"
  },
  {
    id: 5,
    title: "Bureau moderne",
    type: "bureau",
    location: "La Défense",
    price: "780,000",
    size: "120m²",
    bedrooms: 0,
    bathrooms: 2,
    image: "../assets/images/proprietes/images/burreau/burreau5.jpg",
    tag: "Location"
  },
  {
    id: 5,
    title: "Bureau moderne",
    type: "bureau",
    location: "La Défense",
    price: "780,000",
    size: "120m²",
    bedrooms: 0,
    bathrooms: 2,
    image: "../assets/images/proprietes/images/burreau/burreau6.jpg",
    tag: "Location"
  },

  //****************COMMERCIAL******************************
  {
    id: 6,
    title: "Local commercial",
    type: "commercial",
    location: "Ouagadougou",
    price: "650,000",
    size: "180m²",
    bedrooms: 0,
    bathrooms: 1,
    image: "../assets/images/proprietes/images/commercial/local1.jpg",
    tag: "À vendre"
  },

  {
    id: 7,
    title: "Local commercial",
    type: "commercial",
    location: "Ouagadougou",
    price: "650,000",
    size: "180m²",
    bedrooms: 0,
    bathrooms: 1,
    image: "../assets/images/proprietes/images/commercial/local2.jpg",
    tag: "À vendre"
  },
  {
    id: 8,
    title: "Local commercial",
    type: "commercial",
    location: "Ouagadougou",
    price: "650,000",
    size: "180m²",
    bedrooms: 0,
    bathrooms: 1,
    image: "../assets/images/proprietes/images/commercial/local3.jpg",
    tag: "À vendre"
  },
  {
    id: 9,
    title: "Local commercial",
    type: "commercial",
    location: "Ouagadougou",
    price: "650,000",
    size: "180m²",
    bedrooms: 0,
    bathrooms: 1,
    image: "../assets/images/proprietes/images/commercial/local4.jpg",
    tag: "À vendre"
  },
  {
    id: 10,
    title: "Local commercial",
    type: "commercial",
    location: "Ouagadougou",
    price: "650,000",
    size: "180m²",
    bedrooms: 0,
    bathrooms: 1,
    image: "../assets/images/proprietes/images/commercial/local5.jpg",
    tag: "À vendre"
  },
  {
    id: 10,
    title: "Local commercial",
    type: "commercial",
    location: "Ouagadougou",
    price: "650,000",
    size: "180m²",
    bedrooms: 0,
    bathrooms: 1,
    image: "../assets/images/proprietes/images/commercial/local6.jpg",
    tag: "À vendre"
  }


        ];

        // Fonction pour afficher les propriétés
        function displayProperties(filteredProperties = properties) {
            const propertiesGrid = document.getElementById('properties-grid');
            propertiesGrid.innerHTML = '';

            filteredProperties.forEach(property => {
                const propertyCard = document.createElement('div');
                propertyCard.className = 'property-card';
                propertyCard.innerHTML = `
                    <div class="property-image" style="background-image: url('${property.image}')">
                        <span class="property-tag">${property.tag}</span>
                        <button class="favorite-btn" data-property-id="${property.id}">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>
                    <div class="property-content">
                        <div class="property-price">${property.price}FCFA</div>
                        <h3 class="property-title">${property.title}</h3>
                        <div class="property-location">
                            <i class="fas fa-map-marker-alt"></i>
                            ${property.location}
                        </div>
                        <div class="property-details">
                            <span><i class="fas fa-bed"></i> ${property.bedrooms} chambres</span>
                            <span><i class="fas fa-bath"></i> ${property.bathrooms} sdb</span>
                            <span><i class="fas fa-ruler-combined"></i> ${property.size}</span>
                        </div>
                    </div>
                `;
                propertiesGrid.appendChild(propertyCard);
            });

            // Gestion des favoris
            document.querySelectorAll('.favorite-btn').forEach(btn => {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    const icon = this.querySelector('i');
                    icon.classList.toggle('far');
                    icon.classList.toggle('fas');
                    showNotification('Propriété ajoutée aux favoris');
                });
            });
        }

        // Fonction pour afficher les notifications
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.textContent = message;
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        // Initialisation de l'affichage des propriétés
        displayProperties();

        // Filtrage par catégorie
        document.querySelectorAll('.category-btn').forEach(button => {
            button.addEventListener('click', function () {
                // Mettre à jour le bouton actif
                document.querySelectorAll('.category-btn').forEach(btn => {
                    btn.classList.remove('active');
                });
                this.classList.add('active');

                // Filtrer les propriétés
                const category = this.getAttribute('data-category');
                let filteredProperties;

                if (category === 'all') {
                    filteredProperties = properties;
                } else {
                    filteredProperties = properties.filter(property => property.type === category);
                }

                displayProperties(filteredProperties);
            });
        });

        // Recherche dynamique
        const searchInput = document.getElementById('search-input');
        const searchBtn = document.getElementById('search-btn');

        function performSearch() {
            const searchTerm = searchInput.value.toLowerCase().trim();

            if (searchTerm === '') {
                displayProperties();
                return;
            }

            const filteredProperties = properties.filter(property => {
                return (
                    property.title.toLowerCase().includes(searchTerm) ||
                    property.location.toLowerCase().includes(searchTerm) ||
                    property.price.toString().toLowerCase().includes(searchTerm) ||
                    property.type.toLowerCase().includes(searchTerm) ||
                    property.tag.toLowerCase().includes(searchTerm)
                );
            });

            displayProperties(filteredProperties);
        }

        // Recherche lors du clic sur le bouton
        searchBtn.addEventListener('click', performSearch);

        // Recherche lors de la pression sur Entrée
        searchInput.addEventListener('keyup', function (event) {
            if (event.key === 'Enter') {
                performSearch();
            }
        });

        // Recherche en temps réel avec délai
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(performSearch, 300);
        });

        // Menu mobile
        document.getElementById('menuToggle').addEventListener('click', function() {
            document.getElementById('adminSidebar').classList.toggle('active');
            document.getElementById('sidebarOverlay').classList.toggle('active');
        });

        document.getElementById('sidebarOverlay').addEventListener('click', function() {
            document.getElementById('adminSidebar').classList.remove('active');
            this.classList.remove('active');
        });

        // Gestion du menu utilisateur
        document.addEventListener('DOMContentLoaded', function() {
            const userInfo = document.getElementById('userInfo');
            const userMenu = document.getElementById('userMenu');
            
            if (userInfo && userMenu) {
                userInfo.addEventListener('click', function(e) {
                    if (window.innerWidth <= 992) {
                        e.preventDefault();
                        e.stopPropagation();
                        userMenu.classList.toggle('active');
                    }
                });
                
                document.addEventListener('click', function(e) {
                    if (!userInfo.contains(e.target) && !userMenu.contains(e.target) && userMenu.classList.contains('active')) {
                        userMenu.classList.remove('active');
                    }
                });
                
                userMenu.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }

            // Fermer le sidebar lorsqu'un lien est cliqué (pour version mobile)
            document.querySelectorAll('.admin-sidebar a').forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 992) {
                        document.getElementById('adminSidebar').classList.remove('active');
                        document.getElementById('sidebarOverlay').classList.remove('active');
                    }
                });
            });
        });
    </script>
</body>
</html>