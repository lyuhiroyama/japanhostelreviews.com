<?php

// Email sending test code:

// require 'vendor/autoload.php'; 
// // automatically loads the classes from installed libraries (Postmark PHP library)

// use Postmark\PostmarkClient;
// // import PostmarkClient class inside Postmark namespace provided by Postmark PHP library

// function sendTestEmail($email) {
//     $client = new PostmarkClient("token-goes-here");

//     $sendTestEmail = $client -> sendEmail(
//         // "info@japanhostelreviews.com" This sends email in my legal name for some reason...
//         "Japan Hostel Reviews <info@japanhostelreviews.com>", // From with display name
//         $email, // To
//         "Test Email", // Subject
//         "Hello! Thanks for signing up.", // TextBody
//         "<h1>Welcome!</h1><p>Thanks for signing up.</p>" // HtmlBody
//     );

//     return $sendTestEmail;
// }

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $email = $_POST['email'];

//     // Set the content type to JSON
//     header('Content-Type: application/json');

//     // Validate the email address
//     if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
//         try {
//             // Attempt to send the email
//             $result = sendTestEmail($email);
//             echo json_encode(["status" => "success", "message" => "Email sent successfully!"]);
//         } catch (Exception $e) {
//             // Log the error
//             error_log("Failed to send email: " . $e->getMessage());
//             echo json_encode([
//                 "status" => "error",
//                 "message" => "Failed to send email. Please try again later.",
//                 "error" => $e->getMessage()
//             ]);
//         }
//     } else {
//         // Log invalid email attempt
//         error_log("Invalid email address attempted: " . $email);
//         echo json_encode(["status" => "error", "message" => "Invalid email address."]);
//     }
// }

?>