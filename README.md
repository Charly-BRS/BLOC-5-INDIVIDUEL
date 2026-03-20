# Vide Grenier en Ligne

## Introduction

**Vide Grenier en Ligne** est une application web développée en PHP utilisant une architecture MVC (Modèle-Vue-Contrôleur). Cette plateforme permet aux utilisateurs de créer et consulter des annonces de vide-grenier en ligne, avec gestion des utilisateurs, upload d'images et système de contact entre vendeurs et acheteurs.

### Fonctionnalités principales
- Inscription et connexion utilisateur avec système "remember me"
- Connexion automatique après inscription
- Création d'annonces avec image obligatoire (JPEG/PNG uniquement)
- Affichage des annonces
- Formulaire de contact vendeur (sans mailto)
- Gestion des erreurs utilisateur

### Technologies utilisées
- **Backend** : PHP 8.x
- **Base de données** : MySQL
- **Architecture** : MVC personnalisé
- **Templating** : Twig
- **Tests** : PHPUnit
- **Conteneurisation** : Docker
- **CI/CD** : GitHub Actions
- **Gestion de version** : GitFlow

## Prérequis

Avant de commencer, assurez-vous d'avoir installé les outils suivants :
- **Docker** et **Docker Compose** (version 3.8+)
- **Git** pour le clonage du repository
- **Navigateur web** pour accéder à l'application

## Installation

Suivez ces étapes pour installer le projet localement :

1. **Clonez le repository** :
   ```bash
   git clone https://github.com/votre-username/vide-grenier-en-ligne.git
   cd vide-grenier-en-ligne
   ```

2. **Installez les dépendances PHP** :
   ```bash
   composer install
   ```

3. **Installez les dépendances front-end** (si nécessaire) :
   ```bash
   npm install
   npm run watch
   ```

4. **Configurez la base de données** :
   - Les scripts SQL sont disponibles dans le dossier `sql/`
   - Importez `sql/import.sql` dans votre base de données MySQL

## Lancement de l'application

### Environnement de développement

Pour lancer l'environnement de développement :

- Sur Windows PowerShell :
  ```powershell
  .\scripts\start-dev.ps1
  ```
- Sur Linux/macOS (si script disponible) :
  ```bash
  ./scripts/start-dev.sh
  ```
- Option alternative Docker Compose :
  ```bash
  docker-compose -f docker-compose.dev.yml up --build
  ```

Le service utilise `docker-compose.dev.yml` pour monter les volumes et activer le rechargement à chaud.

### Environnement de production

Pour lancer l'environnement de production :

- Sur Windows PowerShell :
  ```powershell
  .\scripts\start-prod.ps1
  ```
- Sur Linux/macOS (si script disponible) :
  ```bash
  ./scripts/start-prod.sh
  ```
- Option alternative Docker Compose :
  ```bash
  docker-compose -f docker-compose.prod.yml up --build -d
  ```

La configuration utilise `docker-compose.prod.yml` et un Apache/PHP optimisé pour la production.

## URLs d'accès

- **Développement** : [http://localhost:8080](http://localhost:8080)
- **Production** : [http://localhost:8081](http://localhost:80) (ou selon la configuration du serveur)

## Architecture du projet

Le projet suit une architecture MVC personnalisée :

- **App/Controllers/** : Contrôleurs gérant la logique métier (Api.php, Home.php, Product.php, User.php)
- **App/Models/** : Modèles pour l'accès aux données (Articles.php, Cities.php, User.php)
- **App/Views/** : Templates Twig pour l'affichage (base.html, Home/index.html, etc.)
- **Core/** : Classes de base (Controller.php, Model.php, Router.php, View.php)
- **Utility/** : Classes utilitaires (Hash.php, Upload.php)
- **public/** : Point d'entrée de l'application et assets statiques

Le routing est géré par `Core/Router.php` avec support des paramètres dynamiques.

## Tests

Les tests unitaires sont écrits avec PHPUnit. Pour les exécuter :

- Sur Linux/macOS :
  ```bash
  vendor/bin/phpunit
  ```
- Sur Windows (cmd/powershell) :
  ```powershell
  vendor\bin\phpunit.bat
  ```

Les fichiers de test se trouvent dans le dossier `tests/` :
- BusinessRulesTest.php
- HashTest.php
- UploadTest.php

## Pipeline CI/CD

Le projet utilise GitHub Actions pour l'intégration continue. La pipeline :
- Se déclenche sur les push et pull requests vers les branches `main` et `dev`
- Exécute les tests PHPUnit
- Vérifie la qualité du code (linting, sécurité)
- Déploie automatiquement en production sur les merges vers `main`

## Démonstration

Pour une démonstration complète de l'application :

1. **Lancez l'environnement de développement** :
   ```bash
   ./start-dev.sh
   ```

2. **Accédez à l'application** : [http://localhost:8080](http://localhost:8080)

3. **Ordre de démonstration** :
   - Inscrivez-vous en tant que nouvel utilisateur
   - Connectez-vous (vérifiez le "remember me")
   - Créez une annonce avec une image
   - Consultez les annonces existantes
   - Utilisez le formulaire de contact pour contacter un vendeur

## Gestion des versions avec GitFlow

Le projet utilise GitFlow pour la gestion des versions :

- **main** : Branche de production, code stable et déployé
- **dev** : Branche de développement, intégration des nouvelles fonctionnalités
- **feature/* ** : Branches pour développer de nouvelles fonctionnalités (ex: `feature/ajout-panier`)

### Workflow typique :
1. Créez une branche `feature/nouvelle-fonctionnalite` depuis `dev`
2. Développez et testez
3. Mergez vers `dev` via pull request
4. Une fois stable, mergez `dev` vers `main` pour le déploiement

## Docker

L'application utilise Docker pour la conteneurisation :

- **Conteneur web** : Apache/PHP avec le code de l'application
- **Conteneur base de données** : MySQL pour la persistance des données

Les configurations sont séparées :
- `docker-compose.dev.yml` : Pour le développement (volumes montés, hot-reload)
- `docker-compose.prod.yml` : Pour la production (images optimisées, sécurité renforcée)

## Conclusion

Ce projet démontre une implémentation moderne d'une application web PHP avec architecture MVC, conteneurisation Docker et pratiques DevOps. Il est prêt pour la production avec un environnement de développement simple à mettre en place.

Pour toute question ou contribution, consultez les issues du repository ou contactez l'équipe de développement.
