<?php 
require_once 'config.php';

// Jika user sudah login, langsung arahkan ke dashboard yang sesuai
if (isset($_SESSION['id'])) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: dashboard_admin.php");
    } else {
        header("Location: dashboard_user.php");
    }
    exit();
}

$error = "";

if (isset($_POST['login'])) {
    $username = input_bersih($_POST['username']);
    $password = $_POST['password'];

    // Cari user berdasarkan username
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        
        // Verifikasi password hash
        if (password_verify($password, $row['password'])) {
            // Set session
            $_SESSION['id'] = $row['id'];
            $_SESSION['nama'] = $row['nama'];
            $_SESSION['role'] = $row['role'];

            // Redirect berdasarkan role[cite: 3]
            if ($row['role'] == 'admin') {
                header("Location: dashboard_admin.php");
            } else {
                header("Location: dashboard_user.php");
            }
            exit();
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Wisata Malang Galaxy</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style_stars.css">
</head>
<body>

    <!-- Background Bintang Bergerak[cite: 11] -->
    <div id="stars-container">
        <?php for ($i = 0; $i < 40; $i++): $size = rand(1, 2); ?>
            <div class="star" style="left:<?=rand(0,100)?>%; width:<?=$size?>px; height:<?=$size?>px; --duration:<?=rand(15,30)?>s;"></div>
        <?php endfor; ?>
    </div>

    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="glass-card" style="max-width: 400px; width: 100%;">
            <div class="text-center mb-4">
                <h3 class="fw-bold text-white">Selamat Datang</h3>
                <p class="text-secondary small">Silakan masuk ke akun Anda</p>
            </div>

            <?php if ($error != ""): ?>
                <div class="alert alert-danger bg-danger bg-opacity-10 border-danger text-danger small text-center"><?= $error; ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-3">
                    <label class="form-label small fw-bold text-secondary">Username</label>
                    <input type="text" name="username" class="form-control bg-dark border-secondary text-white" placeholder="Masukkan username" required>
                </div>
                <div class="mb-4">
                    <label class="form-label small fw-bold text-secondary">Password</label>
                    <input type="password" name="password" class="form-control bg-dark border-secondary text-white" placeholder="Masukkan password" required>
                </div>
                
                <div class="d-grid gap-2">
                    <button type="submit" name="login" class="btn btn-primary py-2 fw-bold">Masuk</button>
                    <div class="text-center mt-3">
                        <small class="text-secondary">Belum punya akun? <a href="register.php" class="text-accent text-decoration-none">Daftar di sini</a></small>
                    </div>
                </div>
            </form>
            
            <div class="text-center mt-4">
                <a href="index.php" class="text-secondary small text-decoration-none">← Kembali ke Beranda</a>
            </div>
        </div>
    </div>

</body>
</html>