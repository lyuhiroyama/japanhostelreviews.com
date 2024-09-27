<?php
    include('db_connect.php');

    $sql = "SELECT * FROM hostels ORDER BY rating DESC";
    $result = mysqli_query($conn, $sql);

    $hostels = [];

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $hostels[] = $row;
        }
    }

    header('Content-Type: application/json');
    echo json_encode($hotels);


    mysqli_close($conn);
?>