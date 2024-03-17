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
    $taskId = isset($_POST['taskId']) ? $_POST['taskId'] : '';
    $newState = isset($_POST['newState']) ? $_POST['newState'] : '';

    // Mettre à jour l'état de la tâche dans la base de données
    $sql = "UPDATE taches SET statut = '$newState' WHERE id = $taskId";
    
    if ($conn->query($sql) === TRUE) {
        $responseData = array('success' => true);
        echo json_encode($responseData);
    } else {
        http_response_code(500); // Erreur interne du serveur
        echo json_encode(array('error' => 'Erreur lors de la mise à jour de l\'état de la tâche dans la base de données.'));
    }

    // Fermer la connexion à la base de données
    $conn->close();
} else {
    // Méthode non autorisée
    http_response_code(405); // Méthode non autorisée
    echo json_encode(array('error' => 'Méthode non autorisée'));
}
?>
