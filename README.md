# 🏠 Projet Intégrateur - Plateforme de Gestion Immobilière

Ce projet est une application web de gestion immobilière développée en **PHP**, **HTML**, **CSS**, et **JavaScript**. Il permet à différents types d’utilisateurs (clients, bailleurs, employés) d’interagir avec des annonces immobilières, de gérer des biens, des rendez-vous, et plus encore.

---

## 🚀 Fonctionnalités principales

- 🔐 Authentification par rôle (client, bailleur, employé)
- 🏠 Liste des propriétés avec affichage dynamique
- ❤️ Ajout de propriétés en favoris
- 📅 Prise de rendez-vous
- 🧑‍💼 Tableau de bord personnalisé par type d’utilisateur
- 📊 Gestion des statistiques pour les employés
- 📩 Page de contact

---

## 🗂️ Arborescence du projet


---

## 🛠️ Installation locale

1. Clonez le dépôt :
   ```bash
   git clone https://github.com/Fianesothug/Projet_integrateur.git
" lancer le serveur avec "
http://localhost/Projet_integrateur/

| Rôle         | Accès                                                |
| ------------ | ---------------------------------------------------- |
| **Client**   | Parcourir, ajouter aux favoris, rendez-vous          |
| **Bailleur** | Ajouter/modifier ses propriétés, voir ses biens      |
| **Employé**  | Gérer les clients, propriétés, voir les statistiques |


Voici un fichier `README.md` clair et complet pour ton projet **Projet\_integrateur**, que tu peux directement copier dans la racine de ton dépôt :

---

```markdown
# 🏠 Projet Intégrateur - Plateforme de Gestion Immobilière

Ce projet est une application web de gestion immobilière développée en **PHP**, **HTML**, **CSS**, et **JavaScript**. Il permet à différents types d’utilisateurs (clients, bailleurs, employés) d’interagir avec des annonces immobilières, de gérer des biens, des rendez-vous, et plus encore.

---

## 🚀 Fonctionnalités principales

- 🔐 Authentification par rôle (client, bailleur, employé)
- 🏠 Liste des propriétés avec affichage dynamique
- ❤️ Ajout de propriétés en favoris
- 📅 Prise de rendez-vous
- 🧑‍💼 Tableau de bord personnalisé par type d’utilisateur
- 📊 Gestion des statistiques pour les employés
- 📩 Page de contact

---

## 🗂️ Arborescence du projet

```

Projet\_integrateur/
├── assets/              # Fichiers CSS, JS, images
├── bailleur/            # Pages pour les bailleurs
├── client/              # Pages pour les clients
├── employe/             # Pages pour les employés
├── includes/            # Header, footer, navbar
├── components/          # Composants PHP réutilisables
├── index.php            # Page d’accueil
├── login.php            # Page de connexion
├── register.php         # Page d’inscription
├── favoris.php          # Liste des favoris
├── propriete.php        # Détails d’une propriété
├── rendezvous.php       # Prise de rendez-vous
└── contact.php          # Page de contact

````

---

## 🛠️ Installation locale

1. Clonez le dépôt :
   ```bash
   git clone https://github.com/Fianesothug/Projet_integrateur.git
````

2. Placez le dossier dans le répertoire de votre serveur local (`www` pour WAMP, `htdocs` pour XAMPP).

3. Lancez votre serveur et ouvrez dans votre navigateur :

   ```
   http://localhost/Projet_integrateur/
   ```

4. (Optionnel) Configurez la base de données et modifiez les identifiants dans vos fichiers PHP.

---

## 👨‍💻 Utilisateurs & rôles

| Rôle         | Accès                                                |
| ------------ | ---------------------------------------------------- |
| **Client**   | Parcourir, ajouter aux favoris, rendez-vous          |
| **Bailleur** | Ajouter/modifier ses propriétés, voir ses biens      |
| **Employé**  | Gérer les clients, propriétés, voir les statistiques |

---

## 📦 À venir

* 🔐 Connexion sécurisée (hash des mots de passe)
* 📧 Notifications par mail
* 📁 Téléversement d’images dynamiques pour les propriétés
* 🔎 Recherche et filtres avancés des annonces

---

## 🤝 Collaboration

Pour contribuer :

1. Fork le projet ou clone-le avec `git clone`
2. Crée une branche : `git checkout -b feature/ma-fonction`
3. Commit tes modifications : `git commit -m "Ajout d'une fonctionnalité"`
4. Push ta branche : `git push origin feature/ma-fonction`
5. Crée une **Pull Request** sur GitHub

---

## 📄 Licence

Ce projet est sous licence MIT – vous pouvez l’utiliser, le modifier, et le partager librement.

---

Développé avec ❤️ par Fianesothug en collaboration avec lebossboss

````

---

### 📌 Étapes pour l’ajouter à ton dépôt

Dans ton terminal :

```bash
# À la racine de ton projet
echo "TON_CONTENU_README_ICI" > README.md

# Ou ouvre ton éditeur et colle le contenu

git add README.md
git commit -m "Ajout du README.md"
git push
````
