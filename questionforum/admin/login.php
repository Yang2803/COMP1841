<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../includes/DatabaseConnection.php';

// Check if the admin is already logged in
if (isset($_SESSION['admin_id'])) {
    header('Location: /questionforum/admin/dashboard.php');
    exit;
}

$errors = [];

// Form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username)) {
        $errors[] = "Username is required.";
    }

    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    if (empty($errors)) {
        // Fetch the admin from the database using username
        $query = "SELECT id, username, password FROM admin WHERE username = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$username]);
        $admin = $statement->fetch(PDO::FETCH_ASSOC);

        // Check if the admin exists and verify the password
        if ($admin && $password === $admin['password']) {
            // Password is correct, log the admin in
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];

            header('Location: /questionforum/admin/dashboard.php');
            exit;
        } else {
            $errors[] = "Invalid username or password.";
        }
    }
}

include 'login.html.php';