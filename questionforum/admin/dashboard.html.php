<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Greenwich University Q&A</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/questionforum/styles.css">
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1>Admin Dashboard</h1>
            
            <a href="/questionforum/admin/manage_modules.php" class="manage-btn">Manage Modules</a>
            <a href="/questionforum/index.php" class="back-btn">Back to Forum</a>
            <a href="/questionforum/login/logout.php" class="logout-btn">Logout</a>
        </div>

        <h2>All Posts</h2>
        <?php if (!empty($posts)): ?>
            <ul class="admin-post-list">
                <?php foreach ($posts as $post): ?>
                    <li class="admin-post-item">
                        <!-- Post Header with Delete Button -->
                        <div class="post-header">
                            <div class="post-actions">
                                <a href="/questionforum/admin/delete_post.php?id=<?= $post['id'] ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this post?');">Delete Post</a>
                            </div>
                        </div>

                        <p><strong>Author:</strong> <?= htmlspecialchars($post['username']) ?></p>
                        <p><strong>Module:</strong> <?= htmlspecialchars($post['module_name'] ?? 'No Module') ?></p>
                        <p><strong>Posted on:</strong> <?= date('F j, Y, g:i A', strtotime($post['created_at'])) ?></p>
                        <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>

                        <!-- Display the image if it exists -->
                        <div class="post-image-container">
                            <?php if (!empty($post['image']) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/questionforum/' . $post['image'])): ?>
                                <img src="/questionforum/<?= htmlspecialchars($post['image']) ?>" alt="Post Image" class="post-image">
                            <?php else: ?>
                                <p class="no-image">No Image</p>
                            <?php endif; ?>
                        </div>

                        <!-- Comments Section -->
                        <div class="comments-section">
                            <h3>Comments</h3>
                            <?php if (!empty($post['comments'])): ?>
                                <ul class="comment-list">
                                    <?php foreach ($post['comments'] as $comment): ?>
                                        <li class="comment-item">
                                            <p class="comment-meta">
                                                <strong><?= htmlspecialchars($comment['commenter_username'] ?? 'Anonymous') ?></strong> 
                                                on <?= date('F j, Y, g:i A', strtotime($comment['created_at'])) ?>
                                            </p>
                                            <p class="comment-content"><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
                                            <div class="comment-actions">
                                                <a href="/questionforum/admin/delete_comment.php?id=<?= $comment['id'] ?>&post_id=<?= $post['id'] ?>" class="delete-btn comment-delete-btn" onclick="return confirm('Are you sure you want to delete this comment?');">Delete</a>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <p class="no-comments">No comments yet.</p>
                            <?php endif; ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No posts available.</p>
        <?php endif; ?>
    </div>
</body>
</html>