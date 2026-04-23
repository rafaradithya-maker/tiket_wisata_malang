<?php
session_start();
if (!isset($_SESSION['status']) || $_SESSION['role'] != 'pengguna') {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Dashboard Traveler</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#020617] text-white">
    <nav class="p-5 border-b border-white/5 flex justify-between">
        <h1 class="text-xl font-bold uppercase italic">Malangans<span class="text-blue-500">Tickets</span></h1>
        <span>Halo, <?php echo $_SESSION['username']; ?></span>
    </nav>
    <main class="p-10">
        <h2 class="text-4xl font-black mb-10">PILIH DESTINASI</h2>
        </main>
</body>
</html>