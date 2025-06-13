<?php
require_once 'config.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM kriteria WHERE id='$id'");
$kriteria = mysqli_fetch_assoc($data);

if (isset($_POST['update'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $bobot = (float) $_POST['bobot'];

    mysqli_query($conn, "UPDATE kriteria SET nama='$nama', bobot='$bobot' WHERE id='$id'");
    echo "<script>alert('Kriteria berhasil diupdate!');location.href='index.php?page=admin/kriteria.php';</script>";
}
?>

<style>
.container-kriteria {
    max-width: 600px;
    margin: 40px auto;
    background: #fff;
    padding: 30px 40px;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    font-family: 'Segoe UI', sans-serif;
}

.container-kriteria h2 {
    margin-bottom: 20px;
    color: #00796b;
    text-align: center;
}

form label {
    display: block;
    margin-bottom: 6px;
    font-weight: 600;
    color: #333;
}

form input {
    width: 100%;
    padding: 10px;
    margin-bottom: 18px;
    border: 1px solid #ccc;
    border-radius: 8px;
}

form button {
    padding: 12px 20px;
    border: none;
    background-color: #00796b;
    color: white;
    font-weight: bold;
    border-radius: 8px;
    cursor: pointer;
    width: 100%;
}

form button:hover {
    background-color: #00695c;
}
</style>

<div class="container-kriteria">
    <h2>Edit Kriteria</h2>
    <form method="post">
        <label>Nama Kriteria</label>
        <input type="text" name="nama" value="<?= $kriteria['nama']; ?>" required>

        <label>Bobot Kriteria</label>
        <input type="number" step="0.01" name="bobot" value="<?= $kriteria['bobot']; ?>" required>

        <button type="submit" name="update">Update</button>
    </form>
</div>
