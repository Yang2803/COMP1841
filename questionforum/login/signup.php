<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../includes/DatabaseConnection.php';


if (isset($_SESSION['user_id'])) {
    header('Location: /questionforum/index.php');
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Validate username
    if (empty($username)) {
        $errors[] = "Username is required.";
    } elseif (strlen($username) < 3 || strlen($username) > 50) {
        $errors[] = "Username must be between 3 and 50 characters.";
    } else {
        // Check if username already exists
        $query = "SELECT id FROM users WHERE username = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$username]);
        if ($statement->fetch()) {
            $errors[] = "Username is already taken.";
        }
    }

    // Validate email
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    } else {
        // Check if email already exists
        $query = "SELECT id FROM users WHERE email = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$email]);
        if ($statement->fetch()) {
            $errors[] = "Email is already registered.";
        }
    }

    // Validate password
    if (empty($password)) {
        $errors[] = "Password is required.";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }

    // Validate confirm password
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }


    if (empty($errors)) {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $statement = $pdo->prepare($query);
        $statement->execute([$username, $email, $hashedPassword]);

        $user_id = $pdo->lastInsertId();
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $username;

        header('Location: /questionforum/index.php');
        exit;
    }
}

include 'signup.html.php';
