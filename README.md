# Unity Care CLI 🏥

> Système de gestion hospitalière en ligne de commande avec architecture orientée objet

Une application console interactive pour la gestion rapide des patients, médecins et départements d'une clinique, développée en PHP 8 avec architecture OOP et accès aux données via MySQLi.

---

## 📋 Table des matières

- [Fonctionnalités](#-fonctionnalités)
- [Prérequis](#-prérequis)
- [Installation](#-installation)
- [Structure du projet](#-structure-du-projet)
- [Utilisation](#-utilisation)
- [Architecture](#-architecture)
- [User Stories](#-user-stories)

---

## ✨ Fonctionnalités

### Gestion des données
- **Patients** : Créer, lister, rechercher, modifier et supprimer
- **Médecins** : Gestion complète du personnel médical
- **Départements** : Administration des services hospitaliers

### Statistiques avancées
- Âge moyen des patients
- Ancienneté moyenne des médecins
- Département le plus peuplé
- Répartition des patients par département

### Fonctionnalités techniques
- ✅ Validation des données (email, téléphone, dates)
- 🎨 Affichage en tableaux ASCII formatés
- 🔒 Encapsulation et architecture OOP
- 🏗️ Héritage et interfaces
- 📊 Méthodes statiques pour statistiques

---

## 🔧 Prérequis

- PHP 8.0 ou supérieur
- MySQL 5.7+ ou MariaDB 10.3+
- Extension PDO activée
- Terminal/Console

---

## 📦 Installation

### 1. Cloner le projet
```bash
git clone https://github.com/votre-username/unity-care-cli.git
cd unity-care-cli
```

### 2. Configuration de la base de données

Créer la base de données :
```bash
mysql -u root -p < database/schema.sql
```

Configurer la connexion dans `config/database.php` :
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'unity_care');
define('DB_USER', 'root');
define('DB_PASS', 'votre_mot_de_passe');
```

### 3. Lancer l'application
```bash
php index.php
```

---

## 📁 Structure du projet

```
unity-care-cli/
├── config/
│   └── database.php          # Configuration DB
├── src/
│   ├── Models/
│   │   ├── BaseModel.php     # Classe mère des entités
│   │   ├── Personne.php      # Classe abstraite
│   │   ├── Patient.php       # Gestion patients
│   │   ├── Doctor.php        # Gestion médecins
│   │   └── Department.php    # Gestion départements
│   ├── Utils/
│   │   ├── Validator.php     # Validation statique
│   │   └── ConsoleTable.php  # Affichage tableaux ASCII
│   ├── Interfaces/
│   │   └── Displayable.php   # Interface d'affichage
│   └── Database/
│       └── Connection.php    # Connexion 
├── database/
│   └── schema.sql            # Structure de la DB
├── index.php                 # Point d'entrée
└── README.md
```

---

## 🚀 Utilisation

### Menu principal
```
=== Unity Care CLI ===
1. Gérer les patients
2. Gérer les médecins
3. Gérer les départements
4. Statistiques
5. Quitter
```

### Exemple : Gestion des patients
```
=== Gestion des Patients ===
1. Lister tous les patients
2. Rechercher un patient
3. Ajouter un patient
4. Modifier un patient
5. Supprimer un patient
6. Retour
```

### Affichage des données
```
+----+------------+-----------+------------------+------------+
| ID | Prénom     | Nom       | Email            | Département|
+----+------------+-----------+------------------+------------+
| 1  | Mohammed   | Alami     | m.alami@mail.com | Cardiologie|
| 2  | Fatima     | Bennis    | f.bennis@mail.com| Pédiatrie  |
+----+------------+-----------+------------------+------------+
```

---

## 🏗️ Architecture


### Classes principales

#### BaseModel
Classe abstraite fournissant les méthodes communes :
- `save()` : Insertion/mise à jour
- `delete()` : Suppression
- `findById()` : Recherche par ID
- `getId()` : Récupération de l'ID

#### Validator (statique)
Méthodes de validation :
- `isValidEmail(string $email): bool`
- `isValidPhone(string $phone): bool`
- `isValidDate(string $date): bool`
- `isNotEmpty(string $input): bool`
- `sanitize(string $input): string`

#### Interface Displayable
```php
interface Displayable {
    public function toArray(): array;
    public static function getDisplayHeaders(): array;
}
```

### Méthodes statiques (Statistiques)
```php
Patient::calculateAverageAge(): float
Doctor::calculateAverageYearsOfService(): float
Department::getMostPopulated(): Department
Patient::countByDepartment(): array
```

---

## 📖 User Stories

| ID | Description                                       |
|----|---------------------------------------------------|
| US01 | Navigation via menu numéroté clair              |
| US02 | CRUD complet sur les patients                   |
| US03 | CRUD complet sur les médecins                   |
| US04 | CRUD complet sur les départements               |
| US05 | Consultation des statistiques calculées         |
| US06 | Messages d'erreur clairs pour données invalides |


