<?php
require_once 'config.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];

// cek apakah sub-kriteria dari kriteria ini dipakai di penilaian
$cek = mysqli_query($conn, "
    SELECT p.id 
    FROM penilaian p 
    JOIN sub_kriteria s ON p.id_sub_kriteria = s.id 
    WHERE s.id_kriteria = '$id'
");

if (mysqli_num_rows($cek) > 0) {
    echo "<script>alert('Kriteria tidak bisa dihapus karena sudah digunakan dalam penilaian!');location.href='index.php?page=admin/kriteria.php';</script>";
    exit;
}

// kalau aman, hapus sub-kriteria dan kriteria
mysqli_query($conn, "DELETE FROM sub_kriteria WHERE id_kriteria='$id'");
mysqli_query($conn, "DELETE FROM kriteria WHERE id='$id'");

echo "<script>alert('Kriteria berhasil dihapus!');location.href='index.php?page=admin/kriteria.php';</script>";
