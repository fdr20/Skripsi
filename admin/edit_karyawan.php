<?php
require_once 'config.php';

// Cek login dan role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Cek apakah ada ID karyawan di URL
if (!isset($_GET['id'])) {
    echo "<script>alert('ID tidak ditemukan');location.href='index.php?page=admin/daftar_karyawan.php';</script>";
    exit;
}

$id = intval($_GET['id']); // pastikan aman

// Ambil data karyawan
$result = mysqli_query($conn, "SELECT * FROM karyawan WHERE id = $id");
if (mysqli_num_rows($result) == 0) {
    echo "<script>alert('Data tidak ditemukan');location.href='index.php?page=admin/daftar_karyawan.php';</script>";
    exit;
}

$data = mysqli_fetch_assoc($result);

// Proses update jika form disubmit
if (isset($_POST['update'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $jabatan = mysqli_real_escape_string($conn, $_POST['jabatan']);

    $update = mysqli_query($conn, "UPDATE karyawan SET nama = '$nama', jabatan = '$jabatan' WHERE id = $id");

    if ($update) {
        echo "<script>alert('Data berhasil diperbarui');location.href='index.php?page=admin/daftar_karyawan.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data');</script>";
    }
}
?>

<h2>Edit Data Karyawan</h2>

<style>
    .form-edit {
        max-width: 400px;
        margin-top: 20px;
        display: flex;
        flex-direction: column;
        gap: 12px;
        font-family: Arial, sans-serif;
    }

    .form-edit input {
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #ccc;
    }

    .form-edit button {
        padding: 10px;
        background-color: #4CAF50;
        color: white;
        font-weight: bold;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.2s ease;
    }

    .form-edit button:hover {
        background-color: #388E3C;
    }
</style>

<form method="POST" class="form-edit">
    <input type="text" name="nama" placeholder="Nama Karyawan" value="<?= $data['nama']; ?>" required>
    <input type="text" name="jabatan" placeholder="Jabatan" value="<?= $data['jabatan']; ?>" required>
    <button type="submit" name="update">Update</button>
</form>
