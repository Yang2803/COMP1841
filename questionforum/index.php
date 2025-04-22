<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'includes/DatabaseConnection.php';

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['user_id']);

if ($isLoggedIn) {
    // Fetch posts
    $query = "
        SELECT 
            p.id, p.content, p.image, p.created_at, p.updated_at, p.user_id,
            u.username,
            m.name AS module_name
        FROM posts p
        INNER JOIN users u ON p.user_id = u.id
        LEFT JOIN modules m ON p.module_id = m.id
        ORDER BY p.created_at DESC
    ";
    $statement = $pdo->prepare($query);
    $statement->execute();
    $posts = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Fetch comments for each post
    foreach ($posts as &$post) {
        $commentQuery = "
            SELECT 
                c.id, c.content, c.created_at, c.user_id,
                u.username AS commenter_username
            FROM comments c
            INNER JOIN users u ON c.user_id = u.id
            WHERE c.post_id = ?
            ORDER BY c.created_at ASC
        ";
        $commentStmt = $pdo->prepare($commentQuery);
        $commentStmt->execute([$post['id']]);
        $post['comments'] = $commentStmt->fetchAll(PDO::FETCH_ASSOC);
    }
    unset($post); 
} else {
    $posts = [];
}


include 'home.html.php';

