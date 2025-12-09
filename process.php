<?php
// Afficher les erreurs PHP
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config.php';

// Connexion PDO sécurisée
try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$db;charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Vérifier si un token est envoyé
if (!isset($_POST['token'])) {
    die("Aucun token reçu.");
}

$token = $_POST['token'];

// Chercher le ticket dans la base
$stmt = $pdo->prepare("SELECT used FROM tickets WHERE token = ?");
$stmt->execute([$token]);
$ticket = $stmt->fetch();

// Gestion des cas

if (!$ticket) {
    // Le token n’existe pas du tout
    echo "Ticket inconnu 🚫";
    exit;
}

// Si le ticket existe :
if ($ticket['used'] == 1) {
    // Déjà utilisé
    echo "Ticket déjà utilisé ❌";
} else {
    // Ticket valide → on le marque utilisé
    $update = $pdo->prepare("UPDATE tickets SET used = 1 WHERE token = ?");
    $update->execute([$token]);

    echo "Ticket validé ";
}
?>
