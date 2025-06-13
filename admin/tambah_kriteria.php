<?php
require_once 'config.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $bobot = $_POST['bobot'];

    mysqli_query($conn, "INSERT INTO kriteria (nama, bobot) VALUES ('$nama', '$bobot')");
    echo "<script>alert('Kriteria berhasil ditambahkan!');location.href='index.php?page=admin/kriteria.php';</script>";
}
?>

<h2>Tambah Kriteria</h2>

<style>
.form-box {
    width: 400px;
    margin: 30px auto;
    padding: 25px 30px;
    background-color: #f0f4f7;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    font-family: 'Segoe UI', sans-serif;
}

.form-box h3 {
    margin-bottom: 20px;
    color: #333;
    text-align: center;
}

.form-box label {
    display: block;
    margin-bottom: 6px;
    font-weight: 600;
    color: #555;
}

.form-box input {
    width: 100%;
    padding: 10px;
    margin-bottom: 16px;
    border: 1px solid #ccc;
    border-radius: 6px;
}

.form-box button {
    width: 100%;
    background-color: #388e3c;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 6px;
    font-weight: bold;
    cursor: pointer;
}

.form-box button:hover {
    background-color: #2e7d32;
}
</style>

<div class="form-box">
    <h3>Form Tambah Kriteria</h3>
    <form method="post">
        <label>Nama Kriteria</label>
        <input type="text" name="nama" required>

        <label>Bobot</label>
        <input type="number" name="bobot" required>

        <button type="submit" name="simpan">Simpan</button>
    </form>
</div>
