<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SPK Karyawan Terbaik - COPRAS</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
        }

        .sidebar {
            width: 220px;
            background-color: #2e7d32;
            height: 100vh;
            padding: 20px;
            color: white;
            position: fixed;
            overflow-y: auto;
        }

        .sidebar h2 {
            font-size: 26px;
            margin-bottom: 30px;
            color: white;
        }

        .sidebar a,
        .dropbtn {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px 0;
            font-weight: bold;
            border: none;
            background: none;
            cursor: pointer;
            width: 100%;
            text-align: left;
            font-size: 18px;
        }

        .sidebar a:hover,
        .dropbtn:hover {
            background-color: #1b5e20;
            padding-left: 10px;
        }

        .dropdown-content {
            display: none;
            padding-left: 15px;
            flex-direction: column;
        }

        .dropdown-content a {
            font-weight: normal;
            font-size: 14px;
        }

        .dropdown-content.show {
            display: flex;
        }

        .main-content {
            margin-left: 220px;
            padding: 20px;
            width: calc(100% - 220px);
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>👤 <?= $_SESSION['username']; ?></h2>

    <a href="index.php?page=<?= $_SESSION['role']; ?>/beranda.php">Dashboard</a>

    <?php if ($_SESSION['role'] === 'admin'): ?>
        <a href="index.php?page=admin/daftar_karyawan.php">Karyawan</a>
        <a href="index.php?page=admin/kepala_bagian.php">Kepala Bagian</a>
        <a href="index.php?page=admin/kriteria.php">Kriteria</a>

        <div class="dropdown">
            <button class="dropbtn" onclick="toggleDropdown('penilaianDropdown')">Penilaian ▼</button>
            <div class="dropdown-content" id="penilaianDropdown">
                <a href="index.php?page=admin/penilaian.php">Input Penilaian</a>
                <a href="index.php?page=admin/lihat_penilaian.php">Lihat Penilaian</a>
                <a href="index.php?page=admin/hasil_akhir.php">Hasil Akhir</a>
            </div>
        </div>

        <div class="dropdown">
            <button class="dropbtn" onclick="toggleDropdown('akunDropdown')">Akun ▼</button>
            <div class="dropdown-content" id="akunDropdown">
                <a href="index.php?page=admin/profil_admin.php">Lihat Profil</a>
                <a href="index.php?page=admin/edit_profil.php">Edit Profil</a>
                <a href="index.php?page=admin/tambah_admin.php">Tambah Admin</a>
            </div>
        </div>

    <?php elseif ($_SESSION['role'] === 'kepala'): ?>
        <div class="dropdown">
            <button class="dropbtn" onclick="toggleDropdown('karyawanDropdown')">Karyawan ▼</button>
            <div class="dropdown-content" id="karyawanDropdown">
                <a href="index.php?page=kepala/data_karyawan.php">Data Karyawan</a>
                <a href="index.php?page=kepala/tambah_karyawan.php">Tambah Karyawan</a>
            </div>
        </div>
        <a href="index.php?page=kepala/profil_kepala.php">Profil</a>
    <?php endif; ?>

    <a href="logout.php" style="color: red;">Logout</a>
</div>

<div class="main-content">
    <?php
    if (isset($_SESSION['alert'])) {
        echo "<script>alert('{$_SESSION['alert']}');</script>";
        unset($_SESSION['alert']);
    }

    if (isset($_GET['page'])) {
        include $_GET['page'];
    } else {
        header("Location: index.php?page=" . $_SESSION['role'] . "/beranda.php");
        exit;
    }
    ?>
</div>

<script>
function toggleDropdown(id) {
    const target = document.getElementById(id);
    target.classList.toggle("show");

    document.querySelectorAll('.dropdown-content').forEach((el) => {
        if (el.id !== id) {
            el.classList.remove("show");
        }
    });
}

document.addEventListener('click', function (event) {
    const isClickInside = event.target.closest('.dropdown');
    if (!isClickInside) {
        document.querySelectorAll('.dropdown-content').forEach(el => el.classList.remove('show'));
    }
});
</script>

</body>
</html>
