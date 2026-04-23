<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $whatsapp = mysqli_real_escape_string($conn, $_POST['whatsapp']);

    $query = "SELECT * FROM users WHERE username='$username' AND whatsapp='$whatsapp'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $data['username'];
        $_SESSION['role'] = $data['role'];
        $_SESSION['status'] = "login";

        // Arahkan berdasarkan role
        if ($data['role'] == 'admin') {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: user_dashboard.php");
        }
    } else {
        echo "<script>alert('Akses ditolak! Nama atau WA tidak sesuai.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Malangans Tickets - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    </head>
<body class="bg-[#020617] flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md p-8 glass-panel rounded-3xl">
        <h2 class="text-3xl font-bold text-center mb-8">LOGIN <span class="text-blue-500">TICKETS</span></h2>
        <form method="POST" class="space-y-6">
            <input type="text" name="username" placeholder="Username" class="w-full p-4 rounded-xl bg-black/40 border border-white/10 outline-none focus:border-blue-500">
            <input type="tel" name="whatsapp" placeholder="Nomor WhatsApp" class="w-full p-4 rounded-xl bg-black/40 border border-white/10 outline-none focus:border-blue-500">
            <button type="submit" name="login" class="w-full bg-blue-600 py-4 rounded-xl font-bold uppercase tracking-widest">Masuk</button>
        </form>
    </div>
</body>
</html>