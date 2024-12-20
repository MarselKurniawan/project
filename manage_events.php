<?php
include('includes/db.php');
include('includes/header.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_event'])) {
        $title = $_POST['title'];
        $date = $_POST['date'];
        $description = $_POST['description'];
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

                    // Insert event into the database
                    $stmt = $pdo->prepare("INSERT INTO events (title, date, description, image) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$title, $date, $description, $image]);
                } else {
                    echo "Only PNG, JPG, or JPEG files are allowed.";
                }
            } else {
                echo "File size exceeds the 25MB limit.";
            }
        } else {
            echo "Error uploading the file.";
        }
    }
}

// Fetch all events
$stmt = $pdo->query("SELECT * FROM events");
$events = $stmt->fetchAll();
?>

<h1 class="h3 mb-4 text-gray-800">Manage Events</h1>
<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addEventModal">Add Event</button>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Event ID</th>
            <th>Title</th>
            <th>Date</th>
            <th>Description</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($events as $event): ?>
            <tr>
                <td><?= $event['event_id'] ?></td>
                <td><?= $event['title'] ?></td>
                <td><?= $event['date'] ?></td>
                <td><?= $event['description'] ?></td>
                <td><img src="uploads/<?= $event['image'] ?>" width="50"></td>
                <td>
                    <a href="edit_event.php?id=<?= $event['event_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete_event.php?id=<?= $event['event_id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Add Event Modal -->
<div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEventModalLabel">Add New Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Event Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Event Image</label>
                        <input type="file" class="form-control" id="image" name="image" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="add_event" class="btn btn-primary">Add Event</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>