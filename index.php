<?php
// 1. Cek apakah file config ada sebelum memanggilnya
if (file_exists('config.php')) {
    require_once 'config.php';
} else {
    die("Error: File config.php tidak ditemukan! Pastikan nama filenya benar.");
}

// 2. Cek apakah koneksi database berhasil
if (!$conn) {
    die("Koneksi Database Gagal: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>wisata_malang - Galaxy Theme</title>
    
    <!-- Link Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <!-- Link CSS - Pastikan file style_stars.css ada di folder yang sama[cite: 11] -->
    <link rel="stylesheet" href="style_stars.css">
</head>
<body>

    <!-- Efek Bintang Bergerak[cite: 11] -->
    <div id="stars-container">
        <?php for ($i = 0; $i < 50; $i++): ?>
            <?php $size = rand(1, 3); ?>
            <div class="star" style="left: <?= rand(0, 100) ?>%; width: <?= $size ?>px; height: <?= $size ?>px; --duration: <?= rand(15, 30) ?>s;"></div>
        <?php endfor; ?>
    </div>

    <nav class="navbar navbar-dark pt-4">
        <div class="container">
            <a class="navbar-brand fw-bold fs-3" href="#">MALANG <span class="text-primary">GALAXY</span></a>
            <div class="ms-auto">
                <?php if(isset($_SESSION['id'])): ?>
                    <a href="dashboard_user.php" class="btn btn-primary rounded-pill px-4">Dashboard</a>
                <?php else: ?>
                    <a href="login.php" class="text-white me-3 text-decoration-none">Masuk</a>
                    <a href="register.php" class="btn btn-outline-light rounded-pill px-4">Daftar</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row min-vh-75 align-items-center">
            <div class="col-md-6">
                <div class="glass-card">
                    <h1 class="display-4 fw-bold">Selamat Datang di Wisata Malang</h1>
                    <p class="lead text-secondary">Sistem pemesanan tiket modern dengan fitur QR Code otomatis[cite: 7].</p>
                    <hr class="border-secondary">
                    <div class="d-flex gap-2">
                        <a href="login.php" class="btn btn-primary px-4 py-2">Pesan Sekarang</a>
                        <a href="#" class="btn btn-outline-secondary px-4 py-2">Lihat Wisata</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>