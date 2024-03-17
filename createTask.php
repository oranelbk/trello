<?php
header('Content-Type: application/json');

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = ""; // Mettez ici le mot de passe si vous l'avez défini
$dbname = "trello";

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du POST
    $taskTitle = isset($_POST['taskTitle']) ? $_POST['taskTitle'] : '';
    $taskDescription = isset($_POST['taskDescription']) ? $_POST['taskDescription'] : '';

    // Vérifier si le titre de la tâche n'est pas vide avant d'effectuer la requête
    if (!empty($taskTitle)) {
        // Ajouter la tâche à la base de données
        $sql = "INSERT INTO taches (titre, description, statut) VALUES ('$taskTitle', '$taskDescription', 'todo')";
        if ($conn->query($sql) === TRUE) {
            $taskId = $conn->insert_id;
            $responseData = array('id' => $taskId, 'title' => $taskTitle, 'description' => $taskDescription, 'status' => 'todo');
            echo json_encode($responseData);
        } else {
            http_response_code(500); // Erreur interne du serveur
            echo json_encode(array('error' => 'Erreur lors de l\'ajout de la tâche à la base de données.'));
        }
    } else {
        http_response_code(400); // Requête incorrecte
        echo json_encode(array('error' => 'Le titre de la tâche ne peut pas être vide.'));
    }

    // Fermer la connexion à la base de données
    $conn->close();
} else {
    // Méthode non autorisée
    http_response_code(405); // Méthode non autorisée
    echo json_encode(array('error' => 'Méthode non autorisée'));
}
?>
