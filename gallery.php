<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />

  <meta name="description" content="" />
  <meta name="keywords" content="" />

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon" />
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon" />

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect" />
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet" />

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
  <link href="assets/vendor/aos/aos.css" rel="stylesheet" />
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet" />
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet" />

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet" />
</head>

<body class="index-page">
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">
      <a href="home.php" class="logo d-flex align-items-center me-auto">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <h1 class="sitename">Organisasi Mahasiswa</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li>
            <a href="home.php" class="active">Home<br /></a>
          </li>
          <li><a href="about.html">About</a></li>
          <li><a href="members.php">Member</a></li>
          <li><a href="gallery.php">Gallery</a></li>
          <li><a href="contact.php">Contact</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

    </div>
  </header>
  <main class="main pt-4">
    <?php
    include('includes/db.php');  // Include the database connection file
    
    // Fetch events from the database
    $stmt = $pdo->query("SELECT * FROM events");
    $events = $stmt->fetchAll();
    ?>

    <!-- Portfolio Section -->
    <section id="portfolio" class="portfolio section">
      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Gallery</h2>
        <p>Kegiatan Kami</p>
      </div>
      <!-- End Section Title -->

      <div class="container">
        <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">
          <ul class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
            <!-- <li data-filter="*" class="filter-active">All</li> -->
          </ul>
          <!-- End Portfolio Filters -->

          <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">
            <?php foreach ($events as $event): ?>
              <div class="col-lg-4 col-md-6 portfolio-item isotope-item">
                <div class="portfolio-content h-100">
                  <img src="uploads/<?php echo $event['image']; ?>" class="img-fluid" alt="" />
                  <div class="portfolio-info">
                    <h4>
                      <?php echo $event['title']; ?>
                    </h4>
                    <p>
                      <?php echo $event['description']; ?>
                    </p>
                    <a href="uploads/<?php echo $event['image']; ?>" title="<?php echo $event['title']; ?>">
                    </a>
                  </div>
                </div>
              </div>
              <!-- End Portfolio Item -->
            <?php endforeach; ?>
          </div>
          <!-- End Portfolio Container -->
        </div>
      </div>
    </section>
    <!-- /Portfolio Section -->

  </main>

  <footer id="footer" class="footer">
    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="home.php" class="d-flex align-items-center">
            <span class="sitename">Organisasi Mahasiswa</span>
          </a>
          <div class="footer-contact pt-3">
            <p>Bla Bla</p>
            <p>Bla bla, Jawtim 535022</p>
            <p class="mt-3">
              <strong>Phone:</strong> <span>+62 123 456 789</span>
            </p>
            <p><strong>Email:</strong> <span>info@contoh.com</span></p>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Useful Links</h4>
          <ul>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Home</a></li>
            <li>
              <i class="bi bi-chevron-right"></i> <a href="#">About us</a>
            </li>
            <li>
              <i class="bi bi-chevron-right"></i> <a href="#">Services</a>
            </li>
            <li>
              <i class="bi bi-chevron-right"></i>
              <a href="#">Terms of service</a>
            </li>
          </ul>
        </div>

        <div class="col-lg-4 col-md-12">
          <h4>Follow Us</h4>
          <p>Lorem Ipsum sit dolor amet roi imsoem amat ngut nub</p>
          <div class="social-links d-flex">
            <a href=""><i class="bi bi-twitter-x"></i></a>
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""><i class="bi bi-linkedin"></i></a>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>
</body>

</html>