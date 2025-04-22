<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?> - Greenwich University Q&A</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/questionforum/styles.css">
    <
</head>

<body>

    <?php include '../navigation.html.php'; ?>

    <main class="content-container">
        <div class="contact-container">
            <h2>Contact with Us</h2>

            <?php if (!empty($errors)): ?>
                <div class="error-messages">
                    <?php foreach ($errors as $error): ?>
                        <p class="error-message"><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($output)): ?>
                <p class="success-message"><?= htmlspecialchars($output) ?></p>
            <?php else: ?>
                <form action="/questionforum/contact/contact.php" method="POST" class="contact-form">
                    <div class="form-group">
                        <label for="name">Your Name:</label>
                        <input type="text" name="name" id="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Your Email:</label>
                        <input type="email" name="email" id="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="message">Your Message:</label>
                        <textarea name="message" id="message" placeholder="Write your message here..." required><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
                    </div>

                    <div class="form-buttons">
                        <button type="submit" class="submit-btn">Send Message</button>
                        <a href="/questionforum/index.php" class="cancel-btn">Cancel</a>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </main>
</body>

</html>