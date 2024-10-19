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

    // Get data from the form
    $user_name = htmlspecialchars($_POST['user_name']);
    $review_text = htmlspecialchars($_POST['review_text']);
    

    // Insert the review into the database
    $insert_stmt = $conn->prepare("INSERT INTO reviews (hostel_id, user_name, review_text) VALUES (:hostel_id, :user_name, :review_text)");
    $insert_stmt->bindParam(':hostel_id', $hostel_id, PDO::PARAM_INT);
    $insert_stmt->bindParam(':user_name', $user_name, PDO::PARAM_STR);
    $insert_stmt->bindParam(':review_text', $review_text, PDO::PARAM_STR);
    $insert_stmt->execute(); // Remember to set parent dir permission mode -> 777, and db files to -> 775.
    
    
    // Redirect to the same page to avoid resubmission on refresh
    header("Location: hostel_details.php?id=$hostel_id");
    exit();
}



// Fetch hostel details
$stmt = $conn->prepare("SELECT * FROM hostels WHERE id = :id");
$stmt->bindParam(':id', $hostel_id, PDO::PARAM_INT);
$stmt->execute();
$hostel = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($hostel['name']); ?> - Hostel Reviews</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"> <!-- import Google Material Icons -->
    <link rel="stylesheet" href="styles.css">
    <style>
        
        .panel-container {
            display: flex;
            justify-content: space-between;
            min-height: 100vh;
            margin-top: 60px;
            background-color: #faf8f2; 
        }
        .center-panel {
            margin-left: 270px;
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

        #review-form {
            display: flex;
            flex-direction: column;
            width: 100%; /* 100% of its container */
            max-width: 750px;
        }

        #review-form #username-input {
            width: 200px;
            height: 40px;
            border-radius: 25px; 
            padding-left: 18px;
        }


        #review-form #review-input {            
            border-radius: 25px; 
            border: 1px solid #bababa;
            padding: 10px 20px;
            width: 100%; /* 100% of its container */
            max-width: 750px;
            height: 40px;
            margin: 10px 0;
        }

        #review-form #submit-button {
            width: 120px;
            height: 30px;
            border-radius: 25px; 
        }

        #review-form #submit-button:hover {
            background-color: #d69d11;
        }

        #reviews {
            margin: 20px;
            width: 100%;
            max-width: 750px;
        }

        .review {
            margin: 30px 0;
        }

        .review-voting-container button {
            color: #a3780d;
            font-size: 20px;
            border: none;
            background-color: transparent;
            width: 30px;
            height: 30px;
        }

        .review-voting-container button:hover {
            background-color: #f3e7ca;
            border-radius: 10px;
        }

        .review-voting-container span {
            margin: 0 2px; /* Spacing */
        }

        /* .review-voting-container button.active-upvote {
            color: red;
            background-color: #f3e7ca;
            border-radius: 10px;
        }

        .review-voting-container button.active-downvote {
            color: blue;
            background-color: #f3e7ca;
            border-radius: 10px;
        } */

       

        .hostel-info-right-panel {
            height: 100%;
            margin: 20px 20px;
            padding: 30px;
            border-radius: 15px;
            background-color: #f7efda; /* For stronger orange-yellow: #f3e7ca */
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

            <!-- Review submission form -->
            <form id="review-form" method="POST" action="hostel_details.php?id=<?php echo $hostel_id; ?>">
                <input id="username-input" type="text" name="user_name" placeholder="Display Name" autocomplete="off" required>
                <textarea id="review-input" name="review_text" placeholder="Add a review" required></textarea>
                <button id="submit-button" type="submit">Submit Review</button>
            </form>

            <!-- Reviews -->
            <div id="reviews"></div>

        </div>
        
        <!-- Right panel -->
        <div class="hostel-info-right-panel">
            <h3><?php echo htmlspecialchars($hostel['name']); ?></h2>
            <p><?php echo htmlspecialchars($hostel['description']); ?></p>
            <p>Location: <?php echo htmlspecialchars($hostel['location']); ?></p>
            <p>Price Range: <?php echo htmlspecialchars($hostel['price_range']); ?></p>
        </div>

    </div>


    <script>

    // Fetch reviews via AJAX
    function fetchReviews() {
        $.getJSON('get_reviews.php?id=<?php echo $hostel_id ?>', function(reviews) {
            $('#reviews').empty();
            if (reviews.length > 0) {
                reviews.forEach(review => {
                    $('#reviews').append(`
                        <div class="review">
                            <p><strong>${review.user_name}</strong>  <em>${review.date_posted}</em></p>
                            <p>${review.review_text}</p>
                            <div class="review-voting-container" data-id="${review.id}">
                                <button class="upvote" data-id="${review.id}">⬆</button>
                                <span class="vote-count">${review.upvote - review.downvote}</span>
                                <button class="downvote" data-id="${review.id}">⬇</button>
                            </div>
                        </div>
                    `)
                })
                bindVoteButtons();
            } else {
                $('#reviews').html('<p>No reviews yet.</p>');
            }
        })
    } // endof fetchReviews()

    // Function which binds event listeners to vote buttons:
    function bindVoteButtons() {
        $('.upvote').click(function () {
            // $(this).addClass('active-upvote');
            const reviewId = $(this).data('id');
            if (trackVote(reviewId, 'upvote')) updateVote(reviewId, 'upvote');
        });

        $('.downvote').click(function () {
            // $(this).addClass('active-downvote');
            const reviewId = $(this).data('id');
            if (trackVote(reviewId, 'downvote')) updateVote(reviewId, 'downvote');
        });
    } // endof bindVoteButtons()

    // Track review votes in localStorage:
    function trackVote(reviewId, voteType) {
        let voteKey = `reviewVote_${reviewId}`;
        if (!localStorage.getItem(voteKey)) {
            localStorage.setItem(voteKey, voteType);
            return true;
        }
        return false;
     } // endof trackVote()

    // Update review vote count via AJAX then refresh review:
    function updateVote(reviewId, voteType) {
        $.post('update_review_votes.php', {id: reviewId, vote: voteType}, () => {
            fetchReviews();
        }, 'json');
    } // endof updateVote()

    $(document).ready(function() {
        fetchReviews();
    });

    </script>

</body>
</html>
