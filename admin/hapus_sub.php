<?php
require_once 'config.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];

// cek apakah sub-kriteria ini dipakai dalam penilaian
$cek = mysqli_query($conn, "SELECT id FROM penilaian WHERE id_sub_kriteria = '$id'");

if (mysqli_num_rows($cek) > 0) {
    echo "<script>alert('Sub-kriteria tidak bisa dihapus karena sudah digunakan dalam penilaian!');location.href='index.php?page=admin/kriteria.php';</script>";
    exit;
}

// jika belum digunakan, aman dihapus
mysqli_query($conn, "DELETE FROM sub_kriteria WHERE id='$id'");
echo "<script>alert('Sub-kriteria berhasil dihapus!');location.href='index.php?page=admin/kriteria.php';</script>";
