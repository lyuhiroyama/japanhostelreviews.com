<?php
include('header.php');
include('db_connect.php');

// Get the hostel ID from the URL in each hostel's anchor tag
$hostel_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch hostel details
$stmt = $conn->prepare("SELECT * FROM hostels WHERE id = :id");
$stmt->bindParam(':id', $hostel_id, PDO::PARAM_INT);
$stmt->execute();
$hostel = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch hostel reviews
// $review_stmt = $conn->prepare("SELECT * FROM reviews WHERE hostel_id = :id");
// $review_stmt->bindParam(':id', $hostel_id, PDO::PARAM_INT);
// $review_stmt->execute();
// $reviews = $review_stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($hostel['name']); ?> - Hostel Reviews</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .panel-container {
            display: flex;
            justify-content: space-between;
            height: auto;
            margin-top: 60px;
        }
        .center-panel {
            margin-left: 250px;
            flex-grow: 1; /* Fills rest of the space. Without this center-panel shortens in width. */
            display: flex;
            justify-content: center;
        }
        
    </style>
</head>

<body>
    <div class="panel-container">

        <?php include('left_panel.php'); ?>
        <div class="center-panel">
            <div class="hostel-info">
                <h2><?php echo htmlspecialchars($hostel['name']); ?></h2>
                <p><?php echo htmlspecialchars($hostel['description']); ?></p>
                <p>Location: <?php echo htmlspecialchars($hostel['location']); ?></p>
                <p>Price Range: <?php echo htmlspecialchars($hostel['price_range']); ?></p>
                <p>Rating: <?php echo htmlspecialchars($hostel['rating']); ?></p>
                <img src="<?php echo htmlspecialchars($hostel['thumbnail']); ?>" style="max-width: 300px;">
            </div>
        </div>
        <?php include('right_panel.php'); ?>
    </div>


    
    <!-- <h3>Reviews</h3>
    <div id="reviews">
        <?php if ($reviews): ?>
            <?php foreach ($reviews as $review): ?>
                <div class="review">
                    <p><strong><?php echo htmlspecialchars($review['user_name']); ?></strong> rated it <?php echo htmlspecialchars($review['rating']); ?>/5</p>
                    <p><?php echo htmlspecialchars($review['review_text']); ?></p>
                    <p><em>Posted on <?php echo htmlspecialchars($review['date_posted']); ?></em></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No reviews yet.</p>
        <?php endif; ?>
    </div> -->
</body>
</html>
