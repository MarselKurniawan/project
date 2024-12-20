<?php
include('includes/db.php');
include('includes/header.php');

// Check if 'id' is provided in the URL
if (isset($_GET['id'])) {
    $memberId = $_GET['id'];

    // Fetch member data
    $stmt = $pdo->prepare("SELECT * FROM members WHERE member_id = ?");
    $stmt->execute([$memberId]);
    $member = $stmt->fetch();

    if (!$member) {
        // If member not found, redirect
        header("Location: manage_members.php");
        exit();
    }

    // Handle form submission to update member data
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $role = $_POST['role'];
        $bio = $_POST['bio'];

        // Handle photo update
        $photo = $_FILES['photo']['name'];
        if ($photo) {
            $target = "uploads/" . basename($photo);
            move_uploaded_file($_FILES['photo']['tmp_name'], $target);
        } else {
            $photo = $member['photo']; // Retain old photo if not updated
        }

        // Update member details in database
        $stmt = $pdo->prepare("UPDATE members SET name = ?, role = ?, photo = ?, bio = ? WHERE member_id = ?");
        $stmt->execute([$name, $role, $photo, $bio, $memberId]);

        // Redirect to the member management page after updating
        header("Location: manage_members.php");
        exit();
    }
} else {
    header("Location: manage_members.php");
    exit();
}
?>

<h1 class="h3 mb-4 text-gray-800">Edit Member</h1>

<form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="name" class="form-label">Member Name</label>
        <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($member['name']) ?>"
            required>
    </div>
    <div class="mb-3">
        <label for="role" class="form-label">Role</label>
        <input type="text" class="form-control" id="role" name="role" value="<?= htmlspecialchars($member['role']) ?>"
            required>
    </div>
    <div class="mb-3">
        <label for="bio" class="form-label">Bio</label>
        <textarea class="form-control" id="bio" name="bio" required><?= htmlspecialchars($member['bio']) ?></textarea>
    </div>
    <div class="mb-3">
        <label for="photo" class="form-label">Photo</label>
        <input type="file" class="form-control" id="photo" name="photo">
        <p><small>Current photo: <img src="uploads/<?= $member['photo'] ?>" width="50" height="50"
                    alt="Current Photo"></small></p>
    </div>
    <button type="submit" class="btn btn-primary">Update Member</button>
    <a href="manage_members.php" class="btn btn-secondary">Cancel</a>
</form>

<?php include('includes/footer.php'); ?>