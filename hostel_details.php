<?php

// ini_set('display_errors', 1); // These three lines displays errors in the output
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

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
            background-color: #fcfaf5; 
        }
        .center-panel {
            margin-left: 270px;
            flex-grow: 1; /* Fills rest of the space. Without this center-panel shortens in width. */
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .hostel-info-center h2 { /* hostel title (center panel) */
            padding: 20px;
        }

        .hostel-info-center img {
            padding-bottom: 15px;
            width: 100%; /* 100% of its container */
            max-width: 750px;
        }

        .hostel-info-center .hostel-voting-container2 {
            margin: 10px 0;
            width: fit-content; /* Adjusts width to fit its contents dynamically */
            border-radius: 50px;
            background-color: #e6deca;
            display: flex;
            align-items: center;
        }

        .hostel-info-center .hostel-voting-container2 button {
            color: #a3780d;
            font-size: 20px;
            border: none;
            background-color: transparent;
            width: 30px;
            height: 30px;
        }

        .hostel-info-center .hostel-voting-container2 button:hover {
            color: #ff0000;
            background-color: #f3e7ca;
            border-radius: 10px;
        }

        .hostel-info-center .hostel-voting-container2 span {
            margin: 0 2px; /* Spacing */
        }   



        #review-form {
            display: flex;
            flex-direction: column;
            width: 100%; /* 100% of its container */
            max-width: 750px;
        }


        #review-form #review-input {            
            border-radius: 25px; 
            border: 1px solid #bababa;
            padding: 10px 20px;
            width: 100%; /* 100% of its container */
            max-width: 750px;
            height: 40px;
            margin: 10px 0;
            background-color: #faf8f2;
        }

        #review-form #username-input {
            width: 200px;
            height: 40px;
            border-radius: 25px; 
            padding-left: 18px;
            margin-bottom: 10px;
            background-color: #faf8f2;
            border: 1px solid #bababa;
        }

        #review-form #submit-button {
            color: white;
            width: 120px;
            height: 40px;
            border-radius: 25px; 
            border: none;
            background-color: #805c05;
            align-self: flex-start; /* Place button to the right, not left. */
        }

        #review-form #submit-button:hover {
            background-color: #5e4403;
        }

        #reviews {
            margin: 20px;
            width: 100%;
            max-width: 750px;
        }

        .review {
            margin: 30px 0;
        }

        .review .review-text {
            margin: 10px 0;
        }

        .review .review-username-timestamp {
            font-size: 15px;
        }

        .review em {
            color: #757575;
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
            color: #ff0000;
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

       #see-more-button {
        font-size: 15px;
        background-color: #e74c3c;
        color: white;
        border: none;
        border-radius: 20px;
        cursor: pointer;
        padding: 5px 15px;
        margin-bottom: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
       }

       #see-more-button:hover {
        background-color: #802a21;
       }

       #see-more-button span { /* Reverse caret */
        position: relative;
        top: 3px;
       }

        .hostel-info-right-panel {
            position: fixed;
            right: 20px; /* position it 20px from the right */
            height: auto;
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
                <div class="hostel-voting-container2"> 
                    <!-- class of the same name exists in center_panel.php already, hence '2' -->
                    <button class="upvote" data-id="<?php echo $hostel_id; ?>">⬆</button>
                    <span class="vote-count"><?php echo ($hostel['upvote'] - $hostel['downvote']); ?></span>
                    <button class="downvote" data-id="<?php echo $hostel_id; ?>">⬇</button>
                </div>
            </div>

            <!-- Review submission form -->
            <form id="review-form" method="POST" action="hostel_details.php?id=<?php echo $hostel_id; ?>">
                <textarea id="review-input" name="review_text" placeholder="Add a review" required></textarea>
                <input id="username-input" type="text" name="user_name" placeholder="Display Name" autocomplete="off" required>
                <button id="submit-button" type="submit">Submit Review</button>
            </form>

            <!-- Reviews -->
            <div id="reviews"></div>
            <button id="see-more-button">
                <span class="material-symbols-outlined">keyboard_arrow_down</span>
                View more reviews
            </button>

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
        
    let reviewOffset = 0;
    let reviewLimit = 10;

    // Fetch reviews via AJAX
    function fetchReviews() {
        $.getJSON(`get_reviews.php?id=<?php echo $hostel_id ?>&reviewOffset=${reviewOffset}&reviewLimit=${reviewLimit}`, function(reviews) {
            
            if (sessionStorage.getItem('newReviewSubmitted')) {
                reviews.shift(); // Remove the new review prepended @submission.
                sessionStorage.removeItem('newReviewSubmitted');
            }

            if (reviews.length > 0) {
                reviews.forEach(review => {
                    $('#reviews').append(`
                        <div class="review">
                            <p class="review-username-timestamp">
                                <strong>${review.user_name}</strong>  <em>•  ${timeAgo(review.date_posted)}  •</em>
                            </p>
                            <p class="review-text">${review.review_text}</p>
                            <div class="review-voting-container" data-id="${review.id}">
                                <button class="upvote" data-id="${review.id}">⬆</button>
                                <span class="vote-count">${review.upvote - review.downvote}</span>
                                <button class="downvote" data-id="${review.id}">⬇</button>
                            </div>
                        </div>
                    `)
                })
                bindVoteButtons();
                reviewOffset += reviewLimit; // +10 to offset to prevent same review from being queried.
                // Keep 'see more reviews' button from displaying once all reviews are displayed.
                reviews.length < reviewLimit ? $('#see-more-button').hide() : $('#see-more-button').show(); 
            } else if (reviewOffset == 0) { // When there are no reviews
                $('#see-more-button').hide();
                $('#reviews').html('<p>No reviews yet.</p>');
            } else {
                $('#see-more-button').hide();
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

            // Update upvote/downvote num here instead of calling fetchReviews()
            let $voteCount = $(`.review-voting-container[data-id='${reviewId}']`).find('.vote-count');
            let currentVoteCount = parseInt($voteCount.text());

            if (voteType === 'upvote') {
                $voteCount.text(currentVoteCount + 1);
            } else if (voteType === 'downvote') {
                $voteCount.text(currentVoteCount - 1);
            }

        }, 'json');
    } // endof updateVote()

    function timeAgo(date) { // To convert post date to "__ ago"
        const now = new Date();
        const past = new Date(date + ' UTC');
        const diff = now - past; // Difference in milliseconds

        const seconds = Math.floor(diff / 1000);
        const minutes = Math.floor(seconds / 60);
        const hours = Math.floor(minutes / 60);
        const days = Math.floor(hours / 24);
        const months = Math.floor(days / 30);
        const years = Math.floor(days / 365);

        if (minutes < 1) return `${seconds}s ago`;
        if (minutes < 60) return `${minutes}m ago`;
        if (hours < 24) return `${hours}h ago`;
        if (days < 30) return `${days}d ago`;
        if (months < 12) return `${months}mo ago`;
        return `${years}y ago`;
    }

    // Tried to pre-pend new review just for that session but later chose to work on ordering reviews from most upvotes first, hence the comment-out:

    // $('#review-form').submit(function(event) { 
    //     // event.preventDefault(); // Prevent form submission default page reload mechanism.

    //     const review = {
    //     user_name: $('#username-input').val(),
    //     review_text: $('#review-input').val(),
    //     date_posted: new Date() // .toISOString() not sure if I need this
    //     };

    //     $.post('get_reviews.php', review, function(response) {
            
    //         $('#reviews').prepend(`
    //             <div class="review">
    //                 <p><strong>${review.user_name}</strong> <em>${timeAgo(review.date_posted)}</em></p>
    //                 <p>${review.review_text}</p>
    //                 <div class="review-voting-container">
    //                     <button class="upvote">⬆</button>
    //                     <span class="vote-count">0</span>
    //                     <button class="downvote">⬇</button>
    //                 </div>
    //             </div>
    //         `);
    //         sessionStorage.setItem('newReviewSubmitted', 'true');
    //     }, 'json');
    // })

    $('#see-more-button').click(function() {
        fetchReviews();
    });

    $(document).ready(function() {
        fetchReviews();
    });

    </script>

</body>
</html>
