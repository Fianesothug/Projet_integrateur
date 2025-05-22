



________________________________________
🎯 OBJECTIF DU FRONT-END
Créer une interface responsive, conviviale et claire pour chaque type d’utilisateur (client, bailleur, agent, manager), tout en permettant aux visiteurs non connectés de consulter les propriétés.
________________________________________
🧱 1. STRUCTURE GÉNÉRALE (HTML + CSS + JS)
Projet_integrateur/
│
├── index.php               ← Page d'accueil (publique)
├── login.php               ← Connexion (client/bailleur/agent/manager)
├── register.php            ← Inscription (client ou bailleur)
├── propriete.php           ← Détail d’une propriété
├── favoris.php             ← Liste des favoris d’un client
├── rendezvous.php          ← Prise de rendez-vous
│
├── includes/
│   ├── header.php          ← En-tête (logo + titre site)
│   ├── navbar.php          ← Menu de navigation dynamique selon utilisateur
│   └── footer.php          ← Pied de page (contact, infos, liens)
│
├── assets/
│   ├── css/
│   │   ├── style.css       ← Styles principaux
│   │   ├── header.css      ← Spécifique à l’en-tête
│   │   ├── footer.css      ← Pied de page
│   │   └── responsive.css  ← Responsive design
│   ├── js/
│   │   ├── script.js       ← Comportement général (menu mobile, etc.)
│   │   └── rendezvous.js   ← JS pour le formulaire de rdv
│   └── images/
│       ├── bannieres/      ← Image d’accueil
│       └── proprietes/     ← Photos des biens
│
├── components/
│   ├── carte-propriete.php     ← Carte HTML d’une propriété
│   └── formulaire-inscription.php ← Formulaire de base (utilisé par register.php)
________________________________________
🔗 2. LIENS ENTRE LES FICHIERS (navigation + inclusion)
🌐 Pages publiques
Fichier	Liens et interactions
index.php	- Affiche les propriétés disponibles (via components/carte-propriete.php)- Lien vers propriete.php?id=X- Barre de navigation (includes/navbar.php)
login.php	Formulaire avec action vers le back-end (traitement/login.php)Redirige vers le tableau de bord selon le rôle
register.php	Inclut components/formulaire-inscription.phpPeut inclure un ?role=client ou ?role=bailleur dans l’URL
________________________________________
🧑‍💼 Espace Client
Fichier	Liens
client/tableau-bord.php	Liens vers favoris.php, rendezvous.php, profil.php
favoris.php	Affiche les propriétés aimées avec option "Retirer des favoris"
rendezvous.php	Formulaire de demande de rdv pour une propriété
client/profil.php	Affiche/édite les infos du client
________________________________________
🏠 Espace BAILLEUR
Fichier	Liens
bailleur/tableau-bord.php	Liens vers ajout-propriete.php, mes-biens.php
ajout-propriete.php	Formulaire avec champ image et infos du bien
mes-biens.php	Tableau des biens + boutons "Modifier", "Supprimer"
________________________________________
🧑‍💼 Espace EMPLOYÉ - Agent
Fichier	Liens
employe/tableau-bord.php	Liens vers ajout-propriete.php, clients affectés
employe/ajout-propriete.php	Identique au bailleur
gestion-clients.php	Voir clients affectés, les rendez-vous
________________________________________
👨‍💼 Espace EMPLOYÉ - Manager
Fichier	Liens
employe/manager/tableau-bord.php	Liens vers tous les autres fichiers du manager
gestion-utilisateurs.php	CRUD sur clients, bailleurs, agents
affectations.php	Lister clients non affectés, les affecter
statistiques.php	Graphiques statistiques
________________________________________
🧩 3. COMPOSANTS À INCLURE
includes/header.php
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Agence Immobilière</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/responsive.css">
</head>
<body>
  <?php include 'navbar.php'; ?>
includes/navbar.php
Menu dynamique :
<nav>
  <ul>
    <li><a href="index.php">Accueil</a></li>
    <?php if (!isset($_SESSION['role'])): ?>
      <li><a href="login.php">Connexion</a></li>
      <li><a href="register.php">Inscription</a></li>
    <?php elseif ($_SESSION['role'] === 'client'): ?>
      <li><a href="/client/tableau-bord.php">Mon espace</a></li>
      <li><a href="favoris.php">Favoris</a></li>
    <?php elseif ($_SESSION['role'] === 'bailleur'): ?>
      <li><a href="/bailleur/mes-biens.php">Mes biens</a></li>
    <?php elseif ($_SESSION['role'] === 'manager'): ?>
      <li><a href="/employe/manager/tableau-bord.php">Manager</a></li>
    <?php endif; ?>
  </ul>
</nav>
includes/footer.php
<footer>
  <p>&copy; 2025 - Agence Immobilière</p>
</footer>
</body>
</html>
________________________________________
📋 4. EXEMPLES DE LIENS HTML
•	Lien vers les détails d’une propriété :
<a href="propriete.php?id=12">Voir détails</a>
•	Lien vers la modification d’un bien :
<a href="bailleur/modifier-propriete.php?id=12">Modifier</a>
•	Soumission formulaire :
<form action="traitement/ajout-propriete.php" method="POST" enctype="multipart/form-data">
________________________________________
📜 5. ROUTAGE BASIQUE EN PHP
Dans chaque page sensible :
include 'includes/auth-client.php'; // ou auth-bailleur.php
________________________________________
✅ Résumé des liens entre parties
Page/Composant	Inclut / Lié à
index.php	navbar.php, carte-propriete.php, footer.php
login.php	Formulaire de login → vérification PHP
register.php	formulaire-inscription.php
propriete.php	Affiche un bien spécifique + bouton rdv ou favoris
navbar.php	Liens dynamiques selon $_SESSION['role']
footer.php	Présent sur toutes les pages
script.js	Menu mobile, interactions JS
________________________________________



