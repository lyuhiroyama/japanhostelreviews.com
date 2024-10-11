<?php

ini_set('display_errors', 1); // These three lines displays errors in the output
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('header.php');
include('db_connect.php');


// Get the hostel ID from the URL in each hostel's anchor tag
$hostel_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Handle the review submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get the data from the form
    $user_name = htmlspecialchars($_POST['user_name']);
    $rating = intval($_POST['rating']);
    $review_text = htmlspecialchars($_POST['review_text']);

    echo $hostel_id;
    echo $user_name;
    echo $rating;
    echo $review_text;
    

    // Insert the review into the database
    $insert_stmt = $conn->prepare("INSERT INTO reviews (hostel_id, user_name, rating, review_text) VALUES (:hostel_id, :user_name, :rating, :review_text)");
    $insert_stmt->bindParam(':hostel_id', $hostel_id, PDO::PARAM_INT);
    $insert_stmt->bindParam(':user_name', $user_name, PDO::PARAM_STR);
    $insert_stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
    $insert_stmt->bindParam(':review_text', $review_text, PDO::PARAM_STR);
    $insert_stmt->execute();
    
    
    // Redirect to the same page to avoid resubmission on refresh
    header("Location: hostel_details.php?id=$hostel_id");
    exit();
}



// Fetch hostel details
$stmt = $conn->prepare("SELECT * FROM hostels WHERE id = :id");
$stmt->bindParam(':id', $hostel_id, PDO::PARAM_INT);
$stmt->execute();
$hostel = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch hostel reviews
$review_stmt = $conn->prepare("SELECT * FROM reviews WHERE hostel_id = :id");
$review_stmt->bindParam(':id', $hostel_id, PDO::PARAM_INT);
$review_stmt->execute();
$reviews = $review_stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($hostel['name']); ?> - Hostel Reviews</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"> <!-- import Google Material Icons -->
    <link rel="stylesheet" href="styles.css">
    <style>
        .panel-container {
            display: flex;
            justify-content: space-between;
            height: 100%;
            margin-top: 60px;
        }
        .center-panel {
            margin-left: 270px;
            height: 100%;
            flex-grow: 1; /* Fills rest of the space. Without this center-panel shortens in width. */
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .hostel-info {
            padding: 30px;
        }

        h2 { /* hostel title (center panel) */
            padding: 20px;
        }

        .hostel-info-center img {
            padding-bottom: 15px;
            width: 100%; /* 100% of its container */
            max-width: 750px;
        }

        #review-input {            
            border-radius: 25px; 
            border: 1px solid #bababa;
            padding: 10px 20px;
            width: 100%; /* 100% of its container */
            max-width: 750px;
            height: 40px;
        }

        #reviews {
            margin: 20px;
            width: 100%;
            max-width: 750px;
        }

        .review {
            margin: 30px 0;
        }

        .review-header {
            display: flex;
        }

        .hostel-info-right-panel {
            height: 100%;
            margin: 20px 20px;
            padding: 30px;
            border-radius: 15px;
            background-color: #f9f5ea; /* For stronger orange-yellow: #f3e7ca */
            width: 250px; 
        }

        .hostel-info-right-panel h3 {
            margin-bottom: 10px;
        }

        .hostel-info-right-panel p {
            padding: 10px;
        }
        
    </style>
</head>

<body>
    <div class="panel-container">

        <?php include('left_panel.php'); ?>

        <div class="center-panel">

            <div class="hostel-info-center">
                <h2><?php echo htmlspecialchars($hostel['name']); ?></h2>
                <img src="<?php echo htmlspecialchars($hostel['thumbnail']); ?>">
            </div>

            <!-- <input id="review-input" type="text" placeholder="Add a review"> -->

            <!-- Review submission form -->
            <form id="review-form" method="POST" action="hostel_details.php?id=<?php echo $hostel_id; ?>">
                <input type="text" name="user_name" placeholder="Your Name" required>
                <input type="number" name="rating" placeholder="Rating (1-5)" min="1" max="5" required>
                <textarea name="review_text" placeholder="Write your review..." required></textarea>
                <button type="submit">Submit Review</button>
            </form>


            <div id="reviews">
                <?php if ($reviews): ?>
                <?php foreach ($reviews as $review): ?>
                    <div class="review">
                        <div class="review-header">
                            <span class="material-symbols-outlined">person</span><p><strong><?php echo htmlspecialchars($review['user_name']); ?></strong></p>
                            <p><em>Posted on <?php echo htmlspecialchars($review['date_posted']); ?></em></p>
                        </div>
                        <p><?php echo htmlspecialchars($review['review_text']); ?></p>
                    </div>
                <?php endforeach; ?>
                <?php else: ?>
                    <p>No reviews yet.</p>
                <?php endif; ?>

            </div>

        </div>

        <div class="hostel-info-right-panel">
            <h3><?php echo htmlspecialchars($hostel['name']); ?></h2>
            <p><?php echo htmlspecialchars($hostel['description']); ?></p>
            <p>Location: <?php echo htmlspecialchars($hostel['location']); ?></p>
            <p>Price Range: <?php echo htmlspecialchars($hostel['price_range']); ?></p>
            <p>Rating: <?php echo htmlspecialchars($hostel['rating']); ?></p>
        </div>

    </div>


    

</body>
</html>
