<?php
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'kepala') {
    header("Location: login.php");
    exit;
}
?>

<h2>Dashboard Kepala Bagian</h2>
<p>Selamat datang, <?= $_SESSION['username'] ?>!</p>
<ul>
    <li>Gunakan menu dropdown di atas untuk mengelola data karyawan Anda.</li>
</ul>