________________________________________
🎯 Objectif : Un back-end sécurisé, modulaire, logique et évolutif
Le back-end dans ton cas se fait avec PHP + MySQL. Il sert à :
•	gérer la base de données,
•	assurer la sécurité (authentification, rôles, sessions),
•	faire communiquer les pages dynamiquement,
•	exécuter les actions métiers (ajout de propriété, rendez-vous, etc.).
________________________________________
📁 STRUCTURE BACK-END CONSEILLÉE (selon ton arborescence)
________________________________________
🔧 1. includes/ (fonctions partagées)
•	db.php ← Connexion PDO à la base
•	auth.php ← Fonctions de connexion/déconnexion
•	auth-client.php, auth-bailleur.php, auth-agent.php, auth-manager.php ← Vérification des rôles
•	functions.php ← Fonctions utilitaires (affichage, redirections, etc.)
🔧 2. sql/
•	structure.sql ← Fichier pour créer la base (tables, index, relations)
•	dummy-data.sql ← Données de test
________________________________________
🔐 2. AUTHENTIFICATION & SÉCURITÉ
🔸 a) Gestion des rôles :
Dans la table utilisateurs (ou séparée), il faut un champ role : client, bailleur, agent, manager
🔸 b) Login (login.php)
•	Vérifie les identifiants (email + mot de passe)
•	Vérifie le rôle
•	Démarre la session avec :
$_SESSION['user_id'] = $user['id'];
$_SESSION['role'] = $user['role'];
•	Redirige vers le bon tableau de bord selon le rôle
🔸 c) Middleware de sécurité
Exemple pour un fichier auth-client.php :
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'client') {
  header('Location: ../login.php');
  exit();
}
________________________________________
🧩 3. MODULES FONCTIONNELS
🟦 A. MODULE CLIENT
•	register.php : insertion en base avec vérification des champs
•	favoris.php : ajout/suppression via table favoris (avec AJAX possible)
•	rendezvous.php : formulaire lié à une propriété (enregistre dans rendezvous)
•	client/tableau-bord.php : liste des rendez-vous, favoris, infos perso
________________________________________
🟨 B. MODULE BAILLEUR
•	register.php (ou spécifique) : identique à client, mais rôle différent
•	bailleur/ajout-propriete.php :
o	Formulaire d’ajout
o	Upload des images
o	Insertion dans proprietes + images
•	bailleur/mes-biens.php : affichage et édition des propriétés par le bailleur
•	Sécurité : ne voir que ses propres propriétés
________________________________________
🟧 C. MODULE EMPLOYE - AGENT
•	employe/ajout-propriete.php : même logique que bailleur
•	employe/tableau-bord.php :
o	voir ses clients affectés
o	voir les rdv clients
o	tableau des actions à faire
________________________________________
🟥 D. MODULE EMPLOYE - MANAGER
•	employe/manager/gestion-utilisateurs.php :
o	CRUD sur les utilisateurs (ajouter, modifier, supprimer client, bailleur, agent)
•	employe/manager/affectations.php :
o	liste des clients non affectés
o	assignation à un agent
•	employe/manager/statistiques.php :
o	Requêtes SQL (COUNT, GROUP BY, etc.) + affichage avec Chart.js
________________________________________
🗃 4. BASE DE DONNÉES RECOMMANDÉE
✅ Tables essentielles :
utilisateurs (id, nom, email, mot_de_passe, role)
proprietes (id, titre, type, usage, prix, localisation, bailleur_id, statut)
images (id, propriete_id, chemin)
favoris (id, client_id, propriete_id)
rendezvous (id, client_id, propriete_id, date, statut)
affectations (id, agent_id, client_id)
👉 Utilise clés étrangères + index pour optimiser les relations
________________________________________
📨 5. TRAITEMENT DES FORMULAIRES
Exemple d’ajout de propriété :
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'];
    $type = $_POST['type'];
    $prix = $_POST['prix'];
    $bailleur_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO proprietes (titre, type, prix, bailleur_id) VALUES (?, ?, ?, ?)");
    $stmt->execute([$titre, $type, $prix, $bailleur_id]);
}
________________________________________
📦 6. GESTION DES UPLOADS
Pour les photos des propriétés :
•	Créer un dossier uploads/proprietes/
•	Stocker les noms de fichiers dans la table images
•	Protéger les extensions / poids / MIME
________________________________________
📈 7. STATISTIQUES POUR LE MANAGER
Exemples de requêtes :
-- Nb de clients
SELECT COUNT(*) FROM utilisateurs WHERE role = 'client';

-- Nb de propriétés par type
SELECT type, COUNT(*) FROM proprietes GROUP BY type;

-- Rdv confirmés
SELECT COUNT(*) FROM rendezvous WHERE statut = 'confirmé';
________________________________________
✅ Résumé : To-do Back-End
Action	Fait ?
Connexion à la base (PDO)	
Authentification et gestion des rôles	
Sécurité via middlewares	
Gestion des propriétés (CRUD)	⏳
Favoris et rendez-vous	⏳
Affectation clients/agents	
Statistiques Manager	
Traitement des formulaires + upload fichiers	


