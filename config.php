<?php

$host = getenv('MYSQLHOST');
$user = getenv('MYSQLUSER');
$pass = getenv('MYSQLPASSWORD');
$db   = getenv('MYSQLDATABASE');
$port = getenv('MYSQLPORT');

// Debug : afficher variables pour vérifier si elles existent
// Commenter après test
var_dump($host, $user, $db, $port);
// exit(); // décommenter pour stopper le script et tester le serveur seul

try {
    if ($host && $user && $db && $port) {
        $pdo = new PDO(
            "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4",
            $user,
            $pass,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );
    } else {
        // MySQL non configuré, créer un PDO factice pour ne pas planter
        $pdo = null;
    }
} catch (PDOException $e) {
    // Ne pas planter le serveur
    $pdo = null;
    error_log("Erreur de connexion PDO : " . $e->getMessage());
}
