<?php
// Aktifkan error reporting untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
include('includes/db.php');

// Validasi dan ambil ID dari URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $news_id = intval($_GET['id']);

    try {
        // Query untuk mendapatkan detail berita berdasarkan ID
        $stmt = $pdo->prepare("SELECT * FROM news WHERE news_id = :news_id");
        $stmt->bindParam(':news_id', $news_id, PDO::PARAM_INT);
        $stmt->execute();

        // Ambil data berita
        $news = $stmt->fetch(PDO::FETCH_ASSOC);

        // Jika berita tidak ditemukan, tampilkan pesan error
        if (!$news) {
            echo "<p>News not found.</p>";
            exit;
        }
    } catch (PDOException $e) {
        echo "<p>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
        exit;
    }
} else {
    echo "<p>Invalid news ID.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($news['title']); ?> - News Details</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link ke CSS jika ada -->
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="assets/css/main.css" rel="stylesheet">

</head>

<body>
    <!-- Header -->

    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center">

            <a href="home.php" class="logo d-flex align-items-center me-auto">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <h1 class="sitename">Organisasi Mahasiswa</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="#hero" class="active">Home<br></a></li>
                    <li><a href="about.html">About</a></li>
                    <li><a href="members.php">Member</a></li>
                    <li><a href="gallery.php">Gallery</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            <a class="btn-getstarted flex-md-shrink-0" href="home.php#about">Get Started</a>

        </div>
    </header>

    <!-- News Details Section -->
    <section id="news-details" class="news-details section" style="margin-top:4rem;">
        <div class="container">
            <div class="news-header">
                <h1><?php echo htmlspecialchars($news['title']); ?></h1>
                <p class="news-date">Published on:
                    <?php echo htmlspecialchars(date('F j, Y', strtotime($news['date']))); ?>
                </p>
            </div>

            <div class="news-content">
                <p><?php echo nl2br(htmlspecialchars($news['content'])); ?></p>
                <!-- nl2br untuk menampilkan line break -->
            </div>
        </div>
    </section>

    <!-- Footer -->
</body>

</html>