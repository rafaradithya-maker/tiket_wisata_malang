<?php
// Memanggil konfigurasi database
require_once 'config.php';

// Proses saat tombol daftar ditekan
if (isset($_POST['register'])) {
    $nama     = input_bersih($_POST['nama']); // Menggunakan fungsi pembersihan dari config
    $username = input_bersih($_POST['username']);
    $password = $_POST['password'];
    
    // Enkripsi password agar aman
    $password_aman = password_hash($password, PASSWORD_DEFAULT);

    // Cek apakah username sudah ada di database
    $cek_user = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    
    if (mysqli_num_rows($cek_user) > 0) {
        $error = "Username sudah digunakan, cari yang lain![cite: 6]";
    } else {
        // Simpan data ke tabel users dengan role default 'user'[cite: 6]
        $query = "INSERT INTO users (nama, username, password, role) VALUES ('$nama', '$username', '$password_aman', 'user')";
        
        if (mysqli_query($conn, $query)) {
            echo "<script>
                    alert('Pendaftaran Berhasil! Silakan Login.');
                    window.location='login.php';
                </script>";
        } else {
            $error = "Terjadi kesalahan sistem saat mendaftar.[cite: 6]";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - wisata_malang</title>
    <!-- Bootstrap CSS[cite: 6] -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Custom Theme CSS[cite: 11] -->
    <link rel="stylesheet" href="style_stars.css">
</head>
<body>

    <!-- Background Bintang Bergerak[cite: 11] -->
    <div id="stars-container">
        <?php for ($i = 0; $i < 50; $i++): $size = rand(1, 3); ?>
            <div class="star" style="left:<?=rand(0,100)?>%; width:<?=$size?>px; height:<?=$size?>px; --duration:<?=rand(15,35)?>s;"></div>
        <?php endfor; ?>
    </div>

    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="glass-card" style="max-width: 450px; width: 100%;">
            <h3 class="text-center fw-bold mb-2">Daftar Akun</h3>
            <p class="text-center text-secondary small mb-4">Bergabunglah untuk mulai menjelajahi Malang</p>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-danger bg-danger bg-opacity-10 border-danger text-danger text-center small"><?= $error; ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-3">
                    <label class="form-label small fw-bold text-secondary">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control bg-dark border-secondary text-white" placeholder="Masukkan nama lengkap" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold text-secondary">Username</label>
                    <input type="text" name="username" class="form-control bg-dark border-secondary text-white" placeholder="Buat username" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold text-secondary">Password</label>
                    <input type="password" name="password" class="form-control bg-dark border-secondary text-white" placeholder="Buat password" required>
                </div>
                
                <div class="d-grid gap-2 mt-4">
                    <button type="submit" name="register" class="btn btn-primary py-2 fw-bold">Daftar Sekarang</button>
                    <a href="login.php" class="btn btn-outline-light btn-sm border-0 mt-2">Sudah punya akun? Login di sini</a>
                </div>
            </form>
            
            <div class="text-center mt-4">
                <a href="index.php" class="text-secondary small text-decoration-none">← Kembali ke Beranda</a>
            </div>
        </div>
    </div>

</body>
<!-- Navigasi Sederhana di Halaman Auth -->
<nav class="navbar navbar-expand navbar-dark mb-4">
    <div class="container justify-content-center">
        <ul class="navbar-nav gap-3">
            <li class="nav-item">
                <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'login.php' ? 'active fw-bold text-accent' : '' ?>" href="login.php">LOGIN</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'register.php' ? 'active fw-bold text-accent' : '' ?>" href="register.php">REGISTER</a>
            </li>
        </ul>
    </div>
</nav>
</html>