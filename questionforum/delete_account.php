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


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'] ?? '';

    // Fetch the current password hash from the database
    $passwordQuery = "SELECT password FROM users WHERE id = ?";
    $passwordStmt = $pdo->prepare($passwordQuery);
    $passwordStmt->execute([$user_id]);
    $storedPassword = $passwordStmt->fetchColumn();

    // Validate the password
    if (empty($current_password)) {
        $_SESSION['deleteError'] = "Password is required.";
        header('Location: profile.php');
        exit;
    }

    // Verify hashed password
    if (!password_verify($current_password, $storedPassword)) {
        $_SESSION['deleteError'] = "Incorrect password. Please try again.";
        header('Location: profile.php');
        exit;
    }

    // Delete the user's avatar file if it exists
    $avatarQuery = "SELECT avatar FROM users WHERE id = ?";
    $avatarStmt = $pdo->prepare($avatarQuery);
    $avatarStmt->execute([$user_id]);
    $avatar = $avatarStmt->fetchColumn();
    if ($avatar && file_exists($avatar)) {
        unlink($avatar);
    }

 
    $deletePostComments = "
        DELETE c FROM comments c
        INNER JOIN posts p ON c.post_id = p.id
        WHERE p.user_id = ?
    ";
    $deletePostCommentsStmt = $pdo->prepare($deletePostComments);
    $deletePostCommentsStmt->execute([$user_id]);

  
    $deletePosts = "DELETE FROM posts WHERE user_id = ?";
    $deletePostsStmt = $pdo->prepare($deletePosts);
    $deletePostsStmt->execute([$user_id]);


    $deleteComments = "DELETE FROM comments WHERE user_id = ?";
    $deleteCommentsStmt = $pdo->prepare($deleteComments);
    $deleteCommentsStmt->execute([$user_id]);


    $deleteUser = "DELETE FROM users WHERE id = ?";
    $deleteUserStmt = $pdo->prepare($deleteUser);
    $deleteUserStmt->execute([$user_id]);

 
    session_destroy();
    header('Location: index.php');
    exit;
}


header('Location: profile.php');
exit;
