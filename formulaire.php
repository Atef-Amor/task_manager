<?php
include('db.php');  // Connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $description = $_POST['description'];
    $deadline = $_POST['deadline'];

    // Insérer la nouvelle tâche dans la base de données
    $stmt = $pdo->prepare("INSERT INTO tasks (description, deadline, status) VALUES (?, ?, 0)");
    $stmt->execute([$description, $deadline]);

    // Redirection vers la page d'accueil après l'ajout
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Tâche</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <div class="container">
        <h1>Ajouter une nouvelle tâche</h1>

        <form action="formulaire.php" method="POST" class="task-form">
            <label for="description">Description de la tâche</label>
            <input type="text" name="description" id="description" required>

            <label for="deadline">Deadline</label>
            <input type="date" name="deadline" id="deadline" required>

            <button type="submit">Ajouter</button>
        </form>
    </div>
</body>
</html>

