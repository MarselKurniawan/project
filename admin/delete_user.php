<?php
include('includes/db.php');

// Check if 'id' is provided in the URL
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Prepare and execute the deletion query
    $stmt = $pdo->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->execute([$userId]);

    // Redirect back to the user management page
    header("Location: manage_users.php");
    exit();
} else {
    // If 'id' is not set, redirect back to the user management page
    header("Location: manage_users.php");
    exit();
}
?>
