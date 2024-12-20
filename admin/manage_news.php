<?php
include('includes/db.php');
include('includes/header.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_news'])) {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $date = $_POST['date'];

        $stmt = $pdo->prepare("INSERT INTO news (title, content, date) VALUES (?, ?, ?)");
        $stmt->execute([$title, $content, $date]);
    }
}

// Fetch all news
$stmt = $pdo->query("SELECT * FROM news");
$news = $stmt->fetchAll();
?>

<h1 class="h3 mb-4 text-gray-800">Manage News</h1>
<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addNewsModal">Add News</button>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>News ID</th>
            <th>Title</th>
            <th>Date</th>
            <th>Content</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($news as $article): ?>
            <tr>
                <td><?= $article['news_id'] ?></td>
                <td><?= $article['title'] ?></td>
                <td><?= $article['date'] ?></td>
                <td><?= substr($article['content'], 0, 50) ?>...</td>
                <td>
                    <a href="edit_news.php?id=<?= $article['news_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete_news.php?id=<?= $article['news_id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Add News Modal -->
<div class="modal fade" id="addNewsModal" tabindex="-1" aria-labelledby="addNewsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewsModalLabel">Add New News</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">News Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea class="form-control" id="content" name="content" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="add_news" class="btn btn-primary">Add News</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>