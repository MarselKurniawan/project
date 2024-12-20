<?php
include('includes/db.php');
include('includes/header.php');

// Fetch event details by ID
if (isset($_GET['id'])) {
    $event_id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM events WHERE event_id = ?");
    $stmt->execute([$event_id]);
    $event = $stmt->fetch();

    // Handle form submission to update the event
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $_POST['title'];
        $date = $_POST['date'];
        $description = $_POST['description'];

        // Check if a new image was uploaded
        if ($_FILES['image']['name']) {
            $image = $_FILES['image']['name'];
            $imageTmpName = $_FILES['image']['tmp_name'];
            $imageSize = $_FILES['image']['size'];
            $imageError = $_FILES['image']['error'];
            $imageExt = strtolower(pathinfo($image, PATHINFO_EXTENSION));

            // Validate image file (allowed types and max size 25MB)
            if ($imageError === 0) {
                if ($imageSize <= 25 * 1024 * 1024) { // 25 MB
                    if ($imageExt === 'png' || $imageExt === 'jpg' || $imageExt === 'jpeg') {
                        $target = "uploads/" . basename($image);
                        move_uploaded_file($imageTmpName, $target);
                        // Update event with new image
                        $stmt = $pdo->prepare("UPDATE events SET title = ?, date = ?, description = ?, image = ? WHERE event_id = ?");
                        $stmt->execute([$title, $date, $description, $image, $event_id]);
                    } else {
                        echo "Only PNG, JPG, or JPEG files are allowed.";
                    }
                } else {
                    echo "File size exceeds the 25MB limit.";
                }
            } else {
                echo "Error uploading the file.";
            }
        } else {
            // No image uploaded, update event without changing image
            $stmt = $pdo->prepare("UPDATE events SET title = ?, date = ?, description = ? WHERE event_id = ?");
            $stmt->execute([$title, $date, $description, $event_id]);
        }

        header('Location: manage_events.php'); // Redirect back to events list
    }
}
?>

<h1 class="h3 mb-4 text-gray-800">Edit Event</h1>

<form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="title" class="form-label">Event Title</label>
        <input type="text" class="form-control" id="title" name="title" value="<?= $event['title'] ?>" required>
    </div>
    <div class="mb-3">
        <label for="date" class="form-label">Date</label>
        <input type="date" class="form-control" id="date" name="date" value="<?= $event['date'] ?>" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description"
            required><?= $event['description'] ?></textarea>
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">Event Image</label>
        <input type="file" class="form-control" id="image" name="image">
        <img src="uploads/<?= $event['image'] ?>" width="100" class="mt-2" alt="Event Image">
    </div>
    <button type="submit" class="btn btn-primary">Update Event</button>
</form>

<?php include('includes/footer.php'); ?>