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
document.addEventListener('DOMContentLoaded', function() {
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
    image: "assets/images/proprietes/images/appartements/appart1/appart01.png",
    tag: "Location"
  },
  {
    id: 2,
    title: "Appartement simple",
    type: "appartement",
    location: "Ouaga 2000 zone A",
    price: "175,000",
    size: "110m²",
    bedrooms: 2,
    bathrooms: 1,
    image: "assets/images/proprietes/images/appartements/appart2/appart02.png",
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
    image: "assets/images/proprietes/images/appartements/appart3/appart03.png",
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
    image: "assets/images/proprietes/images/appartements/appart4/appart04.png",
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
    image: "assets/images/proprietes/images/appartements/appart5/appart05.png",
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
    image: "assets/images/proprietes/images/appartements/appart6/appart06.png",
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
    image: "assets/images/proprietes/images/appartements/appart7/appart07.png",
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
    image: "assets/images/proprietes/images/appartements/appart8/appart08.png",
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
    image: "assets/images/proprietes/images/appartements/appart9/appart09.png",
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
    image: "assets/images/proprietes/images/vendre/vendre01/vendre01.png",
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
    image: "assets/images/proprietes/images/vendre/vendre02/vendre02.png",
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
    image: "assets/images/proprietes/images/vendre/vendre03/vendre03.png",
    tag: "À vendre"
  },
  {
    id: 13,
    title: "Maison de luxe",
    type: "maison",
    location: "Ouaga 2000",
    price: "1,000,000",
    size: "850m²",
    bedrooms: 8,
    bathrooms: 5,
    image: "assets/images/proprietes/images/vendre/vendre04/vendre04.png",
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
    image: "assets/images/proprietes/images/vendre/vendre05/vendre05.png",
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
    image: "assets/images/proprietes/images/vendre/vendre06/vendre06.png",
    tag: "À vendre"
  },

  // *****************VILLA********************************
  {
    id: 16,
    title: "Villa duplex 06 pièces",
    type: "villa",
    location: "Balkuy",
    price: "200,000",
    size: "300m²",
    bedrooms: 6,
    bathrooms: 4,
    image: "assets/images/proprietes/images/louer/louer1/villa1.png",
    tag: "Location"
  },
  {
    id: 17,
    title: "Villa duplex 06 pièces",
    type: "villa",
    location: "Balkuy",
    price: "200,000",
    size: "300m²",
    bedrooms: 6,
    bathrooms: 4,
    image: "assets/images/proprietes/images/louer/louer02/villa2.png",
    tag: "Location"
  },
  {
    id: 18,
    title: "Villa duplex 07 pièces",
    type: "villa",
    location: "Cité Azimo",
    price: "900,000",
    size: "500m²",
    bedrooms: 7,
    bathrooms: 5,
    image: "assets/images/proprietes/images/louer/louer03/villa3.png",
    tag: "Location"
  },
  {
    id: 19,
    title: "Villa 7 pièces",
    type: "villa",
    location: "Ouaga 2000",
    price: "350,000",
    size: "300m²",
    bedrooms: 7,
    bathrooms: 4,
    image: "assets/images/proprietes/images/louer/louer04/villa4.png",
    tag: "Location"
  },
  {
    id: 20,
    title: "Villa duplex 07 pièces",
    type: "villa",
    location: "Ouaga 2000 Zone B",
    price: "600,000",
    size: "300m²",
    bedrooms: 7,
    bathrooms: 3,
    image: "assets/images/proprietes/images/louer/louer05/villa5.png",
    tag: "Location"
  },
  {
    id: 21,
    title: "Villa duplex 07 pièces",
    type: "villa",
    location: "Ouaga 2000",
    price: "500,000",
    size: "400m²",
    bedrooms: 7,
    bathrooms: 4,
    image: "assets/images/proprietes/images/louer/louer06/villa6.png",
    tag: "Location"
  },
  {
    id: 22,
    title: "Villa 08 pièces",
    type: "villa",
    location: "Somgandé",
    price: "600,000",
    size: "500m²",
    bedrooms: 8,
    bathrooms: 7,
    image: "assets/images/proprietes/images/louer/louer07/villa7.png",
    tag: "Location"
  },
  {
    id: 23,
    title: "Villa duplex 08 pièces",
    type: "villa",
    location: "Ouaga 2000",
    price: "1,000,000",
    size: "800m²",
    bedrooms: 8,
    bathrooms: 7,
    image: "assets/images/proprietes/images/louer/louer08/villa8.png",
    tag: "Location"
  },
  {
    id: 24,
    title: "Villa duplex 09 pièces",
    type: "villa",
    location: "Ouaga 2000",
    price: "600,000",
    size: "800m²",
    bedrooms: 9,
    bathrooms: 7,
    image: "assets/images/proprietes/images/louer/louer09/villa9.png",
    tag: "Location"
  },
  
  // ****************BUREAU **********************************
  {
    id: 25,
    title: "Bureau moderne",
    type: "bureau",
    location: "La Défense",
    price: "780,000",
    size: "120m²",
    bedrooms: 0,
    bathrooms: 2,
    image: "assets/images/proprietes/images/burreau/burreau1.jpg",
    tag: "Location"
  },
  {
    id: 26,
    title: "Bureau moderne",
    type: "bureau",
    location: "La Défense",
    price: "780,000",
    size: "120m²",
    bedrooms: 0,
    bathrooms: 2,
    image: "assets/images/proprietes/images/burreau/burreau2.jpg",
    tag: "Location"
  },
  {
    id: 27,
    title: "Bureau moderne",
    type: "bureau",
    location: "La Défense",
    price: "780,000",
    size: "120m²",
    bedrooms: 0,
    bathrooms: 2,
    image: "assets/images/proprietes/images/burreau/burreau3.jpg",
    tag: "Location"
  },
  {
    id: 28,
    title: "Bureau moderne",
    type: "bureau",
    location: "La Défense",
    price: "780,000",
    size: "120m²",
    bedrooms: 0,
    bathrooms: 2,
    image: "assets/images/proprietes/images/burreau/burreau4.jpg",
    tag: "Location"
  },
  {
    id: 29,
    title: "Bureau moderne",
    type: "bureau",
    location: "La Défense",
    price: "780,000",
    size: "120m²",
    bedrooms: 0,
    bathrooms: 2,
    image: "assets/images/proprietes/images/burreau/burreau5.jpg",
    tag: "Location"
  },
  {
    id: 30,
    title: "Bureau moderne",
    type: "bureau",
    location: "La Défense",
    price: "780,000",
    size: "120m²",
    bedrooms: 0,
    bathrooms: 2,
    image: "assets/images/proprietes/images/burreau/burreau6.jpg",
    tag: "Location"
  },

  //****************COMMERCIAL******************************
  {
    id: 31,
    title: "Local commercial",
    type: "commercial",
    location: "Ouagadougou",
    price: "650,000",
    size: "180m²",
    bedrooms: 0,
    bathrooms: 1,
    image: "assets/images/proprietes/images/commercial/local1.jpg",
    tag: "À vendre"
  },
  {
    id: 32,
    title: "Local commercial",
    type: "commercial",
    location: "Ouagadougou",
    price: "650,000",
    size: "180m²",
    bedrooms: 0,
    bathrooms: 1,
    image: "assets/images/proprietes/images/commercial/local2.jpg",
    tag: "À vendre"
  },
  {
    id: 33,
    title: "Local commercial",
    type: "commercial",
    location: "Ouagadougou",
    price: "650,000",
    size: "180m²",
    bedrooms: 0,
    bathrooms: 1,
    image: "assets/images/proprietes/images/commercial/local3.jpg",
    tag: "À vendre"
  },
  {
    id: 34,
    title: "Local commercial",
    type: "commercial",
    location: "Ouagadougou",
    price: "650,000",
    size: "180m²",
    bedrooms: 0,
    bathrooms: 1,
    image: "assets/images/proprietes/images/commercial/local4.jpg",
    tag: "À vendre"
  },
  {
    id: 35,
    title: "Local commercial",
    type: "commercial",
    location: "Ouagadougou",
    price: "650,000",
    size: "180m²",
    bedrooms: 0,
    bathrooms: 1,
    image: "assets/images/proprietes/images/commercial/local5.jpg",
    tag: "À vendre"
  },
  {
    id: 36,
    title: "Local commercial",
    type: "commercial",
    location: "Ouagadougou",
    price: "650,000",
    size: "180m²",
    bedrooms: 0,
    bathrooms: 1,
    image: "assets/images/proprietes/images/commercial/local6.jpg",
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
        <a href="login.php" class="favorite-btn" data-property-id="${property.id}">
          <i class="far fa-heart"></i>
        </a>
      </div>
      <div class="property-content">
        <div class="property-price">${property.price}FCFA${property.tag === 'Location' ? '/mois' : ''}</div>
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

  // Gestion simplifiée des favoris avec redirection
  document.querySelectorAll('.favorite-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
      if (!isUserLoggedIn()) {
        e.preventDefault();
        window.location.href = 'login.php';
      }
      // Si l'utilisateur est connecté, le lien fonctionnera normalement
    });
  });
}

