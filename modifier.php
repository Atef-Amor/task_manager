<?php
include('db.php');  // Connexion à la base de données

// Vérifier si l'ID est passé en paramètre dans l'URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Récupérer les données de la tâche à modifier
    $stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ?");
    $stmt->execute([$id]);
    $task = $stmt->fetch();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $description = $_POST['description'];
        $deadline = $_POST['deadline'];

        // Mettre à jour la tâche dans la base de données
        $stmt = $pdo->prepare("UPDATE tasks SET description = ?, deadline = ? WHERE id = ?");
        $stmt->execute([$description, $deadline, $id]);

        // Redirection vers la page d'accueil après modification
        header('Location: index.php');
        exit;
    }
} else {
    die('ID de la tâche manquant.');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier une Tâche</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <h1>Modifier la tâche</h1>

    <form action="modifier.php?id=<?php echo $task['id']; ?>" method="POST">
        <label for="description">Description de la tâche</label>
        <input type="text" name="description" id="description" value="<?php echo htmlspecialchars($task['description']); ?>" required>

        <label for="deadline">Deadline</label>
        <input type="date" name="deadline" id="deadline" value="<?php echo htmlspecialchars($task['deadline']); ?>" required>

        <button type="submit">Mettre à jour</button>
    </form>
</body>
</html>
