<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Q&A - Greenwich University</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/questionforum/styles.css">
</head>

<body>
    <!-- Content for Logged-In Users -->
    <?php if ($isLoggedIn): ?>
        <?php include 'navigation.html.php'; ?>

        <main class="content-container">
            <?php
            $user_id = $_SESSION['user_id'];
            $avatarQuery = "SELECT avatar FROM users WHERE id = ?";
            $avatarStmt = $pdo->prepare($avatarQuery);
            $avatarStmt->execute([$user_id]);
            $user = $avatarStmt->fetch(PDO::FETCH_ASSOC);
            $avatar = $user['avatar'] ?? null;
            ?>

            <a href="/questionforum/posts/post_question.php" class="create-post-box">
                <div class="create-post-container">
                    <!-- Avatar -->
                    <div class="create-post-avatar">
                        <?php if (!empty($avatar) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/questionforum/' . $avatar)): ?>
                            <img src="/questionforum/<?= htmlspecialchars($avatar) ?>" alt="User Avatar" class="create-post-avatar-img">
                        <?php else: ?>
                            <div class="create-post-default-avatar">No Avatar</div>
                        <?php endif; ?>
                    </div>
                    <!-- Placeholder ask question -->
                    <div class="create-post-placeholder">
                        <p>Let's ask your question!</p>
                    </div>
                </div>
            </a>

            <?php if (!empty($posts)): ?>
                <ul class="post-list">
                    <?php foreach ($posts as $post): ?>
                        <li class="post-item">
                            <p class="post-meta"><strong>Author:</strong> <?= htmlspecialchars($post['username']) ?></p>
                            <p class="post-meta"><strong>Module:</strong> <?= htmlspecialchars($post['module_name']) ?></p>
                            <p class="post-meta"><strong>Posted on:</strong> <?= date('F j, Y, g:i A', strtotime($post['created_at'])) ?></p>
                            <?php if (!empty($post['updated_at'])): ?>
                                <p class="post-meta"><strong>Edited on:</strong> <?= date('F j, Y, g:i A', strtotime($post['updated_at'])) ?></p>
                            <?php endif; ?>
                            <p class="post-content"><?= nl2br(htmlspecialchars($post['content'])) ?></p>

                            <div class="post-image-container">
                                <?php if (!empty($post['image']) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/questionforum/' . $post['image'])): ?>
                                    <img src="/questionforum/<?= htmlspecialchars($post['image']) ?>" alt="Post Image" class="post-image">
                                <?php else: ?>
                                    <p class="no-image">No Image</p>
                                <?php endif; ?>
                            </div>

                            <!-- Edit and Delete Buttons -->
                            <?php if ($post['user_id'] == $user_id): ?>
                                <div class="post-actions">
                                    <a href="/questionforum/posts/edit.php?id=<?= $post['id'] ?>" class="edit-btn">Edit</a>
                                    <a href="/questionforum/posts/delete.php?id=<?= $post['id'] ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
                                </div>
                            <?php endif; ?>

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
                                                <!-- Delete Button (only for the comment's author) -->
                                                <?php if ($comment['user_id'] == $user_id): ?>
                                                    <div class="comment-actions">
                                                        <a href="/questionforum/comments/delete.php?id=<?= $comment['id'] ?>&post_id=<?= $post['id'] ?>" class="delete-btn comment-delete-btn" onclick="return confirm('Are you sure you want to delete this comment?');">Delete</a>
                                                    </div>
                                                <?php endif; ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: ?>
                                    <p class="no-comments">No comments yet.</p>
                                <?php endif; ?>

                                <!-- Comment Form -->
                                <form action="/questionforum/comments/post_comment.php" method="POST" class="comment-form">
                                    <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                                    <div class="form-group">
                                        <textarea name="content" placeholder="Add a comment..." required></textarea>
                                    </div>
                                    <button type="submit" class="submit-btn">Post Comment</button>
                                </form>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="no-posts">No posts available yet.</p>
            <?php endif; ?>
        </main>
    <?php else: ?>
        <!-- Welcome Screen -->
        <div class="welcome-container">
            <div class="welcome-header">
                <img src="/questionforum/uploads/assets/greenwich-logo.webp" alt="Greenwich University Logo" class="welcome-logo">
                <h1>Welcome to Greenwich University Q&A</h1>
                <p class="welcome-tagline">Empower Your Learning</p>
            </div>
            <p class="welcome-text">Ask questions, share answers, and connect with peers at Greenwich University. Join our vibrant community to unlock a world of knowledge!</p>
            <div class="welcome-buttons">
                <a href="/questionforum/login/login.php" class="welcome-btn signin-btn">Sign In</a>
                <a href="/questionforum/login/signup.php" class="welcome-btn join-btn">Join Now</a>
            </div>
            <div class="welcome-stats">
                <p><span class="stat-highlight">500+</span> Students | <span class="stat-highlight">1000+</span> Questions Answered</p>
            </div>
            <div class="welcome-footer">
                <p>Part of the Greenwich University Experience</p>
            </div>
        </div>
    <?php endif; ?>
</body>

</html>