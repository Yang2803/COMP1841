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

// Get the post ID from the query parameter
$post_id = $_GET['id'] ?? null;
if (!$post_id || !is_numeric($post_id)) {
    header('Location: /questionforum/index.php');
    exit;
}

// Fetch the post to delete
$query = "SELECT user_id, image FROM posts WHERE id = ?";
$statement = $pdo->prepare($query);
$statement->execute([$post_id]);
$post = $statement->fetch(PDO::FETCH_ASSOC);

// Check if the post exists and belongs to the user
if (!$post || $post['user_id'] != $user_id) {
    header('Location: /questionforum/index.php');
    exit;
}

// Delete the associated image file (if any)
if (!empty($post['image']) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/questionforum/' . $post['image'])) {
    unlink($_SERVER['DOCUMENT_ROOT'] . '/questionforum/' . $post['image']);
}

$query = "DELETE FROM posts WHERE id = ? AND user_id = ?";
$statement = $pdo->prepare($query);
$statement->execute([$post_id, $user_id]);


header('Location: /questionforum/index.php');
exit;