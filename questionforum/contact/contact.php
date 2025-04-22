<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../includes/DatabaseConnection.php';


$isLoggedIn = isset($_SESSION['user_id']);
if (!$isLoggedIn) {
    header('Location: ../login/login.php');
    exit;
}

$title = "Contact with Us";
$output = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');


    $errors = [];
    if (empty($name)) {
        $errors[] = "Name is required.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "A valid email is required.";
    }
    if (empty($message)) {
        $errors[] = "Message is required.";
    }

    if (empty($errors)) {
        ini_set('sendmail_path', '"E:\XAMPP\sendmail\sendmail.exe" -t');
        ini_set('SMTP', 'smtp.gmail.com');
        ini_set('smtp_port', 465);
        ini_set('smtp_ssl', 'auto');
        ini_set('error_logfile', 'error.log');
        ini_set('auth_username', '05quynhgiang@gmail.com');
        ini_set('auth_password', 'hwbo roze jyrb cmxu');

        $to = '05quynhgiang@gmail.com';
        $subject = 'Contact Form Submission from ' . $name;
        $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";
        $headers = "From: $email\r\nReply-To: $email\r\n";

        if (mail($to, $subject, $body, $headers)) {
            $output = "Thank you for your message! We will get back to you shortly.";
        } else {
            $errors[] = "Failed to send your message. Please try again later.";
        }
    }
} else {
    $errors = [];
}

include 'contact.html.php';