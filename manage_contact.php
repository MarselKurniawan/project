<?php
include('includes/db.php');
include('includes/header.php');

// Fetch all contact messages
$stmt = $pdo->query("SELECT * FROM contact");
$contacts = $stmt->fetchAll();
?>

<h1 class="h3 mb-4 text-gray-800">Manage Contact Messages</h1>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Contact ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Message</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($contacts as $contact): ?>
            <tr>
                <td><?= $contact['contact_id'] ?></td>
                <td><?= $contact['name'] ?></td>
                <td><?= $contact['email'] ?></td>
                <td><?= substr($contact['message'], 0, 50) ?>...</td>
                <td>
                    <a href="delete_contact.php?id=<?= $contact['contact_id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include('includes/footer.php'); ?>