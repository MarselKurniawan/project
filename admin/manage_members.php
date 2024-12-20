<?php
include('includes/db.php');
include('includes/header.php');

// Menangani request POST untuk menambahkan member
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_member'])) {
        $name = $_POST['name'];
        $role = $_POST['role'];
        $bio = $_POST['bio'];

        // Proses file foto
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
            $photo = $_FILES['photo']['name'];
            $target = "uploads/" . basename($photo);

            // Validasi upload file (periksa tipe file dan ukuran)
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            $max_size = 25 * 1024 * 1024; // Maksimal 25 MB

            if (in_array($_FILES['photo']['type'], $allowed_types) && $_FILES['photo']['size'] <= $max_size) {
                // Pindahkan file yang diupload ke folder target
                if (move_uploaded_file($_FILES['photo']['tmp_name'], $target)) {
                    // Insert member ke dalam database
                    $stmt = $pdo->prepare("INSERT INTO members (name, role, photo, bio) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$name, $role, $photo, $bio]);
                    echo "<div class='alert alert-success'>Member added successfully!</div>";
                } else {
                    echo "<div class='alert alert-danger'>Failed to upload photo.</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Invalid file type or file size exceeds the limit.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>No photo uploaded or error occurred with the file upload.</div>";
        }
    }
}

// Fetch semua data member
$stmt = $pdo->query("SELECT * FROM members");
$members = $stmt->fetchAll();
?>


<h1 class="h3 mb-4 text-gray-800">Manage Members</h1>
<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addMemberModal">Add Member</button>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Member ID</th>
            <th>Name</th>
            <th>Role</th>
            <th>Photo</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($members as $member): ?>
            <tr>
                <td><?= $member['member_id'] ?></td>
                <td><?= $member['name'] ?></td>
                <td><?= $member['role'] ?></td>
                <td><img src="uploads/<?= $member['photo'] ?>" width="50" height="50"></td>
                <td>
                    <a href="edit_member.php?id=<?= $member['member_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete_member.php?id=<?= $member['member_id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Add Member Modal -->
<div class="modal fade" id="addMemberModal" tabindex="-1" aria-labelledby="addMemberModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMemberModalLabel">Add New Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Member Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <input type="text" class="form-control" id="role" name="role" required>
                    </div>
                    <div class="mb-3">
                        <label for="bio" class="form-label">Bio</label>
                        <textarea class="form-control" id="bio" name="bio" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="photo" class="form-label">Photo</label>
                        <input type="file" class="form-control" id="photo" name="photo" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="add_member" class="btn btn-primary">Add Member</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>