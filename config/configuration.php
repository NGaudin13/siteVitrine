<?php

const DEBUG = true; // production : false | dev : true

/* ============================================================
   BASE DE DONNÉES
   ============================================================ */
const BD_HOST   = 'localhost';
const BD_DBNAME = 'sitevitrineoflabim';
const BD_USER   = 'root';
const BD_PWD    = '';
const BD_CHARSET = 'utf8mb4';

/* ============================================================
   LANGUE & INFOS SITE
   ============================================================ */
const LANG   = 'FR-fr';
const AUTEUR = 'GAUDIN';

/* ============================================================
   CHEMINS DU PROJET
   ============================================================ */
define('PATH_CONTROLLERS', './controllers/');
define('PATH_ENTITY',      './entities/');
define('PATH_ASSETS',      './assets/');
define('PATH_LIB',         './lib/');
define('PATH_MODELS',      './models/');
define('PATH_VIEWS',       './views/');
define('PATH_TEXTES',      './languages/');

/* Sous-dossiers assets */
define('PATH_CSS',     PATH_ASSETS . 'css/');
define('PATH_IMAGES',  PATH_ASSETS . 'images/');
define('PATH_SCRIPTS', PATH_ASSETS . 'scripts/');

/* ============================================================
   CHEMINS DU PROJET ADMIN
   ============================================================ */
define('PATH_VIEWS_ADMIN', './views/views_admin/');


/* ============================================================
   CONNEXION PDO
   ============================================================ */
try {

    $dsn = 'mysql:host=' . BD_HOST .
           ';dbname=' . BD_DBNAME .
           ';charset=' . BD_CHARSET;

    $pdo = new PDO($dsn, BD_USER, BD_PWD, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);

} catch (PDOException $e) {

    if (DEBUG) {
        die('Erreur connexion BDD : ' . $e->getMessage());
    } else {
        die('Erreur interne.');
    }
}