// Fonction pour vérifier si l'utilisateur est connecté
function isUserLoggedIn() {
  return document.body.dataset.userLoggedIn === 'true';
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
  button.addEventListener('click', function() {
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
    } else if (category === 'maison' || category === 'villa') {
      // Regrouper les maisons et villas ensemble
      filteredProperties = properties.filter(property => 
        property.type === 'maison' || property.type === 'villa'
      );
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
  const searchTerm = searchInput.value.toLowerCase();

  if (searchTerm.trim() === '') {
    displayProperties();
    return;
  }

  const filteredProperties = properties.filter(property => {
    // Normaliser le type de propriété pour la recherche
    let searchType = property.type;
    if (searchType === 'villa') searchType = 'maison';

    return (
      property.title.toLowerCase().includes(searchTerm) ||
      property.location.toLowerCase().includes(searchTerm) ||
      property.price.toLowerCase().includes(searchTerm) ||
      property.tag.toLowerCase().includes(searchTerm) ||
      searchType.toLowerCase().includes(searchTerm)
    );
  });

  displayProperties(filteredProperties);
}

searchBtn.addEventListener('click', performSearch);
searchInput.addEventListener('keyup', function(event) {
  if (event.key === 'Enter') {
    performSearch();
  }
});

// Menu mobile
document.querySelector('.mobile-menu-btn').addEventListener('click', function() {
  document.querySelector('.nav-menu').classList.toggle('active');
});

const menuToggle = document.getElementById('menu-toggle');
const navMenu = document.querySelector('.nav-menu');

menuToggle.addEventListener('click', () => {
  navMenu.classList.toggle('active');
  menuToggle.classList.toggle('menu-open');
});