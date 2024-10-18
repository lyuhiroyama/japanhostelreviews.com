<?php

include('db_connect.php');

// Get hodtel ID from query parameter:
$hostel_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

try {
    $stmt = $conn -> query('SELECT * FROM reviews WHERE hostel_id = :hostel_id');
    $stmt -> bindParam(':hostel_id', $_hostel_id, PDO::PARAM_INT);
    $stmt -> execute();
    $reviews = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    header("Content-Type: application/json");
    echo json_encode($reviews);
    
} catch(PDOException $e) {
    echo "Connection failed: " . $e -> getMessage();
}



$conn = null;

?>