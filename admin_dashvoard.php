<?php
session_start();
if (!isset($_SESSION['status']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Panel Kontrol Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#020617] text-white">
    <nav class="p-5 bg-blue-900/20 border-b border-blue-500/30 flex justify-between">
        <h1 class="text-xl font-bold">ADMIN PANEL</h1>
        <a href="index.php?logout=true" class="text-red-400 font-bold">LOGOUT</a>
    </nav>
    <main class="p-10">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold">Manajemen Tiket</h2>
            <button class="bg-blue-600 px-6 py-2 rounded-lg">+ Tambah Data</button>
        </div>
        </main>
</body>
</html>