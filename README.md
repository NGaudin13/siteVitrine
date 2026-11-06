<!-- FICHIER : siteVitrine/README.md -->

# OFLABIM — Site vitrine

Site vitrine d'**OFLABIM**, bureau d'études et d'ingénierie BIM
(installations techniques, eau potable et assainissement, CVC, industrie).

Développé par **NBsolutions** en PHP (architecture MVC) avec MySQL.
Le client modifie lui-même une partie des contenus depuis un
**back-office**, sans toucher au code.

---

## Sommaire

1. [Fonctionnalités](#fonctionnalités)
2. [Technologies](#technologies)
3. [Organisation du code](#organisation-du-code)
4. [Installation locale (XAMPP)](#installation-locale-xampp)
5. [Tests automatiques](#tests-automatiques)
6. [Mise en ligne](#mise-en-ligne)
7. [Sécurité](#sécurité)
8. [Travailler avec Git](#travailler-avec-git)
9. [Modifier le site](#modifier-le-site)
10. [Reste à faire avant livraison](#reste-à-faire-avant-livraison)

---

## Fonctionnalités

### Site public

| Page | Adresse | Contenu |
|---|---|---|
| Accueil | `?page=accueil` | Bandeau, démonstration Réel / BIM, BIM, services, à propos, domaines, livrables, témoignages |
| Présentation | `?page=presentation` | L'entreprise, stratégie BIM (vidéo), parcours, exemples de maquettes |
| Services | `?page=service` | Carrousel des 4 prestations et leur détail |
| Contact | `?page=contact` | Coordonnées, formulaire, carte Google Maps |
| Conditions | `?page=conditions` | Conditions générales d'utilisation |
| Confidentialité | `?page=confidentialite` | Politique de confidentialité (RGPD) |
| Mentions légales | `?page=mentions` | Mentions obligatoires (loi LCEN) |
| 404 | toute page inconnue | Page « introuvable » personnalisée |

- Les bandeaux d'Accueil, Présentation, Services et Contact partagent le même
  style (classes `ofl-hero`) et la même hauteur.
- **Démonstration Réel / BIM** (accueil) : le bouton « Voir la démonstration »
  ouvre une section où l'on fait glisser une poignée entre une photo et la
  maquette BIM (souris, doigt ou flèches du clavier).
- **Formulaire de contact** : protection CSRF, champ anti-robot invisible,
  messages d'erreur par champ, envoi par `mail()`.
- Site responsive (ordinateur, tablette, mobile).
- SEO : titre, description et URL canonique propres à chaque page, un seul
  `h1` par page, admin interdit aux moteurs de recherche.

### Back-office

Accessible après connexion : `index.php?page=login`.

| Écran | Ce que le client peut modifier |
|---|---|
| Tableau de bord | Coordonnées de l'entreprise (téléphone, e-mail, adresse, horaires…) |
| Accueil | Introduction (`home-intro`), À propos (`home-about`), Domaines d'intervention (`home-domains`) |
| Présentation | Parcours : réalisations et compétences (`presentation-path`) |
| Contact | Types de demande du formulaire (`contact-nature-demande`) |

Les images envoyées depuis l'admin sont vérifiées (vrai fichier image,
taille, type) puis rangées dans `assets/images/`.

---

## Technologies

- **PHP 8** (sans framework), architecture **MVC**
- **MySQL / MariaDB** via PDO (requêtes préparées)
- **Bootstrap 5.3**, Bootstrap Icons, Font Awesome, Swiper (chargés par CDN)
- **JavaScript** natif (comparateur, ouverture de la démonstration)
- **pytest** pour les tests automatiques
- **XAMPP** en local, **Git / GitHub** pour les versions

---

## Organisation du code

```text
siteVitrine/
├── index.php                  Point d'entrée unique : choisit la page et le contrôleur
├── .htaccess                  Sécurité Apache (HTTPS, fichiers interdits)
├── sitevitrineoflabim.sql     Structure + contenu de la base
│
├── config/
│   ├── configuration.php                Réglages + connexion PDO
│   └── configuration.local.example.php  Modèle des réglages du serveur en ligne
│
├── controllers/               Logique de chaque page (public, admin, connexion, contact)
├── entities/                  Objets métier : Page, Section, ContentBlock, User
├── models/                    Accès à la base pour chaque entité
├── lib/
│   ├── foncBase.php           Fonctions communes (CSRF, URL, chemins d'images)
│   └── ImageUpload.php        Envoi sécurisé des images de l'admin
├── languages/                 Textes de l'interface
├── views/                     Pages publiques, header, footer
│   └── views_admin/           Écrans du back-office
│       └── sections/          Un formulaire par section modifiable
├── assets/
│   ├── css/style.css          Tout le style du site et de l'admin
│   ├── images/                Images du site et images envoyées par l'admin
│   └── scripts/               JavaScript (carrousel des services)
├── scripts/
│   └── changer_mot_de_passe.php   Changement du mot de passe admin (terminal)
└── tests/                     Tests automatiques pytest
```

### Comment le contenu est stocké

Les textes et images modifiables ne sont pas écrits dans les vues :
ils sont en base, rangés ainsi :

```text
Page (accueil, presentation…)
 └── Section (home-intro, home-about…)
      └── ContentBlock (title, text_1, image…)
```

Le contrôleur charge ces blocs dans `$sectionsContent`, et la vue affiche
`$sectionsContent['home-intro']['title']`, avec un texte par défaut si le
bloc est vide.
Les coordonnées de l'entreprise sont celles de l'utilisateur **n° 1**
(`$siteUser`), disponibles sur toutes les pages.

---

## Installation locale (XAMPP)

1. **Copier le projet** dans `C:\xampp\htdocs\siteVitrine`.
2. **Démarrer Apache et MySQL** dans le panneau XAMPP.
3. **Créer la base** : dans phpMyAdmin, créer `sitevitrineoflabim`
   (interclassement `utf8mb4_unicode_ci`), puis importer `sitevitrineoflabim.sql`.
4. **Configuration** : rien à faire. Sans fichier `config/configuration.local.php`,
   le site utilise les réglages XAMPP (`root` sans mot de passe, mode debug actif).
5. **Définir le mot de passe admin** (celui du fichier SQL n'est pas à utiliser) :

   ```powershell
   C:\xampp\php\php.exe scripts\changer_mot_de_passe.php
   ```

   Le script demande l'e-mail du compte puis le nouveau mot de passe
   (12 caractères minimum). Seul son hash est enregistré.

6. **Ouvrir le site** : <http://localhost/siteVitrine/index.php>
   et l'admin : <http://localhost/siteVitrine/index.php?page=login>

---

## Tests automatiques

Les tests ouvrent le site comme un navigateur et vérifient : les pages
publiques, les erreurs 404, la connexion et la sécurité du back-office,
l'enregistrement réel des contenus, le formulaire de contact, la protection
CSRF, le SEO, les obligations légales et le comparateur Réel / BIM.

**Ils ne touchent jamais la vraie base.** À chaque lancement, ils recréent une
base `sitevitrineoflabim_test` à partir du fichier SQL, démarrent leur propre
serveur PHP (port 8071), puis l'arrêtent.

**Première fois :** copier `tests/.env.local.example` en `tests/.env.local`
et y choisir un mot de passe admin de test (fichier ignoré par Git).

**Lancer :** démarrer **MySQL** dans XAMPP (Apache inutile), puis :

```powershell
cd C:\xampp\htdocs\siteVitrine
uv run --with pytest --with requests --with beautifulsoup4 pytest tests
```

Résultat attendu : tout en `passed`, plus **1 `xfailed`**. Ce test volontaire
rappelle que les mentions légales ne sont pas encore complétées ; il passera
en `xpassed` une fois les `[À COMPLÉTER]` remplis.

---

## Mise en ligne

Prévu pour un **hébergement mutualisé** PHP + MySQL avec Apache
(OVHcloud, o2switch…). Le compte d'hébergement et le nom de domaine sont
**au nom du client**.

1. **Base de données** : la créer dans le panneau de l'hébergeur, puis y
   importer un export phpMyAdmin de la base locale.
2. **Réglages du serveur** : sur le serveur uniquement, copier
   `config/configuration.local.example.php` en `config/configuration.local.php`
   et y mettre les accès MySQL de l'hébergeur, avec `DEBUG = false`.
   Ce fichier est ignoré par Git : les mots de passe ne vont jamais sur GitHub.
3. **Envoyer les fichiers** dans le dossier web (`www/` ou `public_html/`),
   par FTP (FileZilla) ou par Git depuis le panneau de l'hébergeur.
   Ne pas envoyer : `tests/`, `.git/`, `CODE_COMPLET.txt`, `exporter_code.ps1`.
4. **HTTPS** : activer le certificat gratuit (Let's Encrypt) dans le panneau.
   Le `.htaccess` redirige ensuite automatiquement `http://` vers `https://`.
5. **Mot de passe admin** : en définir un nouveau, solide, pour le client.
6. **Vérifier** : toutes les pages, le formulaire de contact (réception de
   l'e-mail), la connexion admin et l'envoi d'une image.

Les chemins d'images s'adaptent seuls (fonction `url_asset()`) : le site marche
dans `localhost/siteVitrine/` comme à la racine d'un domaine.

---

## Sécurité

| Protection | Où |
|---|---|
| Mots de passe hachés (bcrypt), jamais dans le code ni dans Git | `scripts/changer_mot_de_passe.php`, `authController.php` |
| Jeton CSRF sur tous les formulaires | `lib/foncBase.php` (`csrf_field()`, `csrf_verify()`) |
| Session régénérée à la connexion, cookie `HttpOnly`, `SameSite`, `Secure` en HTTPS | `index.php`, `authController.php` |
| Requêtes SQL préparées (PDO) | `models/` |
| Affichage échappé (`htmlspecialchars`) contre le XSS | `views/` |
| Images vérifiées à l'envoi | `lib/ImageUpload.php` |
| Erreurs PHP masquées en ligne (`DEBUG = false`) | `config/`, `index.php` |
| Fichiers et dossiers sensibles inaccessibles (`.sql`, `config/`, `.git/`…) | `.htaccess` |
| Aucun script exécutable dans le dossier des images | `assets/images/.htaccess` |
| Anti-robot et anti-injection d'en-têtes sur le formulaire de contact | `contactController.php` |

---

## Travailler avec Git

| Branche | Rôle |
|---|---|
| `develop` | Travail au quotidien : toutes les modifications se font ici |
| `main` | Version en ligne : ne reçoit que des fusions depuis `develop` |

```powershell
# Au quotidien, sur develop
git add -A
git commit -m "feat: ..."
git push origin develop

# Publier une version
git checkout main
git merge develop --no-ff -m "release: ..."
git push origin main
git checkout develop
```

Jamais dans Git (voir `.gitignore`) : `config/*.local.php`, `tests/.env.local`,
`.vscode/`, `CODE_COMPLET.txt`, `exporter_code.ps1`.

---

## Modifier le site

- **Textes et images gérés par l'admin** : passer par le back-office.
- **Image de fond d'un bandeau** : variable `$heroImage` en haut de la vue
  (`views/accueil.php`, `presentation.php`, `service.php`, `contact.php`).
- **Images du comparateur Réel / BIM** : remplacer
  `assets/images/comparateur-reel.png` et `comparateur-bim.png` par deux images
  **de même taille et même cadrage**. Les repères (`ofl-pin`) sont placés en %
  de l'image, à replacer si le cadrage change.
- **Ajouter une page** : créer la vue dans `views/`, ajouter son nom dans
  `$publicPages` (`index.php`) et son titre / description SEO dans
  `controllers/homeController.php`.
- **Style** : tout est dans `assets/css/style.css`. Les blocs de l'accueil
  sont préfixés `ofl-`, l'admin est limité à `.admin-shell`.
- Après chaque modification : relancer les tests.

---

## Reste à faire avant livraison

- [ ] Compléter les `[À COMPLÉTER]` de `views/mentions.php` (forme juridique,
      SIRET, RCS, TVA, directeur de publication, hébergeur).
- [ ] Remplacer, si possible, les visuels du comparateur par une vraie photo
      et la vue Revit d'un projet OFLABIM.
- [ ] Vérifier que les témoignages affichés correspondent à de vrais clients.
- [ ] Mettre en ligne (voir [Mise en ligne](#mise-en-ligne)) et définir le
      mot de passe admin du client.

### Évolutions possibles (hors contrat actuel)

- Administration de la page Services
- Liste des messages reçus par le formulaire de contact dans l'admin
- Plusieurs comptes administrateurs
- Envoi des e-mails par SMTP (meilleure délivrabilité que `mail()`)