<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Profile - Greenwich University Q&A</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="styles.css">
    
</head>

<body>

    <?php include 'navigation.html.php'; ?>

    <main class="content-container">
        <div class="edit-profile-container">
            <h2>Edit Profile</h2>

            <?php if (!empty($errors)): ?>
                <div class="error-messages">
                    <?php foreach ($errors as $error): ?>
                        <p class="error-message"><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form action="edit_profile.php" method="POST" class="edit-profile-form">
                <div class="form-group-edit-pro5">
                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username" value="<?= htmlspecialchars($user['username']) ?>" required>
                </div>

                <div class="form-group-edit-pro5">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                </div>

                <div class="form-group-edit-pro5">
                    <label for="gender">Gender:</label>
                    <select name="gender" id="gender">
                        <option value="">Select Gender</option>
                        <option value="Male" <?= $user['gender'] === 'Male' ? 'selected' : '' ?>>Male</option>
                        <option value="Female" <?= $user['gender'] === 'Female' ? 'selected' : '' ?>>Female</option>
                        <option value="Other" <?= $user['gender'] === 'Other' ? 'selected' : '' ?>>Other</option>
                    </select>
                </div>

                <div class="form-group-edit-pro5">
                    <label for="dob">Date of Birth:</label>
                    <input type="date" name="dob" id="dob" value="<?= htmlspecialchars($user['dob'] ?? '') ?>">
                </div>

                <div class="form-group-edit-pro5">
                    <label for="new_password">New Password (leave blank to keep current):</label>
                    <input type="password" name="new_password" id="new_password">
                </div>

                <div class="form-group-edit-pro5">
                    <label for="current_password">Current Password (required to change password):</label>
                    <input type="password" name="current_password" id="current_password">
                </div>

                <div class="form-buttons">
                    <button type="submit" class="submit-btn">Save Changes</button>
                    <a href="profile.php" class="cancel-btn">Cancel</a>
                </div>
            </form>
        </div>
    </main>
</body>

</html>