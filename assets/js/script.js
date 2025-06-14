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
    location: "Paris 15ème",
    price: "350,000",
    size: "85m²",
    bedrooms: 3,
    bathrooms: 2,
    image: "assets/images/proprietes/images/appartement/appart1.jpg",
    tag: "À vendre"
  },
  {
    id: 2,
    title: "Loft industriel",
    type: "appartement",
    location: "Lyon 3ème",
    price: "420,000",
    size: "110m²",
    bedrooms: 2,
    bathrooms: 1,
    image: "assets/images/proprietes/images/appartement/appart2.jpg",
    tag: "À vendre"
  },
  {
    id: 2,
    title: "Loft industriel",
    type: "appartement",
    location: "Lyon 3ème",
    price: "420,000",
    size: "110m²",
    bedrooms: 2,
    bathrooms: 1,
    image: "assets/images/proprietes/images/appartement/appart3.jpg",
    tag: "À vendre"
  },
  {
    id: 2,
    title: "Loft industriel",
    type: "appartement",
    location: "Lyon 3ème",
    price: "420,000",
    size: "110m²",
    bedrooms: 2,
    bathrooms: 1,
    image: "assets/images/proprietes/images/appartement/appart4.jpg",
    tag: "À vendre"
  },
  {
    id: 2,
    title: "Loft industriel",
    type: "appartement",
    location: "Lyon 3ème",
    price: "420,000",
    size: "110m²",
    bedrooms: 2,
    bathrooms: 1,
    image: "assets/images/proprietes/images/appartement/appart5.jpg",
    tag: "À vendre"
  },
  {
    id: 2,
    title: "Loft industriel",
    type: "appartement",
    location: "Lyon 3ème",
    price: "420,000",
    size: "110m²",
    bedrooms: 2,
    bathrooms: 1,
    image: "assets/images/proprietes/images/appartement/appart6.jpg",
    tag: "À vendre"
  },
  {
    id: 2,
    title: "Loft industriel",
    type: "appartement",
    location: "Lyon 3ème",
    price: "420,000",
    size: "110m²",
    bedrooms: 2,
    bathrooms: 1,
    image: "assets/images/proprietes/images/appartement/appart7.jpg",
    tag: "À vendre"
  },
  {
    id: 2,
    title: "Loft industriel",
    type: "appartement",
    location: "Lyon 3ème",
    price: "420,000",
    size: "110m²",
    bedrooms: 2,
    bathrooms: 1,
    image: "assets/images/proprietes/images/appartement/appart8.jpg",
    tag: "À vendre"
  },
  //*******************MAISON*****************************
  {
    id: 3,
    title: "Maison de campagne",
    type: "maison",
    location: "Normandie",
    price: "520,000",
    size: "150m²",
    bedrooms: 4,
    bathrooms: 3,
    image: "assets/images/proprietes/images/maison/maison1.jpg",
    tag: "Location"
  },
  {
    id: 3,
    title: "Maison de campagne",
    type: "maison",
    location: "Normandie",
    price: "520,000",
    size: "150m²",
    bedrooms: 4,
    bathrooms: 3,
    image: "assets/images/proprietes/images/maison/maison2.jpg",
    tag: "Location"
  },
  {
    id: 3,
    title: "Maison de campagne",
    type: "maison",
    location: "Normandie",
    price: "520,000",
    size: "150m²",
    bedrooms: 4,
    bathrooms: 3,
    image: "assets/images/proprietes/images/maison/maison3.jpg",
    tag: "Location"
  },
  {
    id: 3,
    title: "Maison de campagne",
    type: "maison",
    location: "Normandie",
    price: "520,000",
    size: "150m²",
    bedrooms: 4,
    bathrooms: 3,
    image: "assets/images/proprietes/images/maison/maison4.jpg",
    tag: "Location"
  },
  {
    id: 3,
    title: "Maison de campagne",
    type: "maison",
    location: "Normandie",
    price: "520,000",
    size: "150m²",
    bedrooms: 4,
    bathrooms: 3,
    image: "assets/images/proprietes/images/maison/maison5.jpg",
    tag: "Location"
  },
  {
    id: 3,
    title: "Maison de campagne",
    type: "maison",
    location: "Normandie",
    price: "520,000",
    size: "150m²",
    bedrooms: 4,
    bathrooms: 3,
    image: "assets/images/proprietes/images/maison/maison6.jpg",
    tag: "Location"
  },


  // *****************VILLA********************************
  {
    id: 4,
    title: "Villa contemporaine",
    type: "villa",
    location: "Côte d'Azur",
    price: "1,250,000",
    size: "220m²",
    bedrooms: 5,
    bathrooms: 4,
    image: "assets/images/proprietes/images/villa/villa1.jpg",
    tag: "À vendre"
  },
  {
    id: 4,
    title: "Villa contemporaine",
    type: "villa",
    location: "Côte d'Azur",
    price: "1,250,000",
    size: "220m²",
    bedrooms: 5,
    bathrooms: 4,
    image: "assets/images/proprietes/images/villa/villa2.jpg",
    tag: "À vendre"
  },
  {
    id: 4,
    title: "Villa contemporaine",
    type: "villa",
    location: "Côte d'Azur",
    price: "1,250,000",
    size: "220m²",
    bedrooms: 5,
    bathrooms: 4,
    image: "assets/images/proprietes/images/villa/villa3.jpg",
    tag: "À vendre"
  },
  {
    id: 4,
    title: "Villa contemporaine",
    type: "villa",
    location: "Côte d'Azur",
    price: "1,250,000",
    size: "220m²",
    bedrooms: 5,
    bathrooms: 4,
    image: "assets/images/proprietes/images/villa/villa4.jpg",
    tag: "À vendre"
  },
  {
    id: 4,
    title: "Villa contemporaine",
    type: "villa",
    location: "Côte d'Azur",
    price: "1,250,000",
    size: "220m²",
    bedrooms: 5,
    bathrooms: 4,
    image: "assets/images/proprietes/images/villa/villa5.jpg",
    tag: "À vendre"
  },
  {
    id: 4,
    title: "Villa contemporaine",
    type: "villa",
    location: "Côte d'Azur",
    price: "1,250,000",
    size: "220m²",
    bedrooms: 5,
    bathrooms: 4,
    image: "assets/images/proprietes/images/villa/villa6.jpg",
    tag: "À vendre"
  },
  {
    id: 4,
    title: "Villa contemporaine",
    type: "villa",
    location: "Côte d'Azur",
    price: "1,250,000",
    size: "220m²",
    bedrooms: 5,
    bathrooms: 4,
    image: "assets/images/proprietes/images/villa/villa7.jpg",
    tag: "À vendre"
  },
  {
    id: 4,
    title: "Villa contemporaine",
    type: "villa",
    location: "Côte d'Azur",
    price: "1,250,000",
    size: "220m²",
    bedrooms: 5,
    bathrooms: 4,
    image: "assets/images/proprietes/images/villa/villa8.jpg",
    tag: "À vendre"
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
    image: "assets/images/proprietes/images/burreau/burreau1.jpg",
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
    image: "assets/images/proprietes/images/burreau/burreau2.jpg",
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
    image: "assets/images/proprietes/images/burreau/burreau3.jpg",
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
    image: "assets/images/proprietes/images/burreau/burreau4.jpg",
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
    image: "assets/images/proprietes/images/burreau/burreau5.jpg",
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
    image: "assets/images/proprietes/images/burreau/burreau6.jpg",
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
    image: "assets/images/proprietes/images/commercial/local1.jpg",
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
    image: "assets/images/proprietes/images/commercial/local2.jpg",
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
    image: "assets/images/proprietes/images/commercial/local3.jpg",
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
    image: "assets/images/proprietes/images/commercial/local4.jpg",
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
    image: "assets/images/proprietes/images/commercial/local5.jpg",
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
          <button class="favorite-btn"><i class="far fa-heart"></i></button>
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

  // Gestion des boutons favoris a rendre  dynamique et lie a la base donnée
  document.querySelectorAll('.favorite-btn').forEach(btn => {
    btn.addEventListener('click', function () {
      this.classList.toggle('active');
      const icon = this.querySelector('i');
      if (this.classList.contains('active')) {
        icon.className = 'fas fa-heart';
      } else {
        icon.className = 'far fa-heart';
      }
    });
  });
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
  const searchTerm = searchInput.value.toLowerCase();

  if (searchTerm.trim() === '') {
    displayProperties();
    return;
  }

  const filteredProperties = properties.filter(property => {
    return (
      property.title.toLowerCase().includes(searchTerm) ||
      property.location.toLowerCase().includes(searchTerm) ||
      property.price.toLowerCase().includes(searchTerm) ||
      property.tag.toLowerCase().includes(searchTerm) ||
      property.type.toLowerCase().includes(searchTerm)
    );
  });

  displayProperties(filteredProperties);
}

searchBtn.addEventListener('click', performSearch);
searchInput.addEventListener('keyup', function (event) {
  if (event.key === 'Enter') {
    performSearch();
  }
});

// Menu mobile
document.querySelector('.mobile-menu-btn').addEventListener('click', function () {
  document.querySelector('.nav-menu').classList.toggle('active');
});



const menuToggle = document.getElementById('menu-toggle');
const navMenu = document.querySelector('.nav-menu');

menuToggle.addEventListener('click', () => {
  navMenu.classList.toggle('active');
  menuToggle.classList.toggle('menu-open');
});
