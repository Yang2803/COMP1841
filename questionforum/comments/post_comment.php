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

// Form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = $_POST['post_id'] ?? null;
    $content = trim($_POST['content'] ?? '');

    // Validate input
    if (!$post_id || !is_numeric($post_id)) {
        header('Location: /questionforum/index.php');
        exit;
    }

    if (empty($content)) {
        header('Location: /questionforum/index.php');
        exit;
    }

    // Verify the post exists
    $postQuery = "SELECT id FROM posts WHERE id = ?";
    $postStmt = $pdo->prepare($postQuery);
    $postStmt->execute([$post_id]);
    if (!$postStmt->fetch()) {
        header('Location: /questionforum/index.php');
        exit;
    }

    // Insert the comment into the database
    $query = "INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)";
    $statement = $pdo->prepare($query);
    $statement->execute([$post_id, $user_id, $content]);

 
    header('Location: /questionforum/index.php');
    exit;
}


header('Location: /questionforum/index.php');
exit;