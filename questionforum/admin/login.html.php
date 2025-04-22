<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - Greenwich University Q&A</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/questionforum/styles.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-header">
            <img src="/questionforum/uploads/assets/greenwich-logo.webp" alt="Greenwich University Logo" class="auth-logo">
            <h1>Admin Login</h1>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="error-messages">
                <?php foreach ($errors as $error): ?>
                    <p class="error-message"><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="/questionforum/admin/login.php" method="POST" class="auth-form">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>

            <div class="form-buttons">
                <button type="submit" class="submit-btn">Login</button>
            </div>
        </form>
    </div>
</body>
</html>