<?php // Used in center_panel.php

    // update_hostel_votes.php: Updates hostel votes & returns the new vote count

    include('db_connect.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $hostel_id = intval($_POST['id']);
        $vote = $_POST['vote'];

        if ($vote === 'upvote') {
            $stmt = $conn -> prepare("UPDATE hostels SET upvote = upvote + 1 WHERE id = :id");
        } elseif ($vote === 'downvote') {
            $stmt = $conn -> prepare("UPDATE hostels SET downvote = downvote + 1 WHERE id = :id");
        }

        $stmt->bindParam(':id', $hostel_id);
        $stmt->execute();

        $fetch_stmt = $conn->prepare("SELECT upvote, downvote FROM hostels WHERE id = :id");
        $fetch_stmt->bindParam(':id', $hostel_id);
        $fetch_stmt->execute();
        $result = $fetch_stmt->fetch(PDO::FETCH_ASSOC);

        $newVoteCount = $result['upvote'] - $result['downvote'];

        echo json_encode(['status' => 'success', 'newVoteCount' => $newVoteCount]);
    }

?>