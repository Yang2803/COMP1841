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
$query = "SELECT id, username, email, gender, dob FROM users WHERE id = ?";
$statement = $pdo->prepare($query);
$statement->execute([$user_id]);
$user = $statement->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $gender = !empty($_POST['gender']) ? $_POST['gender'] : null;
    $dob = !empty($_POST['dob']) ? $_POST['dob'] : null;
    $new_password = !empty($_POST['new_password']) ? $_POST['new_password'] : null;
    $current_password = $_POST['current_password'] ?? '';

    // Validate inputs
    $errors = [];

    // Validate username
    if (empty($username)) {
        $errors[] = "Username is required.";
    }

    // Validate email
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "A valid email is required.";
    }

    // Check if username or email is already taken
    $checkQuery = "SELECT id FROM users WHERE (username = ? OR email = ?) AND id != ?";
    $checkStmt = $pdo->prepare($checkQuery);
    $checkStmt->execute([$username, $email, $user_id]);
    if ($checkStmt->fetch()) {
        $errors[] = "Username or email is already taken.";
    }

    // Validate current password if new password is provided
    if ($new_password) {
        if (empty($current_password)) {
            $errors[] = "Current password is required to change your password.";
        } else {
            // Fetch the current password from the database
            $passwordQuery = "SELECT password FROM users WHERE id = ?";
            $passwordStmt = $pdo->prepare($passwordQuery);
            $passwordStmt->execute([$user_id]);
            $storedPassword = $passwordStmt->fetchColumn();

            // Verify the current password using password_verify
            if (!password_verify($current_password, $storedPassword)) {
                $errors[] = "Current password is incorrect.";
            }
        }
    }

    if (empty($errors)) {
        $updateQuery = "UPDATE users SET username = ?, email = ?, gender = ?, dob = ?";
        $params = [$username, $email, $gender, $dob];

        if ($new_password) {
            $updateQuery .= ", password = ?";
            $params[] = password_hash($new_password, PASSWORD_DEFAULT);
        }

        $updateQuery .= " WHERE id = ?";
        $params[] = $user_id;

        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->execute($params);


        $_SESSION['username'] = $username;


        header('Location: profile.php');
        exit;
    }
}


include 'edit_profile.html.php';
