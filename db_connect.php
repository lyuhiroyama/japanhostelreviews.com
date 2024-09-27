<?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "hostel_reviews";

    try {
        $conn = mysqli_connect($servername, $username, $password, $dbname);
    } catch(mysqli_sql_exception) {
        echo "Could not connect to database";
    }

?>