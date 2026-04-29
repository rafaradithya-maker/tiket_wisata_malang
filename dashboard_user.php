<?php 
require_once 'config.php';

// Cek akses: Wajib login sebagai user[cite: 3]
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];

// Ambil data tiket terakhir yang dibeli oleh user ini
$query_tiket = "SELECT * FROM tiket WHERE user_id = '$user_id' ORDER BY id_tiket DESC LIMIT 3";
$result_tiket = mysqli_query($conn, $query_tiket);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Wisata - Galaxy Malang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style_stars.css">
</head>
<body>

    <!-- Background Bintang Bergerak[cite: 11] -->
    <div id="stars-container">
        <?php for ($i = 0; $i < 40; $i++): $size = rand(1, 2); ?>
            <div class="star" style="left:<?=rand(0,100)?>%; width:<?=$size?>px; height:<?=$size?>px; --duration:<?=rand(20,40)?>s;"></div>
        <?php endfor; ?>
    </div>

    <!-- Navigasi Dashboard -->
    <nav class="navbar navbar-expand-lg navbar-dark border-bottom border-secondary mb-5">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">🚀 GALAXY <span class="text-accent">DASHBOARD</span></a>
            <div class="ms-auto text-white small">
                Halo, <span class="fw-bold"><?= $_SESSION['nama']; ?></span> | 
                <a href="logout.php" class="text-danger ms-2 text-decoration-none">Keluar</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <!-- Bagian Kiri: Pilihan Wisata[cite: 3] -->
            <div class="col-lg-7 mb-4">
                <h4 class="fw-bold mb-4">Pilih Destinasi Wisata</h4>
                <div class="row g-3">
                    <!-- Card Wisata 1 -->
                    <div class="col-md-6">
                        <div class="glass-card h-100 p-3">
                            <h5 class="fw-bold text-white">Jatim Park</h5>
                            <p class="small text-secondary">Wisata edukasi dan bermain keluarga paling populer di Kota Batu[cite: 3].</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="text-accent fw-bold"><?= rupiah(100000); ?></span>
                                <a href="pesan.php?wisata=Jatim Park" class="btn btn-sm btn-primary px-3">Pesan</a>
                            </div>
                        </div>
                    </div>
                    <!-- Card Wisata 2 -->
                    <div class="col-md-6">
                        <div class="glass-card h-100 p-3">
                            <h5 class="fw-bold text-white">Gunung Bromo</h5>
                            <p class="small text-secondary">Eksplorasi lautan pasir dan sunrise yang ikonik di Jawa Timur[cite: 3].</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="text-accent fw-bold"><?= rupiah(75000); ?></span>
                                <a href="pesan.php?wisata=Bromo" class="btn btn-sm btn-primary px-3">Pesan</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bagian Kanan: Tiket yang Dibeli[cite: 7] -->
            <div class="col-lg-5">
                <h4 class="fw-bold mb-4">Tiket Saya</h4>
                <div class="glass-card p-4">
                    <?php if (mysqli_num_rows($result_tiket) > 0): ?>
                        <div class="list-group list-group-flush bg-transparent">
                            <?php while ($row = mysqli_fetch_assoc($result_tiket)): ?>
                                <div class="list-group-item bg-transparent border-secondary text-white px-0 py-3">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1 fw-bold"><?= $row['wisata']; ?></h6>
                                            <small class="text-secondary d-block"><?= $row['jumlah']; ?> Tiket - <?= date('d M Y', strtotime($row['tgl_beli'])); ?></small>
                                        </div>
                                        <span class="badge <?= $row['status'] == 'lunas' ? 'bg-success' : 'bg-warning' ?> px-2 py-1">
                                            <?= strtoupper($row['status']); ?>
                                        </span>
                                    </div>
                                    <?php if ($row['status'] == 'lunas'): ?>
                                        <div class="mt-2 text-center bg-white p-2 rounded">
                                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=<?= $row['kode_barcode']; ?>" alt="QR">
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endwhile; ?>
                        </div>
                        <div class="text-center mt-3">
                            <a href="riwayat.php" class="text-accent small text-decoration-none">Lihat Semua Riwayat →</a>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <p class="text-secondary small">Kamu belum memiliki tiket.</p>
                            <p class="fs-1">🎫</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center py-5 mt-5">
        <small class="text-secondary">&copy; 2026 Wisata Malang - Rafarel Adzka Radithya</small>
    </footer>

</body>
</html>