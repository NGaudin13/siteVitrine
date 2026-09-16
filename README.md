# NBSOLUTIONS -- Site vitrine

Site vitrine développé en **PHP** avec une architecture **MVC**, une
base de données **MySQL** et un **back-office d'administration**.

Le projet permet de présenter l'activité et les services de NBSOLUTIONS
tout en donnant au client la possibilité de modifier plusieurs contenus
du site depuis une interface d'administration, sans avoir à intervenir
directement dans le code PHP.

------------------------------------------------------------------------

## Technologies utilisées

-   PHP
-   MySQL
-   HTML5 / CSS3
-   Bootstrap
-   JavaScript
-   Architecture MVC
-   XAMPP
-   Git

------------------------------------------------------------------------

## Fonctionnalités du site

### Partie publique

Le site comprend notamment :

-   une page d'accueil ;
-   une page de présentation ;
-   une page de services ;
-   une page de contact ;
-   les conditions générales ;
-   la politique de confidentialité ;
-   une page 404 personnalisée ;
-   un header et un footer communs ;
-   une interface responsive adaptée aux ordinateurs, tablettes et
    mobiles.

------------------------------------------------------------------------

## Back-office

Le projet possède un **back-office fonctionnel** accessible après
authentification.

### Connexion

``` text
http://localhost/siteVitrine/index.php?page=login
```

### Identifiants administrateur

``` text
E-mail : contact@oflabim.fr
Mot de passe : admin123
```

Une fois connecté, l'administrateur accède à un **tableau de bord**
permettant de gérer les contenus prévus dans l'interface
d'administration.

### Administration de la page d'accueil

Le back-office contient une administration dédiée à la page d'accueil
avec plusieurs sections distinctes :

-   **Introduction (`home-intro`)** : gestion du contenu d'introduction
    de la page d'accueil ;
-   **À propos (`home-about`)** : gestion de la section de présentation
    / à propos ;
-   **Domaines (`home-domains`)** : gestion des contenus associés aux
    domaines présentés sur la page d'accueil.

Ces différentes parties sont séparées dans le back-office afin de
permettre une modification ciblée du contenu.

### Administration de la page Présentation

Une interface spécifique permet d'administrer la page de présentation.

Le projet contient notamment la section :

-   **Parcours / `presentation-path`** : gestion du contenu
    correspondant au parcours présenté sur cette page.

### Administration de la page Contact

Une interface d'administration est également prévue pour la partie
Contact.

Elle permet notamment de gérer :

-   **les natures de demande (`contact-nature-demande`)** proposées dans
    le formulaire de contact.

Cela permet de faire évoluer les choix disponibles dans le formulaire
sans modifier directement la vue publique.

### Organisation du back-office

Le back-office est structuré autour de plusieurs contrôleurs dédiés :

``` text
adminController.php
adminDashboardController.php
adminAccueilController.php
AdminPresentationController.php
adminContactController.php
authController.php
```

Les vues d'administration sont regroupées dans :

``` text
views/views_admin/
```

avec notamment :

``` text
adminDashboard.php
adminAccueil.php
adminPresentation.php
adminContact.php
adminTabs.php
```

Les différentes zones administrables sont elles-mêmes séparées en
composants :

``` text
views/views_admin/sections/
├── home-intro.php
├── home-about.php
├── home-domains.php
├── presentation-path.php
└── contact-nature-demande.php
```

Cette organisation permet de faire évoluer le back-office section par
section sans devoir reconstruire toute l'administration.

------------------------------------------------------------------------

## Gestion dynamique des contenus

Le projet utilise une structure générique basée sur quatre objets
principaux :

-   `Page`
-   `Section`
-   `ContentBlock`
-   `User`

Les classes correspondantes sont séparées entre les **entités** et les
**modèles**.

``` text
entities/
├── Page.php
├── Section.php
├── ContentBlock.php
└── User.php

models/
├── PageModel.php
├── SectionModel.php
├── ContentBlockModel.php
└── UserModel.php
```

