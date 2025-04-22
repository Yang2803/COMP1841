<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../includes/DatabaseConnection.php';

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
if (!$isLoggedIn) {
    header('Location: /questionforum/login/login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$errors = [];

// Fetch available modules for the dropdown
$query = "SELECT id, name FROM modules ORDER BY name";
$statement = $pdo->prepare($query);
$statement->execute();
$modules = $statement->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = trim($_POST['content'] ?? '');
    $module_id = !empty($_POST['module_id']) ? $_POST['module_id'] : null; // Allow null if not provided
    $image = $_FILES['image'] ?? null;

    // Validate content
    if (empty($content)) {
        $errors[] = "Post content is required.";
    }

    // Validate module_id only if provided
    if ($module_id !== null && (!is_numeric($module_id) || $module_id <= 0)) {
        $errors[] = "Please select a valid module.";
    } elseif ($module_id !== null) {
        // Verify the module exists
        $moduleQuery = "SELECT id FROM modules WHERE id = ?";
        $moduleStmt = $pdo->prepare($moduleQuery);
        $moduleStmt->execute([$module_id]);
        if (!$moduleStmt->fetch()) {
            $errors[] = "Selected module does not exist.";
        }
    }

    // Handle image upload (optional)
    $imagePath = null;
    if ($image && $image['error'] !== UPLOAD_ERR_NO_FILE) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxSize = 2 * 1024 * 1024; // 2MB
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/questionforum/uploads/posts/';
        $uploadDirRelative = 'uploads/posts/';

        // Create the uploads directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                $errors[] = "Failed to create upload directory: $uploadDir";
            }
        }

        // Check if the directory is writable
        if (!is_writable($uploadDir)) {
            $errors[] = "Upload directory is not writable: $uploadDir";
        } else {
            // Validate the uploaded file
            if ($image['error'] !== UPLOAD_ERR_OK) {
                $errors[] = "Error uploading image. Error code: " . $image['error'];
            } elseif ($image['size'] > $maxSize) {
                $errors[] = "Image is too large. Maximum size is 2MB.";
            } elseif (!in_array($image['type'], $allowedTypes)) {
                $errors[] = "Only JPEG, PNG, and GIF images are allowed.";
            } else {
                // Generate a unique file name
                $fileExt = pathinfo($image['name'], PATHINFO_EXTENSION);
                $fileName = 'post_' . $user_id . '_' . time() . '.' . $fileExt;
                $filePath = $uploadDir . $fileName;
                $filePathRelative = $uploadDirRelative . $fileName;

                // Check if the temporary file exists
                if (!file_exists($image['tmp_name'])) {
                    $errors[] = "Temporary file does not exist: " . $image['tmp_name'];
                } elseif (!is_uploaded_file($image['tmp_name'])) {
                    $errors[] = "File is not a valid uploaded file: " . $image['tmp_name'];
                } else {
                    // Move the uploaded file
                    if (move_uploaded_file($image['tmp_name'], $filePath)) {
                        $imagePath = $filePathRelative;
                    } else {
                        $errors[] = "Failed to upload image to $filePath. Check permissions and ensure the directory exists.";
                    }
                }
            }
        }
    }

    // If no errors, save the post to the database
    if (empty($errors)) {
        $query = "INSERT INTO posts (user_id, content, image, module_id) VALUES (?, ?, ?, ?)";
        $statement = $pdo->prepare($query);
        $statement->execute([$user_id, $content, $imagePath, $module_id]); // module_id can be NULL

        // Redirect to the homepage after successful post creation
        header('Location: /questionforum/index.php');
        exit;
    }
}

// Include the create post template
include 'post_question.html.php';