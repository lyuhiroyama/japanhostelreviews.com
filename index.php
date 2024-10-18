<?php

include("header.php"); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Japan Hostel Reviews</title>
    <link rel="stylesheet" href="styles.css">
    <style>
    .panel-container {
        display: flex;
        justify-content: space-between;
        height: auto;
        margin-top: 60px;
        background-color: #faf8f2; 
    }
    </style>
</head>
<body>
    <div class="panel-container">
        
            <?php include 'left_panel.php';?>
            <?php include 'center_panel.php';?>
            <?php include 'right_panel.php';?>

        
    </div>
</body>
</html>
