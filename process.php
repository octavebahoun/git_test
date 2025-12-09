<?php
require __DIR__ . '/config.php';

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
    echo "Ticket inconnu 🚫";
    exit;
}

// Si le ticket existe
if ($ticket['used'] == 1) {
    echo "Ticket déjà utilisé ❌";
} else {
    $update = $pdo->prepare("UPDATE tickets SET used = 1 WHERE token = ?");
    $update->execute([$token]);

    echo "Ticket validé ✔️";
}
