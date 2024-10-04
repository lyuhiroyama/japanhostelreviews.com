<?php

include("header.php"); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Japan Hostel Reviews</title>
</head>
<body>
    <div class="panel-container">
        
            <?php include 'left_panel.php';?>
            <div class="body-panel">
            </div>
            <?php include 'right_panel.php';?>

        
    </div>

    

    <script>
        // Fetch & Dipslay hostels
        function fetchHostels() {
            $.getJSON('get_hostels.php', function(hostels) {
                $('#hostel-list').empty();
                hostels.forEach(hostel => {
                    $('.body-panel').append(`
                        <div class="hostel-container">
                            <a href="hostel_details.php?id=${hostel.id}">
                                <div class="hostel">
                                    <div class="hostel-info">
                                        <h3>${hostel.name}</h3>
                                        <p>${hostel.description}</p>
                                        <p>Location: ${hostel.location}</p>
                                        <p>Price Range: ${hostel.price_range}</p>
                                        <p>Rating: ${hostel.rating}</p>
                                    </div>
                                    <img src="${hostel.thumbnail}" class="thumbnail">
                                </div>
                            </a>
                        </div>
                    `)
                })
            })
        }

        $(document).ready(fetchHostels);
        
    </script>
</body>
</html>
