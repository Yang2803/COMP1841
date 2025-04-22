<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Post - Greenwich University Q&A</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/questionforum/styles.css">
    
</head>

<body>
    <!-- Include the Navigation Bar -->
    <?php include '../navigation.html.php'; ?>

    <main class="content-container">
        <div class="post-create-container">
            <h2>Create a New Post</h2>

            <?php if (!empty($errors)): ?>
                <div class="error-messages">
                    <?php foreach ($errors as $error): ?>
                        <p class="error-message"><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form action="/questionforum/posts/post_question.php" method="POST" enctype="multipart/form-data" class="post-form">
                <div class="form-group">
                    <label for="content">Post Content:</label>
                    <textarea name="content" id="content" placeholder="Write your post here..." required><?= htmlspecialchars($_POST['content'] ?? '') ?></textarea>
                </div>

                <div class="form-group">
                    <label for="module_id">Module (optional):</label>
                    <select name="module_id" id="module_id">
                        <option value="">Select a module</option>
                        <?php foreach ($modules as $module): ?>
                            <option value="<?= $module['id'] ?>" <?= isset($_POST['module_id']) && $_POST['module_id'] == $module['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($module['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="image">Upload Image (optional):</label>
                    <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/gif">
                </div>

                <div class="form-buttons">
                    <button type="submit" class="submit-btn">Create Post</button>
                    <a href="/questionforum/index.php" class="cancel-btn">Cancel</a>
                </div>
            </form>
        </div>
    </main>
</body>

</html>