<?php
// ... kode koneksi database Anda ...

// Tambahkan fungsi ini di dalam config.php
function bersih_data($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return mysqli_real_escape_string($conn, $data);
}
/**
 * config.php
 * File pusat konfigurasi sistem
 */

// 1. Pengaturan Error Reporting (Aktifkan saat pengembangan, matikan saat sudah online)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 2. Definisi Parameter Database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_wisata";

// 3. Membuat Koneksi Database (MySQLi)
$conn = mysqli_connect($host, $user, $pass, $db);

// Cek apakah koneksi berhasil
if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// 4. Memulai Session (Wajib untuk sistem login)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 5. Fungsi Bantuan: Format Mata Uang (Rupiah)
if (!function_exists('rupiah')) {
    function rupiah($angka) {
        return "Rp " . number_format($angka, 0, ',', '.');
    }
}

// 6. Fungsi Bantuan: Pembersihan Input (Keamanan dari SQL Injection)
function input_bersih($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return mysqli_real_escape_string($conn, $data);
}

// 7. Pengaturan Zona Waktu (WIB)
date_default_timezone_set('Asia/Jakarta');

/**
 * Catatan:
 * Gunakan require_once 'config.php'; di setiap file PHP lain
 * agar variabel $conn dan fungsi-fungsi di atas bisa langsung dipakai.
 */
?>