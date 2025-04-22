<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Modules - Greenwich University Q&A</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/questionforum/styles.css">
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1>Manage Modules</h1>
            <a href="/questionforum/admin/dashboard.php" class="back-btn">Back to Dashboard</a>
            <a href="/questionforum/login/logout.php" class="logout-btn">Logout</a>
        </div>

        <!-- Success/Error Messages -->
        <?php if (!empty($success)): ?>
            <div class="success-message">
                <p><?= htmlspecialchars($success) ?></p>
            </div>
        <?php endif; ?>
        <?php if (!empty($errors)): ?>
            <div class="error-messages">
                <?php foreach ($errors as $error): ?>
                    <p class="error-message"><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Add Module Form -->
        <h2>Add New Module</h2>
        <form action="/questionforum/admin/manage_modules.php" method="POST" class="module-form">
            <input type="hidden" name="action" value="add">
            <div class="form-group">
                <label for="module_name">Module Name:</label>
                <input type="text" name="module_name" id="module_name" value="" required>
            </div>
            <button type="submit" class="submit-btn">Add Module</button>
        </form>

        <!-- Module List -->
        <h2>Existing Modules</h2>
        <?php if (!empty($modules)): ?>
            <ul class="module-list">
                <?php foreach ($modules as $module): ?>
                    <li class="module-item">
                        <form action="/questionforum/admin/manage_modules.php" method="POST" class="module-edit-form">
                            <input type="hidden" name="action" value="edit">
                            <input type="hidden" name="module_id" value="<?= $module['id'] ?>">
                            <div class="form-group">
                                <input type="text" name="module_name" value="<?= htmlspecialchars($module['name']) ?>" required>
                            </div>
                            <button type="submit" class="edit-btn">Update</button>
                            <button type="submit" formaction="/questionforum/admin/manage_modules.php" formmethod="POST" name="action" value="delete" class="delete-btn" onclick="return confirm('Are you sure you want to delete this module?');">Delete</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No modules available.</p>
        <?php endif; ?>
    </div>
</body>
</html>