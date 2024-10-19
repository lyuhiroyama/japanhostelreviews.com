<?php

include('db_connect.php');

// Get hodtel ID via query parameter:
$hostel_id = isset($_GET['id']) ? intval($_GET['id']) : 0; 

// Get reviewLimit / reviewOffset via query parameter:
$reviewLimit = isset($_GET['reviewLimit']) ? intval($_GET['reviewLimit']) : 10;
$reviewOffset = isset($_GET['reviewOffset']) ? intval($_GET['reviewOffset']) : 0;

try {
    $stmt = $conn -> prepare('SELECT * FROM reviews WHERE hostel_id = :hostel_id LIMIT ' . $reviewLimit . ' OFFSET ' . $reviewOffset); 
    $stmt -> bindParam(':hostel_id', $hostel_id, PDO::PARAM_INT);
    $stmt -> execute();
    $reviews = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    header("Content-Type: application/json");
    echo json_encode($reviews);
    
} catch(PDOException $e) {
    echo "Connection failed: " . $e -> getMessage();
}



$conn = null;

?>