<?php

try {
    $conn = new PDO("sqlite:hostel_site.sqlite"); // Connect to SQLite databiase file

    $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $conn -> exec("CREATE TABLE IF NOT EXISTS hostels (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        location TEXT,
        price_range TEXT,
        rating REAL,
        description TEXT,
        thumbnail TEXT
    )");

    $conn -> exec(" CREATE TABLE IF NOT EXISTS reviews (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        hostel_id INTEGER,
        user_name TEXT NOT NULL,
        rating REAL,
        review_text TEXT,
        date_posted DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (hostel_id) REFERENCES hostels(id) ON DELETE CASCADE
    )");

} catch (PDOException $e) {
    echo "Connection failed: " . $e -> getMessage();
    exit;
}

?>
