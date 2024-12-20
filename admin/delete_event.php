<?php
include('includes/db.php');

// Check if the ID is set
if (isset($_GET['id'])) {
    $event_id = $_GET['id'];

    // First, delete the image from the uploads directory
    $stmt = $pdo->prepare("SELECT image FROM events WHERE event_id = ?");
    $stmt->execute([$event_id]);
    $event = $stmt->fetch();
    $image_path = "uploads/" . $event['image'];

    if (file_exists($image_path)) {
        unlink($image_path); // Delete the image file
    }

    // Then, delete the event from the database
    $stmt = $pdo->prepare("DELETE FROM events WHERE event_id = ?");
    $stmt->execute([$event_id]);

    header('Location: manage_events.php'); // Redirect back to events list
}
?>