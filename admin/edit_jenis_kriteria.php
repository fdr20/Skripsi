<?php
require_once 'config.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

$id = $_GET['id'];
$kriteria = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM kriteria WHERE id = '$id'"));

if (isset($_POST['update'])) {
    $jenis = $_POST['jenis'];
    mysqli_query($conn, "UPDATE kriteria SET jenis='$jenis' WHERE id='$id'");
    echo "<script>alert('Jenis kriteria berhasil diperbarui!');location.href='index.php?page=admin/kriteria.php';</script>";
}
?>

<style>
.container-jenis {
    max-width: 500px;
    margin: 40px auto;
    background: #fff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    font-family: 'Segoe UI', sans-serif;
}
.container-jenis h2 {
    text-align: center;
    color: #388e3c;
}
form label {
    font-weight: bold;
    display: block;
    margin: 12px 0 6px;
}
form select, form button {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 8px;
    border: 1px solid #ccc;
}
form button {
    background: #388e3c;
    color: white;
    border: none;
    font-weight: bold;
}
form button:hover {
    background: #2e7d32;
}
</style>

<div class="container-jenis">
    <h2>Edit Jenis Kriteria</h2>
    <form method="post">
        <label>Nama Kriteria</label>
        <input type="text" value="<?= $kriteria['nama']; ?>" readonly>

        <label>Jenis Kriteria</label>
        <select name="jenis" required>
            <option value="benefit" <?= $kriteria['jenis'] == 'benefit' ? 'selected' : '' ?>>Benefit</option>
            <option value="cost" <?= $kriteria['jenis'] == 'cost' ? 'selected' : '' ?>>Cost</option>
        </select>

        <button type="submit" name="update">Simpan Perubahan</button>
    </form>
</div>
