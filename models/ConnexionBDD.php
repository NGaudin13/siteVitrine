<?php
function getbdd() {
    try {
        // Accès base de données
        $bdd = new PDO('mysql:host=' . BD_HOST . ';dbname=' . BD_DBNAME . ';charset=utf8', BD_USER, BD_PWD);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $bdd;
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}
