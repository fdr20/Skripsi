<?php
require_once 'config.php';

// Cek login dan role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Cek apakah ada parameter ID yang dikirim
if (!isset($_GET['id'])) {
    echo "<script>alert('ID karyawan tidak ditemukan');location.href='index.php?page=admin/daftar_karyawan.php';</script>";
    exit;
}

$id = intval($_GET['id']); // pastikan aman dari SQL injection

// Cek apakah karyawan ada
$cek = mysqli_query($conn, "SELECT * FROM karyawan WHERE id = $id");
if (mysqli_num_rows($cek) == 0) {
    echo "<script>alert('Karyawan tidak ditemukan');location.href='index.php?page=admin/daftar_karyawan.php';</script>";
    exit;
}

// Hapus data karyawan
$delete = mysqli_query($conn, "DELETE FROM karyawan WHERE id = $id");

if ($delete) {
    echo "<script>alert('Data karyawan berhasil dihapus');location.href='index.php?page=admin/daftar_karyawan.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus data');location.href='index.php?page=admin/daftar_karyawan.php';</script>";
}
?>
