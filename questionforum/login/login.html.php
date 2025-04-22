<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sign In - Greenwich University Q&A</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/questionforum/styles.css">
</head>

<body>
    <div class="auth-container">
        <div class="auth-header">
            <img src="/questionforum/uploads/assets/greenwich-logo.webp" alt="Greenwich University Logo" class="auth-logo">
            <h1>Sign In to Greenwich University Q&A</h1>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="error-messages">
                <?php foreach ($errors as $error): ?>
                    <p class="error-message"><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="/questionforum/login/login.php" method="POST" class="auth-form">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>

            <div class="form-buttons">
                <button type="submit" class="submit-btn">Sign In</button>
                <a href="/questionforum/login/signup.php" class="cancel-btn">Don't have an account? Sign Up</a>
            </div>
        </form>
    </div>
</body>

</html>