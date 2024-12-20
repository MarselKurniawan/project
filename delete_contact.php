<?php
include('includes/db.php');

// Check if 'id' is passed in the URL
if (isset($_GET['id'])) {
    $contact_id = $_GET['id'];

    // Prepare SQL statement to delete the contact message
    $stmt = $pdo->prepare("DELETE FROM contact WHERE contact_id = ?");
    $stmt->execute([$contact_id]);

    // Redirect back to the manage contacts page
    header('Location: manage_contact.php');
    exit();
} else {
    // If no ID is provided, redirect to the contacts list page
    header('Location: manage_contact.php');
    exit();
}
?>
