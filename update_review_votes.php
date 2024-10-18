<?php // Used in hostel_details.php

    include('db_connect.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $hostel_id = intval($_POST['id']);
        $vote = $_POST['vote'];

        if ($vote === 'upvote') {
            $stmt = $conn -> prepare("UPDATE reviews SET upvote = upvote + 1 WHERE id = :id");
        } elseif ($vote === 'downvote') {
            $stmt = $conn -> prepare("UPDATE reviews SET downvote = downvote + 1 WHERE id = :id");
        }

        $stmt->bindParam(':id', $hostel_id);
        $stmt->execute();

        // Fetch the updated vote count
        $fetch_stmt = $conn->prepare("SELECT upvote, downvote FROM reviews WHERE id = :id");
        $fetch_stmt->bindParam(':id', $review_id);
        $fetch_stmt->execute();
        $result = $fetch_stmt->fetch(PDO::FETCH_ASSOC);

        $newVoteCount = $result['upvote'] - $result['downvote'];

        // Return the new vote count as part of the JSON response
        echo json_encode(['status' => 'success', 'newVoteCount' => $newVoteCount]);
    }

?>