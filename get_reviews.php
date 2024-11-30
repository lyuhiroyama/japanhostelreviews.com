<?php

include('db_connect.php');

// Get hostel ID via query parameter:
$hostel_id = isset($_GET['id']) ? intval($_GET['id']) : 0; 

// Get reviewLimit / reviewOffset via query parameter:
$reviewLimit = isset($_GET['reviewLimit']) ? intval($_GET['reviewLimit']) : 10;
$reviewOffset = isset($_GET['reviewOffset']) ? intval($_GET['reviewOffset']) : 0;

try {
    $stmt = $conn->prepare('SELECT * FROM reviews WHERE hostel_id = :hostel_id LIMIT ' . $reviewLimit . ' OFFSET ' . $reviewOffset); 
    $stmt->bindParam(':hostel_id', $hostel_id, PDO::PARAM_INT);
    $stmt->execute();
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Format the date to ISO 8601.
    // This is an attempt to fix the mobile-displaying-'NaNy'-as-dates problem. Not yet sure if it works.
    foreach ($reviews as &$review) {
        $date = new DateTime($review['date_posted']);
        $review['date_posted'] = $date->format(DateTime::ATOM); // ISO 8601 format
    }

    header("Content-Type: application/json");
    echo json_encode($reviews);
    
} catch(PDOException $e) {
    echo "Connection failed: " . $e -> getMessage();
}



$conn = null;

?>