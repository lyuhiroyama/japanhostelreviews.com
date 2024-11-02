<?php

include('db_connect.php');

$query = isset($_GET['q']) ? $_GET['q'] : '';

try {
    $stmt = $conn->prepare('SELECT * FROM hostels WHERE name LIKE :query OR location LIKE :query');
    $searchTerm = '%' . $query . '%';
    $stmt->bindParam(':query', $searchTerm, PDO::PARAM_STR);
    $stmt->execute();
    $hostels = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    header("Content-Type: application/json");
    echo json_encode($hostels);
    
} catch(PDOException $e) {
    echo "Connection failed: " . $e -> getMessage();
}



$conn = null;

?>