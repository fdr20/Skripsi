<?php
require_once 'config.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT sub_kriteria.*, kriteria.nama AS nama_kriteria 
                             FROM sub_kriteria 
                             JOIN kriteria ON sub_kriteria.id_kriteria = kriteria.id 
                             WHERE sub_kriteria.id = '$id'");
$sub = mysqli_fetch_assoc($data);

if (isset($_POST['update'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $bobot = (int) $_POST['bobot'];

    mysqli_query($conn, "UPDATE sub_kriteria SET nama='$nama', bobot='$bobot' WHERE id='$id'");
    echo "<script>alert('Sub-kriteria berhasil diupdate!');location.href='index.php?page=admin/kriteria.php';</script>";
}
?>

<style>
.container-sub {
    max-width: 600px;
    margin: 40px auto;
    background: #fff;
    padding: 30px 40px;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    font-family: 'Segoe UI', sans-serif;
}

.container-sub h2 {
    margin-bottom: 20px;
    color: #1976d2;
    text-align: center;
}

form label {
    display: block;
    margin-bottom: 6px;
    font-weight: 600;
    color: #333;
}

form input[type="text"], form input[type="number"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 18px;
    border: 1px solid #ccc;
    border-radius: 8px;
}

form button {
    padding: 12px 20px;
    border: none;
    background-color: #1976d2;
    color: white;
    font-weight: bold;
    border-radius: 8px;
    cursor: pointer;
    width: 100%;
}

form button:hover {
    background-color: #1565c0;
}
</style>

<div class="container-sub">
    <h2>Edit Sub-Kriteria: <?= $sub['nama_kriteria']; ?></h2>
    <form method="post">
        <label for="nama">Nama Sub-Kriteria</label>
        <input type="text" name="nama" value="<?= $sub['nama']; ?>" required>

        <label for="bobot">Bobot Sub-Kriteria (1-5)</label>
        <input type="number" name="bobot" value="<?= $sub['bobot']; ?>" required min="1" max="5">

        <button type="submit" name="update">Update</button>
    </form>
</div>
