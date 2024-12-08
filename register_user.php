<?php

include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);

    // Throw error is email is invalid:
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { 
        echo json_encode(['status' => 'error', 'message' => 'Invalid email format']);
        exit;
    }

    // Check if username already exists:
    $stmt = $conn -> prepare("SELECT * FROM users WHERE username = :username");
    $stmt -> bindParam(':username', $username, PDO::PARAM_STR);
    $stmt -> execute();

    if ($stmt -> rowCount() > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Username already taken.']);
        exit;
    }

    // Check if email already exists:
    $stmt = $conn -> prepare("SELECT * FROM users WHERE email = :email");
    $stmt -> bindParam(':email', $email, PDO::PARAM_STR);
    $stmt -> execute();

    if ($stmt -> rowCount() > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Email already registered.']);
        exit;
    }

    // Insert new user into db:
    $stmt = $conn -> prepare("INSERT INTO users (username, email) VALUES (:username, :email)");
    $stmt -> bindParam(':username', $username, PDO::PARAM_STR);
    $stmt -> bindParam(':email', $email, PDO::PARAM_STR);
    $stmt -> execute();

    // Return insert statement status:
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Registration successful.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Registration failed.']);
    }
}

?>