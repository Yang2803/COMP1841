<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Post - Greenwich University Q&A</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/questionforum/styles.css">
    
</head>

<body>

    <?php include '../navigation.html.php'; ?>

    <main class="content-container">
        <div class="post-create-container">
            <h2>Edit Post</h2>

            <?php if (!empty($errors)): ?>
                <div class="error-messages">
                    <?php foreach ($errors as $error): ?>
                        <p class="error-message"><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form action="/questionforum/posts/edit.php?id=<?= $post['id'] ?>" method="POST" enctype="multipart/form-data" class="post-form">
                <div class="form-group">
                    <label for="content">Post Content:</label>
                    <textarea name="content" id="content" placeholder="Write your post here..." required><?= htmlspecialchars($post['content']) ?></textarea>
                </div>

                <div class="form-group">
                    <label for="module_id">Module (optional):</label>
                    <select name="module_id" id="module_id">
                        <option value="">Select a module</option>
                        <?php foreach ($modules as $module): ?>
                            <option value="<?= $module['id'] ?>" <?= $post['module_id'] == $module['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($module['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Current Image:</label>
                    <?php if (!empty($post['image']) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/questionforum/' . $post['image'])): ?>
                        <img src="/questionforum/<?= htmlspecialchars($post['image']) ?>" alt="Current Post Image" class="current-post-image">
                        <label>
                            <input type="checkbox" name="remove_image" value="1"> Remove Current Image
                        </label>
                    <?php else: ?>
                        <p>No image uploaded.</p>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="image">Upload New Image (optional):</label>
                    <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/gif">
                </div>

                <div class="form-buttons">
                    <button type="submit" class="submit-btn">Update Post</button>
                    <a href="/questionforum/index.php" class="cancel-btn">Cancel</a>
                </div>
            </form>
        </div>
    </main>
</body>

</html>