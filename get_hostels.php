<?php

include('db_connect.php');

try {
    $stmt = $conn -> query('SELECT * FROM hostels');
    $hostels = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    header("Content-Type: application/json");
    echo json_encode($hostels);
    
} catch(PDOException $e) {
    echo "Connection failed: " . $e -> getMessage();
}



// HELlo

$conn = null;

?>