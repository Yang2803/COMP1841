<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'includes/DatabaseConnection.php';


$isLoggedIn = isset($_SESSION['user_id']);
if (!$isLoggedIn) {
    header('Location: login/login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user information 
$query = "SELECT id, username, email, bio, avatar, gender, dob FROM users WHERE id = ?";
$statement = $pdo->prepare($query);
if (!$statement) {
    die("Database query preparation failed: " . $pdo->errorInfo()[2]);
}

$statement->execute([$user_id]);
$user = $statement->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    session_destroy();
    header('Location: login/login.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bio'])) {
    $newBio = trim($_POST['bio']);
    
    $updateQuery = "UPDATE users SET bio = ? WHERE id = ?";
    $updateStmt = $pdo->prepare($updateQuery);
    $updateStmt->execute([$newBio, $user_id]);

    $user['bio'] = $newBio;

    $statement = $pdo->prepare($query);
    $statement->execute([$user_id]);
    $user = $statement->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['avatar'])) {
    $avatar = $_FILES['avatar'];


    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $maxSize = 2 * 1024 * 1024; 
    $uploadDir = 'uploads/avatars/';
    $uploadOk = true;
    $errorMessage = '';

    if ($avatar['error'] !== UPLOAD_ERR_OK) {
        $errorMessage = "Error uploading file.";
        $uploadOk = false;
    }

    if ($uploadOk && $avatar['size'] > $maxSize) {
        $errorMessage = "File is too large. Maximum size is 2MB.";
        $uploadOk = false;
    }

    if ($uploadOk && !in_array($avatar['type'], $allowedTypes)) {
        $errorMessage = "Only JPEG, PNG, and GIF files are allowed.";
        $uploadOk = false;
    }

    if ($uploadOk) {
        $fileExt = pathinfo($avatar['name'], PATHINFO_EXTENSION);
        $fileName = 'user_' . $user_id . '_' . time() . '.' . $fileExt;
        $filePath = $uploadDir . $fileName;

        if (move_uploaded_file($avatar['tmp_name'], $filePath)) {
            $updateQuery = "UPDATE users SET avatar = ? WHERE id = ?";
            $updateStmt = $pdo->prepare($updateQuery);
            $updateStmt->execute([$filePath, $user_id]);

            $user['avatar'] = $filePath;

            $statement = $pdo->prepare($query);
            $statement->execute([$user_id]);
            $user = $statement->fetch(PDO::FETCH_ASSOC);
        } else {
            $errorMessage = "Failed to move uploaded file.";
        }
    }

    if (!empty($errorMessage)) {
        $uploadError = $errorMessage;
    }
}

include 'profile.html.php';