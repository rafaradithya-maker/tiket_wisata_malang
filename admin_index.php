<?php
session_start();
include 'koneksi.php';

// PROSES LOGIN
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
    } else {
        echo "<script>alert('Data salah atau belum terdaftar!');</script>";
    }
}

// PROSES LOGOUT
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Malangans Travel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #020617; color: white; font-family: sans-serif; }
        .glass-panel { background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(15px); border: 1px solid rgba(255, 255, 255, 0.1); }
        .hidden-page { display: none; }
    </style>
</head>
<body>

    <?php if (!isset($_SESSION['status'])): ?>
    <section class="min-h-screen flex items-center justify-center p-6">
        <div class="w-full max-w-md text-center">
            <h1 class="text-3xl font-bold mb-8 uppercase tracking-widest">Malangans<span class="text-blue-500">Tickets</span></h1>
            <div class="glass-panel rounded-3xl p-8 shadow-2xl">
                <form method="POST" class="space-y-6 text-left">
                    <div>
                        <label class="text-xs font-bold text-blue-400 uppercase">Username</label>
                        <input type="text" name="username" required class="w-full bg-black/40 border border-white/10 rounded-xl px-5 py-4 mt-2 focus:border-blue-500 outline-none" placeholder="Nama Anda">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-blue-400 uppercase">WhatsApp</label>
                        <input type="text" name="whatsapp" required class="w-full bg-black/40 border border-white/10 rounded-xl px-5 py-4 mt-2 focus:border-blue-500 outline-none" placeholder="0812xxxx">
                    </div>
                    <button type="submit" name="login" class="w-full bg-blue-600 hover:bg-blue-700 py-4 rounded-xl font-bold uppercase tracking-widest transition">Lihat Destinasi</button>
                </form>
            </div>
        </div>
    </section>

    <?php else: ?>
    <nav class="p-5 flex justify-between items-center bg-slate-950/90 border-b border-white/5 sticky top-0 z-50">
        <h1 class="text-xl font-black uppercase">Malangans<span class="text-blue-500">Tickets</span></h1>
        <div class="flex items-center gap-4">
            <div class="text-right">
                <p class="text-[10px] text-gray-500 font-bold"><?php echo strtoupper($_SESSION['role']); ?></p>
                <p class="text-sm font-bold text-blue-400"><?php echo $_SESSION['username']; ?></p>
            </div>
            <a href="?logout=true" class="text-red-500 bg-white/5 w-10 h-10 flex items-center justify-center rounded-full"><i class="fas fa-sign-out-alt"></i></a>
        </div>
    </nav>

    <main class="container mx-auto px-6 py-12">
        <h2 class="text-4xl font-bold mb-8">Halo, <span class="text-blue-500"><?php echo $_SESSION['username']; ?></span></h2>

        <?php if ($_SESSION['role'] == 'admin'): ?>
            <div class="bg-blue-600/20 border border-blue-500 p-6 rounded-2xl mb-10">
                <h3 class="font-bold text-blue-400 mb-2 italic">Panel Admin Aktif</h3>
                <button class="bg-blue-600 px-6 py-2 rounded-lg text-sm font-bold">+ Tambah Wisata Baru</button>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="bg-white/5 border border-white/10 p-6 rounded-3xl group hover:border-blue-500 transition">
                <div class="h-48 bg-slate-800 rounded-2xl mb-4 overflow-hidden">
                    <img src="C:\Xamppp\htdocs\wisata\assets\jpk1.jpeg">
                </div>
                <h3 class="text-xl font-bold mb-2">Jatim Park 1</h3>
                <p class="text-gray-400 text-sm mb-4">Wisata edukasi seru di Kota Batu.</p>
                <p class="text-blue-400 font-bold text-xl mb-4">Rp 100.000</p>
                
                <?php if ($_SESSION['role'] == 'admin'): ?>
                    <div class="flex gap-2">
                        <button class="flex-1 bg-yellow-600 py-2 rounded-lg text-xs font-bold uppercase">Edit</button>
                        <button class="flex-1 bg-red-600 py-2 rounded-lg text-xs font-bold uppercase">Hapus</button>
                    </div>
                <?php else: ?>
                    <button class="w-full bg-blue-600 py-3 rounded-xl font-bold text-xs uppercase">Pesan Tiket</button>
                <?php endif; ?>
            </div>
        </div>
    </main>
    <?php endif; ?>

</body>
</html>