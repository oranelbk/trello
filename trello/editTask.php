<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = ""; // Mettez ici le mot de passe si vous l'avez défini
$dbname = "trello";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $taskId = isset($_POST['taskId']) ? $_POST['taskId'] : '';
    $taskTitle = isset($_POST['taskTitle']) ? $_POST['taskTitle'] : '';
    $taskDescription = isset($_POST['taskDescription']) ? $_POST['taskDescription'] : '';

    $sql = "UPDATE taches SET titre = '$taskTitle', description = '$taskDescription' WHERE id = $taskId";

    if ($conn->query($sql) === TRUE) {
        $responseData = array('success' => true);
        echo json_encode($responseData);
    } else {
        http_response_code(500);
        echo json_encode(array('error' => 'Erreur lors de la modification de la tâche dans la base de données.'));
    }

    $conn->close();
} else {
    http_response_code(405);
    echo json_encode(array('error' => 'Méthode non autorisée'));
}
?>
