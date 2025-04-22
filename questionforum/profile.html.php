<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Profile - Greenwich University Q&A</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/questionforum/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    
</head>

<body>
    <?php include 'navigation.html.php'; ?>

    <main class="content-container">
        <div class="profile-container">
            <h2 class="profile-username"><?= htmlspecialchars($user['username'] ?? 'Unknown User') ?></h2>

            <div class="profile-info">
                <!-- Display Avatar -->
                <div class="avatar-container">
                    <?php if (!empty($user['avatar']) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/questionforum/' . $user['avatar'])): ?>
                        <img src="/questionforum/<?= htmlspecialchars($user['avatar']) ?>" alt="User Avatar" class="user-avatar">
                    <?php else: ?>
                        <div class="default-avatar">No Avatar</div>
                    <?php endif; ?>
                </div>

                <!-- Avatar Upload Form -->
                <div class="avatar-upload-section">
                    <form action="/questionforum/profile.php" method="POST" enctype="multipart/form-data" class="avatar-form">
                        <input type="file" name="avatar" class="avatar-input" accept="image/jpeg,image/png,image/gif" required>
                        <button type="submit" class="submit-btn">Upload Avatar</button>
                    </form>
                    <?php if (isset($uploadError)): ?>
                        <p class="error-message"><?= htmlspecialchars($uploadError) ?></p>
                    <?php endif; ?>
                </div>

                <!-- Display Profile Info -->
                <p><strong>Username:</strong> <?= htmlspecialchars($user['username'] ?? 'Unknown User') ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($user['email'] ?? 'Not set') ?></p>
                <p><strong>Gender:</strong> <?= htmlspecialchars($user['gender'] ?? 'Not set') ?></p>
                <p><strong>Date of Birth:</strong> <?= htmlspecialchars($user['dob'] ?? 'Not set') ?></p>
            </div>

            <div class="bio-section">
                <h3>Bio</h3>
                <div class="bio-box">
                    <?php if (!empty($user['bio'])): ?>
                        <p><?= nl2br(htmlspecialchars($user['bio'])) ?></p>
                    <?php else: ?>
                        <p class="no-bio">No bio yet. Add one to share about yourself!</p>
                    <?php endif; ?>
                </div>
                <div class="bio-button-container">
                    <button type="button" class="edit-bio-btn" onclick="openBioModal()">Edit Bio</button>
                </div>
            </div>

            <!-- Bio Edit -->
            <div id="bioModal" class="modal">
                <div class="modal-content">
                    <span class="close-btn" onclick="closeBioModal()">×</span>
                    <h3>Edit Bio</h3>
                    <form action="/questionforum/profile.php" method="POST" class="bio-form">
                        <textarea name="bio" class="bio-input" placeholder="Tell us about yourself..."><?= htmlspecialchars($user['bio'] ?? '') ?></textarea>
                        <div class="modal-buttons">
                            <button type="submit" class="submit-btn">Save</button>
                            <button type="button" class="cancel-btn" onclick="closeBioModal()">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Edit Profile and Delete Account Buttons -->
            <div class="profile-actions">
                <a href="/questionforum/edit_profile.php" class="edit-profile-btn">Edit Profile</a>
                <button type="button" class="delete-account-btn" onclick="openDeleteModal()">Delete Account</button>
            </div>

            <!-- Delete Account-->
            <div id="deleteModal" class="modal">
                <div class="modal-content">
                    <span class="close-btn" onclick="closeDeleteModal()">×</span>
                    <h3>Delete Account</h3>
                    <p class="warning-message">Are you sure you want to delete your account? This action cannot be undone.</p>
                    <form action="/questionforum/delete_account.php" method="POST" class="delete-form">
                        <label for="current_password">Enter Current Password:</label>
                        <input type="password" name="current_password" id="current_password" class="password-input" required>
                        <?php if (isset($deleteError)): ?>
                            <p class="error-message"><?= htmlspecialchars($deleteError) ?></p>
                        <?php endif; ?>
                        <div class="modal-buttons">
                            <button type="submit" class="delete-btn">Delete</button>
                            <button type="button" class="cancel-btn" onclick="closeDeleteModal()">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>

            <p class="back-link"><a href="/questionforum/index.php">Back to Home</a></p>
        </div>
    </main>

    <script>
        function openBioModal() {
            document.getElementById('bioModal').style.display = 'block';
        }

        function closeBioModal() {
            document.getElementById('bioModal').style.display = 'none';
        }

        function openDeleteModal() {
            document.getElementById('deleteModal').style.display = 'block';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }

        window.onclick = function(event) {
            const bioModal = document.getElementById('bioModal');
            const deleteModal = document.getElementById('deleteModal');
            if (event.target === bioModal) {
                bioModal.style.display = 'none';
            }
            if (event.target === deleteModal) {
                deleteModal.style.display = 'none';
            }
        }
    </script>
</body>

</html>