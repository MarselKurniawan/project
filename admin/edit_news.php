<?php
include('includes/db.php');
include('includes/header.php');

// Fetch news details by ID
if (isset($_GET['id'])) {
    $news_id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM news WHERE news_id = ?");
    $stmt->execute([$news_id]);
    $news = $stmt->fetch();

    // Handle form submission to update the news
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $date = $_POST['date'];

        // Update the news details
        $stmt = $pdo->prepare("UPDATE news SET title = ?, content = ?, date = ? WHERE news_id = ?");
        $stmt->execute([$title, $content, $date, $news_id]);

        header('Location: manage_news.php'); // Redirect back to the news list
    }
}
?>

<h1 class="h3 mb-4 text-gray-800">Edit News</h1>

<form method="POST">
    <div class="mb-3">
        <label for="title" class="form-label">News Title</label>
        <input type="text" class="form-control" id="title" name="title" value="<?= $news['title'] ?>" required>
    </div>
    <div class="mb-3">
        <label for="content" class="form-label">Content</label>
        <textarea class="form-control" id="content" name="content" required><?= $news['content'] ?></textarea>
    </div>
    <div class="mb-3">
        <label for="date" class="form-label">Date</label>
        <input type="date" class="form-control" id="date" name="date" value="<?= $news['date'] ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Update News</button>
</form>

<?php include('includes/footer.php'); ?>