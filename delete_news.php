<?php
include('includes/db.php');

// Check if the ID is set
if (isset($_GET['id'])) {
    $news_id = $_GET['id'];

    // Delete the news article from the database
    $stmt = $pdo->prepare("DELETE FROM news WHERE news_id = ?");
    $stmt->execute([$news_id]);

    header('Location: manage_news.php'); // Redirect back to news list
}
?>