Cette organisation permet de représenter le contenu du site sous la
forme :

``` text
Page
  └── Section
       └── ContentBlock
```

Le but est d'éviter de coder en dur tous les contenus dans les pages et
de permettre leur administration depuis le back-office.

------------------------------------------------------------------------

## Architecture du projet

``` text
siteVitrine/
│
├── assets/
│   ├── css/
│   ├── images/
│   └── scripts/
│
├── config/
├── controllers/
├── entities/
├── languages/
├── lib/
├── models/
│
├── views/
│   ├── views_admin/
│   │   └── sections/
│   ├── accueil.php
│   ├── presentation.php
│   ├── service.php
│   ├── contact.php
│   ├── login.php
│   ├── header.php
│   └── footer.php
│
├── index.php
└── sitevitrineoflabim.sql
```

### Controllers

Les contrôleurs gèrent les requêtes, la navigation et les interactions
entre les modèles et les vues.

Les contrôleurs publics et les contrôleurs du back-office sont séparés
afin de conserver une architecture claire.

### Models

Les modèles assurent l'accès et la manipulation des données enregistrées
dans MySQL.

### Entities

Les entités représentent les principaux objets métier manipulés par
l'application.

### Views

Les vues contiennent l'affichage des pages publiques et des interfaces
d'administration.

------------------------------------------------------------------------

## Installation locale

### 1. Installer le projet

Placer le dossier dans :

``` text
xampp/htdocs/siteVitrine
```

### 2. Démarrer XAMPP

Démarrer :

-   Apache
-   MySQL

### 3. Importer la base de données

Depuis **phpMyAdmin**, importer :

``` text
sitevitrineoflabim.sql
```

### 4. Configurer la connexion à MySQL

Vérifier les paramètres présents dans :

``` text
config/configuration.php
```

### 5. Accéder au site

``` text
http://localhost/siteVitrine/index.php?page=accueil
```

### 6. Accéder au back-office

``` text
http://localhost/siteVitrine/index.php?page=login
```

Identifiants :

``` text
contact@oflabim.fr
admin123
```

------------------------------------------------------------------------

## État actuel du projet

-   [x] Architecture MVC fonctionnelle
-   [x] Base de données MySQL
-   [x] Site vitrine fonctionnel
-   [x] Interface responsive
-   [x] Header et footer communs
-   [x] Authentification administrateur
-   [x] Tableau de bord administrateur
-   [x] Back-office dédié à la page d'accueil
-   [x] Administration de la section Introduction
-   [x] Administration de la section À propos
-   [x] Administration des Domaines
-   [x] Back-office dédié à la page Présentation
-   [x] Administration du Parcours
-   [x] Back-office dédié à la page Contact
-   [x] Administration des natures de demande
-   [x] Gestion structurée en Pages / Sections / ContentBlocks
-   [x] Gestion des utilisateurs
-   [x] Page 404
-   [x] Projet versionné avec Git
-   [x] Architecture prévue pour accueillir de nouvelles fonctionnalités

------------------------------------------------------------------------

## Évolutions possibles

L'architecture actuelle permet notamment d'envisager :

-   l'ajout de nouvelles sections administrables ;
-   l'administration complète de la page Services ;
-   la gestion avancée des images et médias ;
-   la gestion des messages reçus via le formulaire de contact ;
-   l'ajout de nouveaux comptes administrateurs ;
-   une gestion plus avancée des droits utilisateurs ;
-   l'optimisation SEO ;
-   le renforcement de la sécurité pour la mise en production ;
-   le déploiement sur un serveur distant.

------------------------------------------------------------------------

## Objectif du projet

L'objectif est de disposer d'un **site vitrine professionnel et
administrable**, tout en conservant une architecture PHP simple et
maintenable.

Le découpage en **Pages, Sections et ContentBlocks**, associé aux
contrôleurs et vues spécifiques du back-office, permet de faire évoluer
progressivement le contenu administrable sans reconstruire
l'application.
