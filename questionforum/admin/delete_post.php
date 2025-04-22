<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../includes/DatabaseConnection.php';

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: /questionforum/admin/login.php');
    exit;
}

// Check if post ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: /questionforum/admin/dashboard.php');
    exit;
}

$post_id = $_GET['id'];

// Delete comments associated with the post first
$commentQuery = "DELETE FROM comments WHERE post_id = ?";
$commentStmt = $pdo->prepare($commentQuery);
$commentStmt->execute([$post_id]);

// Delete the post
$query = "DELETE FROM posts WHERE id = ?";
$statement = $pdo->prepare($query);
$statement->execute([$post_id]);

header('Location: /questionforum/admin/dashboard.php');
exit;