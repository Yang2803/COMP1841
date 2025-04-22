<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../includes/DatabaseConnection.php';


$isLoggedIn = isset($_SESSION['user_id']);
if (!$isLoggedIn) {
    header('Location: /questionforum/login/login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Get the comment ID and post ID from the query parameters
$comment_id = $_GET['id'] ?? null;
$post_id = $_GET['post_id'] ?? null;

if (!$comment_id || !is_numeric($comment_id) || !$post_id || !is_numeric($post_id)) {
    header('Location: /questionforum/index.php');
    exit;
}

// Fetch the comment to delete
$query = "SELECT user_id FROM comments WHERE id = ? AND post_id = ?";
$statement = $pdo->prepare($query);
$statement->execute([$comment_id, $post_id]);
$comment = $statement->fetch(PDO::FETCH_ASSOC);

// Check if the comment exists and belongs to the user
if (!$comment || $comment['user_id'] != $user_id) {
    header('Location: /questionforum/index.php');
    exit;
}


$query = "DELETE FROM comments WHERE id = ? AND user_id = ?";
$statement = $pdo->prepare($query);
$statement->execute([$comment_id, $user_id]);


header('Location: /questionforum/index.php');
exit;