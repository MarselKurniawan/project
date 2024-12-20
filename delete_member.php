<?php
include('includes/db.php');

// Check if 'id' is provided in the URL
if (isset($_GET['id'])) {
    $memberId = $_GET['id'];

    // Fetch member data
    $stmt = $pdo->prepare("SELECT * FROM members WHERE member_id = ?");
    $stmt->execute([$memberId]);
    $member = $stmt->fetch();

    if ($member) {
        // Delete photo from uploads folder
        if (file_exists("uploads/" . $member['photo'])) {
            unlink("uploads/" . $member['photo']);
        }

        // Delete member from database
        $stmt = $pdo->prepare("DELETE FROM members WHERE member_id = ?");
        $stmt->execute([$memberId]);

        // Redirect to the manage members page after deletion
        header("Location: manage_members.php");
        exit();
    } else {
        // If member not found, redirect to manage members page
        header("Location: manage_members.php");
        exit();
    }
} else {
    header("Location: manage_members.php");
    exit();
}
?>