<?php
require_once 'config.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$kriteria = mysqli_query($conn, "SELECT * FROM kriteria ORDER BY nama ASC");

// warna soft per kriteria
$colors = ['#d0e8d0', '#d0e4f7', '#ecd9f6', '#ffe0b2', '#f8d7da', '#d0f0ec'];
$headerColors = ['#388e3c', '#1976d2', '#8e24aa', '#f57c00', '#c62828', '#00897b'];
?>

<h2>Data Kriteria</h2>

<a href="index.php?page=admin/tambah_kriteria.php" style="display:inline-block; margin-bottom: 20px; background:#4caf50; color:white; padding:10px 18px; border-radius:8px; text-decoration:none;">+ Tambah Kriteria</a>

<style>
.card-kriteria {
    border-radius: 10px;
    margin-bottom: 30px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    font-family: 'Segoe UI', sans-serif;
}
.card-header {
    padding: 14px 20px;
    font-size: 16px;
    font-weight: bold;
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.card-header a {
    color: white;
    margin-left: 12px;
    text-decoration: underline;
    font-size: 14px;
}
.kriteria-table {
    width: 100%;
    border-collapse: collapse;
    background-color: white;
}
.kriteria-table th {
    background-color: #f3f3f3;
    color: #444;
    padding: 10px 14px;
    text-align: left;
    font-weight: 600;
    border-bottom: 1px solid #ddd;
}
.kriteria-table td {
    padding: 10px 14px;
    border-bottom: 1px solid #eee;
}
.kriteria-table tr:hover {
    background-color: #f9f9f9;
}
.kriteria-table .aksi a {
    margin-right: 10px;
    color: #1976d2;
    text-decoration: none;
    font-weight: bold;
}
.kriteria-table .aksi a:hover {
    text-decoration: underline;
}
.tambah-sub-btn {
    display: inline-block;
    background: #0288d1;
    color: white;
    padding: 8px 14px;
    border-radius: 6px;
    font-size: 14px;
    margin: 12px 20px;
    text-decoration: none;
    float: right;
}
</style>

<?php
$no = 1;
while ($k = mysqli_fetch_assoc($kriteria)) {
    $bg = $colors[($no - 1) % count($colors)];
    $head = $headerColors[($no - 1) % count($headerColors)];
    echo "<div class='card-kriteria' style='background-color: $bg;'>
            <div class='card-header' style='background-color: $head;'>
                <span>Kriteria {$no}: {$k['nama']} (Bobot: {$k['bobot']}, Jenis: {$k['jenis']})</span>
                <span>
                    <a href='index.php?page=admin/edit_kriteria.php&id={$k['id']}'>Edit</a>
                    <a href='index.php?page=admin/edit_jenis_kriteria.php&id={$k['id']}'>Jenis</a>
                    <a href='index.php?page=admin/hapus_kriteria.php&id={$k['id']}' onclick=\"return confirm('Hapus kriteria dan seluruh sub-kriterianya?')\">Hapus</a>
                </span>
            </div>
            <table class='kriteria-table'>
                <thead>
                    <tr>
                        <th style='width:5%;'>No</th>
                        <th>Nama Sub-Kriteria</th>
                        <th>Bobot</th>
                        <th class='aksi'>Aksi</th>
                    </tr>
                </thead>
                <tbody>";

    $sub = mysqli_query($conn, "SELECT * FROM sub_kriteria WHERE id_kriteria='{$k['id']}' ORDER BY nama ASC");
    $subNo = 1;
    while ($s = mysqli_fetch_assoc($sub)) {
        echo "<tr>
                <td>{$subNo}</td>
                <td>{$s['nama']}</td>
                <td>{$s['bobot']}</td>
                <td class='aksi'>
                    <a href='index.php?page=admin/edit_sub.php&id={$s['id']}'>Edit</a>
                    <a href='index.php?page=admin/hapus_sub.php&id={$s['id']}' onclick=\"return confirm('Hapus sub-kriteria ini?')\">Hapus</a>
                </td>
              </tr>";
        $subNo++;
    }

    echo "  </tbody>
            </table>
            <a href='index.php?page=admin/tambah_sub.php&id_kriteria={$k['id']}' class='tambah-sub-btn'>+ Tambah Sub-Kriteria</a>
          </div>";
    $no++;
}
?>
