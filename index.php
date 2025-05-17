<?php
// Connexion à la base de données
include('db.php');  // Fichier de connexion à la base de données

// Filtrer les tâches par statut si nécessaire
$status_filter = '';
if (isset($_GET['status'])) {
    $status_filter = $_GET['status'] === 'completed' ? "WHERE status = 1" : "WHERE status = 0";
}

// Récupérer toutes les tâches depuis la base de données
$query = "SELECT * FROM tasks $status_filter";
$stmt = $pdo->query($query);

// Récupérer les résultats sous forme de tableau associatif
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Tâches</title>
    <style>
        /* Style global pour le corps de la page */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        /* Style pour le titre principal */
        h1 {
            background-color: #007BFF;
            color: white;
            padding: 20px;
            text-align: center;
            margin: 0;
        }

        /* Style du lien "Ajouter une tâche" */
        a {
            text-decoration: none;
            color: #007BFF;
            padding: 10px 20px;
            background-color: #f8f9fa;
            border-radius: 5px;
            display: inline-block;
            margin: 20px 0;
        }

        a:hover {
            background-color: #007BFF;
            color: white;
        }

        /* Style pour l'alerte dynamique */
        #dynamicAlert {
            display: none;
            padding: 15px;
            background-color: #FFDDC1;
            color: #D8000C;
            border: 2px solid #D8000C;
            margin-bottom: 20px;
            text-align: center;
            font-size: 18px;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Style pour la table */
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Style pour les en-têtes de table */
        th {
            background-color: #007BFF;
            color: white;
            padding: 12px 15px;
            font-size: 16px;
            text-align: left;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        /* Style pour les cellules de la table */
        td {
            padding: 12px 15px;
            font-size: 14px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        /* Style pour les lignes de la table 
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }*/
        

 

        /* Style pour les liens "Modifier" et "Supprimer" */
        a {
            color: #007BFF;
            text-decoration: none;
            margin-right: 10px;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Style pour les cases à cocher */
        input[type="checkbox"] {
            margin-left: 10px;
        }

        /* Style pour les liens de filtrage de tâches */
        div {
            text-align: center;
            margin-bottom: 20px;
        }

        div a {
            margin: 0 15px;
            padding: 8px 12px;
            background-color: #f1f1f1;
            border-radius: 5px;
        }

        div a:hover {
            background-color: #007BFF;
            color: white;
        }
               /* Style pour les tâches avec un deadline proche */
               .red {
            background-color: red; /* Tomate */
            color: white;
        }
    </style>
</head>
<body>
    <h1>Liste des Tâches</h1>
    <a href="formulaire.php">Ajouter une tâche</a>

    <!-- Alerte dynamique -->
    <div id="dynamicAlert"></div>

    <!-- Filtrer par statut -->
    <div>
        <a href="index.php?status=completed">Tâches terminées</a> | 
        <a href="index.php?status=pending">Tâches non terminées</a> | 
        <a href="index.php">Toutes les tâches</a>
    </div>

    <table>
        <tr>
            <th>Description</th>
            <th>Deadline</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
        <?php
        foreach ($tasks as $task) {
            // Vérifier si la deadline est inférieure à 2 jours
            $deadline = new DateTime($task['deadline']);
            $now = new DateTime();
            $interval = $now->diff($deadline);
            $is_deadline_near = ($interval->days <= 2 && $interval->invert == 0);

            // Calculer le statut de la tâche
            $status = $task['status'] == 1 ? 'Terminée' : 'Non terminée';
            $status_class = $task['status'] == 1 ? 'checked' : '';

            // Ajouter la classe "red" si la tâche a un deadline proche
            $row_class = $is_deadline_near ? 'red' : '';

            echo "<tr class='$row_class'>";
            echo "<td>" . htmlspecialchars($task['description']) . "</td>";
            echo "<td>" . htmlspecialchars($task['deadline']) . "</td>";
            echo "<td>" . $status;
            if ($is_deadline_near) {
                echo "<br><span class='alert'>Attention : deadline proche !</span>";
            }
            echo "</td>";

            // Liens pour modifier et supprimer la tâche
            echo "<td>
                    <a href='modifier.php?id=".$task['id']."'>Modifier</a>
                    <a href='supprimer.php?id=".$task['id']."'>Supprimer</a>
                    <form action='update_status.php' method='POST' style='display:inline'>
                        <input type='hidden' name='id' value='".$task['id']."'>
                        <input type='checkbox' name='status' " . ($status_class ? 'checked' : '') . " onclick='this.form.submit()'>
                    </form>
                </td>";
            echo "</tr>";
        }
        ?>
    </table>

    <!-- Script JavaScript pour l'alerte dynamique -->
    <script>
        // Fonction pour afficher un message d'alerte
        function showAlert(message) {
            var alertBox = document.getElementById("dynamicAlert");
            alertBox.style.display = "block"; // Afficher l'alerte
            alertBox.innerHTML = message; // Ajouter le message à l'alerte
        }

        // Vérifier les tâches avec un deadline proche (moins de 2 jours)
        var tasks = <?php echo json_encode($tasks); ?>;
        tasks.forEach(function(task) {
            var deadline = new Date(task.deadline);
            var now = new Date();
            var timeDiff = deadline - now;
            var twoDaysInMs = 2 * 24 * 60 * 60 * 1000; // Deux jours en millisecondes

            if (timeDiff <= twoDaysInMs && timeDiff >= 0) {
                // Afficher l'alerte si la deadline est proche
                showAlert("Attention : il y a des tâches dont le deadline approche !");
            }
        });
    </script>
</body>
</html>
