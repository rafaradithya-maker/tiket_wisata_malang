<?php 
require_once 'config.php';

// Proteksi halaman: Hanya Admin
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Ambil semua data tiket dan join dengan tabel user untuk tahu siapa pembelinya
$query = "SELECT tiket.*, users.nama FROM tiket 
          JOIN users ON tiket.user_id = users.id 
          ORDER BY tgl_beli DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Wisata Malang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-dark shadow mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Panel Admin Wisata Malang</a>
            <a href="logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">Semua Transaksi Tiket</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Nama User</th>
                                        <th>Wisata</th>
                                        <th>Jumlah</th>
                                        <th>Total Bayar</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                    <tr>
                                        <td><?= $row['tgl_beli']; ?></td>
                                        <td><?= $row['nama']; ?></td>
                                        <td><?= $row['wisata']; ?></td>
                                        <td><?= $row['jumlah']; ?></td>
                                        <td><?= rupiah($row['total_harga']); ?></td>
                                        <td>
                                            <?php if($row['status'] == 'lunas'): ?>
                                                <span class="badge bg-success text-uppercase">Lunas</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning text-dark text-uppercase">Pending</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>