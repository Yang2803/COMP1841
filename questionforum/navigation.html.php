<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = isset($_SESSION['user_id']);
$user_id = $isLoggedIn ? $_SESSION['user_id'] : null;

$avatar = null;
if ($isLoggedIn) {
    include 'includes/DatabaseConnection.php';
    $query = "SELECT avatar FROM users WHERE id = ?";
    $statement = $pdo->prepare($query);
    $statement->execute([$user_id]);
    $navUser = $statement->fetch(PDO::FETCH_ASSOC);
    $avatar = $navUser['avatar'] ?? null;
}
?>

<?php if ($isLoggedIn): ?>
    <nav class="vertical-nav">
        <div class="nav-avatar-container">
            <?php if (!empty($avatar) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/questionforum/' . $avatar)): ?>
                <img src="/questionforum/<?= htmlspecialchars($avatar) ?>" alt="User Avatar" class="nav-avatar">
            <?php else: ?>
                <div class="nav-default-avatar">No Avatar</div>
            <?php endif; ?>
        </div>

        <div class="nav-header">
            <a href="/questionforum/profile.php" class="nav-header-link"><?= htmlspecialchars($_SESSION['username'] ?? 'Unknown User'); ?></a>
        </div>
        <ul>
            <li><a href="/questionforum/index.php">Home</a></li>
            <li><a href="/questionforum/contact/contact.php">Contact with Us</a></li>
            <li><a href="/questionforum/admin/login.php" >Admin Area</a></li>
            <li><a href="/questionforum/login/logout.php" class="navbar-link logout-btn">Sign Out</a></li>
            
        </ul>
    </nav>
<?php endif; ?>