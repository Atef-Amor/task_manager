<?php
include('db.php');  // Connexion à la base de données

// Vérifier si l'ID est passé en paramètre dans l'URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Supprimer la tâche de la base de données
    $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->execute([$id]);

    // Redirection vers la page d'accueil après suppression
    header('Location: index.php');
    exit;
} else {
    die('ID de la tâche manquant.');
}
