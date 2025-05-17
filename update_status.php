<?php
include('db.php');  // Connexion à la base de données

// Vérifier si l'ID de la tâche est passé et si le statut est spécifié
if (isset($_POST['id']) && isset($_POST['status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'] == 'on' ? 1 : 0;  // Convertir le statut à 1 pour "terminée" et 0 pour "non terminée"

    // Mettre à jour le statut de la tâche
    $stmt = $pdo->prepare("UPDATE tasks SET status = ? WHERE id = ?");
    $stmt->execute([$status, $id]);
}

// Rediriger vers la page d'accueil après la mise à jour
header('Location: index.php');
exit;
