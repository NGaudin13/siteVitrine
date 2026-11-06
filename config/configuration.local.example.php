<?php
// =========================================================
// FICHIER : siteVitrine/config/configuration.local.example.php
// MODÈLE des réglages du serveur en ligne.
//
// 1) Copier ce fichier SUR LE SERVEUR sous le nom :
//        config/configuration.local.php
// 2) Remplacer les valeurs par celles de l'hébergeur
//    (panneau d'hébergement > Bases de données).
//
// configuration.local.php est ignoré par Git : les mots de passe
// ne partent jamais sur GitHub.
// =========================================================

const DEBUG = false;                       // en ligne : toujours false

const BD_HOST   = 'adresse-du-serveur-mysql';   // ex : localhost, ou xxxxx.mysql.db chez OVH
const BD_DBNAME = 'nom_de_la_base';
const BD_USER   = 'utilisateur_mysql';
const BD_PWD    = 'mot_de_passe_mysql';