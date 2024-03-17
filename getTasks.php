<?php
header('Content-Type: application/json');

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = ""; // Mot de passe Windows par défaut
$dbname = "trello";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

// Récupération des tâches par statut
$tasks = array('todo' => array(), 'inProgress' => array(), 'done' => array());

$sql = "SELECT id, titre, description, statut FROM taches";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $task = array('id' => $row['id'], 'title' => $row['titre'], 'description' => $row['description']);

        switch ($row['statut']) {
            case 'todo':
                $tasks['todo'][] = $task;
                break;
            case 'inProgress':
                $tasks['inProgress'][] = $task;
                break;
            case 'done':
                $tasks['done'][] = $task;
                break;
            default:
                break;
        }
    }
}

$conn->close();

echo json_encode($tasks);
?>
