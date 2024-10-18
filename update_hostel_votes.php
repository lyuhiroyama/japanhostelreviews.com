<?php // Used in center_panel.php

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

        echo json_encode(['status' => 'success']);
    }

?>