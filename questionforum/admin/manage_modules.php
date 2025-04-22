<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../includes/DatabaseConnection.php';

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: /questionforum/admin/login.php');
    exit;
}

$errors = [];
$success = '';

// Fetch all modules
$moduleQuery = "SELECT id, name FROM modules ORDER BY name";
$moduleStmt = $pdo->prepare($moduleQuery);
$moduleStmt->execute();
$modules = $moduleStmt->fetchAll(PDO::FETCH_ASSOC);

// Add Module
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $module_name = trim($_POST['module_name'] ?? '');


    if (empty($module_name)) {
        $errors[] = "Module name is required.";
    } else {
        // Check if the module name already exists
        $checkQuery = "SELECT id FROM modules WHERE name = ?";
        $checkStmt = $pdo->prepare($checkQuery);
        $checkStmt->execute([$module_name]);
        if ($checkStmt->fetch()) {
            $errors[] = "Module name already exists.";
        }
    }

    if (empty($errors)) {
        $insertQuery = "INSERT INTO modules (name) VALUES (?)";
        $insertStmt = $pdo->prepare($insertQuery);
        $insertStmt->execute([$module_name]);
        $success = "Module added successfully.";

        $moduleStmt->execute();
        $modules = $moduleStmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Edit Module
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
    $module_id = $_POST['module_id'] ?? null;
    $module_name = trim($_POST['module_name'] ?? '');

    if (!$module_id || !is_numeric($module_id)) {
        $errors[] = "Invalid module ID.";
    }
    if (empty($module_name)) {
        $errors[] = "Module name is required.";
    } else {

        $checkQuery = "SELECT id FROM modules WHERE name = ? AND id != ?";
        $checkStmt = $pdo->prepare($checkQuery);
        $checkStmt->execute([$module_name, $module_id]);
        if ($checkStmt->fetch()) {
            $errors[] = "Module name already exists.";
        }
    }


    if (empty($errors)) {
        $updateQuery = "UPDATE modules SET name = ? WHERE id = ?";
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->execute([$module_name, $module_id]);
        $success = "Module updated successfully.";

        $moduleStmt->execute();
        $modules = $moduleStmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Delete Module
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $module_id = $_POST['module_id'] ?? null;

  
    if (!$module_id || !is_numeric($module_id)) {
        $errors[] = "Invalid module ID.";
    } else {
        // Check if the module is used in any posts
        $checkQuery = "SELECT id FROM posts WHERE module_id = ?";
        $checkStmt = $pdo->prepare($checkQuery);
        $checkStmt->execute([$module_id]);
        if ($checkStmt->fetch()) {
            $errors[] = "Cannot delete module because it is associated with one or more posts.";
        }
    }

    if (empty($errors)) {
        $deleteQuery = "DELETE FROM modules WHERE id = ?";
        $deleteStmt = $pdo->prepare($deleteQuery);
        $deleteStmt->execute([$module_id]);
        $success = "Module deleted successfully.";

        $moduleStmt->execute();
        $modules = $moduleStmt->fetchAll(PDO::FETCH_ASSOC);
    }
}


include 'manage_modules.html.php';