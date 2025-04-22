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

// Check if comment ID and post ID are provided
if (!isset($_GET['id']) || !is_numeric($_GET['id']) || !isset($_GET['post_id']) || !is_numeric($_GET['post_id'])) {
    header('Location: /questionforum/admin/dashboard.php');
    exit;
}

$comment_id = $_GET['id'];
$post_id = $_GET['post_id'];

// Verify the comment exists
$commentQuery = "SELECT id FROM comments WHERE id = ? AND post_id = ?";
$commentStmt = $pdo->prepare($commentQuery);
$commentStmt->execute([$comment_id, $post_id]);
if (!$commentStmt->fetch()) {
    header('Location: /questionforum/admin/dashboard.php');
    exit;
}

// Delete the comment
$query = "DELETE FROM comments WHERE id = ?";
$statement = $pdo->prepare($query);
$statement->execute([$comment_id]);

header('Location: /questionforum/admin/dashboard.php');
exit;