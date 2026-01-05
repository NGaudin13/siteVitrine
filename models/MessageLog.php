<?php
// Modèle messageLog
function writeToLog($message) {
    // Spécifiez le chemin vers votre fichier de log
    $logFile = 'C:/xampp/htdocs/wwwlaurie/var/messageLog.log';

    // Ajoutez la date et l'heure actuelles au message
    $message = date('Y-m-d H:i:s') . ' - ' . $message;

    // Écrivez le message dans le fichier de log
    file_put_contents($logFile, $message . PHP_EOL, FILE_APPEND);
}
