<?php
header('Content-Type: application/json');

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = ""; // Mot de passe Windows par défaut
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

  // Supprimer la tâche de la base de données
  $sql = "DELETE FROM taches WHERE id = $taskId";

  if ($conn->query($sql) === TRUE) {
    $responseData = array('success' => true);
    echo json_encode($responseData);
  } else {
    http_response_code(500); // Erreur interne du serveur
    echo json_encode(array('error' => 'Erreur lors de la suppression de la tâche dans la base de données.'));
  }

  // Fermer la connexion à la base de données
  $conn->close();
} else {
  // Méthode non autorisée
  http_response_code(405); // Méthode non autorisée
  echo json_encode(array('error' => 'Méthode non autorisée'));
}
?>
